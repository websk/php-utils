<?php

declare(strict_types=1);

namespace WebSK\Utils\Tests;

use DateTimeZone;
use PHPUnit\Framework\TestCase;
use WebSK\Utils\DateTime;

final class DateTimeTest extends TestCase
{
    private string $originalTimezone;

    protected function setUp(): void
    {
        $this->originalTimezone = date_default_timezone_get();
        date_default_timezone_set('UTC');
    }

    protected function tearDown(): void
    {
        date_default_timezone_set($this->originalTimezone);
    }

    public function testFormatSupportsFullAndShortYear(): void
    {
        self::assertSame('5 января 2024', DateTime::format('20240105', DateTime::MONTH_FULL, DateTime::YEAR_FULL));
        self::assertSame('5 01/24', DateTime::format('20240105', DateTime::MONTH_DIGIT, DateTime::YEAR_SHORT, '/'));
        self::assertSame('', DateTime::format('invalid', DateTime::MONTH_FULL, DateTime::YEAR_FULL));
    }

    public function testFormatFromUnixTimestampIsDeterministic(): void
    {
        $timestamp = 1704456300; // 2024-01-05 12:05:00 UTC

        self::assertSame(
            '05 января 2024 12:05',
            DateTime::formatFromUnixTs(
                $timestamp,
                DateTime::DAY_FULL,
                DateTime::MONTH_FULL,
                DateTime::YEAR_DISPLAY_SHOW,
                DateTime::YEAR_FULL,
                ' ',
                DateTime::TIME_DISPLAY_SHOW
            )
        );
    }

    public function testCreateFromIntegerTimestampUsesRequestedTimezone(): void
    {
        $date = DateTime::createFromTimestamp('1704067200', new DateTimeZone('Europe/Moscow'));

        self::assertSame('2024-01-01 03:00:00.000000 +03:00', $date->format('Y-m-d H:i:s.u P'));
    }

    public function testCreateFromFractionalTimestampPreservesMicroseconds(): void
    {
        $date = DateTime::createFromTimestamp('1704067200.123456', new DateTimeZone('UTC'));

        self::assertSame('2024-01-01 00:00:00.123456 +00:00', $date->format('Y-m-d H:i:s.u P'));
    }

    public function testDeltaMinutesTruncatesPartialMinute(): void
    {
        self::assertSame(2, DateTime::getDeltaMinutesFromTwoUnixTimes(100, 249));
    }
}
