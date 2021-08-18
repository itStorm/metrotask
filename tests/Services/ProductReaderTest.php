<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Metrotask\Services\JsonLoader;
use Metrotask\Services\ProductReader;
use Metrotask\Interfaces\OfferCollectionInterface;
use Metrotask\Product\Product;

class ProductReaderTest extends TestCase
{
    /**
     * @var ProductReader
     */
    private $productReader;

    public function setUp(): void
    {
        $loader = $this->createMock(JsonLoader::class);
        $loader->method('load')
            ->willReturn([
                [
                    'offerId' => 111,
                    'productTitle' => 'Product test 1',
                    'vendorId' => 35,
                    'price' => 100,
                ],
                [
                    'offerId' => 222,
                    'productTitle' => 'Product test 2',
                    'vendorId' => 45,
                    'price' => 20,
                ],
            ]);

        $this->productReader = new ProductReader($loader);
    }

    public function testRead(): void
    {
        $productCollection = $this->productReader->read('test_path');

        $this->assertInstanceOf(OfferCollectionInterface::class, $productCollection);
        $product = $productCollection->get(222);
        $this->assertInstanceOf(Product::class, $product);
        $this->assertEquals($product->getField('productTitle'), 'Product test 2');
    }
}