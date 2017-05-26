<?php

namespace AppBundle\Controller;

use AppBundle\CommandQuery\Command\ProductCreate;
use AppBundle\Entity\Product;
use AppBundle\Form\Type\ProductType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Admin controller
 *
 * @author    Krzysztof Niziol <krzysztof.niziol@meritoo.pl>
 * @copyright Meritoo.pl
 *
 * @Route("/admin")
 */
class AdminController extends BaseController
{
    /**
     * Adds / creates product
     *
     * @param Request $request The request
     * @return array|RedirectResponse
     *
     * @Route("/new-product", name="app.admin.new_product")
     * @Template()
     */
    public function createProductAction(Request $request)
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /*
             * Let's prepare data of product
             */
            $name = $form
                ->get(ProductType::FIELD_NAME)
                ->getData();

            $description = $form
                ->get(ProductType::FIELD_DESCRIPTION)
                ->getData();

            $price = $form
                ->get(ProductType::FIELD_PRICE)
                ->getData();

            /*
             * ...and handle the "product create" command
             */
            $command = new ProductCreate($name, $description, $price);

            $this
                ->get('command_bus')
                ->handle($command);

            return $this->redirectToRoute('app.product.index');
        }

        return [
            'form' => $form->createView(),
        ];
    }
}
