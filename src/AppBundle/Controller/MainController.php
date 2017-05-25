<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * The main controller
 *
 * @author    Krzysztof Niziol <krzysztof.niziol@meritoo.pl>
 * @copyright Meritoo.pl
 */
class MainController extends BaseController
{
    /**
     * Homepage
     *
     * @return array
     *
     * @Route("/", name="app.homepage")
     * @Template()
     */
    public function indexAction()
    {
        return [];
    }
}
