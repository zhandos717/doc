<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @production
        <!-- Google tag (gtag.js) -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=G-27X6XFV0GK"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());

            gtag('config', 'G-27X6XFV0GK');
        </script>
    @endproduction
    <meta charset="utf-8" />
    <title>MoonShine - админ панель для проектов на Laravel</title>
    <meta name="description" content="MoonShine - пакет для ускоренной разработки web-проектов на Laravel.
MoonShine отлично подходит для создания админ панели, MVP, backoffice, и CMS. Простая для новичков, безграничная для профессионалов. Открытый исходный код." />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1" />

    <!-- Theme settings -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}" />
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}" />
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}" />
    <link rel="mask-icon" href="{{ asset('safari-pinned-tab.svg') }}" color="#1A1B41" />
    <meta name="msapplication-TileColor" content="#1A1B41" />
    <meta name="theme-color" content="#1A1B41" />

    <style>
        [x-cloak] { display: none !important; }
    </style>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body x-data="{ openMobileMenu: false }" x-cloak>
<!-- Site header -->
<header class="header pt-6 2xl:pt-10">
    <div class="container">
        <div class="header-inner flex items-center justify-between gap-x-6 lg:gap-x-12 lg:justify-start">
            <div class="header-logo shrink-0">
                <a href="{{ route('home') }}" class="relative w-[114px]" rel="home">
                    <img src="{{ Vite::asset('resources/images/logo-moon.svg') }}" class="animate-wiggle w-[67px] h-[70px]" alt="MoonShine" />
                    <img src="{{ Vite::asset('resources/images/logo-text.svg') }}" class="absolute top-1/2 left-[42px] z-2 -translate-y-1/2 w-[71px] h-[21px]" alt="MoonShine" />
                </a>
            </div>
            <!-- /.header-logo -->
            <div class="header-menu hidden grow lg:block">
                <nav class="hidden flex-wrap gap-10 2xl:flex">
                    @foreach(config('promo_menu_' . app()->getLocale(), []) as $menu)
                        <a
                            href="{{ $menu['link'] }}"
                            class="font-semibold text-white hover:text-pink"
                            @if($menu['blank']) target="_blank" @endif
                        >
                            {{ $menu['title'] }}
                        </a>
                    @endforeach
                </nav>
            </div>
            <!-- /.header-menu -->
            <div class="header-actions flex items-center">
                <div class="flex items-center gap-x-2 sm:gap-x-3 md:gap-x-5">

                    {{--<button type="button" class="text-white hover:text-pink">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 md:h-6 md:w-6" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="m23.58 21.572-4.612-4.613a10.481 10.481 0 0 0 2.165-6.391c0-2.823-1.1-5.476-3.096-7.473A10.497 10.497 0 0 0 10.565 0a10.5 10.5 0 0 0-7.472 3.095c-4.12 4.12-4.12 10.825 0 14.945a10.497 10.497 0 0 0 7.472 3.096 10.48 10.48 0 0 0 6.392-2.166l4.612 4.613a1.419 1.419 0 0 0 2.011 0 1.423 1.423 0 0 0 0-2.011ZM5.104 16.029c-3.011-3.011-3.01-7.911 0-10.923a7.674 7.674 0 0 1 5.462-2.26 7.673 7.673 0 0 1 5.46 2.26 7.674 7.674 0 0 1 2.262 5.462 7.675 7.675 0 0 1-2.262 5.461 7.669 7.669 0 0 1-5.461 2.262 7.678 7.678 0 0 1-5.461-2.262Z"
                            />
                        </svg>
                    </button>--}}

                    <x-doc-search />

                    <div class="h-4 w-[1px] bg-white/25"></div>

                    <a href="{{ config('links_' . app()->getLocale() . '.github') }}" class="text-white hover:text-pink" target="_blank" rel="noopener nofollow">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 md:h-6 md:w-6" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M12 .5C5.37.5 0 5.78 0 12.292c0 5.211 3.438 9.63 8.205 11.188.6.111.82-.254.82-.567 0-.28-.01-1.022-.015-2.005-3.338.711-4.042-1.582-4.042-1.582-.546-1.361-1.335-1.725-1.335-1.725-1.087-.731.084-.716.084-.716 1.205.082 1.838 1.215 1.838 1.215 1.07 1.803 2.809 1.282 3.495.981.108-.763.417-1.282.76-1.577-2.665-.295-5.466-1.309-5.466-5.827 0-1.287.465-2.339 1.235-3.164-.135-.298-.54-1.497.105-3.121 0 0 1.005-.316 3.3 1.209.96-.262 1.98-.392 3-.398 1.02.006 2.04.136 3 .398 2.28-1.525 3.285-1.209 3.285-1.209.645 1.624.24 2.823.12 3.121.765.825 1.23 1.877 1.23 3.164 0 4.53-2.805 5.527-5.475 5.817.42.354.81 1.077.81 2.182 0 1.578-.015 2.846-.015 3.229 0 .309.21.678.825.56C20.565 21.917 24 17.495 24 12.292 24 5.78 18.627.5 12 .5Z"
                            />
                        </svg>
                    </a>
                    <div class="h-4 w-[1px] bg-white/25"></div>
                    <a href="{{ route('locale', ['local' => 'en']) }}" class="flex items-center gap-x-2 text-white hover:text-pink" rel="nofollow">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 md:h-6 md:w-6 fill-pink" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M6.502 6.422h-.301l-.562 2.812h1.425l-.562-2.812Zm11.375 5.625a7.35 7.35 0 0 0 1.154 2.037c.447-.561.898-1.222 1.201-2.037h-2.355Z" />
                            <path
                                d="M21.89 4.266h-8.73l1.82 14.61c.033.597-.13 1.16-.52 1.6L11.374 24H21.89c1.163 0 2.11-.946 2.11-2.11V6.423c0-1.163-.947-2.156-2.11-2.156Zm0 7.78h-.187a8.922 8.922 0 0 1-1.694 3.08c.517.473 1.069.86 1.618 1.294a.703.703 0 1 1-.879 1.097c-.597-.47-1.157-.865-1.717-1.379-.56.514-1.073.908-1.67 1.38a.703.703 0 1 1-.878-1.098c.549-.434 1.054-.821 1.57-1.293-.659-.792-1.246-1.796-1.646-3.08h-.188a.703.703 0 1 1 0-1.406h2.11v-.704a.703.703 0 1 1 1.405 0v.704h2.157a.703.703 0 1 1 0 1.406Z"
                            />
                            <path
                                d="M11.445 1.848A2.112 2.112 0 0 0 9.352 0H2.11C.946 0 0 .946 0 2.11v15.562c0 1.163.946 2.11 2.11 2.11h11.088c.205-.235.377-.382.384-.688.002-.077-2.127-17.17-2.137-17.246ZM8.622 13.439a.703.703 0 0 1-.827-.551l-.45-2.247H5.359l-.45 2.247a.703.703 0 0 1-1.379-.276l1.407-7.031a.704.704 0 0 1 .689-.565h1.453c.335 0 .624.237.69.565l1.406 7.031a.703.703 0 0 1-.552.827Zm-.407 7.748.121.965c.08.646.51 1.305 1.216 1.634l2.36-2.599H8.215Z"
                            />
                        </svg>
                        <span class="text-xs sm:text-sm font-medium">EN</span>
                    </a>
                </div>
                {{--
                    <a href="#" class="btn btn-purple ml-8 !hidden md:!flex 2xl:ml-12">MoonShine PRO</a>
                --}}
                <button class="ml-4 flex text-white transition hover:text-pink 2xl:hidden" @click="openMobileMenu = ! openMobileMenu">
                    <span class="sr-only">Меню</span>
                    <svg class="h-8 w-8" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
            <!-- /.header-actions -->
        </div>
        <!-- /.header-inner -->
    </div>
    <!-- /.container -->
</header>

<main class="py-12 md:py-16 lg:py-20">
    <div class="container prose prose-invert">
        {!! $content !!}
    </div>
</main>

<!-- Site footer -->
<footer class="footer py-8 sm:py-12 xl:py-16">
    <div class="container">
        <div class="flex flex-col 2xl:flex-row items-center gap-x-6 gap-y-10">
            <div class="footer-logo shrink-0 text-center sm:text-left">
                <a href="{{ route('home') }}" class="relative w-[114px]" rel="home">
                    <img src="{{ Vite::asset('resources/images/logo-moon.svg') }}" class="animate-wiggle w-[67px] h-[70px]" alt="MoonShine" />
                    <img src="{{ Vite::asset('resources/images/logo-text.svg') }}" class="absolute top-1/2 left-[42px] z-2 -translate-y-1/2 w-[71px] h-[21px]" alt="MoonShine" />
                </a>
            </div><!-- /.footer-logo -->

            <div class="footer-menu grow">
                <nav class="flex flex-wrap justify-center 2xl:justify-start gap-x-6 gap-y-3">
                    @foreach(config('promo_menu_' . app()->getLocale(), []) as $menu)
                        <a
                            href="{{ $menu['link'] }}"
                            class="font-semibold text-white hover:text-pink"
                            @if($menu['blank']) target="_blank" @endif
                        >
                            {{ $menu['title'] }}
                        </a>
                    @endforeach

                    <a href="/rules" class="font-semibold text-white hover:text-pink">Пользовательское соглашение</a>
                    <a href="/politics" class="font-semibold text-white hover:text-pink">Политика конфиденциальности</a>
                </nav>
            </div>
            <div class="footer-social">
                <div class="flex flex-wrap items-center justify-center sm:justify-end gap-x-4 md:gap-x-6 gap-y-3">
                    <a href="{{ config('links_' . app()->getLocale() . '.github') }}"
                       class="inline-flex items-center text-white hover:text-pink" target="_blank" rel="noopener nofollow">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 lg:h-6" fill="white" viewBox="0 0 24 24">
                            <path
                                d="M12 .5C5.37.5 0 5.78 0 12.292c0 5.211 3.438 9.63 8.205 11.188.6.111.82-.254.82-.567 0-.28-.01-1.022-.015-2.005-3.338.711-4.042-1.582-4.042-1.582-.546-1.361-1.335-1.725-1.335-1.725-1.087-.731.084-.716.084-.716 1.205.082 1.838 1.215 1.838 1.215 1.07 1.803 2.809 1.282 3.495.981.108-.763.417-1.282.76-1.577-2.665-.295-5.466-1.309-5.466-5.827 0-1.287.465-2.339 1.235-3.164-.135-.298-.54-1.497.105-3.121 0 0 1.005-.316 3.3 1.209.96-.262 1.98-.392 3-.398 1.02.006 2.04.136 3 .398 2.28-1.525 3.285-1.209 3.285-1.209.645 1.624.24 2.823.12 3.121.765.825 1.23 1.877 1.23 3.164 0 4.53-2.805 5.527-5.475 5.817.42.354.81 1.077.81 2.182 0 1.578-.015 2.846-.015 3.229 0 .309.21.678.825.56C20.565 21.917 24 17.495 24 12.292 24 5.78 18.627.5 12 .5Z"
                            />
                        </svg>
                        <span class="ml-2 lg:ml-3 text-xxs font-semibold">GitHub</span>
                    </a>
                    <div class="h-4 w-[2px] bg-white/25"></div>
                    <a href="{{ config('links_' . app()->getLocale() . '.youtube') }}" class="inline-flex items-center text-white hover:text-pink" target="_blank"
                       rel="nofollow noopener">
                        <img class="h-5 lg:h-6" src="{{ Vite::asset('resources/images/icons/youtube.svg') }}" alt="YouTube">
                        <span class="ml-2 lg:ml-3 text-xxs font-semibold">YouTube</span>
                    </a>
                    <div class="h-4 w-[2px] bg-white/25"></div>
                    <a href="{{ config('links_' . app()->getLocale() . '.chat') }}" class="inline-flex items-center text-white hover:text-pink" target="_blank"
                       rel="nofollow noopener">
                        <img class="h-5 lg:h-6" src="{{ Vite::asset('resources/images/icons/telegram.svg') }}" alt="Telegram">
                        <span class="ml-2 lg:ml-3 text-xxs font-semibold">Telegram</span>
                    </a>
                </div>
            </div><!-- /.footer-social -->
        </div>
        <div class="footer-copyright mt-10">
            <div class="text-[#999] text-xxs md:text-xs text-center">CutCode, MoonShine, {{ now()->year }} © Все права
                защищены.
            </div>
        </div><!-- /.footer-copyright -->
    </div><!-- /.container -->
</footer>

<div
    class="bg-body fixed inset-0 z-[9999] overflow-auto"
    x-show="openMobileMenu"
    x-transition:enter="ease-out duration-300"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="ease-in duration-150"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
>
    <div class="h-full pt-6 2xl:pt-10 pb-12 overflow-y-auto">
        <div class="container">
            <div class="mmenu-heading flex items-center">
                <div class="shrink-0 grow">
                    <a href="{{ route('home') }}" class="relative w-[114px]" rel="home">
                        <img src="{{ Vite::asset('resources/images/logo-moon.svg') }}" class="animate-wiggle w-[67px] h-[70px]" alt="MoonShine" />
                        <img src="{{ Vite::asset('resources/images/logo-text.svg') }}" class="absolute top-1/2 left-[42px] z-2 -translate-y-1/2 w-[71px] h-[21px]" alt="MoonShine" />
                    </a>
                </div>
                <div class="shrink-0 flex items-center">
                    <button id="closeMobileMenu" class="text-white hover:text-pink transition"
                            @click="openMobileMenu = ! openMobileMenu">
                        <span class="sr-only">Закрыть меню</span>
                        <svg class="w-8 h-8" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                             stroke="currentColor"
                             aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div><!-- /.mmenu-heading -->
            <div class="mmenu-inner pt-6">
                {{--<a href="#" class="btn btn-purple">MoonShine Pro</a>--}}
                <nav class="flex flex-col gap-y-3 mt-8">
                    @foreach(config('promo_menu_' . app()->getLocale(), []) as $menu)
                        <a
                            href="{{ $menu['link'] }}"
                            class="text-md font-semibold text-white hover:text-pink"
                            @if($menu['blank']) target="_blank" @endif
                        >
                            {{ $menu['title'] }}
                        </a>
                    @endforeach
                </nav>
                <div class="flex flex-wrap items-center gap-x-4 md:gap-x-6 gap-y-3 mt-10">
                    <a href="{{ config('links_' . app()->getLocale() . '.github') }}"
                       class="inline-flex items-center text-white hover:text-pink" target="_blank" rel="noopener nofollow">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 lg:h-6" fill="white" viewBox="0 0 24 24">
                            <path
                                d="M12 .5C5.37.5 0 5.78 0 12.292c0 5.211 3.438 9.63 8.205 11.188.6.111.82-.254.82-.567 0-.28-.01-1.022-.015-2.005-3.338.711-4.042-1.582-4.042-1.582-.546-1.361-1.335-1.725-1.335-1.725-1.087-.731.084-.716.084-.716 1.205.082 1.838 1.215 1.838 1.215 1.07 1.803 2.809 1.282 3.495.981.108-.763.417-1.282.76-1.577-2.665-.295-5.466-1.309-5.466-5.827 0-1.287.465-2.339 1.235-3.164-.135-.298-.54-1.497.105-3.121 0 0 1.005-.316 3.3 1.209.96-.262 1.98-.392 3-.398 1.02.006 2.04.136 3 .398 2.28-1.525 3.285-1.209 3.285-1.209.645 1.624.24 2.823.12 3.121.765.825 1.23 1.877 1.23 3.164 0 4.53-2.805 5.527-5.475 5.817.42.354.81 1.077.81 2.182 0 1.578-.015 2.846-.015 3.229 0 .309.21.678.825.56C20.565 21.917 24 17.495 24 12.292 24 5.78 18.627.5 12 .5Z"
                            />
                        </svg>
                        <span class="ml-2 lg:ml-3 text-xxs font-medium">GitHub</span>
                    </a>
                    <div class="h-4 w-[2px] bg-white/25"></div>
                    <a href="{{ config('links_' . app()->getLocale() . '.youtube') }}" class="inline-flex items-center text-white hover:text-pink" target="_blank"
                       rel="nofollow noopener">
                        <img class="h-5 lg:h-6" src="{{ Vite::asset('resources/images/icons/youtube.svg') }}" alt="YouTube">
                        <span class="ml-2 lg:ml-3 text-xxs font-medium">YouTube</span>
                    </a>
                    <div class="h-4 w-[2px] bg-white/25"></div>
                    <a href="{{ config('links_' . app()->getLocale() . '.chat') }}" class="inline-flex items-center text-white hover:text-pink" target="_blank"
                       rel="nofollow noopener">
                        <img class="h-5 lg:h-6" src="{{ Vite::asset('resources/images/icons/telegram.svg') }}" alt="Telegram">
                        <span class="ml-2 lg:ml-3 text-xxs font-medium">Telegram</span>
                    </a>
                </div>
            </div><!-- /.mmenu-inner -->
        </div><!-- /.container -->
    </div>
</div>
</body>
</html>
