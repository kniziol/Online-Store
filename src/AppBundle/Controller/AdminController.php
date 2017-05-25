<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

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
     * @Route("/", name="app.admin")
     * @Template()
     */
    public function indexAction()
    {
        return [];
    }
}
