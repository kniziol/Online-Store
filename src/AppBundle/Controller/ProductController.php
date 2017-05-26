<?php

namespace AppBundle\Controller;

use AppBundle\CommandQuery\Command\ProductList;
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
        $command = new ProductList($perPage, $page);

        $this
            ->get('command_bus')
            ->handle($command);

        /* @var $pagination SlidingPagination */
        $pagination = $command->getPagination();

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
