<?php

namespace Database\Factories;

use App\Models\Meal;
use Illuminate\Database\Eloquent\Factories\Factory;

class MealFactory extends Factory
{
    protected $model = Meal::class;

    public function definition()
    {
        $mealNames = [
            'Grilled Chicken Sandwich',
            'Caesar Salad',
            'Beef Burger',
            'Vegetarian Pasta',
            'BBQ Ribs',
            'Fish Tacos',
            'Chicken Alfredo',
            'Vegetable Stir Fry',
            'Margherita Pizza',
            'Tiramisu'
        ];

        $descriptions = [
            'A delicious grilled chicken sandwich with fresh vegetables and a tangy sauce.',
            'Classic Caesar salad with crispy croutons and creamy Caesar dressing.',
            'Juicy beef burger with lettuce, tomato, and a special sauce.',
            'Pasta with a rich tomato and basil sauce, topped with Parmesan cheese.',
            'Tender ribs slow-cooked with a smoky BBQ sauce.',
            'Tacos filled with crispy fish, cabbage slaw, and a zesty sauce.',
            'Creamy Alfredo pasta with chicken and mushrooms.',
            'Stir-fried vegetables with a savory sauce, served over rice.',
            'Classic Margherita pizza with fresh mozzarella, tomatoes, and basil.',
            'A classic Italian dessert with coffee-soaked ladyfingers and mascarpone cheese.'
        ];

        return [
            'name' => $this->faker->unique()->randomElement($mealNames),
            'description' => $this->faker->randomElement($descriptions),
            'price' => $this->faker->randomFloat(2, 5, 50),
            'available_quantity' => $this->faker->numberBetween(1, 100),
            'discount' => $this->faker->randomFloat(2, 0, 0.5),
        ];
    }
}
