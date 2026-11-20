<?php

declare(strict_types=1);

namespace SightPress\ThemeDefault\Tests\Integration;

use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\TestCase;
use SightPress\Core\Theme\ThemeLoader;
use SightPress\Core\Theme\ThemeValidator;
use SightPress\ThemeDefault\DefaultTheme;

/**
 * Core's own checks pass on the theme: theme.json loads and every colour pair has enough contrast in every mode.
 */
#[CoversNothing]
final class ValidateThemeTest extends TestCase
{
    public function testCoreAcceptsTheTheme(): void
    {
        $theme = new ThemeLoader()->load(new DefaultTheme()->paths()->root);
        $result = new ThemeValidator()->validate($theme);

        self::assertSame([], array_map(static fn ($issue): string => $issue->message, $result->issues));
        self::assertTrue($result->passes());
    }
}
