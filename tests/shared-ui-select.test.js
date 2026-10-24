const assert = require('node:assert/strict');
const fs = require('node:fs');
const path = require('node:path');
const test = require('node:test');
const vm = require('node:vm');
const { JSDOM } = require('jsdom');
const jquery = require('jquery');

const source = fs.readFileSync(path.join(__dirname, '../assets/js/shared-ui.js'), 'utf8');
const start = source.indexOf('    SUI.suiSelect = function(el)');
const end = source.indexOf('})(jQuery);', start);
assert.ok(start !== -1 && end > start);

function setup(t, options) {
    const dom = new JSDOM('<select id="test-select" aria-labelledby="label"></select>', {
        runScripts: 'outside-only'
    });
    t.after(() => dom.window.close());
    const $ = jquery(dom.window);
    dom.window.jQuery = $;
    dom.window.SUI = {};
    dom.window.eval('(function($) {\n' + source.slice(start, end) + '\n})(jQuery);');
    const select = $('select');
    for (const [index, option] of options.entries()) {
        const element = $('<option></option>').val(option.value === undefined ? String(index) : option.value).text(option.label);
        for (const [name, value] of Object.entries(option.data || {})) {
            element.attr('data-' + name, value);
        }
        select.append(element);
    }
    dom.window.SUI.suiSelect(select[0]);
    return { $, select, wrap: select.parent() };
}

test('colored labels remain literal text on initialization, selection and refresh', t => {
    const label = '<img src=x onerror="alert(1)"> & <b>Label</b>';
    const { $, select, wrap } = setup(t, [
        { label: 'First', data: { color: '#123456' } },
        { label, data: { color: '#abcdef' } },
        { label: 'Plain' }
    ]);
    const value = wrap.find('.list-value');
    assert.equal(value.text(), 'First');
    assert.equal(value.find('span').css('background-color'), 'rgb(18, 52, 86)');
    assert.equal(wrap.find('li').eq(1).text(), label);
    assert.equal(wrap.find('img, b').length, 0);
    assert.equal(wrap.find('li span').first().attr('aria-hidden'), 'true');
    let changes = 0;
    select.on('change', () => changes++);
    wrap.find('li').eq(1).trigger('click');
    assert.equal(value.text(), label);
    assert.equal(value.find('span').attr('data-color'), '#abcdef');
    assert.equal(value.find('span').css('background-color'), 'rgb(171, 205, 239)');
    assert.equal(select.val(), '1');
    assert.equal(changes, 1);
    assert.equal(wrap.find('li').eq(1).attr('aria-selected'), 'true');
    select.val('2').trigger('sui:change');
    assert.equal(value.text(), 'Plain');
    assert.equal(value.children().length, 0);
    select.val('1').trigger('sui:change');
    assert.equal(value.text(), label);
    assert.equal(wrap.find('img, b').length, 0);
    assert.equal($('.current').length, 1);
});

test('color and icon metadata cannot create attributes or elements', t => {
    const color = 'red;" onclick="alert(1)"><img src=x>';
    const icon = 'check" onclick="alert(1)"><img src=x>';
    const { wrap } = setup(t, [
        { label: 'Color', data: { color } },
        { label: '<b>Icon label</b>', data: { icon } }
    ]);
    assert.equal(wrap.find('img, b, [onclick]').length, 0);
    assert.equal(wrap.find('.list-value span').attr('data-color'), color);
    assert.equal(wrap.find('li span').attr('data-color'), color);
    assert.equal(wrap.find('li i').attr('class'), 'sui-icon-' + icon);
    assert.equal(wrap.find('li i').attr('aria-hidden'), 'true');
    assert.equal(wrap.find('li').eq(1).text(), ' <b>Icon label</b>');
});

test('content decorations keep intentional markup while labels stay text', t => {
    const label = '<img src=x> Label & text';
    const { wrap } = setup(t, [
        { label, data: { content: '<strong>Decoration</strong>' } },
        { label: '<b>Plain label</b>' }
    ]);
    const item = wrap.find('li').first();
    assert.equal(item.hasClass('sui-element-flex'), true);
    assert.equal(item.children('span').first().text(), label);
    assert.equal(item.find('strong').text(), 'Decoration');
    assert.equal(wrap.find('li').eq(1).text(), '<b>Plain label</b>');
    assert.equal(wrap.find('img, b').length, 0);
});

test('navigation only accepts HTTP(S) URLs and leading fragment identifiers', () => {
    const handlerStart = source.indexOf('        function handleValue()');
    const handlerEnd = source.indexOf('} // Toggle the dropdown', handlerStart);
    assert.ok(handlerStart !== -1 && handlerEnd > handlerStart);
    const handler = source.slice(handlerStart, handlerEnd + 1);
    const cases = [
        ['http://example.test/path', true],
        ['https://example.test/path#section', true],
        ['#section', true],
        ['#', true],
        ['javascript:alert(1)#', false],
        ['java\nscript:alert(1)#section', false],
        ['data:text/html,<h1>test</h1>#section', false],
        ['//example.test/#section', false],
        ['/path#section', false],
        ['plain#value', false],
        ['plain', false],
        ['', false]
    ];

    for (const [value, allowed] of cases) {
        const location = { href: 'unchanged' };
        vm.runInNewContext(handler + '\nhandleValue();', {
            jq: [{ value }],
            window: { location }
        });
        assert.equal(location.href, allowed ? value : 'unchanged', value);
    }
});

test('selecting a fragment option navigates without changing selection behavior', t => {
    const { select, wrap } = setup(t, [
        { label: 'First' },
        { label: 'Section', value: '#section' }
    ]);
    let changes = 0;
    select.on('change', () => changes++);
    wrap.find('li').eq(1).trigger('click');
    assert.equal(select[0].ownerDocument.defaultView.location.hash, '#section');
    assert.equal(select.val(), '#section');
    assert.equal(wrap.find('.list-value').text(), 'Section');
    assert.equal(changes, 1);
});
