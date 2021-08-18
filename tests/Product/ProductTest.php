<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;

class ProductTest extends TestCase
{
    /**
     * @var array
     */
    private $data;

    /**
     * @var \Metrotask\Product\Product
     */
    private $product;

    public function setUp(): void
    {
        $this->data = [
            'offerId' => 124,
            'productTitle' => 'Napkins',
            'vendorId' => 35,
            'price' => 15.5
        ];
        $this->product = new Metrotask\Product\Product($this->data);
    }

    public function testGetters()
    {
        $this->assertEquals(124, $this->product->getId());
        $this->assertEquals($this->data, $this->product->getData());
        $this->assertEquals(15.5, $this->product->getField('price'));
    }
}