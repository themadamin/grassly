declare namespace App {
namespace Data {
export type OfferData = {
id: number,
user_id: number,
farmer: App.Data.UserData,
product: App.Data.ProductListItemData,
title: string,
total_quantity: number,
remaining_quantity: number,
unit: string,
total_display: string,
remaining_display: string,
region: string,
price: number,
currency: App.Enums.Currency,
price_formatted: string,
visibility: App.Enums.OfferVisibility,
status: App.Enums.OfferStatus,
description: string | null,
available_from: string,
available_to: string | null,
};
export type OfferListItemData = {
id: number,
product: App.Data.ProductListItemData,
title: string,
region: string,
total_quantity: number,
remaining_quantity: number,
unit: string,
total_display: string,
price: number,
currency: App.Enums.Currency,
price_formatted: string,
visibility: App.Enums.OfferVisibility,
status: App.Enums.OfferStatus,
available_from: string,
available_to: string | null,
};
export type ProductData = {
id: number,
user_id: number,
name: string,
region: string,
notes: string | null,
offers_count: number,
farmer: App.Data.UserData,
};
export type ProductListItemData = {
id: number,
name: string,
region: string,
notes: string | null,
offers_count: number,
};
export type UserData = {
id: number,
name: string,
email: string,
role: App.Enums.UserRole | null,
avatar: string | null,
};
}
namespace Enums {
export type Currency = 'USD';
export type OfferStatus = 'draft' | 'on_sale' | 'closed';
export type OfferVisibility = 'public' | 'private';
export type UserRole = 'farmer' | 'merchant' | 'admin';
}
}
declare namespace Illuminate {
export type CursorPaginator<TKey, TValue> = {
data: TKey extends string ? Record<TKey, TValue> : TValue[],
links: {
url: string | null,
label: string,
active: boolean,
}[],
meta: {
path: string,
per_page: number,
next_cursor: string | null,
next_page_url: string | null,
prev_cursor: string | null,
prev_page_url: string | null,
},
};
export type CursorPaginatorInterface<TKey, TValue> = Illuminate.CursorPaginator<TKey, TValue>;
export type LengthAwarePaginator<TKey, TValue> = {
data: TKey extends string ? Record<TKey, TValue> : TValue[],
links: {
url: string | null,
label: string,
active: boolean,
}[],
meta: {
total: number,
current_page: number,
first_page_url: string,
from: number | null,
last_page: number,
last_page_url: string,
next_page_url: string | null,
path: string,
per_page: number,
prev_page_url: string | null,
to: number | null,
},
};
export type LengthAwarePaginatorInterface<TKey, TValue> = Illuminate.LengthAwarePaginator<TKey, TValue>;
}
declare namespace Spatie {
namespace LaravelData {
export type CursorPaginatedDataCollection<TKey, TValue> = Illuminate.CursorPaginator<TKey, TValue>;
export type PaginatedDataCollection<TKey, TValue> = Illuminate.LengthAwarePaginator<TKey, TValue>;
}
}
