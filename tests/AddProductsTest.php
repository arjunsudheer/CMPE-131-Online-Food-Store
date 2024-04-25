<?php

use Arjunsudheer\Cmpe131OnlineFoodStore as source;

use PHPUnit\Framework\TestCase;

require 'vendor/autoload.php';
require __DIR__ . "/../src/main-page/add-products.php";

class AddProductsTest extends TestCase
{
    function testDefaultQuery()
    {
        $products = new source\AddProductItems(4);

        $query = $products->createQuery();
        $this->assertSame("SELECT * FROM Items", $query);
    }

    function testFruitFilterQuery()
    {
        $products = new source\AddProductItems(4, ["", "Fruits", "Sort By"]);

        $query = $products->createQuery();
        $this->assertSame("SELECT * FROM Items WHERE Type='Fruits'", $query);
    }

    function testVegetableFilterAndPriceSortQuery()
    {
        $products = new source\AddProductItems(4, ["", "Vegetables", "price"]);

        $query = $products->createQuery();
        $this->assertSame("SELECT * FROM Items WHERE Type='Vegetables' ORDER BY Price ASC", $query);
    }

    function testApplesSearchQuery()
    {
        $products = new source\AddProductItems(4, ["apples", "Fruits", "Vegetables", "Dairy", "Protein", "Sweets", "Sort By"]);

        $query = $products->createQuery();
        $this->assertSame("SELECT * FROM Items WHERE Type='Fruits' AND (Product LIKE '%apples%' OR Brand LIKE '%apples%') OR Type='Vegetables' AND (Product LIKE '%apples%' OR Brand LIKE '%apples%') OR Type='Dairy' AND (Product LIKE '%apples%' OR Brand LIKE '%apples%') OR Type='Protein' AND (Product LIKE '%apples%' OR Brand LIKE '%apples%') OR Type='Sweets' AND (Product LIKE '%apples%' OR Brand LIKE '%apples%')", $query);
    }

    function testFruitAndVegetableFilterAndWeightSortAndMelonSearchQuery()
    {
        $products = new source\AddProductItems(4, ["melon", "Fruits", "Vegetables", "weight"]);

        $query = $products->createQuery();
        $this->assertSame("SELECT * FROM Items WHERE Type='Fruits' AND (Product LIKE '%melon%' OR Brand LIKE '%melon%') OR Type='Vegetables' AND (Product LIKE '%melon%' OR Brand LIKE '%melon%') ORDER BY Weight ASC", $query);
    }
}
