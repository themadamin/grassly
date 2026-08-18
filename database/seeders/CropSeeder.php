<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Crop;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

/**
 * The closed list of crops, grouped under CategorySeeder's categories
 * (FAO/USDA commodity lists — a solid starter set, not exhaustive). Farmers
 * pick one of these for a Product; no free-typing. Idempotent via
 * updateOrCreate on slug — depends on CategorySeeder having run first (see
 * DatabaseSeeder call order).
 */
class CropSeeder extends Seeder
{
    public function run(): void
    {
        foreach (self::byCategory() as $categoryName => $cropNames) {
            // firstOrFail: a missing category means CategorySeeder hasn't run
            // yet, or the two lists have drifted apart — fail loud, don't
            // silently skip crops.
            $category = Category::query()
                ->where('slug', Str::slug($categoryName))
                ->firstOrFail();

            foreach ($cropNames as $cropName) {
                Crop::query()->updateOrCreate(
                    ['slug' => Str::slug($cropName)],
                    ['name' => $cropName, 'category_id' => $category->id],
                );
            }
        }
    }

    /**
     * @return array<string, list<string>>
     */
    public static function byCategory(): array
    {
        return [
            'Vegetables' => [
                'Tomato', 'Potato', 'Onion', 'Carrot', 'Cabbage', 'Cucumber',
                'Bell Pepper', 'Spinach', 'Lettuce', 'Broccoli', 'Eggplant', 'Pumpkin',
            ],
            'Fruits' => [
                'Apple', 'Banana', 'Orange', 'Grape', 'Mango', 'Strawberry',
                'Watermelon', 'Pineapple', 'Pear', 'Peach', 'Lemon', 'Avocado',
            ],
            'Grains' => [
                'Wheat', 'Rice', 'Maize', 'Barley', 'Oats', 'Rye', 'Sorghum', 'Millet',
            ],
            'Legumes' => [
                'Soybean', 'Chickpea', 'Lentil', 'Kidney Bean', 'Black Bean',
                'Green Pea', 'Peanut',
            ],
            'Nuts & Seeds' => [
                'Almond', 'Walnut', 'Cashew', 'Sunflower Seed', 'Pistachio',
                'Hazelnut', 'Sesame Seed',
            ],
            'Dairy' => [
                'Cow Milk', 'Goat Milk', 'Cheese', 'Butter', 'Yogurt',
            ],
            'Livestock' => [
                'Cattle', 'Sheep', 'Goat', 'Pig',
            ],
            'Poultry' => [
                'Chicken', 'Duck', 'Turkey', 'Eggs',
            ],
            'Herbs & Spices' => [
                'Basil', 'Mint', 'Cilantro', 'Parsley', 'Thyme', 'Rosemary',
                'Black Pepper', 'Chili Pepper', 'Ginger', 'Turmeric',
            ],
            'Other' => [
                'Coffee', 'Cocoa', 'Tea', 'Cotton', 'Sugarcane', 'Honey',
            ],
        ];
    }
}
