<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DocumentCategory;

class DocumentCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = ['Finance', 'Legal', 'Human Resources', 'Marketing', 'Operations'];

        foreach ($categories as $category) {
            DocumentCategory::create(['name' => $category]);
        }
    }
}
