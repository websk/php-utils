<?php

declare(strict_types=1);

namespace WebSK\Utils\Tests;

use PHPUnit\Framework\TestCase;
use WebSK\Utils\Sanitize;
use WebSK\Utils\Transliteration;

final class SanitizeAndTransliterationTest extends TestCase
{
    public function testNullableHtmlValuesAndSpecialCharacters(): void
    {
        self::assertSame('', Sanitize::sanitizeTagContent(null));
        self::assertSame('&lt;strong&gt;Привет&lt;/strong&gt;', Sanitize::sanitizeTagContent('<strong>Привет</strong>'));
        self::assertSame('', Sanitize::sanitizeAttrValue(null));
        self::assertSame('&quot;quoted&quot; &amp; &apos;single&apos;', Sanitize::sanitizeAttrValue('"quoted" & \'single\''));
    }

    public function testSqlColumnNameKeepsOnlySafeCharacters(): void
    {
        self::assertSame('usersname1', Sanitize::sanitizeSqlColumnName('users.name #1'));
    }

    public function testTransliterationHandlesUtf8AndPunctuation(): void
    {
        self::assertSame('privet-mir', Transliteration::transliteration('Привет, мир!', false));
        self::assertSame('yozh-no-5', Transliteration::transliteration('Ёж № 5', false));
    }

    public function testTransliterationCanRemoveEnglishStopWords(): void
    {
        self::assertSame('cat-dog', Transliteration::transliteration('The cat with dog'));
        self::assertSame('the-cat-with-dog', Transliteration::transliteration('The cat with dog', false));
    }

    public function testRussianTextDetection(): void
    {
        self::assertTrue(Transliteration::checkRussian('Привет, мир!'));
        self::assertFalse(Transliteration::checkRussian('Hello world'));
        self::assertFalse(Transliteration::checkRussian('Привет world'));
    }
}
