<?php

namespace WebSK\Utils;

/**
 * Class DateTime
 * @package WebSK\Utils
 */
class DateTime
{
    const int DAY_FULL = 1;
    const int DAY_SHORT = 2;
    const int DAY_NO = 3;

    const int MONTH_SHORT = 1;
    const int MONTH_FULL = 2;
    const int MONTH_DIGIT = 3;
    const int MONTH_NODAY = 4;

    const int YEAR_DISPLAY_AUTO = 1;
    const int YEAR_DISPLAY_SHOW = 2;
    const int YEAR_DISPLAY_HIDE = 3;

    const int YEAR_SHORT = 1;
    const int YEAR_FULL = 2;
    const int YEAR_NO = 3;

    const int TIME_DISPLAY_SHOW = 1;
    const int TIME_DISPLAY_HIDE = 2;

    /**
     * @param string $date
     * @param int $month_format
     * @param int $year_format
     * @param string $separator
     * @return string
     */
    public static function format(string $date, int $month_format, int $year_format, string $separator = ' '): string
    {
        $months_formats =
            array(
                self::MONTH_SHORT => array(
                    'янв',
                    'фев',
                    'мар',
                    'апр',
                    'мая',
                    'июн',
                    'июл',
                    'авг',
                    'сен',
                    'окт',
                    'ноя',
                    'дек'
                ),
                self::MONTH_FULL => array(
                    'января',
                    'февраля',
                    'марта',
                    'апреля',
                    'мая',
                    'июня',
                    'июля',
                    'августа',
                    'сентября',
                    'октября',
                    'ноября',
                    'декабря'
                ),
                self::MONTH_DIGIT => ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'],
            );

        $matches = [];

        preg_match('#(?P<year>\d{4})(?P<month>\d{2})(?P<day>\d{2})#', $date, $matches);

        if ($matches) {
            $ret = (int)$matches['day'];

            $ret .= ' ' . $months_formats[$month_format][(int)$matches['month'] - 1];

            switch ($year_format) {
                case self::YEAR_FULL:
                    $ret .= $separator . $matches['year'];
                    break;
                case self::YEAR_SHORT:
                    $ret .= $separator . substr($matches['year'], 2, 2);
                    break;
            }

            return $ret;
        }

        return '';
    }

    /**
     * Форматирует дату и время. Принимает unix time. По-умолчанию отдает дату в формате "20 апр".
     * Можно указать флаги форматирования дня (day_format), месяца (month_format) и года (year_format), разделитель (separator).
     * По-умолчанию год не выводится, force_year разрешает вывод года
     * @param ?int $unix_ts
     * @param int $day_format
     * @param int $month_format
     * @param int $year_display
     * @param int $year_format
     * @param string $separator
     * @param int $time_display
     * @return string
     */
    public static function formatFromUnixTs(
        ?int $unix_ts = null,
        int $day_format = self::DAY_FULL,
        int $month_format = self::MONTH_SHORT,
        int $year_display = self::YEAR_DISPLAY_AUTO,
        int $year_format = self::YEAR_FULL,
        string $separator = ' ',
        int $time_display = self::TIME_DISPLAY_HIDE
    ): string {
        $months_formats =
            array(
                self::MONTH_SHORT => array(
                    'янв',
                    'фев',
                    'мар',
                    'апр',
                    'мая',
                    'июня',
                    'июля',
                    'авг',
                    'сен',
                    'окт',
                    'ноя',
                    'дек'
                ),
                self::MONTH_FULL => array(
                    'января',
                    'февраля',
                    'марта',
                    'апреля',
                    'мая',
                    'июня',
                    'июля',
                    'августа',
                    'сентября',
                    'октября',
                    'ноября',
                    'декабря'
                ),
                self::MONTH_DIGIT => array('01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'),
                self::MONTH_NODAY => array(
                    'январь',
                    'февраль',
                    'март',
                    'апрель',
                    'май',
                    'июнь',
                    'июль',
                    'август',
                    'сентябрь',
                    'октябрь',
                    'ноябрь',
                    'декабрь'
                ),
            );

        if (!$unix_ts) {
            $unix_ts = time();
        }

        $formated_time_str = '';

        if ($day_format == self::DAY_FULL) {
            $formated_time_str = date('d', $unix_ts);
        }

        if ($day_format == self::DAY_SHORT) {
            $formated_time_str = date('j', $unix_ts);
        }

        if ($day_format == self::DAY_NO && $month_format != self::MONTH_SHORT) {
            $month_format = self::MONTH_NODAY;
        }

        $formated_time_str .= $separator . $months_formats[$month_format][(int)date('m', $unix_ts) - 1];

        if (($year_display == self::YEAR_DISPLAY_SHOW)
            || ((date('Y', $unix_ts) != date('Y')) && $year_display == self::YEAR_DISPLAY_AUTO)
        ) {
            switch ($year_format) {
                case self::YEAR_FULL:
                    $formated_time_str .= $separator . date('Y', $unix_ts);
                    break;
                case self::YEAR_SHORT:
                    $formated_time_str .= $separator . date('y', $unix_ts);
                    break;
            }
        }

        if ($time_display == self::TIME_DISPLAY_SHOW) {
            $formated_time_str .= ' ' . date('H', $unix_ts) . ':' . date('i', $unix_ts);
        }

        return $formated_time_str;
    }

    /**
     * @param int $time_first
     * @param int $time_second
     * @return int
     */
    public static function getDeltaMinutesFromTwoUnixTimes(int $time_first, int $time_second): int
    {
        $delta = $time_second - $time_first;
        $min = intval(($delta) / 60);

        return $min;
    }

    /**
     * @param int $unix_ts
     * @return string
     */
    public static function getDateTimeStr(int $unix_ts): string
    {
        $output = "";

        $months_ru = array(
            'dud',
            'января',
            'февраля',
            'марта',
            'апреля',
            'мая',
            'июня',
            'июля',
            'августа',
            'сентября',
            'октября',
            'ноября',
            'декабря'
        );

        $dv = getdate($unix_ts);
        $dvt = getdate(); // today

        $is_today = false;

        if (($dv['year'] == $dvt['year']) && ($dv['mon'] == $dvt['mon']) && ($dv['mday'] == $dvt['mday'])) {
            $is_today = true;
        }

        $hours = $dv['hours'];
        if ($hours < 10) {
            $hours = "0" . $hours;
        }

        $minutes = $dv['minutes'];
        if ($minutes < 10) {
            $minutes = "0" . $minutes;
        }

        if (!$is_today) {
            $output .= $dv['mday'] . " " . $months_ru[$dv['mon']];
            if ($dv['year'] != $dvt['year']) {
                $output .= " " . $dv['year'];
            }

            $output .= " ";
        }

        $output .= $hours . ":" . $minutes;

        return $output;
    }

    /**
     * @param $timestamp
     * @param \DateTimeZone|null $timezone_obj
     * @return \DateTime
     */
    public static function createFromTimestamp($timestamp, ?\DateTimeZone $timezone_obj = null): \DateTime
    {
        $time_format = strpos($timestamp, '.') === false ? 'U' : 'U.u';
        $datetime_obj = \DateTime::createFromFormat($time_format, $timestamp);
        if (!$timezone_obj) {
            /**
             * @see https://php.net/manual/en/datetime.createfromformat.php Note for timezone param
             * The timezone parameter and the current timezone are ignored when the time parameter either contains a
             * UNIX timestamp (e.g. 946684800) or specifies a timezone (e.g. 2010-01-28T15:00:00+02:00).
             */
            $timezone_obj = new \DateTimeZone(date_default_timezone_get());
        }

        $datetime_obj->setTimezone($timezone_obj);

        return $datetime_obj;
    }
}
