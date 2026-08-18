<?php

namespace App\Providers;

use Spatie\LaravelTypeScriptTransformer\TypeScriptTransformerApplicationServiceProvider as BaseTypeScriptTransformerServiceProvider;
use Spatie\TypeScriptTransformer\Formatters\PrettierFormatter;
use Spatie\TypeScriptTransformer\Transformers\AttributedClassTransformer;
use Spatie\TypeScriptTransformer\Transformers\EnumTransformer;
use Spatie\TypeScriptTransformer\TypeScriptTransformerConfigFactory;
use Spatie\TypeScriptTransformer\Writers\GlobalNamespaceWriter;

/**
 * Frontend types are still hand-written per model (see docs/coding-rules.md) —
 * EXCEPT the filter DTOs, which are generated from PHP so the allowed filter
 * shape + sort keys stay typed on both sides. `php artisan typescript:transform`
 * scans app/ for `#[TypeScript]` classes/enums (currently OfferFilterData +
 * OfferSortOption) and writes them into resources/js/types/generated.d.ts as the
 * ambient `App.Data.*` / `App.Enums.*` namespaces.
 */
class TypeScriptTransformerServiceProvider extends BaseTypeScriptTransformerServiceProvider
{
    protected function configure(TypeScriptTransformerConfigFactory $config): void
    {
        $config
            // AttributedClassTransformer picks up any class marked `#[TypeScript]`
            // (our laravel-data filter DTO); EnumTransformer emits backed enums as
            // string-literal unions (OfferSortOption).
            ->transformer(AttributedClassTransformer::class)
            ->transformer(EnumTransformer::class)
            ->transformDirectories(app_path())
            // File lands at resources/js/types/generated.d.ts (tsconfig already
            // globs resources/js/**/*.d.ts, so it's picked up with no extra wiring).
            ->outputDirectory(resource_path('js/types'))
            ->writer(new GlobalNamespaceWriter('generated.d.ts'))
            ->formatter(PrettierFormatter::class);
    }
}
