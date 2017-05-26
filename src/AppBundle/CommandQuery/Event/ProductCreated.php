<?php

namespace AppBundle\CommandQuery\Event;

use AppBundle\Entity\Product;
use SimpleBus\Message\Name\NamedMessage;

/**
 * The "product created" event / message
 *
 * @author    Krzysztof Niziol <krzysztof.niziol@meritoo.pl>
 * @copyright Meritoo.pl
 */
class ProductCreated implements NamedMessage
{
    /**
     * The new, just created product
     *
     * @var Product
     */
    private $product;

    /**
     * Class constructor
     *
     * @param Product $product The new, just created product
     */
    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    /**
     * Returns the new, just created product
     *
     * @return Product
     */
    public function getProduct(): Product
    {
        return $this->product;
    }

    /**
     * {@inheritdoc}
     */
    public static function messageName()
    {
        return 'app.product_created.event';
    }
}
