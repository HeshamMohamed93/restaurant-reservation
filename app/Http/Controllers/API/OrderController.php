<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Meal;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Reservation;
use App\Services\ServiceOnlyCheckout;
use App\Services\TaxServiceCheckout;
use App\Utils\PaymentType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function placeOrder(Request $request)
    {
        $request->validate([
            'reservation_id' => 'required|exists:reservations,id',
            'meals' => 'required|array',
            'meals.*.meal_id' => 'required|exists:meals,id',
            'meals.*.quantity' => 'required|integer|min:1',
        ]);

        DB::beginTransaction();

        try {
            $reservation = Reservation::findOrFail($request->reservation_id);

            $order = Order::create([
                'reservation_id' => $reservation->id,
                'table_id' => $reservation->table_id,
                'customer_id' => $reservation->customer_id,
                'user_id' => auth()->id(),
                'total' => 0,
                'paid' => false,
                'date' => now()
            ]);

            $total = 0;

            foreach ($request->meals as $mealOrder) {
                $meal = Meal::findOrFail($mealOrder['meal_id']);

                if ($meal->available_quantity < $mealOrder['quantity']) {
                    DB::rollBack();
                    return response()->json(['message' => "Meal {$meal->id} does not have enough quantity."], 400);
                }

                $amountToPay = ($meal->price - ($meal->price * ($meal->discount / 100))) * $mealOrder['quantity'];
                $total += $amountToPay;

                OrderDetail::create([
                    'order_id' => $order->id,
                    'meal_id' => $meal->id,
                    'amount_to_pay' => $amountToPay
                ]);

                $meal->decrement('available_quantity', $mealOrder['quantity']);
            }

            $order->update(['total' => $total]);

            DB::commit();

            return response()->json(['message' => 'Order placed successfully!', 'order' => $order], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'An error occurred while placing the order.', 'error' => $e->getMessage()], 500);
        }
    }

    public function pay(Request $request)
    {
        $validated = $request->validate([
            'order_id' => 'required|exists:orders,id',
            'checkout_method' => 'required|string|in:' . implode(',', PaymentType::getAll())
        ]);

        $order = Order::find($validated['order_id']);
        if (!$order) {
            return response()->json(['error' => 'Order not found'], 404);
        }

        $strategy = $this->getCheckoutStrategy($validated['checkout_method']);
        if (!$strategy) {
            return response()->json(['error' => 'Invalid checkout method'], 400);
        }

        $total = $strategy->calculateTotal($order);
        $order->paid = $total;
        $order->save();

        return response()->json([
            'order_id' => $order->id,
            'total' => $total
        ]);
    }

    private function getCheckoutStrategy($method)
    {
        switch ($method) {
            case 'tax_service':
                return new TaxServiceCheckout();
            case 'service_only':
                return new ServiceOnlyCheckout();
            default:
                return null;
        }
    }
}
