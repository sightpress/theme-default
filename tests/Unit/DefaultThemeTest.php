<?php

declare(strict_types=1);

namespace SightPress\ThemeDefault\Tests\Unit;

use Opis\JsonSchema\Validator;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use SightPress\Theme\LayoutDefinition;
use SightPress\Theme\Template\RequiredTemplates;
use SightPress\Theme\ThemeSchema;
use SightPress\ThemeDefault\DefaultTheme;

#[CoversClass(DefaultTheme::class)]
final class DefaultThemeTest extends TestCase
{
    public function testItsManifestDescribesTheDefaultTheme(): void
    {
        $manifest = new DefaultTheme()->manifest();

        self::assertSame('default', $manifest->id);
        self::assertSame('SightPress Default', $manifest->name);
        self::assertSame(DefaultTheme::VERSION, $manifest->version);
        self::assertSame('^0.2', $manifest->requires->constraint);
        self::assertSame(LayoutDefinition::REQUIRED, array_map(static fn (LayoutDefinition $layout): string => $layout->id, $manifest->layouts));
        self::assertTrue($manifest->rightToLeft);
        self::assertNotNull($manifest->previewDescription);
        self::assertNull($manifest->screenshot);
        self::assertEquals($manifest, new DefaultTheme()->manifest());
    }

    public function testThemeJsonMatchesTheSchemaAndTheManifest(): void
    {
        $file = new DefaultTheme()->paths()->tokensFile();
        $json = (string) file_get_contents($file);
        $validator = new Validator();
        $validator->resolver()?->registerFile(ThemeSchema::ID, ThemeSchema::file());

        self::assertTrue($validator->validate(json_decode($json, false, 32, JSON_THROW_ON_ERROR), ThemeSchema::ID)->isValid());
        /** @var array{name: string, version: string} $data */
        $data = json_decode($json, true, 32, JSON_THROW_ON_ERROR);
        self::assertSame(DefaultTheme::ID, $data['name']);
        self::assertSame(DefaultTheme::VERSION, $data['version']);
    }

    /**
     * @return iterable<string, array{string}>
     */
    public static function requiredTemplates(): iterable
    {
        foreach (RequiredTemplates::files() as $file) {
            yield $file => [$file];
        }
    }

    #[DataProvider('requiredTemplates')]
    public function testEveryRequiredTemplateIsThere(string $file): void
    {
        self::assertFileExists(new DefaultTheme()->paths()->templates() . '/' . $file);
    }

    public function testTheThemeShipsNoScreenshotOrPreviewOutput(): void
    {
        $root = new DefaultTheme()->paths()->root;
        foreach (['templates', 'assets'] as $folder) {
            $files = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($root . '/' . $folder, \FilesystemIterator::SKIP_DOTS));
            foreach ($files as $entry) {
                self::assertInstanceOf(\SplFileInfo::class, $entry);
                self::assertDoesNotMatchRegularExpression('/^screenshot|^page\.png$/i', $entry->getFilename());
            }
        }
    }
}
