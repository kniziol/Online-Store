<?php

namespace AppBundle\CommandQuery\Command;

use Knp\Component\Pager\Pagination\PaginationInterface;
use SimpleBus\Message\Name\NamedMessage;

/**
 * The "product list" command
 *
 * @author    Krzysztof Niziol <krzysztof.niziol@meritoo.pl>
 * @copyright Meritoo.pl
 */
class ProductList implements NamedMessage
{
    /**
     * Amount of products per one page
     *
     * @var int
     */
    private $perPage;

    /**
     * Current page number.
     * Used for pagination.
     *
     * @var int
     */
    private $pageNumber = 1;

    /**
     * The pagination
     *
     * @var PaginationInterface
     */
    private $pagination;

    /**
     * Class constructor
     *
     * @param int $perPage    Amount of products per one page
     * @param int $pageNumber (optional) Current page number. Used for pagination.
     */
    public function __construct($perPage, $pageNumber = 1)
    {
        $this->perPage = $perPage;
        $this->pageNumber = $pageNumber;
    }

    /**
     * Returns amount of products per one page
     *
     * @return int
     */
    public function getPerPage(): int
    {
        return $this->perPage;
    }

    /**
     * Returns current page number.
     * Used for pagination.
     *
     * @return int
     */
    public function getPageNumber(): int
    {
        return $this->pageNumber;
    }

    /**
     * Returns the pagination
     *
     * @return PaginationInterface
     */
    public function getPagination(): PaginationInterface
    {
        return $this->pagination;
    }

    /**
     * Sets the pagination
     *
     * @param PaginationInterface $pagination The pagination
     * @return ProductList
     */
    public function setPagination(PaginationInterface $pagination): ProductList
    {
        $this->pagination = $pagination;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public static function messageName()
    {
        return 'app.product_list.command';
    }
}
