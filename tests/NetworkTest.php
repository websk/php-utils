<?php

declare(strict_types=1);

namespace WebSK\Utils\Tests;

use PHPUnit\Framework\TestCase;
use WebSK\Utils\Network;

final class NetworkTest extends TestCase
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

    public function testIpAndNetworkValidation(): void
    {
        self::assertTrue(Network::isValidIp('203.0.113.10'));
        self::assertFalse(Network::isValidIp('999.0.0.1'));
        self::assertTrue(Network::isValidNetOrIp('192.168.1.0/24'));
        self::assertFalse(Network::isValidNetOrIp('192.168.1.0/33'));
    }

    public function testPortBoundaries(): void
    {
        self::assertTrue(Network::isValidPort(0));
        self::assertTrue(Network::isValidPort(65535));
        self::assertFalse(Network::isValidPort(-1));
        self::assertFalse(Network::isValidPort(65536));
    }

    public function testIpBelongsToOneOfSubnets(): void
    {
        self::assertTrue(Network::checkIpBySubnetMask('192.168.10.25', ['', '10.0.0.0/8', '192.168.10.0/24']));
        self::assertFalse(Network::checkIpBySubnetMask('203.0.113.10', ['10.0.0.0/8', '192.168.0.0/16']));
    }

    public function testClientIpUsesPublicForwardedAddressBeforePrivateNetwork(): void
    {
        $_SERVER['REMOTE_ADDR'] = '10.0.0.10';
        $_SERVER['HTTP_X_FORWARDED_FOR'] = '203.0.113.20,192.168.1.2';

        self::assertSame('203.0.113.20', Network::getClientIpXff());
        self::assertSame('10.0.0.10', Network::getClientIpRemoteAddr());
    }

    public function testRemoteAddressDefaultsToEmptyString(): void
    {
        unset($_SERVER['REMOTE_ADDR']);

        self::assertSame('', Network::getClientIpRemoteAddr());
    }
}
