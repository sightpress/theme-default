# SightPress default theme

The default theme of SightPress, a powerful CMS for everyone, designed with blind and low-vision creators and
audiences in mind, built on modern, object-oriented PHP.

Every SightPress install has this theme, and every site falls back on it when its own theme is missing. It meets
WCAG 2.2 AA in light and dark mode, with "more contrast" and in forced colours (Windows contrast themes). It reflows
at 320 pixels and at 400% zoom, and honours reduced motion.

## What's in it

- `theme.json`: the design tokens. They cover colours for light and dark mode (with "more contrast" overrides),
  chart colours, typography, spacing, radius and the focus ring, plus the colour pairs whose contrast core checks.
- `templates/`: the Twig templates. These are the shell (`master.html.twig`), the layouts `default`, `home` and
  `search`, the standard layouts `landing`, `sidebar` (with a side column for the pages in a section) and
  `full-width`, and accessible partials: messages, the search form, buttons, alerts, cards, a dialog, a disclosure,
  pagination and tables.
- `assets/`: the stylesheet (`css/site.css`) and a small script (`js/site.js`) that only enhances pages that already
  work without it.
- `src/DefaultTheme.php`: the theme class core finds through `extra.sightpress.theme`. It implements
  `ThemeInterface` from [theme-interface](https://github.com/sightpress/theme-interface).

The theme is presentation only: it registers no services, routes or commands.

## What it looks like

The theme ships no screenshot. Every picture of it is made from its preview page: one page with every kind of
block, built by `theme:preview`. Each release has the preview (a zip that opens offline) and its screenshots
attached, and every pull request gets the same preview as a download and a comment.

In words: a light grey top bar with the site name in bold and a row of underlined blue links. Below it is a light
grey band with a large bold heading, a line of grey text and a solid blue Download button. The rest is a white page
with dark text, bold headings and blue underlined links.

## Requirements

- PHP 8.5 or later
- `sightpress/theme-interface` 0.2

## Development

Core is a dev dependency, used for the theme checks and the preview.

```sh
composer install
composer check     # code style, PHPStan, tests with the 100% coverage gate, and theme:validate
composer preview   # writes build/theme-preview/default/; open index.html in any browser
```

`composer preview -- --screenshot` also writes the screenshots, if Node.js and Playwright's Chromium are installed
(`npx playwright install chromium`). `build/` is never committed.

If your PHP has no coverage extension, use the development image from the
[core](https://github.com/sightpress/core) repo (`docker/dev-php/`).

### Continuous integration

- **CI** (`composer check`) runs on every pull request and on every push to `main`.
- **Theme preview** runs on every pull request. It uploads the preview page with its screenshots and axe report as one
  artifact, and keeps one comment on the pull request up to date with the download link, the description above and
  the accessibility result.
- **Release Please** keeps a release pull request open. Merging it tags the release and attaches the preview and the
  screenshots to it.

## Contributing

Everyone can help, not only developers. See [CONTRIBUTING.md](CONTRIBUTING.md) and the
[Code of Conduct](CODE_OF_CONDUCT.md).

## Licence

GNU General Public License v3.0 or later. See [LICENSE](LICENSE).
