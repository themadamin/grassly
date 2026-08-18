<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

/**
 * The closed list of top-level crop categories (FAO/USDA commodity groupings).
 * Reference data, not user-editable — farmers pick from Crop, not Category,
 * directly. Idempotent via updateOrCreate on slug, safe to re-run.
 */
class CategorySeeder extends Seeder
{
    public function run(): void
    {
        foreach (self::names() as $name) {
            Category::query()->updateOrCreate(
                ['slug' => Str::slug($name)],
                ['name' => $name],
            );
        }
    }

    /**
     * @return list<string>
     */
    public static function names(): array
    {
        return [
            'Vegetables',
            'Fruits',
            'Grains',
            'Legumes',
            'Nuts & Seeds',
            'Dairy',
            'Livestock',
            'Poultry',
            'Herbs & Spices',
            'Other',
        ];
    }
}
