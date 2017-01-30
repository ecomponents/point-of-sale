<?php

declare(strict_types = 1);

/**
 * All rights reserved.
 * @copyright Copyright (c) 2017 Gab Amba
 * @license https://github.com/gabbydgab/LicenseAgreement MIT License
 */

namespace CodingMattersTest\PoS;

use CodingMatters\PoS\Exception\ItemNotFound;
use PHPUnit\Framework\TestCase;
use CodingMatters\PoS\Basket;
use CodingMatters\PoS\Item;

final class BasketTest extends TestCase
{
    const NO_ITEMS = 0;
    const ZERO_AMOUNT = 0;

    /** @var Basket */
    private $basket;

    /**
     * Called every test-case
     */
    public function setUp() : void
    {
        $this->basket = new Basket();
    }

    /**
     * Empty Basket
     *  - Should return no items
     *  - Should return zero amount
     */
    public function testEmptyBasket() : void
    {
        $this->totalItemsShouldBe(self::NO_ITEMS);
        $this->totalAmountShouldBe(self::ZERO_AMOUNT);
    }

    /**
     * Adding Single Item To The Basket
     *
     * Added an item with amount of $10,
     *  - Should return 1 item
     *  - Should return 10 as total amount
     */
    public function testAddingSingleItemToTheBasket() : void
    {
        $expectedItems = 1;
        $expectedAmount = 10;

        $item = $this->mockItem($expectedAmount);

        $this->basket->addItem($item);

        $this->totalItemsShouldBe($expectedItems);
        $this->totalAmountShouldBe($expectedAmount);
    }

    /**
     * Adding Multiple Items Into The Basket
     *
     * Added item #1 with amount of 3
     * Added item #2 with amount of 4.5
     *  - Should return 2 items
     *  - Should return 7.5 as total amount
     */
    public function testAddingMultipleItemsIntoTheBasket() : void
    {
        $expectedItems = 2;
        $expectedAmount = 7.5;

        $item = $this->mockItem(3);
        $item2 = $this->mockItem(4.5);

        $this->basket->addItem($item, $item2);

        $this->totalItemsShouldBe($expectedItems);
        $this->totalAmountShouldBe($expectedAmount);
    }

    /**
     * Adding The Same Item In The Basket
     *
     * Added item with amount of 3
     *  - Should return 1 item
     *  - Should return twice the amount (6)
     */
    public function testAddingTheSameItemInTheBasket() : void
    {
        $expectedItems = 1;
        $expectedAmount = 6;

        $item = $this->mockItem(3);

        $this->basket->addItem($item, $item);

        $this->totalItemsShouldBe($expectedItems);
        $this->totalAmountShouldBe($expectedAmount);
    }

    /**
     * Removing An Item From An Empty Basket
     *
     * If basket is empty;
     *  - Should return ItemNotFound Exception
     */
    public function testRemovingAnItemFromAnEmptyBasket() : void
    {
        $this->expectException(ItemNotFound::class);

        $item = $this->mockItem();

        $this->basket->removeItem($item);
    }

    /**
     * Remove Item From The Basket
     *
     * Added 3 items amounting 3, 4.5, 2.18 respectively.
     * Remove item #3 with amount 2.18
     *  - Should return 2 items
     *  - Should return total amount of 7.5
     */
    public function testRemoveItemFromTheBasket() : void
    {
        $expectedItems = 1;
        $expectedAmount = 3;

        $item = $this->mockItem(3);
        $item2 = $this->mockItem(4.5);

        $this->basket->addItem($item, $item2);

        $this->basket->removeItem($item2);

        $this->totalItemsShouldBe($expectedItems);
        $this->totalAmountShouldBe($expectedAmount);
    }

    /**
     * RemovingTheSameItemIfItemIsAddedMultipleTimes
     */
    public function testRemovingTheSameItemIfItemIsAddedMultipleTimes() : void
    {
        $this->markTestIncomplete('logic not yet solved');
        $expectedItems = 1;
        $expectedAmount = 7.5;

        $item = $this->mockItem(3);
        $item2 = $this->mockItem(7.5);

        $this->basket->addItem($item, $item, $item2);

        $this->basket->removeItem($item);

        $this->totalItemsShouldBe($expectedItems);
        $this->totalAmountShouldBe($expectedAmount);
    }

    /**
     * Helper method for asserting total items in a basket
     *
     * @param int $total
     * @return void
     */
    private function totalItemsShouldBe(int $total) : void
    {
        $this->assertEquals($total, $this->basket->totalItems());
    }

    /**
     * Helper method for asserting total amount in a basket
     *
     * @param int $total
     * @return void
     */
    private function totalAmountShouldBe(float $total) : void
    {
        $this->assertEquals($total, $this->basket->totalAmount());
    }

    /**
     * Helper method in creating mock Item object
     *
     * @param float $amount
     * @return PHPUnit_Framework_MockObject_MockObject
     */
    private function mockItem(float $amount = 0)
    {
        $mock = $this->createMock(Item::class);
        $mock->method("amount")
            ->willReturn($amount);

        return $mock;
    }
}
