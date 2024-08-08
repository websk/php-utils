<?php

namespace WebSK\Utils;

/**
 * Class Filter
 * @package WebSK\Utils
 */
class Filter
{
    /** @var bool */
    public bool $is_positive = false;

    /** @var bool */
    public bool $is_negative = false;

    /** @var string */
    public string $mask = '';

    /** @var string */
    public string $sign = '';

    /** @var string */
    public string $target_url = '';

    /**
     * Filter constructor.
     * @param string $filter_str
     */
    public function __construct(string $filter_str)
    {
        $this->sign = substr($filter_str, 0, 1);

        if ($this->sign == '+') {
            $this->is_positive = true;
        }

        if ($this->sign == '-') {
            $this->is_negative = true;
        }

        $mask_source = substr($filter_str, 2);
        $mask_source_arr = explode('=>', $mask_source);

        $this->mask = $mask_source_arr[0];

        if (array_key_exists(1, $mask_source_arr)) {
            $this->target_url = $mask_source_arr[1];
        }
    }

    /**
     * @param string $real_url
     * @return bool
     */
    public function matchesPage(string $real_url = ''): bool
    {
        $page_url = Url::getUriNoQueryString();

        if ($real_url != '') {
            $page_url = $real_url;
        }

        $mask = '@' . $this->mask . '@';
        if (preg_match($mask, $page_url)) {
            return true;
        }

        return false;
    }
}
