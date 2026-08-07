// Hand-written mirrors of the PHP backed enums in `app/Enums`. These are the
// single source of truth for enum types on the frontend.
//
// KEEP IN SYNC WITH PHP: when you add/rename/remove a case in an `app/Enums`
// enum, update the matching union here. The string members MUST equal the PHP
// enum `->value`s exactly — they cross the wire as those strings.
//
//   app/Enums/Currency.php        → Currency
//   app/Enums/OfferStatus.php     → OfferStatus
//   app/Enums/OfferVisibility.php → OfferVisibility
//   app/Enums/OrderStatus.php     → OrderStatus
//   app/Enums/UserRole.php        → UserRole

export type Currency = 'USD';

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
