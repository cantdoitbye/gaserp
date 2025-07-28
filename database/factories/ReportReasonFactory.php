<?php

namespace Database\Factories;

use App\Models\ReportReason;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ReportReason>
 */
class ReportReasonFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ReportReason::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    public function definition()
    {
        return [
            'report_reason' => $this->faker->sentence,
        ];
    }
}
