<?php

namespace AppBundle\Twig\Extension;

use DateTime;
use IntlDateFormatter;
use NumberFormatter;
use Twig_Extension;
use Twig_SimpleFilter;
use Twig_SimpleFunction;

/**
 * The main Twig Extension related of application
 *
 * @author    Krzysztof Niziol <krzysztof.niziol@meritoo.pl>
 * @copyright Meritoo.pl
 */
class AppTwigExtension extends Twig_Extension
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
     * {@inheritdoc}
     */
    public function getFilters()
    {
        $callable = [
            1 => [
                $this,
                'formatDate',
            ],
            2 => [
                $this,
                'formatCurrency',
            ],
            3 => [
                $this,
                'getPaginatedItemNumber',
            ],
        ];

        return [
            new Twig_SimpleFilter('app_date_format', $callable[1]),
            new Twig_SimpleFilter('app_currency_format', $callable[2]),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        $callable = [
            1 => [
                $this,
                'getPaginatedItemNumber',
            ],
        ];

        return [
            new Twig_SimpleFunction('app_paginated_item_number', $callable[1]),
        ];
    }

    /**
     * Returns formatted date (with or without time)
     *
     * @param int | DateTime $date        The date to format
     * @param bool           $withoutTime (optional) If is set to true, date without time is returend. Otherwise - with.
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

    /**
     * Returns number of item that is part of paginated set
     *
     * @param int $itemPosition Position of the item in set
     * @param int $perPage      Amount of items on one page
     * @param int $pageNumber   (optional) Current number of page
     * @return mixed
     */
    public function getPaginatedItemNumber($itemPosition, $perPage, $pageNumber = 1)
    {
        return $itemPosition + $perPage * ($pageNumber - 1);
    }
}
