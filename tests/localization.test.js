const assert = require('node:assert/strict');
const fs = require('node:fs');
const path = require('node:path');
const test = require('node:test');
const { execFileSync } = require('node:child_process');

function readCatalog(name) {
    const entries = new Map();
    let entry = {};
    let field;
    const finish = () => {
        if (entry.msgid !== undefined) {
            const key = entry.msgctxt === undefined ? entry.msgid : entry.msgctxt + '\x04' + entry.msgid;
            assert.equal(entries.has(key), false, 'Duplicate catalog key: ' + key);
            entries.set(key, entry);
        }
        entry = {};
        field = undefined;
    };
    const text = fs.readFileSync(path.join(__dirname, '../languages', name), 'utf8');
    for (const line of text.split(/\r?\n/)) {
        if (!line.trim()) {
            finish();
        } else if (line.startsWith('#')) {
            assert.equal(/^#,.*\bfuzzy\b/.test(line) && name.endsWith('.po'), false, 'Fuzzy translation');
        } else {
            const match = /^(msgctxt|msgid_plural|msgid|msgstr(?:\[\d+\])?) (".*")$/.exec(line);
            if (match) {
                field = match[1];
                entry[field] = JSON.parse(match[2]);
            } else {
                assert.ok(field && line.startsWith('"'), 'Unexpected PO syntax: ' + line);
                entry[field] += JSON.parse(line);
            }
        }
    }
    finish();
    return entries;
}

const po = readCatalog('ub-en_US.po');
const pot = readCatalog('ub.pot');

test('actual PHP gettext calls are covered, with valid contexts and plural forms', () => {
    const result = JSON.parse(execFileSync('php', [path.join(__dirname, '../scripts/extract-translations.php')], { encoding: 'utf8' }));
    assert.deepEqual(result.errors, []);
    assert.ok(result.entries.length > 1500, 'Source extraction must cover the complete plugin');
    for (const entry of result.entries) {
        const key = (entry.context === null ? '' : entry.context + '\x04') + entry.msgid;
        const location = entry.references.join(', ');
        assert.ok(po.has(key), 'Missing English source entry at ' + location + ': ' + key);
        assert.ok(pot.has(key), 'Missing POT source entry at ' + location + ': ' + key);
        if (entry.plural !== null) {
            assert.equal(po.get(key).msgid_plural, entry.plural, 'Source plural mismatch at ' + location);
        }
    }
});

test('language registration precedes rebuilding cached module labels and default messages', () => {
    const source = fs.readFileSync(path.join(__dirname, '../inc/class-pstoolkit-admin.php'), 'utf8');
    assert.match(source, /add_action\(\s*'init',\s*array\(\s*\$this,\s*'initialize_translated_messages'\s*\),\s*1\s*\)/);
    const result = execFileSync('php', {
        cwd: path.join(__dirname, '..'),
        encoding: 'utf8',
        input: `<?php
        $hooks = array();
        $loaded = false;
        function add_action($hook, $callback, $priority = 10) {
            $GLOBALS['hooks'][$hook][$priority][] = $callback;
        }
        function pstoolkit_dir($path) { return getcwd() . '/' . $path; }
        function load_plugin_textdomain($domain, $deprecated, $path) {
            if ('ub' !== $domain) throw new RuntimeException('Wrong domain');
            $GLOBALS['loaded'] = true;
        }
        function __($message, $domain) {
            return $GLOBALS['loaded'] && 'ub' === $domain ? 'translated:' . $message : $message;
        }
        require 'inc/class-pstoolkit-admin.php';
        class LocalizationAdmin extends PSToolkit_Admin {
            public $labels;
            public function set_configuration() {
                if (!$GLOBALS['loaded']) throw new RuntimeException('Configuration rebuilt before loading translations');
                $this->labels = __('Einstellungen', 'ub');
            }
        }
        $admin = (new ReflectionClass('LocalizationAdmin'))->newInstanceWithoutConstructor();
        $admin->setup_translation();
        add_action('init', array($admin, 'initialize_translated_messages'), 1);
        if (!isset($hooks['init'][0])) throw new RuntimeException('Translations must load at init priority zero');
        ksort($hooks['init']);
        foreach ($hooks['init'] as $callbacks) foreach ($callbacks as $callback) $callback();
        echo json_encode(array($admin->labels, $admin->messages), JSON_UNESCAPED_UNICODE);
        `
    });
    const [label, messages] = JSON.parse(result);
    assert.equal(label, 'translated:Einstellungen');
    assert.equal(Object.keys(messages).length, 7);
    for (const message of Object.values(messages)) assert.ok(message.startsWith('translated:'));
});

function translations(entry) {
    return entry.msgid_plural === undefined
        ? [entry.msgstr]
        : [entry['msgstr[0]'], entry['msgstr[1]']];
}

function placeholders(value) {
    return (value.replace(/%%/g, '').match(/%(?:\d+\$)?[-+ 0#]*(?:\d+|\*)?(?:\.(?:\d+|\*))?[bcdeEfFgGosuxX]/g) || []).sort();
}

test('English catalog is complete and preserves formatting and email placeholders', () => {
    assert.match(po.get('').msgstr, /Language: en_US\n/);
    for (const [key, entry] of po) {
        if (!key) continue;
        assert.ok(pot.has(key), 'Missing POT entry: ' + key);
        assert.equal(pot.get(key).msgid_plural, entry.msgid_plural, 'Plural mismatch: ' + key);
        translations(entry).forEach((translation, index) => {
            assert.ok(translation, 'Empty translation: ' + key);
            const source = index === 0 ? entry.msgid : entry.msgid_plural;
            assert.deepEqual(placeholders(translation), placeholders(source), 'Printf placeholders: ' + key);
            const tokens = value => (value.match(/\b(?:USERNAME|PASSWORD|LOGINLINK|SITE_NAME|BLOG_URL)\b|\{[A-Z_]+\}/g) || []).sort();
            assert.deepEqual(tokens(translation), tokens(source), 'Email placeholders: ' + key);
        });
    }
    for (const key of pot.keys()) {
        if (key) assert.ok(po.has(key), 'Missing English entry: ' + key);
    }
});

test('compiled MO catalog matches the editable English PO catalog', () => {
    const data = fs.readFileSync(path.join(__dirname, '../languages/ub-en_US.mo'));
    const magic = data.readUInt32LE(0);
    assert.ok(magic === 0x950412de || magic === 0xde120495);
    const read = offset => magic === 0x950412de ? data.readUInt32LE(offset) : data.readUInt32BE(offset);
    const count = read(8);
    const originals = read(12);
    const translated = read(16);
    const strings = new Map();
    const value = (table, index) => {
        const length = read(table + index * 8);
        const offset = read(table + index * 8 + 4);
        assert.ok(offset + length < data.length);
        assert.equal(data[offset + length], 0);
        return data.toString('utf8', offset, offset + length);
    };
    for (let index = 0; index < count; index++) {
        strings.set(value(originals, index), value(translated, index));
    }
    assert.equal(strings.size, po.size);
    for (const [key, entry] of po) {
        if (!key) continue;
        const original = key + (entry.msgid_plural === undefined ? '' : '\0' + entry.msgid_plural);
        assert.equal(strings.get(original), translations(entry).join('\0'), key);
    }
});

test('English UI terms have the correct meaning and capitalization', () => {
    const expected = {
        Absender: 'Sender',
        Einstellungen: 'Settings',
        Betreff: 'Subject',
        Löschen: 'Delete',
        Vorlage: 'Template',
        'Letzte Einträge': 'Recent posts',
        'Letzten 7 Tage': 'Last 7 days',
        'Vorlage speichern': 'Save template',
        Hintergrundfarbe: 'Background color'
    };
    for (const [source, translation] of Object.entries(expected)) {
        assert.equal(po.get(source).msgstr, translation);
    }
    const days = ['So', 'Mo', 'Di', 'Mi', 'Do', 'Fr', 'Sa'];
    assert.deepEqual(days.map(day => po.get(day).msgstr), ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa']);
    assert.equal(po.get('Fest').msgstr, 'Solid');
    assert.equal(po.get('background crop option\x04Fest').msgstr, 'Fixed');
});
