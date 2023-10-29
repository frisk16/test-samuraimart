<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\MajorCategory;

class MajorCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MajorCategory::create([
            'name' => '本',
            'description' => '参考書、雑誌、絵本等'
        ]);
        MajorCategory::create([
            'name' => 'コンピュータ',
            'description' => 'ノートPC、デスクトップPC、タブレット等'
        ]);
        MajorCategory::create([
            'name' => 'ディスプレイ',
            'description' => 'デスクトップ用、小型タブレット用等'
        ]);
    }
}
