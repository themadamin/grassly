// Shape of a Laravel paginated API-Resource collection as Inertia serializes it
// (`SomeResource::collection($paginator)`): the rows live under `data`, with
// `links` + `meta` describing the pages. Generic over the row type so any list
// resource can reuse it, e.g. `Paginated<OfferListItem>`.
//
// Keep this in sync with Laravel's paginator payload if you ever customize it.

export type PaginationLinks = {
    first: string | null;
    last: string | null;
    prev: string | null;
    next: string | null;
};

// One entry in `meta.links` — the numbered page buttons Laravel builds.
export type PaginationMetaLink = {
    url: string | null;
    label: string;
    active: boolean;
};

export type PaginationMeta = {
    current_page: number;
    from: number | null;
    last_page: number;
    links: PaginationMetaLink[];
    path: string;
    per_page: number;
    to: number | null;
    total: number;
};

export type Paginated<T> = {
    data: T[];
    links: PaginationLinks;
    meta: PaginationMeta;
};
