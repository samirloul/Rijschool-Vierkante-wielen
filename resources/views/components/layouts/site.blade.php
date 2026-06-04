@props([
    'title' => null,
])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        @php($title = $title)
        @include('partials.head')
    </head>
    <body class="bg-slate-950 text-slate-100">
        <div class="absolute inset-0 -z-10 opacity-70">
            <div class="absolute inset-x-0 top-0 h-[38rem] bg-gradient-to-b from-amber-500/35 via-cyan-500/20 to-transparent"></div>
            <div class="absolute -left-20 top-48 h-96 w-96 rounded-full bg-cyan-400/25 blur-3xl"></div>
            <div class="absolute -right-20 top-20 h-96 w-96 rounded-full bg-amber-300/25 blur-3xl"></div>
            <div class="pattern-grid absolute inset-0"></div>
        </div>

        <header class="sticky top-0 z-30 border-b border-white/10 bg-slate-950/85 backdrop-blur">
            <div class="mx-auto flex w-full max-w-7xl items-center justify-between px-4 py-4 sm:px-6 lg:px-8">
                <a href="{{ route('home') }}" class="text-lg font-semibold tracking-wide text-amber-300">Rijschool Vierkante Wielen</a>
                <nav class="hidden items-center gap-6 text-sm text-slate-200 md:flex">
                    <a href="{{ route('home') }}" class="transition hover:text-amber-300">Home</a>
                    <a href="{{ route('about') }}" class="transition hover:text-amber-300">Over ons</a>
                    <a href="{{ route('packages') }}" class="transition hover:text-amber-300">Rijlespakketten overzicht</a>
                    <a href="{{ route('instructeurs.index') }}" class="transition hover:text-amber-300">Instructeurs</a>
                    <a href="{{ route('leerlingen.index') }}" class="transition hover:text-amber-300">Leerlingen</a>
                    <a href="{{ route('contact') }}" class="transition hover:text-amber-300">Contact</a>
                </nav>
                <div class="flex items-center gap-3 text-sm">
                    @auth
                        <a href="{{ route('dashboard') }}" class="rounded-full border border-cyan-300/60 px-4 py-2 text-cyan-200 transition hover:bg-cyan-300/10">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="rounded-full border border-white/30 px-4 py-2 transition hover:border-white">Inloggen</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="rounded-full bg-amber-400 px-4 py-2 font-semibold text-slate-900 transition hover:bg-amber-300">Aanmelden</a>
                        @endif
                    @endauth
                </div>
            </div>
        </header>

        {{ $slot }}

        <footer class="border-t border-white/10 bg-slate-950/90">
            <div class="mx-auto grid w-full max-w-7xl gap-6 px-4 py-10 text-sm text-slate-300 sm:px-6 md:grid-cols-3 lg:px-8">
                <div>
                    <p class="font-semibold text-white">Rijschool Vierkante Wielen</p>
                    <p class="mt-2">Jongeren, toegankelijkheid en verkeersveiligheid staan bij ons centraal.</p>
                </div>
                <div>
                    <p class="font-semibold text-white">Snelle links</p>
                    <div class="mt-2 space-y-1">
                        <a href="{{ route('about') }}" class="block transition hover:text-amber-200">Over ons</a>
                        <a href="{{ route('packages') }}" class="block transition hover:text-amber-200">Rijlespakketten overzicht</a>
                        <a href="{{ route('contact') }}" class="block transition hover:text-amber-200">Contact</a>
                    </div>
                </div>
                <div>
                    <p class="font-semibold text-white">Bereikbaarheid</p>
                    <p class="mt-2">Ma - Vr: 08:00 - 20:00<br>Za: 09:00 - 16:00</p>
                </div>
            </div>
        </footer>
    </body>
</html>
