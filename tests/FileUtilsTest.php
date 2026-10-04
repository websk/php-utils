<?php

declare(strict_types=1);

namespace WebSK\Utils\Tests;

use PHPUnit\Framework\Attributes\PreserveGlobalState;
use PHPUnit\Framework\Attributes\RunInSeparateProcess;
use PHPUnit\Framework\TestCase;
use WebSK\Utils\FileUtils;

final class FileUtilsTest extends TestCase
{
    private string $temporaryDirectory;

    protected function setUp(): void
    {
        $this->temporaryDirectory = sys_get_temp_dir() . '/php-utils-' . bin2hex(random_bytes(8));
        mkdir($this->temporaryDirectory, 0777, true);
    }

    protected function tearDown(): void
    {
        FileUtils::deleteDir($this->temporaryDirectory);
    }

    #[RunInSeparateProcess]
    #[PreserveGlobalState(false)]
    public function testRenderFileContentOutputsExistingFile(): void
    {
        $path = $this->temporaryDirectory . '/example.txt';
        file_put_contents($path, 'PHP 8.5');

        $this->expectOutputString('PHP 8.5');

        FileUtils::renderFileContent($path);
    }

    public function testRenderFileContentIgnoresMissingFile(): void
    {
        $this->expectOutputString('');

        FileUtils::renderFileContent($this->temporaryDirectory . '/missing.txt');
    }

    public function testDeleteDirRemovesNestedDirectory(): void
    {
        $nestedDirectory = $this->temporaryDirectory . '/first/second';
        mkdir($nestedDirectory, 0777, true);
        file_put_contents($nestedDirectory . '/file.txt', 'content');

        FileUtils::deleteDir($this->temporaryDirectory . '/first');

        self::assertDirectoryDoesNotExist($this->temporaryDirectory . '/first');
    }

    public function testCheckFileNameAcceptsOnlySupportedCharacters(): void
    {
        self::assertTrue(FileUtils::checkFileName('valid_file-123'));
        self::assertFalse(FileUtils::checkFileName('invalid file.php'));
    }
}
