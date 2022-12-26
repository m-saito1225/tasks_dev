<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Task;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
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
			'user_id'		=> $this->faker->numberBetween(1, 10)					,
			'title'			=> $this->faker->realText(30)							,
			'limit'			=> $this->faker->dateTimeBetween('-1 week', '+3 week')	,
			'detail'		=> $this->faker->realText(200)							,
			'img_path'		=> "test/img/testtesttesttest.jpg"						,
			'remarks'		=> $this->faker->realText(50)							,
			'status'		=> $this->faker->numberBetween(0, 2)					,
			'category'		=> $this->faker->numberBetween(1, 7)
		];
	}
}
