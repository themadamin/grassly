<?php

namespace App\Http\Controllers;

use App\Http\Requests\Crop\IndexCropRequest;
use App\Http\Resources\CropResource;
use App\Models\Crop;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

/**
 * JSON search endpoint for the crop typeahead (GET /crops?category_id=&query=).
 * Keeps the full (closed-list) crop table off the client — the frontend
 * queries this as the user types instead of loading every crop up front.
 *
 * Invokable — one route, one action.
 */
class CropController extends Controller
{
    public function index(IndexCropRequest $request): AnonymousResourceCollection
    {
        $validated = $request->validated();

        $categoryId = $validated['category_id'] ?? null;
        $term = $validated['query'] ?? null;

        $crops = Crop::query()
            ->with('category')
            ->when($categoryId, fn(Builder $q, int $categoryId) => $q->where('category_id', $categoryId))
            ->when($term, fn($q, $term) => $q->where('name', 'like', "%{$term}%"))
            ->orderBy('name')
            ->limit(20)
            ->get();

        return CropResource::collection($crops);
    }
}
