<?php

declare(strict_types=1);

namespace WebSK\Utils\Tests;

use PHPUnit\Framework\Attributes\PreserveGlobalState;
use PHPUnit\Framework\Attributes\RunInSeparateProcess;
use PHPUnit\Framework\TestCase;
use WebSK\Utils\Messages;

final class MessagesTest extends TestCase
{
    private array $cookies;

    protected function setUp(): void
    {
        $this->cookies = $_COOKIE;
    }

    protected function tearDown(): void
    {
        $_COOKIE = $this->cookies;
    }

    #[RunInSeparateProcess]
    #[PreserveGlobalState(false)]
    public function testRenderMessagesFromCookie(): void
    {
        $_COOKIE[Messages::MESSAGES_COOKIE_NAME] = json_encode([
            Messages::MESSAGE_TYPE_ERROR => ['First', 'Second'],
            Messages::MESSAGE_TYPE_SUCCESS => ['Saved'],
        ], JSON_THROW_ON_ERROR);

        self::assertSame(
            '<p class="alert alert-danger flash-danger">First<br>Second</p>'
            . '<p class="alert alert-success flash-success">Saved</p>',
            Messages::renderMessages()
        );
    }

    #[RunInSeparateProcess]
    #[PreserveGlobalState(false)]
    public function testMalformedCookieProducesNoMessages(): void
    {
        $_COOKIE[Messages::MESSAGES_COOKIE_NAME] = '{invalid json';

        self::assertSame('', Messages::renderMessages());
    }
}
