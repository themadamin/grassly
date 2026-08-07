import type { Currency, OrderStatus } from '@/types/enums';

// Full order (claim) detail — matches App\Http\Resources\OrderResource.
export type Order = {
    id: number;
    reference: string;
    item: string;
    quantity: number;
    unit: string;
    quantity_display: string;
    price: number;
    currency: Currency;
    price_formatted: string;
    total_formatted: string;
    status: OrderStatus;
    seller_name: string;
    buyer_name: string;
    delivery_window: string | null;
    destination: string | null;
    note: string | null;
    placed_at: string;
};

// Lean order for list screens — matches App\Http\Resources\OrderListItemResource.
export type OrderListItem = {
    id: number;
    reference: string;
    item: string;
    counterparty: string;
    quantity: number;
    quantity_display: string;
    status: OrderStatus;
    placed_at: string;
};
