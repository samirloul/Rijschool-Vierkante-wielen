<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
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
                    <a href="{{ route('packages') }}" class="transition hover:text-amber-300">Lespakketten</a>
                    <a href="{{ route('autos.overzicht') }}" class="transition hover:text-amber-300">Auto's</a>
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

        <main>
            <div class="min-h-screen bg-gradient-to-b from-slate-950 to-slate-900 py-12 px-4 sm:px-6 lg:px-8">
                <div class="max-w-6xl mx-auto">
                    <!-- Header -->
                    <div class="mb-8">
                        <h1 class="text-4xl font-bold text-white mb-2">
                            Auto Overzicht
                        </h1>
                        <p class="text-lg text-slate-300">
                            Bekijk alle beschikbare auto's voor uw lessen
                        </p>
                    </div>

                    <!-- Error Message -->
                    @if (isset($error))
                        <div class="mb-6 p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg">
                            <div class="flex items-center">
                                <svg class="h-5 w-5 text-red-400 dark:text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                        clip-rule="evenodd" />
                                </svg>
                                <p class="ml-3 text-sm font-medium text-red-800 dark:text-red-200">
                                    {{ $error }}
                                </p>
                            </div>
                        </div>
                    @endif

                    <!-- Autos Grid -->
                    @if (count($autos) > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach ($autos as $auto)
                                <div
                                    class="bg-slate-800 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300 overflow-hidden border border-slate-700">
                                    <!-- Header with Brand -->
                                    <div
                                        class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4">
                                        <h2 class="text-2xl font-bold text-white">
                                            {{ $auto->Merk }}
                                        </h2>
                                    </div>

                                    <!-- Content -->
                                    <div class="px-6 py-4">
                                        <!-- Model -->
                                        <div class="mb-4">
                                            <p class="text-sm font-semibold text-slate-400 uppercase tracking-wide">
                                                Model
                                            </p>
                                            <p class="text-lg font-medium text-white">
                                                {{ $auto->Type }}
                                            </p>
                                        </div>

                                        <!-- Transmission -->
                                        <div class="mb-4">
                                            <p class="text-sm font-semibold text-slate-400 uppercase tracking-wide">
                                                Transmissie
                                            </p>
                                            <p class="text-base text-slate-300">
                                                @if ($auto->IsElektrisch)
                                                    <span
                                                        class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-900/40 text-green-400 border border-green-600/50">
                                                        <svg class="h-4 w-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                            <path d="M13 7a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 11-2 0 1 1 0 012 0zm6 0a1 1 0 11-2 0 1 1 0 012 0zM9 15a1 1 0 11-2 0 1 1 0 012 0zm6 0a1 1 0 11-2 0 1 1 0 012 0z" />
                                                        </svg>
                                                        Automatisch (elektrisch)
                                                    </span>
                                                @else
                                                    <span
                                                        class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-900/40 text-blue-400 border border-blue-600/50">
                                                        <svg class="h-4 w-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                            <path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zm-1 14a1 1 0 100-2 1 1 0 000 2zm9-10a1 1 0 11-2 0 1 1 0 012 0zM9 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H9zm5 2a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 00-2-2h-2z" />
                                                        </svg>
                                                        Handgeschakeld
                                                    </span>
                                                @endif
                                            </p>
                                        </div>

                                        <!-- Availability -->
                                        <div class="mb-4">
                                            <p class="text-sm font-semibold text-slate-400 uppercase tracking-wide">
                                                Beschikbaarheid
                                            </p>
                                            <p class="text-base">
                                                @if ($auto->IsActief)
                                                    <span
                                                        class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-900/40 text-green-400 border border-green-600/50">
                                                        <span class="h-2 w-2 bg-green-400 rounded-full mr-2"></span>
                                                        Beschikbaar
                                                    </span>
                                                @else
                                                    <span
                                                        class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-900/40 text-red-400 border border-red-600/50">
                                                        <span class="h-2 w-2 bg-red-400 rounded-full mr-2"></span>
                                                        Niet beschikbaar
                                                    </span>
                                                @endif
                                            </p>
                                        </div>

                                        <!-- License Plate and Year -->
                                        <div class="grid grid-cols-2 gap-4 pt-4 border-t border-slate-700">
                                            <div>
                                                <p class="text-xs font-semibold text-slate-400 uppercase">
                                                    Kenteken
                                                </p>
                                                <p class="text-sm font-medium text-white">
                                                    {{ $auto->Kenteken }}
                                                </p>
                                            </div>
                                            <div>
                                                <p class="text-xs font-semibold text-slate-400 uppercase">
                                                    Bouwjaar
                                                </p>
                                                <p class="text-sm font-medium text-white">
                                                    {{ $auto->Bouwjaar }}
                                                </p>
                                            </div>
                                        </div>

                                        <!-- Notes if available -->
                                        @if ($auto->Opmerkingen)
                                            <div class="mt-4 pt-4 border-t border-slate-700">
                                                <p class="text-xs font-semibold text-slate-400 uppercase">
                                                    Opmerkingen
                                                </p>
                                                <p class="text-sm text-slate-400">
                                                    {{ $auto->Opmerkingen }}
                                                </p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <!-- No Autos Found -->
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-slate-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 8v8m-4-5v5m-4-2v2m-2 0a2 2 0 100-4 2 2 0 000 4zM4 20h16a2 2 0 002-2V6a2 2 0 00-2-2H4a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <h3 class="mt-2 text-lg font-medium text-white">
                                Geen auto's gevonden
                            </h3>
                            <p class="mt-1 text-sm text-slate-400">
                                Er zijn momenteel geen auto's beschikbaar. Probeer het later opnieuw.
                            </p>
                        </div>
                    @endif

                    <!-- Back Button -->
                    <div class="mt-8">
                        <a href="{{ route('home') }}"
                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-slate-900 bg-amber-400 hover:bg-amber-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500">
                            <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            Terug naar Home
                        </a>
                    </div>
                </div>
            </div>
        </main>

        <footer class="border-t border-white/10 bg-slate-950/90">
            <div class="mx-auto grid w-full max-w-7xl gap-6 px-4 py-10 text-sm text-slate-300 sm:px-6 md:grid-cols-3 lg:px-8">
                <div>
                    <p class="font-semibold text-white">Rijschool Vierkante Wielen</p>
                    <p class="mt-2">Jongeren, toegankelijkheid en verkeersveiligheid staan bij ons centraal.</p>
                </div>
                <div>
                    <p class="font-semibold text-white">Snelle links</p>
                    <div class="mt-2 space-y-1">
                        <a href="{{ route('home') }}" class="block transition hover:text-amber-200">Home</a>
                        <a href="{{ route('packages') }}" class="block transition hover:text-amber-200">Lespakketten</a>
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
