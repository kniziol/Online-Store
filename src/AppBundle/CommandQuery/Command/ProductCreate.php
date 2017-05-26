<?php

namespace AppBundle\CommandQuery\Command;

use SimpleBus\Message\Name\NamedMessage;

/**
 * The "product create" command
 *
 * @author    Krzysztof Niziol <krzysztof.niziol@meritoo.pl>
 * @copyright Meritoo.pl
 */
class ProductCreate implements NamedMessage
{
    /**
     * Name of product
     *
     * @var string
     */
    private $name;

    /**
     * Description of product
     *
     * @var string
     */
    private $description;

    /**
     * Price of product
     *
     * @var float
     */
    private $price;

    /**
     * Class constructor
     *
     * @param string $name        Name of product
     * @param string $description Description of product
     * @param float  $price       Price of product
     */
    public function __construct($name, $description, $price)
    {
        $this->name = $name;
        $this->description = $description;
        $this->price = $price;
    }

    /**
     * Returns name of product
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Returns description of product
     *
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * Returns price of product
     *
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * {@inheritdoc}
     */
    public static function messageName()
    {
        return 'app.product_create.command';
    }
}
