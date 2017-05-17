<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;

/**
 * Repository for the Product entity
 *
 * @author    Krzysztof Niziol <krzysztof.niziol@meritoo.pl>
 * @copyright Meritoo.pl
 */
class ProductRepository extends EntityRepository
{
    /**
     * Returns query builder used to get all products ordered by creation date (latest at the top)
     *
     * @param bool $queryBuilderOnly (optional) If is set to true, instance of QueryBuilder is returned only (default
     *                               behaviour). Otherwise - products.
     * @return QueryBuilder|array
     */
    public function getAllProducts($queryBuilderOnly = false)
    {
        $alias = 'p';

        $queryBuilder = $this
            ->createQueryBuilder($alias)
            ->addOrderBy(sprintf('%s.createdAt', $alias), 'desc');

        if ($queryBuilderOnly) {
            return $queryBuilder;
        }

        return $queryBuilder
            ->getQuery()
            ->getResult();
    }
}
