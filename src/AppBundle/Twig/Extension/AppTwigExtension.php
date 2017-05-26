<?php

namespace AppBundle\Twig\Extension;

use AppBundle\Helper\FormattingHelper;
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
     * Helper used for formatting data.
     * Provides some methods that serves formatting dates, currencies etc.
     *
     * @var FormattingHelper
     */
    private $formattingHelper;

    /**
     * Class constructor
     *
     * @param FormattingHelper $formattingHelper Helper used for formatting data. Provides some methods that serves
     *                                           formatting dates, currencies etc.
     */
    public function __construct(FormattingHelper $formattingHelper)
    {
        $this->formattingHelper = $formattingHelper;
    }

    /**
     * {@inheritdoc}
     */
    public function getFilters()
    {
        $callable = [
            1 => [
                $this->formattingHelper,
                'formatDate',
            ],
            2 => [
                $this->formattingHelper,
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
