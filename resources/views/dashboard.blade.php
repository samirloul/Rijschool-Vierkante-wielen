<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        @php($title = 'Mijn Dashboard')
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
                <p class="mt-2 text-sm text-slate-300">{{ auth()->user()->name }}</p>
            </div>

            <nav class="mt-6 space-y-2 text-sm">
                <a href="#overzicht" class="block rounded-xl border border-cyan-300/30 bg-cyan-300/10 px-4 py-3 font-medium text-cyan-100">Overzicht</a>
                <a href="#planning" class="block rounded-xl border border-white/10 bg-slate-800/70 px-4 py-3 text-slate-200 transition hover:border-cyan-300/30 hover:text-cyan-100">Planning</a>
                <a href="#acties" class="block rounded-xl border border-white/10 bg-slate-800/70 px-4 py-3 text-slate-200 transition hover:border-cyan-300/30 hover:text-cyan-100">Snelle Acties</a>
                <a href="#mededelingen" class="block rounded-xl border border-white/10 bg-slate-800/70 px-4 py-3 text-slate-200 transition hover:border-cyan-300/30 hover:text-cyan-100">Mededelingen</a>
                <a href="#team" class="block rounded-xl border border-white/10 bg-slate-800/70 px-4 py-3 text-slate-200 transition hover:border-cyan-300/30 hover:text-cyan-100">Team Blokken</a>
            </nav>

            <div class="mt-6 grid gap-2 text-sm">
                <a href="{{ route('home') }}" class="rounded-xl border border-white/20 px-4 py-2 text-center transition hover:border-cyan-300 hover:text-cyan-200">Naar website</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full rounded-xl bg-rose-400 px-4 py-2 font-semibold text-slate-900 transition hover:bg-rose-300">Uitloggen</button>
                </form>
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
                            <p class="text-xs uppercase tracking-[0.2em] text-cyan-200">Persoonlijk</p>
                            <h1 class="text-lg font-semibold text-white">Mijn Dashboard</h1>
                        </div>
                    </div>
                    <p class="hidden text-sm text-slate-300 sm:block">Vandaag: {{ now()->translatedFormat('l d F Y') }}</p>
                </div>
            </header>

            <main class="mx-auto w-full max-w-7xl space-y-6 px-4 py-8 sm:px-6 lg:px-8">
                <section id="overzicht" class="animate-rise-in rounded-3xl border border-white/15 bg-gradient-to-r from-slate-900/90 to-slate-800/90 p-6 shadow-2xl">
                <p class="text-sm text-slate-300">Welkom terug,</p>
                <h2 class="mt-1 text-3xl font-semibold text-white">{{ auth()->user()->name }}</h2>
                <p class="mt-3 max-w-3xl text-sm leading-relaxed text-slate-300">
                    Hier zie je in een oogopslag je lessen, opmerkingen en acties. Dit dashboard is volledig eigen ontwerp en kan
                    door teamleden per user story verder uitgebreid worden.
                </p>
                </section>

                <section class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
                <article class="rounded-2xl border border-cyan-200/30 bg-cyan-300/10 p-5">
                    <p class="text-sm text-cyan-100">Lessen deze week</p>
                    <p class="mt-2 text-3xl font-semibold text-white">6</p>
                </article>
                <article class="rounded-2xl border border-amber-200/30 bg-amber-300/10 p-5">
                    <p class="text-sm text-amber-100">Open taken</p>
                    <p class="mt-2 text-3xl font-semibold text-white">4</p>
                </article>
                <article class="rounded-2xl border border-emerald-200/30 bg-emerald-300/10 p-5">
                    <p class="text-sm text-emerald-100">Tegoed lessen</p>
                    <p class="mt-2 text-3xl font-semibold text-white">14</p>
                </article>
                <article class="rounded-2xl border border-fuchsia-200/30 bg-fuchsia-300/10 p-5">
                    <p class="text-sm text-fuchsia-100">Nieuwe meldingen</p>
                    <p class="mt-2 text-3xl font-semibold text-white">3</p>
                </article>
                </section>

                <section class="grid gap-4 xl:grid-cols-3">
                <article id="planning" class="rounded-2xl border border-white/10 bg-slate-900/80 p-5 xl:col-span-2">
                    <h3 class="text-lg font-semibold text-white">Planning Vandaag</h3>
                    <div class="mt-4 space-y-3">
                        <div class="rounded-xl border border-white/10 bg-slate-800/70 p-4">
                            <p class="text-sm font-semibold text-white">09:00 - 10:30 | Les met Iris van Dijk</p>
                            <p class="mt-1 text-sm text-slate-300">Ophaaladres: Marconistraat 14, Rotterdam</p>
                            <p class="text-sm text-slate-300">Doel: Kijktechniek en rustig invoegen op de snelweg</p>
                        </div>
                        <div class="rounded-xl border border-white/10 bg-slate-800/70 p-4">
                            <p class="text-sm font-semibold text-white">11:00 - 12:30 | Les met Sami El Azzouzi</p>
                            <p class="mt-1 text-sm text-slate-300">Ophaaladres: Schiedamseweg 210, Rotterdam</p>
                            <p class="text-sm text-slate-300">Doel: Bijzondere verrichtingen en bochtentechniek</p>
                        </div>
                    </div>
                </article>

                <article id="acties" class="rounded-2xl border border-white/10 bg-slate-900/80 p-5">
                    <h3 class="text-lg font-semibold text-white">Snelle Acties</h3>
                    <div class="mt-4 flex flex-col gap-2 text-sm">
                        <button class="rounded-xl border border-cyan-300/40 bg-cyan-300/10 px-4 py-2 text-left font-medium text-cyan-100 transition hover:bg-cyan-300/20">Les wijzigen</button>
                        <button class="rounded-xl border border-amber-300/40 bg-amber-300/10 px-4 py-2 text-left font-medium text-amber-100 transition hover:bg-amber-300/20">Les annuleren</button>
                        <button class="rounded-xl border border-rose-300/40 bg-rose-300/10 px-4 py-2 text-left font-medium text-rose-100 transition hover:bg-rose-300/20">Ziekmelding doorgeven</button>
                        <button class="rounded-xl border border-emerald-300/40 bg-emerald-300/10 px-4 py-2 text-left font-medium text-emerald-100 transition hover:bg-emerald-300/20">Praktijkexamen aanvragen</button>
                    </div>
                </article>
                </section>

                <section class="grid gap-4 lg:grid-cols-2">
                <article id="mededelingen" class="rounded-2xl border border-white/10 bg-slate-900/80 p-5">
                    <h3 class="text-lg font-semibold text-white">Mededelingen</h3>
                    <ul class="mt-4 space-y-3 text-sm text-slate-300">
                        <li class="rounded-xl border border-white/10 bg-slate-800/70 p-4">Vrijdag 16:00: extra theorie-uitleg in lokaal B.</li>
                        <li class="rounded-xl border border-white/10 bg-slate-800/70 p-4">Nieuwe elektrische lesauto beschikbaar vanaf maandag.</li>
                        <li class="rounded-xl border border-white/10 bg-slate-800/70 p-4">Controleer je profielgegevens en ophaaladres voor komende week.</li>
                    </ul>
                </article>

                <article id="team" class="rounded-2xl border border-white/10 bg-slate-900/80 p-5">
                    <h3 class="text-lg font-semibold text-white">Team Gebruik</h3>
                    <p class="mt-3 text-sm text-slate-300">
                        Deze basis is modulair opgebouwd: teamleden kunnen per user story blokken toevoegen zoals facturatie,
                        roosterbeheer, leerlingstatus of wagenparkbeheer.
                    </p>
                    <div class="mt-4 grid gap-2 text-sm">
                        <div class="rounded-xl border border-white/10 bg-slate-800/70 px-4 py-3">User Story blok: Lesplanning</div>
                        <div class="rounded-xl border border-white/10 bg-slate-800/70 px-4 py-3">User Story blok: Facturatie</div>
                        <div class="rounded-xl border border-white/10 bg-slate-800/70 px-4 py-3">User Story blok: Ziekmeldingen</div>
                        <div class="rounded-xl border border-white/10 bg-slate-800/70 px-4 py-3">User Story blok: Examenresultaten</div>
                    </div>
                </article>
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
