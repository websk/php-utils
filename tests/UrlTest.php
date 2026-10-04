<?php

declare(strict_types=1);

namespace WebSK\Utils\Tests;

use PHPUnit\Framework\TestCase;
use WebSK\Utils\Url;

final class UrlTest extends TestCase
{
    private array $server;

    protected function setUp(): void
    {
        $this->server = $_SERVER;
    }

    protected function tearDown(): void
    {
        $_SERVER = $this->server;
    }

    public function testGetUriWithoutQueryString(): void
    {
        $_SERVER['REQUEST_URI'] = '/catalog/item?page=2&sort=name';

        self::assertSame('/catalog/item', Url::getUriNoQueryString());
    }

    public function testGetUriReturnsEmptyStringWhenRequestUriIsMissing(): void
    {
        unset($_SERVER['REQUEST_URI']);

        self::assertSame('', Url::getUriNoQueryString());
    }

    public function testUrlConstructionHelpers(): void
    {
        self::assertSame('/catalog', Url::appendLeadingSlash('catalog'));
        self::assertSame('http://example.com', Url::appendHttp('example.com'));
        self::assertSame('api/v1/users', Url::buildUrl(['/api/', '/v1/', '/users/']));
    }

    public function testUrlValidationAllowsOnlyHttpAndHttps(): void
    {
        self::assertTrue(Url::validateUrlWithScheme('https://example.com/path'));
        self::assertTrue(Url::validateUrlWithScheme('http://example.com'));
        self::assertFalse(Url::validateUrlWithScheme('ftp://example.com/file'));
        self::assertFalse(Url::validateUrlWithScheme('not a url'));
    }

    public function testFilterUrlsPreservesOnlyValidUrls(): void
    {
        self::assertSame(
            [0 => 'https://example.com', 2 => 'http://example.org/path'],
            Url::filterUrls(['https://example.com', 'invalid', 'http://example.org/path'])
        );
    }
}
