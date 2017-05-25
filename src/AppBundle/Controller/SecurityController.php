<?php

namespace AppBundle\Controller;

use AppBundle\Form\Type\LoginType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

/**
 * Security controller
 *
 * @author    Krzysztof Niziol <krzysztof.niziol@meritoo.pl>
 * @copyright Meritoo.pl
 */
class SecurityController extends BaseController
{
    /**
     * The login action.
     * Displays the login form.
     *
     * @param Request $request The request
     * @return array
     *
     * @Route("/login", name="app.login")
     * @Template()
     */
    public function loginAction(Request $request)
    {
        $authenticationUtils = $this->get('security.authentication_utils');

        $lastError = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        $formData = [LoginType::USERNAME_FIELD_NAME => $lastUsername];
        $form = $this->createForm(LoginType::class, $formData);
        $form->handleRequest($request);

        if (!empty($lastError)) {
            $key = $lastError->getMessageKey();
            $domain = 'security_flash_messages';
            $data = $lastError->getMessageData();

            $translated = $this
                ->get('translator')
                ->trans($key, $data, $domain);

            $this
                ->get('session')
                ->getFlashBag()
                ->add('danger', $translated);
        }

        return [
            'last_error' => $lastError,
            'form'       => $form->createView(),
        ];
    }
}
