const assert = require('node:assert/strict');
const fs = require('node:fs');
const path = require('node:path');
const test = require('node:test');
const vm = require('node:vm');

let tokenizerFactory;
const define = Object.assign((id, dependencies, factory) => {
    if (id === 'ace/tokenizer') tokenizerFactory = factory;
}, { packaged: true });
const requireModule = Object.assign(() => {}, { packaged: true });

// Register the bundled modules without bootstrapping the browser editor.
vm.runInNewContext(fs.readFileSync(path.join(__dirname, '../external/ace/ace.js'), 'utf8'), {
    ace: { define, require: requireModule }
}, { timeout: 2000 });

const tokenizerExports = {};
tokenizerFactory(id => {
    assert.equal(id, './config');
    return {};
}, tokenizerExports, { exports: tokenizerExports });
const Tokenizer = tokenizerExports.Tokenizer;

test('only capturing groups outside character classes are rewritten', () => {
    const cases = [
        ['(foo)(bar)', '(?:foo)(?:bar)'],
        ['[()](foo)', '[()](?:foo)'],
        [String.raw`\((foo)\)`, String.raw`\((?:foo)\)`],
        ['(?:foo)(?=bar)(?!baz)(qux)', '(?:foo)(?=bar)(?!baz)(?:qux)'],
        [String.raw`[\]()](foo)`, String.raw`[\]()](?:foo)`],
        [String.raw`[\\()](foo)`, String.raw`[\\()](?:foo)`],
        [String.raw`\[(foo)\]`, String.raw`\[(?:foo)\]`]
    ];

    for (const [input, expected] of cases) {
        assert.equal(Tokenizer.prototype.removeCapturingGroups(input), expected);
    }
});

test('long backslash sequences complete within one second per input', () => {
    const slashes = '\\'.repeat(100000);
    const cases = [
        ['[' + slashes, '[' + slashes],
        ['[' + slashes + '\\]', '[' + slashes + '\\]'],
        ['[' + slashes + '](foo)', '[' + slashes + '](?:foo)']
    ];

    for (const [input, expected] of cases) {
        const result = vm.runInNewContext('removeCapturingGroups(input)', {
            removeCapturingGroups: Tokenizer.prototype.removeCapturingGroups,
            input
        }, { timeout: 1000 });
        assert.equal(result, expected);
    }
});

test('tokenization preserves capture arrays, character classes and backreferences', () => {
    const tokenizer = new Tokenizer({
        start: [
            { regex: '(foo)(bar)', token: 'keyword' },
            { regex: '([a-z]+)(:)', token: ['name', 'punctuation'] },
            { regex: String.raw`[\\()]+`, token: 'punctuation' },
            { regex: String.raw`(x)\1`, token: 'repeat' },
            { defaultToken: 'text' }
        ]
    });

    assert.equal(JSON.stringify(tokenizer.getLineTokens('foobar abc: (\\) xx', 'start')), JSON.stringify({
        tokens: [
            { type: 'keyword', value: 'foobar' },
            { type: 'text', value: ' ' },
            { type: 'name', value: 'abc' },
            { type: 'punctuation', value: ':' },
            { type: 'text', value: ' ' },
            { type: 'punctuation', value: '(\\)' },
            { type: 'text', value: ' ' },
            { type: 'repeat', value: 'xx' }
        ],
        state: 'start'
    }));
});
