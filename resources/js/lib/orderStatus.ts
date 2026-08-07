// Presentational config for OrderStatus pills — shared by the Orders list,
// Order detail, and the campaign-detail claims list so the colours stay
// consistent. Keyed by the OrderStatus string values (mirrors App\Enums\OrderStatus).
// This is styling, not logic — safe to keep as-is.
import type { OrderStatus } from '@/types/enums';

type Pill = { label: string; chip: string; dot: string };

const PILLS: Record<OrderStatus, Pill> = {
    placed: {
        label: 'Placed',
        chip: 'bg-stone text-[#5A6150] border border-[#E8EAE2]',
        dot: 'bg-[#9AA08E]',
    },
    accepted: {
        label: 'Accepted',
        chip: 'bg-stone text-[#5A6150] border border-[#E8EAE2]',
        dot: 'bg-[#9AA08E]',
    },
    packing: {
        label: 'Packing',
        chip: 'bg-[#FAEEDA] text-[#9A6210]',
        dot: 'bg-[#EF9F27]',
    },
    in_transit: {
        label: 'In transit',
        chip: 'bg-[#FAEEDA] text-[#9A6210]',
        dot: 'bg-[#EF9F27]',
    },
    delivered: {
        label: 'Delivered',
        chip: 'bg-lime-pale text-[#3F5610]',
        dot: 'bg-[#7AB82A]',
    },
    cancelled: {
        label: 'Cancelled',
        chip: 'bg-[#FBE4E3] text-[#B0302F]',
        dot: 'bg-alert',
    },
};

export function statusPill(status: OrderStatus): Pill {
    return PILLS[status];
}
