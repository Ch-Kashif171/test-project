<?php

namespace Database\Seeders;

use App\Helpers\Constants;
use App\Models\DropDown;
use App\Models\DropDownOption;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DropDownSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (Constants::DROP_DOWNS as $key => $drop_down) {
            $dropDown = DropDown::create([
                'name' => $drop_down
            ]);
            if ($key == 'option1') {
                $options = Constants::FIRST_OPTIONS;
            } else {
                $options = Constants::SECOND_OPTIONS;
            }
            foreach ($options as $option) {
                DropDownOption::create([
                    'drop_down_id' => $dropDown->id,
                    'option' => $option
            ]);
            }
        }
    }
}
