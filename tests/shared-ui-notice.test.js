const assert = require('node:assert/strict');
const fs = require('node:fs');
const path = require('node:path');
const test = require('node:test');
const { JSDOM } = require('jsdom');
const jquery = require('jquery');

const source = fs.readFileSync(path.join(__dirname, '../assets/js/shared-ui.js'), 'utf8');
const start = source.indexOf('    SUI.openNotice = function(');
const end = source.indexOf('    SUI.closeNotice = function(', start);
assert.ok(start !== -1 && end > start);
const purify = fs.readFileSync(path.join(__dirname, '../external/dompurify/purify.min.js'), 'utf8');

function setup(t, sanitizer = true) {
    const dom = new JSDOM('<div><div id="notice" role="alert"></div></div>', { runScripts: 'outside-only' });
    t.after(() => dom.window.close());
    const $ = jquery(dom.window);
    $.fx.off = true;
    dom.window.jQuery = $;
    const helperStart = source.indexOf('function _defineProperty(');
    dom.window.eval(source.slice(helperStart, source.indexOf('\n', helperStart)));
    dom.window.SUI = { closeNotice() {} };
    if (sanitizer) dom.window.eval(purify);
    dom.window.eval('(function($) { var _this = this;\n' + source.slice(start, end) + '\n})(jQuery);');
    return { window: dom.window, $ };
}

test('notices preserve formatting and links while removing executable markup', t => {
    const { window, $ } = setup(t);
    window.SUI.openNotice('notice',
        '<p>Hello <strong>World</strong> <a href="https://example.test/">Link</a></p>' +
        '<img src=x onerror="alert(1)"><script>alert(1)</script><a href="javascript:alert(1)">Unsafe</a>', {
            autoclose: { show: false },
            dismiss: { show: true, label: '<b>Close</b>', tooltip: '"><img src=x onerror=alert(1)>' }
        });
    const notice = $('#notice');
    assert.equal(notice.find('strong').text(), 'World');
    assert.equal(notice.find('a').first().attr('href'), 'https://example.test/');
    assert.equal(notice.find('a').last().attr('href'), undefined);
    assert.equal(notice.find('script, [onerror], .sui-notice-actions img').length, 0);
    assert.equal(notice.find('.sui-screen-reader-text').text(), '<b>Close</b>');
    assert.equal(notice.find('.sui-tooltip').attr('data-tooltip'), '"><img src=x onerror=alert(1)>');
    assert.equal(notice.find('.sui-notice-icon').length, 1);
    let closed;
    window.SUI.closeNotice = id => { closed = id; };
    notice.find('button').trigger('click');
    assert.equal(closed, 'notice');
});

test('notices fail explicitly if the sanitizer is missing', t => {
    const { window } = setup(t, false);
    assert.throws(() => window.SUI.openNotice('notice', 'Message'), /require DOMPurify/);
});

test('notice dismissal defaults use the active locale', t => {
    const { window, $ } = setup(t);
    for (const label of ['Diese Benachrichtigung schließen', 'Close this notice']) {
        window.pstoolkitSharedUiL10n = { closeNotice: label };
        window.SUI.openNotice('notice', 'Message', {
            autoclose: { show: false },
            dismiss: { show: true }
        });
        assert.equal($('#notice .sui-screen-reader-text').text(), label);
    }
});
