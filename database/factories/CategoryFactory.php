<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Category;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            //テストデータの設定
            'category_name'        => $this->faker->unique->randomElement([
                'プライベート',
                '仕事',
                '生活',
                '遊び',
                '習慣',
                '電話',
                'その他'
            ])
        ];
    }
}
