<?php

namespace Database\Seeders;

use App\Models\PageSlot;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SlotSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ps = PageSlot::all();
        
        if(count($ps) === 0){
            PageSlot::insert([
                [
                    'id'=> 1,
                    'name'=> 'Hero',
                ],
                [
                    'id' => 2,
                    'name' => 'Sidebar',
                ],
                [
                    'id' => 3,
                    'name' => 'Body',
                ],
            ]);
        }
    }
}
