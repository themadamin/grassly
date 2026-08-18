declare namespace App {
    namespace Data {
        namespace Filters {
            export type MarketFilterData = {
                readonly search: string | null;
                readonly category: number | null;
                readonly crop: number | null;
                readonly region: number | null;
                readonly availability: string | null;
                readonly date_from: string | null;
                readonly date_to: string | null;
                readonly price_min: number | null;
                readonly price_max: number | null;
                readonly sort: App.Enums.MarketSortOption | null;
            };
            export type OfferFilterData = {
                readonly status: App.Enums.OfferStatus | null;
                readonly search: string | null;
                readonly price_min: number | null;
                readonly price_max: number | null;
                readonly product_id: number | null;
                readonly region: number | null;
                readonly sort: App.Enums.OfferSortOption | null;
            };
        }
    }
    namespace Enums {
        export type Currency = 'USD';
        export type MarketSortOption =
            | 'newest'
            | 'oldest'
            | 'price_asc'
            | 'price_desc'
            | 'quantity';
        export type MarketTab = 'all' | 'selling' | 'buying';
        export type OfferSortOption =
            | 'newest'
            | 'oldest'
            | 'price_asc'
            | 'price_desc';
        export type OfferStatus = 'draft' | 'on_sale' | 'closed';
        export type OfferVisibility = 'public' | 'private';
        export type OrderStatus =
            | 'placed'
            | 'accepted'
            | 'packing'
            | 'in_transit'
            | 'delivered'
            | 'cancelled';
        export type UserRole = 'farmer' | 'merchant' | 'admin';
    }
}
