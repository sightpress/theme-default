<?php

declare(strict_types=1);

namespace SightPress\ThemeDefault;

use SightPress\Theme\LayoutDefinition;
use SightPress\Theme\ThemeInterface;
use SightPress\Theme\ThemeManifest;
use SightPress\Theme\ThemePaths;
use SightPress\Theme\ThemeRequirement;

/**
 * The default theme of SightPress. Every install has it, and every site falls back on it when its own theme is
 * missing. Its files (theme.json, templates/, assets/) are in the package's root folder.
 */
final class DefaultTheme implements ThemeInterface
{
    public const string ID = 'default';

    /** The theme's version; release-please keeps it equal to the package's and to theme.json's. */
    public const string VERSION = '0.1.0'; // x-release-please-version

    public function manifest(): ThemeManifest
    {
        return new ThemeManifest(
            id: self::ID,
            name: 'SightPress Default',
            description: 'Calm greys and a strong blue on white, with large, readable type. Accessible in light and dark mode, with more contrast and in forced colours.',
            version: self::VERSION,
            requires: new ThemeRequirement('^0.2'),
            layouts: LayoutDefinition::required(),
            rightToLeft: true,
            author: 'SightPress',
            licence: 'GPL-3.0-or-later',
            previewDescription: 'A light grey top bar with the site name in bold and a row of underlined blue links, then a light grey band with a large bold heading, a line of grey text and a solid blue Download button, and below it a white page with dark text, bold headings and blue underlined links.',
        );
    }

    public function paths(): ThemePaths
    {
        return new ThemePaths(dirname(__DIR__));
    }
}
