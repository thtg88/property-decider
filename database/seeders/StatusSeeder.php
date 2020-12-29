<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['name' => 'Queued for Processing'],
            ['name' => 'Processing'],
            ['name' => 'Completed'],
            ['name' => 'Failed'],
        ];
        foreach ($data as $model_data) {
            Status::firstOrCreate($model_data);
        }
    }
}
