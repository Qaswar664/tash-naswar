<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" @class(['dark' => ($appearance ?? 'system') == 'dark'])>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Inline script to detect system dark mode preference and apply it immediately --}}
    <script>
        (function() {
            const appearance = '{{ $appearance ?? 'system' }}';

            if (appearance === 'system') {
                const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;

                if (prefersDark) {
                    document.documentElement.classList.add('dark');
                }
            }
        })();
    </script>

    {{-- Inline style to set the HTML background color based on our theme in app.css --}}
    <style>
        html {
            background-color: oklch(1 0 0);
        }

        html.dark {
            background-color: oklch(0.145 0 0);
        }
    </style>

    {{-- Dynamic Page Title --}}
    <title inertia>{{ config('app.name', 'Tash Naswar Online Store') }}</title>

    {{-- SEO Meta Description (default, can be overridden per-page with Inertia) --}}
    <meta name="description"
        content="Buy premium Tash Naswar online with fast delivery in Pakistan. Fresh, authentic, and hygienically packed Naswar available in bulk and retail." />

    {{-- SEO Keywords (optional, less important for Google but useful for other engines) --}}
    <meta name="keywords"
        content="Tash Naswar, buy Naswar online, fresh naswar Pakistan, naswar delivery, original naswar" />

    {{-- Open Graph for Social Media --}}
    <meta property="og:title" content="Tash Naswar Online Store" />
    <meta property="og:description"
        content="Order authentic Tash Naswar online – hygienic, fresh, and delivered to your doorstep across Pakistan." />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:image" content="{{ asset('images/og-naswar.jpg') }}" />

    {{-- Twitter Card --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Tash Naswar Online Store">
    <meta name="twitter:description"
        content="Premium quality Naswar online in Pakistan. Hygienically packed & delivered fast.">
    <meta name="twitter:image" content="{{ asset('images/og-naswar.jpg') }}">

    <link rel="icon" href="{{ asset('images/logo.webp') }}" type="image/webp">


    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    @routes
    @vite(['resources/js/app.ts', "resources/js/pages/{$page['component']}.vue"])
    @inertiaHead
</head>

<body class="antialiased" style="font-family: Arial, sans-serif;">
    @inertia
</body>

</html>
