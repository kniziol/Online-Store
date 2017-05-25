<?php

namespace AppBundle\Helper;

use AppBundle\Entity\Product;
use Doctrine\ORM\EntityManager;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\Paginator;

/**
 * Helper related to the Product entity
 *
 * @author    Krzysztof Niziol <krzysztof.niziol@meritoo.pl>
 * @copyright Meritoo.pl
 */
class ProductHelper
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
     * Returns products for pagination
     *
     * @param int $perPage    Amount of items on one page
     * @param int $pageNumber (optional) Current number of page
     * @return PaginationInterface
     */
    public function getProductsPagination($perPage, $pageNumber = 1)
    {
        $queryBuilder = $this
            ->entityManager
            ->getRepository(Product::class)
            ->getAllProducts();

        return $this
            ->knpPaginator
            ->paginate($queryBuilder, $pageNumber, $perPage);
    }

    /**
     * Creates a product
     *
     * @param Product $product The product to create
     * @return $this
     */
    public function createProduct(Product $product)
    {
        $this->entityManager->persist($product);
        $this->entityManager->flush();

        return $this;
    }
}
