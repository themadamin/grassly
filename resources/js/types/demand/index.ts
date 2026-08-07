import type { Currency, OfferStatus } from '@/types/enums';
import type { OrderListItem } from '@/types/order';

// Full demand (merchant buy-offer) detail — matches App\Http\Resources\DemandResource.
export type Demand = {
    id: number;
    title: string;
    category: string;
    region: string;
    quantity: number;
    fulfilled_quantity: number;
    unit: string;
    quantity_display: string;
    fulfilled_display: string;
    price: number;
    currency: Currency;
    price_formatted: string;
    progress_percent: number;
    status: OfferStatus;
    merchant_name: string;
    needed_by: string | null;
    note: string | null;
    claims: OrderListItem[];
};

// Lean demand for list screens — matches App\Http\Resources\DemandListItemResource.
export type DemandListItem = {
    id: number;
    title: string;
    category: string;
    region: string;
    quantity: number;
    fulfilled_quantity: number;
    unit: string;
    quantity_display: string;
    price: number;
    currency: Currency;
    price_formatted: string;
    progress_percent: number;
    status: OfferStatus;
};
