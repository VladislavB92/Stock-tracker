<?php

namespace Tests\Feature;

use App\Models\Stock;
use App\Models\Product;
use App\Models\Retailer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Http;

class TrackCommandTest extends TestCase
{
    use RefreshDatabase;

    function trackProductStock()
    {
        $switch = Product::created(['name' => 'Nintendo Switch']);

        $bestBuy = Retailer::create(['name' => 'Best Buy']);

        $this->assertFalse($switch->inStock());

        $stock = new Stock([
            'price' => 1000,
            'url' => 'http://foo.com',
            'sku' => '12345',
            'ins_stock' => false
        ]);

        $bestBuy->addStock($switch, $stock);

        $this->assertFalse($stock->fresh()->in_stock);

        Http::fake(function () {
            return ['foo' => 'bar'];
        });

        $this->artisan('track');

        $this->assertTrue($stock->fresh()->in_stock);
    }
}
