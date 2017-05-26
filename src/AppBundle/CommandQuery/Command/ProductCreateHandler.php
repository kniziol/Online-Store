<?php

namespace AppBundle\CommandQuery\Command;

use AppBundle\CommandQuery\Event\ProductCreated;
use AppBundle\Entity\Product;
use Doctrine\ORM\EntityManager;
use SimpleBus\Message\Recorder\PublicMessageRecorder;

/**
 * Handler for the "product create" command
 *
 * @author    Krzysztof Niziol <krzysztof.niziol@meritoo.pl>
 * @copyright Meritoo.pl
 */
class ProductCreateHandler
{
    /**
     * The central access point to ORM functionality
     *
     * @var EntityManager
     */
    private $entityManager;

    /**
     * Event / message recorder
     *
     * @var PublicMessageRecorder
     */
    private $messageRecorder;

    /**
     * Class constructor
     *
     * @param EntityManager         $entityManager   The central access point to ORM functionality
     * @param PublicMessageRecorder $messageRecorder Event / message recorder
     */
    public function __construct($entityManager, PublicMessageRecorder $messageRecorder)
    {
        $this->entityManager = $entityManager;
        $this->messageRecorder = $messageRecorder;
    }

    /**
     * Handles the command.
     * Creates, saves a product and sends a message that product was created.
     *
     * @param ProductCreate $command The "product create" command
     */
    public function handle(ProductCreate $command)
    {
        $name = $command->getName();
        $description = $command->getDescription();
        $price = $command->getPrice();

        /*
         * Create and persist the product
         */
        $product = Product::create($name, $description, $price);
        $this->entityManager->persist($product);
        $this->entityManager->flush();

        /*
         * Dispatch / record the "product created" event / message
         */
        $message = new ProductCreated($product);
        $this->messageRecorder->record($message);
    }
}
