import type { Currency, OfferStatus, OfferVisibility } from '@/types/enums';
import type { ProductListItem } from '@/types/product';
import type { Region } from '@/types/region';
import type { User } from '@/types/user';

// Full offer detail — matches App\Http\Resources\OfferResource.
export type Offer = {
    id: number;
    user_id: number;
    farmer: User;
    product: ProductListItem;
    title: string;
    total_quantity: number;
    remaining_quantity: number;
    unit: string;
    total_display: string;
    remaining_display: string;
    regions: Region[];
    price: number;
    currency: Currency;
    price_formatted: string;
    visibility: OfferVisibility;
    status: OfferStatus;
    description: string | null;
    available_from: string;
    available_to: string | null;
};

// Lean offer for index/market cards — matches App\Http\Resources\OfferListItemResource.
export type OfferListItem = {
    id: number;
    product: ProductListItem;
    title: string;
    regions: Region[];
    total_quantity: number;
    remaining_quantity: number;
    unit: string;
    total_display: string;
    price: number;
    currency: Currency;
    price_formatted: string;
    visibility: OfferVisibility;
    status: OfferStatus;
    // Human-readable status from OfferStatus::label() (e.g. "On Sale") — the
    // resource sends this alongside the raw `status`, which stays for keying the
    // pill colours.
    status_label: string;
    available_from: string;
    available_to: string | null;
};
