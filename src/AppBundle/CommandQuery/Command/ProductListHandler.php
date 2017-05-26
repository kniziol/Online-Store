<?php

namespace AppBundle\CommandQuery\Command;

use AppBundle\Entity\Product;
use Doctrine\ORM\EntityManager;
use Knp\Component\Pager\Paginator;

/**
 * Handler for the "product list" command
 *
 * @author    Krzysztof Niziol <krzysztof.niziol@meritoo.pl>
 * @copyright Meritoo.pl
 */
class ProductListHandler
{
    /**
     * The central access point to ORM functionality
     *
     * @var EntityManager
     */
    private $entityManager;

    /**
     * The Knp Paginator
     *
     * @var Paginator
     */
    private $knpPaginator;

    /**
     * Class constructor
     *
     * @param EntityManager $entityManager The central access point to ORM functionality
     * @param Paginator     $knpPaginator  The Knp Paginator
     */
    public function __construct($entityManager, $knpPaginator)
    {
        $this->entityManager = $entityManager;
        $this->knpPaginator = $knpPaginator;
    }

    /**
     * Handles the command.
     * Prepares products that will be listed.
     *
     * @param ProductList $command The "product list" command
     */
    public function handle(ProductList $command)
    {
        $pageNumber = $command->getPageNumber();
        $perPage = $command->getPerPage();

        $queryBuilder = $this
            ->entityManager
            ->getRepository(Product::class)
            ->getAllProducts();

        $pagination = $this
            ->knpPaginator
            ->paginate($queryBuilder, $pageNumber, $perPage);

        $command->setPagination($pagination);
    }
}
