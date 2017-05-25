<?php

namespace AppBundle\Helper;

use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * Helper for flash messages.
 * Provides some methods that serves the flash messages.
 *
 * @author    Krzysztof Niziol <krzysztof.niziol@meritoo.pl>
 * @copyright Meritoo.pl
 */
class FlashHelper
{
    /**
     * The Session service
     *
     * @var Session
     */
    private $session;

    /**
     * The Translator service
     *
     * @var TranslatorInterface
     */
    private $translator;

    /**
     * Class constructor
     *
     * @param Session             $session    The session service
     * @param TranslatorInterface $translator The Translator service
     */
    public function __construct(Session $session, TranslatorInterface $translator)
    {
        $this->session = $session;
        $this->translator = $translator;
    }

    /**
     * Adds flash message
     *
     * @param string $message       The message to display. It may be translation key or translated message.
     * @param bool   $positive      (optional) If is set to true, positive flash message will be added / displayed.
     *                              Otherwise - negative.
     * @param string $messageDomain (optional) Translation domain used to translate given message
     * @return $this
     */
    public function add($message, $positive = true, $messageDomain = 'AppBundle')
    {
        $type = 'danger';

        if ($positive) {
            $type = 'success';
        }

        $translated = $this
            ->translator
            ->trans($message, [], $messageDomain);

        $this
            ->session
            ->getFlashBag()
            ->add($type, $translated);

        return $this;
    }
}
