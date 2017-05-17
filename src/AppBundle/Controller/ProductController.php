<?php

namespace AppBundle\Controller;

use Knp\Bundle\PaginatorBundle\Pagination\SlidingPagination;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Products' controller
 *
 * @author    Krzysztof Niziol <krzysztof.niziol@meritoo.pl>
 * @copyright Meritoo.pl
 *
 * @Route("/product")
 */
class ProductController extends BaseController
{
    /**
     * List of products
     *
     * @param int $page (optional) Current page number. Used for pagination.
     * @return array
     *
     * @Route(
     *     "/{page}",
     *     name="app.product.index",
     *     requirements={
     *          "page": "\d+"
     *     },
     *     defaults={
     *          "page": 1
     *     }
     * )
     *
     * @Template()
     */
    public function indexAction($page = 1)
    {
        $perPage = $this->getParameter('knp_paginator.page_range');

        /* @var $pagination SlidingPagination */
        $pagination = $this
            ->get('app.product.helper')
            ->getProductsPagination($perPage, $page);

        /*
         * Oops, there is not such page
         */
        if ($page > $pagination->getPageCount()) {
            throw $this->createNotFoundException();
        }

        return [
            'pagination' => $pagination,
        ];
    }
}
