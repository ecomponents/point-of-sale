<?php

declare(strict_types = 1);

/**
 * All rights reserved.
 * @copyright Copyright (c) 2017 Gab Amba
 * @license https://github.com/gabbydgab/LicenseAgreement MIT License
 */

namespace CodingMatters\PoS;

use CodingMatters\PoS\Exception\ItemNotFound;
use CodingMatters\PoS\Item;

final class Basket
{
    /**
     * Collection of Items
     *
     *  @var array
     */
    private $items = [];

    /**
     * Total amount of items in the basket
     *
     * @var int
     */
    private $amount = 0;

    /**
     * Registering items in a basket (as collection of items)
     *
     * If an item already exists in the basket, will just add the total amount of the item.
     *
     * @param Item [] $items
     * @return void
     */
    public function addItem(Item ...$items) : void
    {
        foreach ($items as $item) {
            if (\in_array($item, $this->items)) {
                $this->amount += $item->amount();
            } else {
                $this->items [] = $item;
            }
        }
    }

    /**
     * Removes an item that exists in the basket and re-adjust the total amount.
     *
     * @param Item $item
     * @throws ItemNotFound
     * @return void
     */
    public function removeItem(Item $item) : void
    {
        if (! \in_array($item, $this->items)) {
            throw new ItemNotFound();
        }

        $key = \array_search($item, $this->items, true);
        unset($this->items[$key]);

        // Should be able to deduct the amount from removed items
        //$this->amount -= $item->amount();
    }

    /**
     * Count total items registered in the basket
     *
     * @return int
     */
    public function totalItems() : int
    {
        return \count($this->items);
    }

    public function totalAmount() : float
    {
        foreach ($this->items as $item) {
            $this->amount += $item->amount();
        }

        return $this->amount;
    }
}
