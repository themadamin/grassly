<?php

namespace Database\Seeders;

use App\Models\Region;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

/**
 * The closed list of Uzbekistan's regions (12 viloyatlar + the Republic of
 * Karakalpakstan + Tashkent city) — the app's order/delivery zones. Farmers
 * and offers pick one of these; no free-typing. Idempotent via
 * updateOrCreate on slug, safe to re-run.
 */
class RegionSeeder extends Seeder
{
    public function run(): void
    {
        foreach (self::names() as $name) {
            Region::query()->updateOrCreate(
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
            'Republic of Karakalpakstan',
            'Andijan Region',
            'Bukhara Region',
            'Fergana Region',
            'Jizzakh Region',
            'Namangan Region',
            'Navoiy Region',
            'Qashqadaryo Region',
            'Samarqand Region',
            'Sirdaryo Region',
            'Surxondaryo Region',
            'Tashkent Region',
            'Xorazm Region',
            'Tashkent City',
        ];
    }
}
