const assert = require('node:assert/strict');
const fs = require('node:fs');
const path = require('node:path');
const test = require('node:test');
const { JSDOM } = require('jsdom');
const jquery = require('jquery');

const source = fs.readFileSync(path.join(__dirname, '../assets/js/shared-ui.js'), 'utf8');
const start = source.indexOf('    SUI.multistrings = function()');
const end = source.indexOf('})(jQuery);', start);
assert.ok(start !== -1 && end > start);

function setup(t, values, attributes = {}) {
    const dom = new JSDOM('<div class="sui-form-field"><label class="sui-label" for="tags">Tags</label><textarea class="sui-multistrings" id="tags"></textarea></div>', {
        runScripts: 'outside-only'
    });
    t.after(() => dom.window.close());
    const $ = jquery(dom.window);
    const textarea = $('textarea').val(values).attr(attributes);
    dom.window.jQuery = $;
    dom.window.SUI = {};
    dom.window.eval('(function($) {\n' + source.slice(start, end) + '\n})(jQuery);');
    return { $, textarea, wrap: $('.sui-multistrings-wrap') };
}

function assertTag(wrap, value) {
    const tag = wrap.find('.sui-multistrings-list > li').not('.sui-multistrings-input').last();
    assert.equal(tag.attr('title'), value);
    assert.equal(tag.clone().children().remove().end().text(), value);
    assert.equal(tag.find('.sui-button-close').length, 1);
    assert.equal(wrap.find('img, script, [onmouseover], [onfocus]').length, 0);
    return tag;
}

const payload = '"><img src=x onerror="alert(1)"> & <b>Tag</b>';

test('loaded tags and input metadata remain literal text and attributes', t => {
    const id = 'tags" onfocus="alert(1)';
    const placeholder = '"><img src=x> & "placeholder"';
    const { textarea, wrap } = setup(t, ' First \n\n' + payload, { id, placeholder });
    assert.equal(textarea.val(), 'First\n' + payload);
    assertTag(wrap, payload);
    const input = wrap.find('input');
    assert.equal(input.attr('placeholder'), placeholder);
    assert.equal(input.attr('id'), id + '-strings');
    assert.equal(input.attr('aria-labelledby'), id + '-strings-label');
    assert.equal(input.attr('aria-describedby'), id + '-strings-description');
    assert.equal(input.attr('autocomplete'), 'off');
});

test('enter adds a literal tag and deleting it updates the textarea', t => {
    const { $, textarea, wrap } = setup(t, 'First');
    const input = wrap.find('input').val(payload);
    const event = $.Event('keydown', { key: 'Enter', keyCode: 13 });
    input.trigger(event);
    assert.equal(event.isDefaultPrevented(), true);
    assert.equal(textarea.val(), 'First\n' + payload);
    assert.equal(input.val(), '');
    assertTag(wrap, payload).find('button').trigger('click');
    assert.equal(textarea.val(), 'First\n');
    assert.equal(wrap.find('.sui-multistrings-list > li').length, 2);
});

test('textarea changes rebuild literal tags and preserve disallowed-key filtering', t => {
    const { $, textarea, wrap } = setup(t, 'First', { 'data-disallowed-keys': '44' });
    textarea.val(payload + ',\nSecond').trigger('change');
    assert.equal(textarea.val(), payload + '\nSecond');
    const first = wrap.find('.sui-multistrings-list > li').first();
    assert.equal(first.attr('title'), payload);
    assert.equal(first.find('img, b').length, 0);
    assertTag(wrap, 'Second');
    const event = $.Event('keydown', { key: ',', keyCode: 188 });
    wrap.find('input').trigger(event);
    assert.equal(event.isDefaultPrevented(), true);
});
