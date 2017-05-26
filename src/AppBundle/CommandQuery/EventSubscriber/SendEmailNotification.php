<?php

namespace AppBundle\CommandQuery\EventSubscriber;

use AppBundle\CommandQuery\Event\ProductCreated;
use AppBundle\Helper\FormattingHelper;
use Swift_Mailer;
use Swift_Message;
use Symfony\Bundle\TwigBundle\TwigEngine;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * Subscriber for the "product created" event / message.
 * Sends e-mail notification.
 *
 * @author    Krzysztof Niziol <krzysztof.niziol@meritoo.pl>
 * @copyright Meritoo.pl
 */
class SendEmailNotification
{
    /**
     * E-mail address used as the "from" e-mail.
     * Defined in configuration.
     *
     * @var string
     */
    private $fromEmail;

    /**
     * The mailer service used to send e-mails
     *
     * @var Swift_Mailer
     */
    private $mailer;

    /**
     * The Translator service
     *
     * @var TranslatorInterface
     */
    private $translator;

    /**
     * Engine that renders Twig templates
     *
     * @var TwigEngine
     */
    private $templating;

    /**
     * Helper used for formatting data.
     * Provides some methods that serves formatting dates, currencies etc.
     *
     * @var FormattingHelper
     */
    private $formattingHelper;

    /**
     * Class constructor
     *
     * @param string              $fromEmail        E-mail address used as the "from" e-mail. Defined in configuration.
     * @param Swift_Mailer        $mailer           The mailer service used to send e-mails
     * @param TranslatorInterface $translator       The Translator service
     * @param TwigEngine          $templating       Engine that renders Twig templates
     * @param FormattingHelper    $formattingHelper Helper used for formatting data. Provides some methods that serves
     *                                              formatting dates, currencies etc.
     */
    public function __construct($fromEmail, Swift_Mailer $mailer, TranslatorInterface $translator, TwigEngine $templating, FormattingHelper $formattingHelper)
    {
        $this->fromEmail = $fromEmail;
        $this->mailer = $mailer;
        $this->translator = $translator;
        $this->templating = $templating;
        $this->formattingHelper = $formattingHelper;
    }

    /**
     * Handles the event
     *
     * @param ProductCreated $event The "product created" event / message
     */
    public function handle(ProductCreated $event)
    {
        $product = $event->getProduct();

        /*
         * Product wasn't saved?
         * Nothing to do
         */
        if ($product->getId() === null) {
            return;
        }

        /*
         * Prepare subject of the message
         */
        $parameters = [
            '%name%' => $product->getName(),
            '%id%'   => $product->getId(),
        ];

        $subject = $this
            ->translator
            ->trans('app.mail.product_created.subject', $parameters, 'AppBundle');

        /*
         * ...content
         */
        $templateParameters = [
            'product' => $product,
        ];

        $templatePath = '@App/Email/product-created.html.twig';
        $body = $this->templating->render($templatePath, $templateParameters);

        /*
         * ...the whole message
         */
        $message = (new Swift_Message($subject, $body, 'text/html', 'utf-8'))
            ->setFrom($this->fromEmail)
            ->setTo('krzysztof.niziol@meritoo.pl'); // tip: it should be fetched from application's configuration

        /*
         * ...and send it
         */
        $this
            ->mailer
            ->send($message);
    }
}
