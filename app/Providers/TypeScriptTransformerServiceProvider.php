<?php

namespace App\Providers;

use Spatie\LaravelTypeScriptTransformer\LaravelData\LaravelDataTypeScriptTransformerExtension;
use Spatie\LaravelTypeScriptTransformer\TypeScriptTransformerApplicationServiceProvider as BaseTypeScriptTransformerServiceProvider;
use Spatie\TypeScriptTransformer\Transformers\AttributedClassTransformer;
use Spatie\TypeScriptTransformer\Transformers\EnumTransformer;
use Spatie\TypeScriptTransformer\TypeScriptTransformerConfigFactory;
use Spatie\TypeScriptTransformer\Writers\GlobalNamespaceWriter;

/**
 * Configures spatie/laravel-typescript-transformer (v3) the modern way —
 * a service provider whose configure() receives the config factory. The old
 * v2 `config/typescript-transformer.php` file is NOT used; ignore blog posts
 * that show it.
 *
 * Pipeline: our `app/Data` DTOs (annotated #[TypeScript]) + `app/Enums` backed
 * enums are scanned and emitted into a single ambient .d.ts, consumed on the
 * frontend as `App.Data.*` / `App.Enums.*` (no imports needed).
 */
class TypeScriptTransformerServiceProvider extends BaseTypeScriptTransformerServiceProvider
{
    protected function configure(TypeScriptTransformerConfigFactory $config): void
    {
        $config
            // Handles plain `#[TypeScript]`-attributed classes. The Laravel Data
            // extension (below) swaps this for a Laravel-aware variant via
            // replaceTransformer(), which is why it must be registered first.
            ->transformer(AttributedClassTransformer::class)
            // useUnionEnums: true → emit string-literal unions
            // (`'draft' | 'on_sale' | 'closed'`) instead of native TS `enum`s.
            // true is the v3 default; set explicitly so the intent is on the record.
            ->transformer(new EnumTransformer(useUnionEnums: true))
            // Teaches the transformer to turn spatie/laravel-data DTOs into TS
            // interfaces (prepends a DataClassTransformer + registers providers).
            ->extension(new LaravelDataTypeScriptTransformerExtension)
            // Only scan our DTOs and enums — nothing else in app/ should leak types.
            ->transformDirectories(app_path('Data'), app_path('Enums'))
            // Output a single ambient-declaration file, kept separate from the
            // starter kit's hand-written resources/js/types/index.ts.
            ->outputDirectory(resource_path('js/types'))
            ->writer(new GlobalNamespaceWriter('generated.d.ts'))
            // Skip the sidecar manifest json so resources/js/types stays tidy.
            ->withoutManifest();
    }
}
