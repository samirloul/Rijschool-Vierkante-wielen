<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @php($title = 'Rijlespakketten Overzicht')
        @include('partials.head')
    </head>
    <body class="min-h-screen overflow-x-hidden bg-slate-950 text-slate-100">
        <div class="absolute inset-0 -z-10 opacity-60">
            <div class="absolute inset-x-0 top-0 h-[30rem] bg-gradient-to-b from-cyan-500/30 via-amber-400/20 to-transparent"></div>
            <div class="pattern-grid absolute inset-0"></div>
        </div>

        <button id="sidebar-backdrop" class="fixed inset-0 z-30 hidden bg-slate-950/70 lg:hidden" aria-label="Sluit sidebar"></button>

        <aside
            id="sidebar"
            class="fixed inset-y-0 left-0 z-40 w-72 -translate-x-full border-r border-white/10 bg-slate-900/95 p-4 backdrop-blur transition-transform duration-300 lg:translate-x-0"
            aria-label="Dashboard navigatie"
        >
            <div class="rounded-2xl border border-white/10 bg-slate-800/80 p-4">
                <p class="text-xs uppercase tracking-[0.2em] text-cyan-200">Vierkante Wielen</p>
                <h2 class="mt-1 text-lg font-semibold text-white">Dashboard Menu</h2>
                <p class="mt-2 text-sm text-slate-300">{{ optional(auth()->user())->name ?? 'Gastgebruiker' }}</p>
            </div>

            <nav class="mt-6 space-y-2 text-sm">
                <a href="{{ route('dashboard') }}#overzicht" class="block rounded-xl border border-white/10 bg-slate-800/70 px-4 py-3 text-slate-200 transition hover:border-cyan-300/30 hover:text-cyan-100">Overzicht</a>
                <a href="{{ route('dashboard.packages') }}" class="block rounded-xl border border-amber-300/30 bg-amber-300/10 px-4 py-3 font-medium text-amber-100 transition hover:bg-amber-300/20">Rijlespakketten Overzicht</a>
                <a href="{{ route('betaling.overzicht') }}" class="block rounded-xl border border-white/10 bg-slate-800/70 px-4 py-3 text-slate-200 transition hover:border-cyan-300/30 hover:text-cyan-100">Betaling Overzicht</a>
            </nav>

            <div class="mt-6 grid gap-2 text-sm">
                <a href="{{ route('home') }}" class="rounded-xl border border-white/20 px-4 py-2 text-center transition hover:border-cyan-300 hover:text-cyan-200">Naar website</a>
                @auth
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full rounded-xl bg-rose-400 px-4 py-2 font-semibold text-slate-900 transition hover:bg-rose-300">Uitloggen</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="rounded-xl bg-cyan-300 px-4 py-2 text-center font-semibold text-slate-900 transition hover:bg-cyan-200">Inloggen</a>
                @endauth
            </div>
        </aside>

        <div class="min-h-screen lg:pl-72">
            <header class="sticky top-0 z-20 border-b border-white/10 bg-slate-950/90 backdrop-blur">
                <div class="mx-auto flex w-full max-w-7xl items-center justify-between px-4 py-4 sm:px-6 lg:px-8">
                    <div class="flex items-center gap-3">
                        <button id="sidebar-toggle" class="rounded-lg border border-white/20 px-3 py-2 text-sm lg:hidden" aria-controls="sidebar" aria-expanded="false">
                            Menu
                        </button>
                        <div>
                            <p class="text-xs uppercase tracking-[0.2em] text-cyan-200">Dashboard</p>
                            <h1 class="text-lg font-semibold text-white">Rijlespakketten Overzicht</h1>
                        </div>
                    </div>
                    <p class="hidden text-sm text-slate-300 sm:block">Vandaag: {{ now()->translatedFormat('l d F Y') }}</p>
                </div>
            </header>

            <main class="mx-auto w-full max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
                @if (! empty($lespakkettenOverzichtError))
                    <div class="mb-4 rounded-xl border border-rose-300/40 bg-rose-300/10 p-4 text-sm text-rose-100">
                        {{ $lespakkettenOverzichtError }}
                    </div>
                @endif

                <section class="overflow-hidden rounded-2xl border border-white/10 bg-slate-900/80">
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-left text-sm">
                            <thead class="bg-slate-800/90 text-slate-200">
                                <tr>
                                    <th class="px-4 py-3 font-medium">Pakket</th>
                                    <th class="px-4 py-3 font-medium">Aantal lessen</th>
                                    <th class="px-4 py-3 font-medium">Prijs</th>
                                    <th class="px-4 py-3 font-medium">Omschrijving</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-white/10 text-slate-200">
                                @forelse ($lespakketten as $lespakket)
                                    <tr>
                                        <td class="px-4 py-3">{{ $lespakket->Naam }}</td>
                                        <td class="px-4 py-3">{{ $lespakket->AantalLessen }}</td>
                                        <td class="px-4 py-3">EUR {{ number_format((float) $lespakket->Prijs, 2, ',', '.') }}</td>
                                        <td class="px-4 py-3">{{ $lespakket->Omschrijving ?? '-' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-4 py-6 text-center text-slate-300">Geen Rijlespakketten gevonden.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </section>
            </main>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const sidebar = document.getElementById('sidebar');
                const toggle = document.getElementById('sidebar-toggle');
                const backdrop = document.getElementById('sidebar-backdrop');

                if (!sidebar || !toggle || !backdrop) {
                    return;
                }

                const openSidebar = function () {
                    sidebar.classList.remove('-translate-x-full');
                    backdrop.classList.remove('hidden');
                    toggle.setAttribute('aria-expanded', 'true');
                };

                const closeSidebar = function () {
                    sidebar.classList.add('-translate-x-full');
                    backdrop.classList.add('hidden');
                    toggle.setAttribute('aria-expanded', 'false');
                };

                toggle.addEventListener('click', function () {
                    if (sidebar.classList.contains('-translate-x-full')) {
                        openSidebar();
                    } else {
                        closeSidebar();
                    }
                });

                backdrop.addEventListener('click', closeSidebar);

                window.addEventListener('resize', function () {
                    if (window.innerWidth >= 1024) {
                        backdrop.classList.add('hidden');
                        sidebar.classList.remove('-translate-x-full');
                        toggle.setAttribute('aria-expanded', 'false');
                    } else {
                        sidebar.classList.add('-translate-x-full');
                    }
                });
            });
        </script>
    </body>
</html>
