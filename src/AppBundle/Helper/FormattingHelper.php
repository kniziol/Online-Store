<?php

namespace AppBundle\Helper;

use DateTime;
use IntlDateFormatter;
use NumberFormatter;

/**
 * Helper used for formatting data.
 * Provides some methods that serves formatting dates, currencies etc.
 *
 * @author    Krzysztof Niziol <krzysztof.niziol@meritoo.pl>
 * @copyright Meritoo.pl
 */
class FormattingHelper
{
    /**
     * Locale of application in ISO format (locale that uses ISO-639-1 and ISO-3166 standard).
     * Defined in configuration.
     *
     * @var string
     */
    private $locale;

    /**
     * Class constructor
     *
     * @param string $locale Locale of application in ISO format (locale that uses ISO-639-1 and ISO-3166 standard).
     *                       Defined in configuration.
     */
    public function __construct($locale)
    {
        $this->locale = $locale;
    }

    /**
     * Returns formatted date (with or without time)
     *
     * @param int|DateTime $date        The date to format
     * @param bool         $withoutTime (optional) If is set to true, date without time is returend. Otherwise - with.
     * @return bool|string
     */
    public function formatDate($date, $withoutTime = false)
    {
        $dateType = IntlDateFormatter::MEDIUM;
        $timeType = IntlDateFormatter::MEDIUM;

        if ($withoutTime) {
            $timeType = IntlDateFormatter::NONE;
        }

        return IntlDateFormatter::create($this->locale, $dateType, $timeType)->format($date);
    }

    /**
     * Returns formatted value with currency
     *
     * @param float $value The date to format
     * @return string
     */
    public function formatCurrency($value)
    {
        $formatter = NumberFormatter::create($this->locale, NumberFormatter::CURRENCY);
        $currencyCode = $formatter->getTextAttribute(NumberFormatter::CURRENCY_CODE);

        return NumberFormatter::create($this->locale, NumberFormatter::CURRENCY)->formatCurrency($value, $currencyCode);
    }
}
