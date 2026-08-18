<?php

namespace App\Enums;

/**
 * The Market's three segmented tabs. Selling = Offer browsing (Phase 3 has
 * data); Buying = Demand browsing (Phase 4 — always empty for now); All =
 * both combined (equals Selling until Demand exists).
 */
enum MarketTab: string
{
    case ALL = 'all';
    case SELLING = 'selling';
    case BUYING = 'buying';
}
