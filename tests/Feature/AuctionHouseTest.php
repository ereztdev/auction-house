<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuctionHouseTest extends TestCase
{

    /**
     * Test adding an item
     */
    public function testAddItem()
    {
        $bidData = [
            "email" => "joe_tester@gmail.com",
            "password" => "password",
            "cat_id" => 199,
            "name" => "test_item_1",
            "min_price" => 8.7,
        ];
        $this->json('POST', 'api/item/add', $bidData, ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJson([
                "success" => true,
                "data" => [
                    "cat_id" => 199,
                    "name" => 'test_item_1',
                    "min_price" => 8.7,
                ]
            ]);
    }

    /**
     * Testing Lower Bid
     */
    public function testLowerBid()
    {
        $bidData = [
            "email" => "joe_tester@gmail.com",
            "password" => "password",
            "bid" => 6,
            "item_id" => 1,
        ];
        $this->json('POST', 'api/item/bid', $bidData, ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJson([
                "success" => true
            ]);
    }

    /**
     * Testing a lower number for the sake of a mid point error on min/max
     */
    public function testEvenLowerBid()
    {
        $bidData = [
            "email" => "joe_tester@gmail.com",
            "password" => "password",
            "bid" => 2,
            "item_id" => 1,
        ];
        $this->json('POST', 'api/item/bid', $bidData, ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJson([
                "success" => true
            ]);
    }

    /**
     * Test highest bid.
     *
     * @return void
     */
    public function testHighBid()
    {
        $bidData = [
            "email" => "joe_tester@gmail.com",
            "password" => "password",
            "bid" => 111,
            "item_id" => 1,
        ];
        $this->json('POST', 'api/item/bid', $bidData, ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJson([
                "success" => true,
                "data" => [
                    "id" => 1,
                    "cat_id" => 199,
                    "name" => "test_item_1",
                    "min_price" => 111,
                ]
            ]);
    }

    /**
     * Testing item fetch returning a custom JSON that includes min/max and highest bidder.
     */
    public function testGetHighestBidder()
    {
        $bidData = [
            "email" => "joe_tester@gmail.com",
            "password" => "password",
        ];
        $this->json('POST', 'api/item/1', $bidData, ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJson([
                "success" => true,
                "data" => [
                    "id" => 1,
                    "name" => "test_item_1",
                    "min_bid" => 2,
                    "highest_bid" => 111,
                    "highest_bid_user_id" => 1
                ],
            ]);
    }
}
