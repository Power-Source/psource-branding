const assert = require('node:assert/strict');
const fs = require('node:fs');
const path = require('node:path');
const test = require('node:test');
const { JSDOM } = require('jsdom');

const source = fs.readFileSync(path.join(__dirname, '../external/icon-font/social-logos.html'), 'utf8');

function setup(t) {
    const dom = new JSDOM(source, { runScripts: 'dangerously' });
    t.after(() => dom.window.close());
    return dom.window.document;
}

test('clicking an icon or its label updates the usage example', t => {
    const document = setup(t);
    const name = document.getElementById('name');
    const items = document.querySelectorAll('.icons__item');

    items[0].click();
    assert.equal(name.textContent, items[0].getAttribute('data-name'));
    items[1].querySelector('i').click();
    assert.equal(name.textContent, items[1].getAttribute('data-name'));
    assert.equal(name.children.length, 0);
});

test('icon names containing markup are displayed literally', t => {
    const document = setup(t);
    const item = document.querySelector('.icons__item');
    const name = document.getElementById('name');
    const label = '<img src=x onerror="alert(1)"> & <b>icon</b>';
    item.setAttribute('data-name', label);

    for (const target of [item, item.querySelector('i')]) {
        target.click();
        assert.equal(name.textContent, label);
        assert.equal(name.childNodes.length, 1);
        assert.equal(name.firstChild.nodeType, 3);
        assert.equal(name.children.length, 0);
    }
});

test('clicking the container preserves the empty-name behavior', t => {
    const document = setup(t);
    document.getElementById('icons').click();
    assert.equal(document.getElementById('name').textContent, '');
});
