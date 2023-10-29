<?php

namespace Database\Seeders;

use App\Models\Widget;
use App\Models\WidgetSetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WidgetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $widgetList = Widget::all();

        if(count($widgetList) === 0){
            $w = Widget::create([
                'id' => 1,
                'name' => 'Product of the day',
                'label' => 'Product of the day'
            ]);
            
            $ws = WidgetSetting::create([
                'widget_id' => $w->id,
                'label' => 'Product of the day',
                'page_slot_id' => 1, // default slot hero
            ]);
        }
    }
}
