const assert = require('node:assert/strict');
const fs = require('node:fs');
const path = require('node:path');
const test = require('node:test');
const { JSDOM } = require('jsdom');
const jquery = require('jquery');

const source = fs.readFileSync(path.join(__dirname, '../inc/modules/admin/assets/js/admin/admin-bar.js'), 'utf8');
const start = source.indexOf('function bind_pstoolkit_submenu_title(');
const end = source.indexOf('function pstoolkit_admin_bar_submenu_add(', start);
assert.ok(start !== -1 && end > start);

test('submenu title updates preserve the drag icon and display input literally', t => {
    const dom = new JSDOM('<div class="sui-accordion-item"><div class="sui-accordion-item-title"></div><div class="pstoolkit-admin-bar-submenu-title"><input type="text"></div></div>', { runScripts: 'outside-only' });
    t.after(() => dom.window.close());
    const $ = jquery(dom.window);
    dom.window.jQuery = $;
    dom.window.eval(source.slice(start, end));
    dom.window.bind_pstoolkit_submenu_title($('body'));
    const payload = '<img src=x onerror="alert(1)"> & <b>Title</b>';
    for (const event of ['change', 'paste', 'cut', 'keydown', 'keyup', 'keypress']) {
        $('input').val(payload).trigger(event);
        const title = $('.sui-accordion-item-title');
        assert.equal(title.text(), payload);
        assert.equal(title.find('.sui-icon-drag[aria-hidden="true"]').length, 1);
        assert.equal(title.find('img, b').length, 0);
    }
});
