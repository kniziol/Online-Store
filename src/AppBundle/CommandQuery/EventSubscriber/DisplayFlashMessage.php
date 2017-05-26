<?php

namespace AppBundle\CommandQuery\EventSubscriber;

use AppBundle\CommandQuery\Event\ProductCreated;
use AppBundle\Helper\FlashHelper;

/**
 * Subscriber for the "product created" event / message.
 * Displays positive flash message that product was saved.
 *
 * @author    Krzysztof Niziol <krzysztof.niziol@meritoo.pl>
 * @copyright Meritoo.pl
 */
class DisplayFlashMessage
{
    /**
     * Helper for flash messages.
     * Provides some methods that serves the flash messages.
     *
     * @var FlashHelper
     */
    private $flashHelper;

    /**
     * Class constructor
     *
     * @param FlashHelper $flashHelper Helper for flash messages. Provides some methods that serves the flash messages.
     */
    public function __construct(FlashHelper $flashHelper)
    {
        $this->flashHelper = $flashHelper;
    }

    /**
     * Handles the event
     *
     * @param ProductCreated $event The "product created" event / message
     */
    public function handle(ProductCreated $event)
    {
        /*
         * Product wasn't saved?
         * Nothing to do
         */
        if ($event->getProduct()->getId() === null) {
            return;
        }

        $this
            ->flashHelper
            ->add('app.flash.saved');
    }
}
