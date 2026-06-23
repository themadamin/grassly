<template>
    <Head title="Grassly — Farmers and merchants, directly">
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link
            rel="preconnect"
            href="https://fonts.gstatic.com"
            crossorigin="anonymous"
        />
        <link
            href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,400;0,500;0,600;0,700;0,800;1,500;1,700&display=swap"
            rel="stylesheet"
        />
    </Head>

    <div
        class="min-h-svh bg-stone text-ink antialiased"
        style="font-family: 'Plus Jakarta Sans', system-ui, sans-serif"
    >
        <div class="mx-auto w-full max-w-[1280px]">
            <!-- NAV -->
            <header class="px-4 pt-6 sm:px-10">
                <nav
                    class="flex items-center justify-between rounded-full border border-[#E8EAE2] bg-white py-3 pr-3 pl-6"
                >
                    <Link
                        :href="'/'"
                        class="flex items-center gap-2.5"
                        aria-label="Grassly home"
                    >
                        <span class="size-[11px] rounded-full bg-lime"></span>
                        <span class="text-xl font-extrabold tracking-[-0.02em]"
                            >Grassly</span
                        >
                    </Link>

                    <div class="hidden items-center gap-9 md:flex">
                        <a
                            href="#how-it-works"
                            class="text-xs font-bold tracking-[0.13em] text-ink uppercase"
                            >How it works</a
                        >
                        <a
                            href="#for-farmers"
                            class="text-xs font-bold tracking-[0.13em] text-[#6B7260] uppercase"
                            >For farmers</a
                        >
                        <a
                            href="#for-merchants"
                            class="text-xs font-bold tracking-[0.13em] text-[#6B7260] uppercase"
                            >For merchants</a
                        >
                    </div>

                    <Link
                        :href="login()"
                        class="rounded-full bg-ink px-6 py-3 text-sm font-bold text-white"
                        >Sign in</Link
                    >
                </nav>
            </header>

            <!-- HERO -->
            <section class="px-4 pt-16 pb-16 text-center sm:px-10 sm:pt-20">
                <div
                    class="mb-7 inline-flex items-center gap-2 rounded-full bg-lime-pale px-4 py-2"
                >
                    <span class="size-[7px] rounded-full bg-lime-dark"></span>
                    <span
                        class="text-xs font-bold tracking-[0.08em] text-[#3F5610] uppercase"
                        >The direct farm-to-merchant marketplace</span
                    >
                </div>

                <h1
                    class="mx-auto max-w-[880px] text-5xl leading-[0.98] font-extrabold tracking-[-0.035em] sm:text-6xl lg:text-[72px]"
                >
                    Farmers and merchants, doing business
                    <span class="text-lime-dark">directly.</span>
                </h1>

                <p
                    class="mx-auto mt-6 max-w-[560px] text-lg leading-relaxed text-[#6B7260] sm:text-[19px]"
                >
                    List your harvest and storage, find buyers, and settle
                    public or private orders — without the middlemen eating your
                    margin.
                </p>

                <div
                    class="mt-9 flex flex-col items-center justify-center gap-3 sm:flex-row sm:gap-3.5"
                >
                    <Link
                        :href="register()"
                        class="inline-flex items-center gap-2.5 rounded-xl bg-lime px-7 py-4 text-base font-bold text-ink"
                    >
                        Get started
                        <svg
                            width="17"
                            height="17"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2.4"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        >
                            <path d="M5 12 H19" />
                            <path d="M13 6 L19 12 L13 18" />
                        </svg>
                    </Link>
                    <a
                        href="#how-it-works"
                        class="inline-flex items-center gap-2.5 rounded-xl px-5 py-4 text-base font-bold text-ink"
                    >
                        <span
                            class="inline-flex size-[34px] items-center justify-center rounded-full border border-[#C8CCBE]"
                        >
                            <svg
                                width="13"
                                height="13"
                                viewBox="0 0 24 24"
                                fill="currentColor"
                            >
                                <path d="M8 5 V19 L19 12 Z" />
                            </svg>
                        </span>
                        See how it works
                    </a>
                </div>

                <!-- TRUST STRIP -->
                <div
                    class="mt-14 inline-flex flex-col items-stretch overflow-hidden rounded-[18px] border border-[#E8EAE2] bg-white sm:flex-row"
                >
                    <div class="px-10 py-5.5 text-center">
                        <div
                            class="text-[34px] leading-none font-extrabold tracking-[-0.03em]"
                        >
                            2,400+
                        </div>
                        <div
                            class="mt-1.5 text-[13px] font-semibold text-[#6B7260]"
                        >
                            Storage units listed
                        </div>
                    </div>
                    <div class="bg-[#E8EAE2] max-sm:h-px sm:w-px"></div>
                    <div class="px-10 py-5.5 text-center">
                        <div
                            class="text-[34px] leading-none font-extrabold tracking-[-0.03em]"
                        >
                            860
                        </div>
                        <div
                            class="mt-1.5 text-[13px] font-semibold text-[#6B7260]"
                        >
                            Active orders
                        </div>
                    </div>
                    <div class="bg-[#E8EAE2] max-sm:h-px sm:w-px"></div>
                    <div class="px-10 py-5.5 text-center">
                        <div
                            class="text-[34px] leading-none font-extrabold tracking-[-0.03em] text-lime-dark"
                        >
                            98.2%
                        </div>
                        <div
                            class="mt-1.5 text-[13px] font-semibold text-[#6B7260]"
                        >
                            On-time delivery
                        </div>
                    </div>
                </div>
            </section>

            <!-- ROLE SPLIT -->
            <section id="for-farmers" class="px-4 pb-16 sm:px-10">
                <div class="grid gap-6 md:grid-cols-2">
                    <!-- Farmer — lime header -->
                    <div
                        class="overflow-hidden rounded-[20px] border border-[#E8EAE2] bg-white"
                    >
                        <div
                            class="relative flex h-[130px] items-center justify-between bg-lime p-6"
                            style="
                                background-image: repeating-radial-gradient(
                                    circle at 84% 20%,
                                    transparent 0 15px,
                                    rgba(15, 21, 16, 0.07) 15px 16.5px
                                );
                            "
                        >
                            <div>
                                <div
                                    class="mb-1.5 text-xs font-extrabold tracking-[0.14em] text-[#3F5610] uppercase"
                                >
                                    I'm a farmer
                                </div>
                                <div
                                    class="text-[27px] font-extrabold tracking-[-0.02em] text-ink"
                                >
                                    Sell what you grow
                                </div>
                            </div>
                            <div
                                class="flex size-[54px] flex-none items-center justify-center rounded-[14px] bg-ink"
                            >
                                <svg
                                    width="26"
                                    height="26"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="#A8E63D"
                                    stroke-width="2"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                >
                                    <path d="M7 20 C7 14 9 11 14 10" />
                                    <path
                                        d="M14 10 C19 9 21 5 21 5 C21 5 16 4 13 6 C10.5 7.7 10 10 14 10 Z"
                                    />
                                    <path
                                        d="M7 20 C7 17 5 14 3 13 C3 13 4 17 7 20 Z"
                                    />
                                </svg>
                            </div>
                        </div>
                        <div class="px-7 pt-6 pb-7">
                            <ul class="flex flex-col gap-4">
                                <li class="flex items-start gap-3.5">
                                    <span
                                        class="flex size-[26px] flex-none items-center justify-center rounded-lg bg-lime-pale"
                                    >
                                        <svg
                                            width="14"
                                            height="14"
                                            viewBox="0 0 24 24"
                                            fill="none"
                                            stroke="#5C8A1A"
                                            stroke-width="3"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                        >
                                            <path d="M5 12 L10 17 L19 7" />
                                        </svg>
                                    </span>
                                    <div>
                                        <div class="text-base font-bold">
                                            List storage &amp; harvest
                                        </div>
                                        <div
                                            class="text-sm leading-snug text-[#6B7260]"
                                        >
                                            Post available crops, quantities,
                                            and cold-storage space.
                                        </div>
                                    </div>
                                </li>
                                <li class="flex items-start gap-3.5">
                                    <span
                                        class="flex size-[26px] flex-none items-center justify-center rounded-lg bg-lime-pale"
                                    >
                                        <svg
                                            width="14"
                                            height="14"
                                            viewBox="0 0 24 24"
                                            fill="none"
                                            stroke="#5C8A1A"
                                            stroke-width="3"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                        >
                                            <path d="M5 12 L10 17 L19 7" />
                                        </svg>
                                    </span>
                                    <div>
                                        <div class="text-base font-bold">
                                            Publish harvest forecasts
                                        </div>
                                        <div
                                            class="text-sm leading-snug text-[#6B7260]"
                                        >
                                            Let merchants pre-book against
                                            what's coming next season.
                                        </div>
                                    </div>
                                </li>
                                <li class="flex items-start gap-3.5">
                                    <span
                                        class="flex size-[26px] flex-none items-center justify-center rounded-lg bg-lime-pale"
                                    >
                                        <svg
                                            width="14"
                                            height="14"
                                            viewBox="0 0 24 24"
                                            fill="none"
                                            stroke="#5C8A1A"
                                            stroke-width="3"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                        >
                                            <path d="M5 12 L10 17 L19 7" />
                                        </svg>
                                    </span>
                                    <div>
                                        <div class="text-base font-bold">
                                            Accept public or private orders
                                        </div>
                                        <div
                                            class="text-sm leading-snug text-[#6B7260]"
                                        >
                                            Sell on the open market or to
                                            trusted buyers only.
                                        </div>
                                    </div>
                                </li>
                            </ul>
                            <Link
                                :href="register()"
                                class="mt-6 block w-full rounded-xl bg-lime py-3.5 text-center text-[15px] font-bold text-ink"
                                >Join as a farmer</Link
                            >
                        </div>
                    </div>

                    <!-- Merchant — ink header -->
                    <div
                        id="for-merchants"
                        class="overflow-hidden rounded-[20px] border border-[#E8EAE2] bg-white"
                    >
                        <div
                            class="relative flex h-[130px] items-center justify-between bg-ink p-6"
                            style="
                                background-image: repeating-radial-gradient(
                                    circle at 84% 20%,
                                    transparent 0 15px,
                                    rgba(168, 230, 61, 0.1) 15px 16.5px
                                );
                            "
                        >
                            <div>
                                <div
                                    class="mb-1.5 text-xs font-extrabold tracking-[0.14em] text-[#8C9482] uppercase"
                                >
                                    I'm a merchant
                                </div>
                                <div
                                    class="text-[27px] font-extrabold tracking-[-0.02em] text-white"
                                >
                                    Source with confidence
                                </div>
                            </div>
                            <div
                                class="flex size-[54px] flex-none items-center justify-center rounded-[14px] bg-lime"
                            >
                                <svg
                                    width="26"
                                    height="26"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="#0F1510"
                                    stroke-width="2"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                >
                                    <path d="M5 7 H19 L18 18 H6 Z" />
                                    <path d="M9 7 V5 a3 3 0 0 1 6 0 v2" />
                                </svg>
                            </div>
                        </div>
                        <div class="px-7 pt-6 pb-7">
                            <ul class="flex flex-col gap-4">
                                <li class="flex items-start gap-3.5">
                                    <span
                                        class="flex size-[26px] flex-none items-center justify-center rounded-lg bg-stone"
                                    >
                                        <svg
                                            width="14"
                                            height="14"
                                            viewBox="0 0 24 24"
                                            fill="none"
                                            stroke="#0F1510"
                                            stroke-width="3"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                        >
                                            <path d="M5 12 L10 17 L19 7" />
                                        </svg>
                                    </span>
                                    <div>
                                        <div class="text-base font-bold">
                                            Browse live listings
                                        </div>
                                        <div
                                            class="text-sm leading-snug text-[#6B7260]"
                                        >
                                            Search produce and storage by
                                            region, crop, and availability.
                                        </div>
                                    </div>
                                </li>
                                <li class="flex items-start gap-3.5">
                                    <span
                                        class="flex size-[26px] flex-none items-center justify-center rounded-lg bg-stone"
                                    >
                                        <svg
                                            width="14"
                                            height="14"
                                            viewBox="0 0 24 24"
                                            fill="none"
                                            stroke="#0F1510"
                                            stroke-width="3"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                        >
                                            <path d="M5 12 L10 17 L19 7" />
                                        </svg>
                                    </span>
                                    <div>
                                        <div class="text-base font-bold">
                                            Place &amp; track orders
                                        </div>
                                        <div
                                            class="text-sm leading-snug text-[#6B7260]"
                                        >
                                            Lock in volume early and follow
                                            every delivery in real time.
                                        </div>
                                    </div>
                                </li>
                                <li class="flex items-start gap-3.5">
                                    <span
                                        class="flex size-[26px] flex-none items-center justify-center rounded-lg bg-stone"
                                    >
                                        <svg
                                            width="14"
                                            height="14"
                                            viewBox="0 0 24 24"
                                            fill="none"
                                            stroke="#0F1510"
                                            stroke-width="3"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                        >
                                            <path d="M5 12 L10 17 L19 7" />
                                        </svg>
                                    </span>
                                    <div>
                                        <div class="text-base font-bold">
                                            Chat directly with growers
                                        </div>
                                        <div
                                            class="text-sm leading-snug text-[#6B7260]"
                                        >
                                            Negotiate terms and build
                                            relationships without
                                            intermediaries.
                                        </div>
                                    </div>
                                </li>
                            </ul>
                            <Link
                                :href="register()"
                                class="mt-6 block w-full rounded-xl bg-ink py-3.5 text-center text-[15px] font-bold text-white"
                                >Join as a merchant</Link
                            >
                        </div>
                    </div>
                </div>
            </section>

            <!-- FEATURE GRID -->
            <section id="how-it-works" class="px-4 pb-20 sm:px-10">
                <div class="mb-9 text-center">
                    <div
                        class="mb-3 text-xs font-extrabold tracking-[0.16em] text-lime-dark uppercase"
                    >
                        Everything in one place
                    </div>
                    <h2
                        class="text-[32px] font-extrabold tracking-[-0.025em] sm:text-[40px]"
                    >
                        Built for the whole season
                    </h2>
                </div>

                <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
                    <!-- Storage listings -->
                    <article
                        class="rounded-[20px] border border-[#E8EAE2] bg-white p-6.5"
                    >
                        <div
                            class="mb-4.5 flex size-[46px] items-center justify-center rounded-[13px] bg-stone"
                        >
                            <svg
                                width="22"
                                height="22"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="#0F1510"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            >
                                <path d="M3 9 L12 4 L21 9 V20 H3 Z" />
                                <path d="M3 9 H21" />
                                <path d="M9 20 V13 H15 V20" />
                            </svg>
                        </div>
                        <h3 class="mb-1.5 text-lg font-bold">
                            Storage listings
                        </h3>
                        <p class="text-sm leading-normal text-[#6B7260]">
                            Post and discover cold storage and warehouse space
                            by location and capacity.
                        </p>
                    </article>

                    <!-- Harvest forecasts -->
                    <article
                        class="rounded-[20px] border border-[#E8EAE2] bg-white p-6.5"
                    >
                        <div
                            class="mb-4.5 flex size-[46px] items-center justify-center rounded-[13px] bg-[#FAEEDA]"
                        >
                            <svg
                                width="22"
                                height="22"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="#EF9F27"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            >
                                <path d="M4 18 L9 12 L13 15 L20 6" />
                                <path d="M15 6 H20 V11" />
                            </svg>
                        </div>
                        <h3 class="mb-1.5 text-lg font-bold">
                            Harvest forecasts
                        </h3>
                        <p class="text-sm leading-normal text-[#6B7260]">
                            Share what's coming and let buyers pre-book against
                            future yield.
                        </p>
                    </article>

                    <!-- Public & private orders -->
                    <article
                        class="rounded-[20px] border border-[#E8EAE2] bg-white p-6.5"
                    >
                        <div
                            class="mb-4.5 flex size-[46px] items-center justify-center rounded-[13px] bg-stone"
                        >
                            <svg
                                width="22"
                                height="22"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="#0F1510"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            >
                                <rect
                                    x="4"
                                    y="4"
                                    width="16"
                                    height="16"
                                    rx="3"
                                />
                                <path d="M9 12 L11 14 L15 9" />
                            </svg>
                        </div>
                        <h3 class="mb-1.5 text-lg font-bold">
                            Public &amp; private orders
                        </h3>
                        <p class="text-sm leading-normal text-[#6B7260]">
                            Sell openly on the marketplace or privately to
                            invited buyers.
                        </p>
                    </article>

                    <!-- Delivery tracking -->
                    <article
                        class="rounded-[20px] border border-[#E8EAE2] bg-white p-6.5"
                    >
                        <div
                            class="mb-4.5 flex size-[46px] items-center justify-center rounded-[13px] bg-stone"
                        >
                            <svg
                                width="22"
                                height="22"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="#0F1510"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            >
                                <path d="M3 7 H14 V16 H3 Z" />
                                <path d="M14 10 H18 L21 13 V16 H14 Z" />
                                <circle cx="7" cy="18" r="2" />
                                <circle cx="17" cy="18" r="2" />
                            </svg>
                        </div>
                        <h3 class="mb-1.5 text-lg font-bold">
                            Delivery tracking
                        </h3>
                        <p class="text-sm leading-normal text-[#6B7260]">
                            Follow every shipment from farm gate to warehouse
                            door in real time.
                        </p>
                    </article>

                    <!-- Real-time chat -->
                    <article
                        class="rounded-[20px] border border-[#E8EAE2] bg-white p-6.5"
                    >
                        <div
                            class="mb-4.5 flex size-[46px] items-center justify-center rounded-[13px] bg-lime-pale"
                        >
                            <svg
                                width="22"
                                height="22"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="#5C8A1A"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            >
                                <path d="M4 5 H20 V16 H12 L8 20 V16 H4 Z" />
                            </svg>
                        </div>
                        <h3 class="mb-1.5 text-lg font-bold">Real-time chat</h3>
                        <p class="text-sm leading-normal text-[#6B7260]">
                            Message growers and buyers directly to negotiate and
                            coordinate.
                        </p>
                    </article>

                    <!-- Community feed -->
                    <article
                        class="rounded-[20px] border border-[#E8EAE2] bg-white p-6.5"
                    >
                        <div
                            class="mb-4.5 flex size-[46px] items-center justify-center rounded-[13px] bg-stone"
                        >
                            <svg
                                width="22"
                                height="22"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="#0F1510"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            >
                                <circle cx="9" cy="8" r="3" />
                                <path
                                    d="M3 19 C3 15 5 14 9 14 C13 14 15 15 15 19"
                                />
                                <path d="M16 6 a3 3 0 0 1 0 5" />
                                <path d="M17 14 C20 14.5 21 16 21 19" />
                            </svg>
                        </div>
                        <h3 class="mb-1.5 text-lg font-bold">Community feed</h3>
                        <p class="text-sm leading-normal text-[#6B7260]">
                            Market news, price signals, and tips from growers in
                            your region.
                        </p>
                    </article>
                </div>
            </section>
        </div>

        <!-- FOOTER -->
        <footer class="border-t border-[#E8EAE2] bg-white">
            <div class="mx-auto w-full max-w-[1280px] px-4 py-10 sm:px-10">
                <div
                    class="flex flex-col items-start justify-between gap-10 sm:flex-row"
                >
                    <div class="max-w-[280px]">
                        <div class="mb-3 flex items-center gap-2.5">
                            <span
                                class="size-[11px] rounded-full bg-lime"
                            ></span>
                            <span
                                class="text-[19px] font-extrabold tracking-[-0.02em]"
                                >Grassly</span
                            >
                        </div>
                        <p class="text-[13px] leading-normal text-[#6B7260]">
                            The direct marketplace linking farmers and
                            merchants. A learning project — not a real
                            commercial service.
                        </p>
                    </div>
                    <div class="flex gap-16">
                        <div class="flex flex-col gap-2.5">
                            <div
                                class="mb-1 text-[11px] font-extrabold tracking-[0.14em] text-ink uppercase"
                            >
                                Product
                            </div>
                            <a
                                href="#how-it-works"
                                class="text-sm text-[#6B7260]"
                                >How it works</a
                            >
                            <a
                                href="#for-farmers"
                                class="text-sm text-[#6B7260]"
                                >For farmers</a
                            >
                            <a
                                href="#for-merchants"
                                class="text-sm text-[#6B7260]"
                                >For merchants</a
                            >
                        </div>
                        <div class="flex flex-col gap-2.5">
                            <div
                                class="mb-1 text-[11px] font-extrabold tracking-[0.14em] text-ink uppercase"
                            >
                                Account
                            </div>
                            <Link :href="login()" class="text-sm text-[#6B7260]"
                                >Sign in</Link
                            >
                            <Link
                                :href="register()"
                                class="text-sm text-[#6B7260]"
                                >Create account</Link
                            >
                        </div>
                    </div>
                </div>
                <div
                    class="mt-9 flex items-center justify-between border-t border-[#E8EAE2] pt-6"
                >
                    <span class="text-[13px] text-[#8A9180]"
                        >© 2026 Grassly</span
                    >
                    <span
                        class="inline-flex items-center gap-2 rounded-full border border-[#E8EAE2] bg-stone px-3.5 py-1.5 text-xs font-bold text-[#6B7260]"
                    >
                        <span class="size-[7px] rounded-full bg-harvest"></span
                        >A learning project
                    </span>
                </div>
            </div>
        </footer>
    </div>
</template>

<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { login, register } from '@/routes';

// This is the public marketing home. Per the working agreement there is no
// real business logic here — the only interactivity is navigation, handled by
// Inertia's <Link> with the generated route helpers (login / register).
//
// TODO(you): if you want the "See how it works" button to smooth-scroll to a
// section instead of navigating, add a ref to that section + a click handler.
// Hint: template refs in Composition API — const howItWorks = ref<HTMLElement>()
// then howItWorks.value?.scrollIntoView({ behavior: 'smooth' }).
</script>
