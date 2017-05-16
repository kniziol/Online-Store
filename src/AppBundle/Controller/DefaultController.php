<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * The default / main controller
 *
 * @author    Krzysztof Niziol <krzysztof.niziol@meritoo.pl>
 * @copyright Meritoo.pl
 */
class DefaultController extends BaseController
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
