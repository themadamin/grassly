// Shape of a plain (non-paginated) Laravel API-Resource collection
// (`SomeResource::collection($items)` on a plain Collection, not a paginator)
// as seen from a raw `fetch()` call — the rows live under `data`, with no
// `links`/`meta` (that's `Paginated<T>` in pagination.ts, for paginator
// results). Generic over the row type, e.g. `ResourceCollection<Crop>`.

export type ResourceCollection<T> = {
    data: T[];
};
