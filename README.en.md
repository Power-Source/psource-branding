<div align="center">

<img src="./Logo.png" alt="PSOURCE Toolkit" width="160">

# PSOURCE Toolkit

**Your brand. Your dashboard. Your ClassicPress.**

A white-label and branding toolkit for login pages, administration, emails, and multisite networks.

</div>

[Deutsch](README.md) | **English**

[![Version](https://img.shields.io/badge/Version-1.0.6-2271b1?style=flat-square)](readme.txt)
![PHP](https://img.shields.io/badge/PHP-8.0%2B-777bb4?style=flat-square&logo=php&logoColor=white)
![WordPress](https://img.shields.io/badge/WordPress-up%20to%207.1.0-21759b?style=flat-square&logo=wordpress&logoColor=white)
![ClassicPress](https://img.shields.io/badge/ClassicPress-2.7.4-03768e?style=flat-square)
[![License](https://img.shields.io/badge/License-GPL--2.0--or--later-2ea44f?style=flat-square)](https://www.gnu.org/licenses/gpl-2.0.html)

---

## An experience that reflects your brand

From the first login to system emails, PSOURCE Toolkit helps you create a consistent experience across your website or network. Customize logos, colors, menus, and content without modifying your installation's core files.

The plugin is designed for website owners, agencies, and multisite administrators who want to offer their users a tailored administration interface.

> In the dashboard, you will find the plugin under **CP Toolkit**. In the source code, you will also encounter the names `PSToolkit` and `psource-branding`.

## Features

The toolkit includes more than 30 modules. Available options depend on factors such as your installation type and assigned permissions.

| Area | Capabilities |
| --- | --- |
| **Login & registration** | Customize the login screen, adjust images and colors, and configure registration features. |
| **Administration** | Customize the admin bar, menus, footer, color schemes, help content, and custom CSS rules. |
| **Dashboard & widgets** | Configure dashboard widgets, add custom feeds, and align the Meta widget with your branding. |
| **Emails** | Customize sender details and HTML templates, configure SMTP, and use email logs. |
| **Frontend** | Configure header and footer content, a cookie notice, an author box, and status pages. |
| **Maintenance & tools** | Manage maintenance and coming-soon modes, text replacement, comment controls, and tracking codes. |
| **Multisite & settings** | Manage network defaults and override permissions, and import or export configurations. |

The complete module definitions are available in [`etc/config.php`](./etc/config.php).

## Requirements

- **PHP 8.0 or newer**
- A **ClassicPress or WordPress installation**
- Administrative permissions; appropriate multisite permissions for network-wide settings

The plugin metadata lists WordPress **4.6** as the minimum version and **6.8.1** as the last tested version. These details do not confirm that every combination of CMS, PHP, and third-party software versions has been tested. Try updates in a staging environment first.

**Node.js and npm are only required for development and testing**, not for running the plugin.

## Installation

1. Download a suitable package from [Releases](https://github.com/Power-Source/psource-branding/releases), or copy the repository contents into:

   ```text
   wp-content/plugins/psource-branding/
   ```

2. Activate **PSOURCE Toolkit** in the plugin administration screen.
3. If needed, activate the plugin network-wide for your multisite installation.
4. Open **CP Toolkit** and configure the modules you want to use.

The JavaScript libraries used at runtime are included in the repository. You do not need to run `npm install` on your web server.

### Your first branding setup

1. **Back up:** Create a backup and, where possible, start on a test installation.
2. **Design:** Begin with the login page, logo, color scheme, and admin footer.
3. **Organize:** Tailor admin menus and dashboard content to your users' tasks.
4. **Communicate:** Configure the sender, email template, and SMTP if needed. Check delivery with a test email.
5. **Review:** Test the interface using the actual user roles you support and on mobile devices.
6. **Reuse:** Export your configuration for other installations.

> **Multisite tip:** Set your network defaults first, then decide which settings individual sites may override.

## Development

### Getting started locally

Clone the repository into the plugins directory of your local installation:

```bash
git clone https://github.com/Power-Source/psource-branding.git
cd psource-branding
npm ci
npm test
```

The JavaScript regression tests require **Node.js 18+**. For development, prefer a current LTS release that also meets the requirements of the installed build dependencies.

### Tests

```bash
npm test
```

The tests use the built-in Node.js test runner, plus jsdom and jQuery for DOM testing. Coverage includes:

- The ACE tokenizer and problematic regular expression inputs
- Safe rendering of select labels and icon names
- Adding, updating, and removing multistrings tags
- HTTP(S) and fragment navigation
- Sanitized HTML notices
- Text rendering of admin bar submenu titles

These tests do not replace full functional testing within ClassicPress or WordPress.

### Synchronizing Shared UI

```bash
npm run sync:shared-ui
```

By default, the script fetches Shared UI from the `main` branch of [`Power-Source/ps-shared-ui`](https://github.com/Power-Source/ps-shared-ui). If the Git source is unavailable, it tries a local fallback.

| Environment variable | Purpose | Default |
| --- | --- | --- |
| `PS_SHARED_UI_GIT_URL` | Git source | `https://github.com/Power-Source/ps-shared-ui.git` |
| `PS_SHARED_UI_REF` | Branch or tag to clone | `main` |
| `PS_SHARED_UI_LOCAL_PATH` | Local source if cloning fails | `../ps-shared-ui` |

> **Important:** Synchronization overwrites files including [`assets/js/shared-ui.js`](./assets/js/shared-ui.js). Local security fixes must also be present in the Shared UI source. Review the diff afterward, run the tests, and update the minified bundle.

### Build and JavaScript bundles

```bash
npm run build
```

This command **synchronizes Shared UI first**, then runs Gulp. The existing [`gulpfile.js`](./gulpfile.js) writes output to `dist/`; it does not automatically replace the separately loaded minified files under `assets/js/`.

For styles, Gulp expects `assets/scss/**/*.scss` and the `sass` Node package. The latter is currently not declared directly in the project. A successful regression test run therefore does not imply that the build will succeed.

To specifically update the loaded Shared UI bundle after a change:

```bash
node <<'NODE'
const fs = require('node:fs');
const uglify = require('uglify-js');
const source = fs.readFileSync('assets/js/shared-ui.js', 'utf8');
const result = uglify.minify(source);
if (result.error) throw result.error;
fs.writeFileSync('assets/js/shared-ui.min.js', result.code + '\n');
NODE

npm test
```

`uglify-js` is installed through the existing `gulp-uglify` dependency.

### Updating DOMPurify

HTML notices are sanitized with **DOMPurify**. The library is loaded locally before Shared UI; no CDN request is required.

When updating the library:

1. Update the `dompurify` dependency and the lockfile.
2. Copy the following files from the installed package into [`external/dompurify/`](./external/dompurify/):
   - `dist/purify.min.js`
   - `dist/purify.min.js.map`
   - `LICENSE`
3. Run `npm test` and check how notices render in the administration interface.

### Project structure

```text
psource-branding/
├── assets/              # Styles, scripts, images, and fonts
├── etc/                 # Configuration and module registration
├── external/            # Locally bundled libraries
├── inc/                 # Plugin classes and modules
├── languages/           # Translation files
├── scripts/             # Helper scripts, including Shared UI sync
├── tests/               # JavaScript and DOM regression tests
├── views/               # Administration and frontend templates
├── psource-branding.php # Plugin entry point and version declaration
└── readme.txt           # Plugin metadata and full changelog
```

## Release notes

The current plugin version is **1.0.5**. Improvements include email template rendering, editor synchronization, and saving settings.

The development changes listed under **Unreleased** include additional DOM and regular expression security fixes, along with regression tests. These changes are not automatically included in an already published package.

See the [changelog](./readme.txt) for the full history.

## Support and contributing

- **Report a bug:** [GitHub Issues](https://github.com/Power-Source/psource-branding/issues)
- **Propose changes:** [Pull Requests](https://github.com/Power-Source/psource-branding/pulls)
- **More projects:** [Power-Source on GitHub](https://github.com/Power-Source)
- **Plugin documentation:** [PSOURCE Toolkit](https://psource.eimen.net/wiki/psource-toolkit-dokumentation/)

For a useful bug report, include your plugin, CMS, and PHP versions, the affected modules, any relevant multisite context, and reproducible steps. Remove credentials and personal information from logs and screenshots.

When contributing code, keep changes focused, add appropriate tests, and update the affected documentation and distributed bundles.

## License

The PHP plugin header and plugin readme declare **GNU GPL Version 2**. Bundled third-party libraries are subject to their respective license notices, such as the [DOMPurify license](./external/dompurify/LICENSE).

Note for contributors: the `license` field in [`package.json`](./package.json) currently specifies `ISC`, which differs from the PHP plugin's license declaration.

---

<div align="center">

**PSOURCE Toolkit** · Developed by [PSOURCE](https://github.com/Power-Source)

A tailored experience starts long before the frontend.

</div>
