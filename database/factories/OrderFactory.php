<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        static $orderNumber = 0;

        $lastOrderNumber = Order::max('order_number') ?? 'ORD-00000';
        $lastNumber = (int) substr($lastOrderNumber, 4);

        $orderNumber++;
        $newNumber = $lastNumber + $orderNumber;

        $customer = Customer::inRandomOrder()->first();
        $product = Product::inRandomOrder()->first();
        $quantity = $this->faker->numberBetween(500, 18000);
        $pplCost = $this->calculatePplCost($product, $quantity);
        $pplSell = $this->faker->randomFloat(2, $pplCost, $pplCost + 0.40);
        $nettTotal = $quantity * $pplSell;
        $vat = $nettTotal * 0.20;
        $total = $nettTotal + $vat;
        $pplProfit = $pplSell - $pplCost;
        $totalProfit = $pplProfit * $quantity;

        return [
            'customer_id' => $customer->id,
            'product_id' => $product->id,
            'order_number' => 'ORD-' . str_pad($newNumber, 5, '0', STR_PAD_LEFT),
            'quantity' => $quantity,
            'ppl_sell' => $pplSell,
            'vat' => $vat,
            'nett_total' => $nettTotal,
            'total' => $total,
            'ppl_cost' => $pplCost,
            'ppl_profit' => $pplProfit,
            'total_profit' => $totalProfit,
        ];
    }

    private function calculatePplCost($product, $quantity)
    {
        $pricing = [
            'DERV' => ['threshold' => 10000, 'low' => 1.10, 'high' => 1.05],
            'IHO' => ['threshold' => 10000, 'low' => 0.70, 'high' => 0.65],
            'Kerosene' => ['threshold' => 10000, 'low' => 0.68, 'high' => 0.63],
            'Gas Oil' => ['threshold' => 10000, 'low' => 0.85, 'high' => 0.80],
            'AdBlue' => ['threshold' => 10000, 'low' => 0.35, 'high' => 0.30],
        ];

        $productName = $product->name;

        if (!isset($pricing[$productName])) {
            return 1.00;
        }

        $productPricing = $pricing[$productName];

        return $quantity < $productPricing['threshold']
            ? $productPricing['high']
            : $productPricing['low'];
    }
}
