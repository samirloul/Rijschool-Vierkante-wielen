<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        @php($title = 'Rijschool Vierkante Wielen')
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
                <nav class="flex items-center gap-6 text-sm text-slate-200">
                    <a href="{{ route('home') }}" class="transition hover:text-amber-300">Home</a>
                    <a href="{{ route('about') }}" class="transition hover:text-amber-300">Over ons</a>
                    <a href="{{ route('packages') }}" class="transition hover:text-amber-300">Lespakketten</a>
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
            <section class="mx-auto grid w-full max-w-7xl gap-10 px-4 pb-16 pt-16 sm:px-6 md:pt-24 lg:px-8 xl:grid-cols-2 xl:items-center">
                <div class="animate-rise-in space-y-7">
                    <p class="inline-flex rounded-full border border-amber-300/40 bg-amber-200/10 px-4 py-1 text-xs font-medium uppercase tracking-[0.2em] text-amber-200">
                        Persoonlijke rijlessen voor iedereen
                    </p>
                    <h1 class="text-4xl font-semibold leading-tight text-white sm:text-5xl xl:text-6xl">
                        Zelfverzekerd de weg op met een rijschool die echt met je meedenkt.
                    </h1>
                    <p class="max-w-xl text-base leading-relaxed text-slate-200 sm:text-lg">
                        Vier instructeurs, drie lesauto&apos;s en extra aandacht voor jongeren met een fysieke beperking.
                        Praktisch, veilig en flexibel in jouw regio.
                    </p>
                    <div class="flex flex-wrap gap-4">
                        <a href="{{ route('packages') }}" class="rounded-full bg-cyan-300 px-6 py-3 text-sm font-semibold text-slate-950 transition hover:bg-cyan-200">Bekijk lespakketten</a>
                        <a href="{{ route('autos.overzicht') }}" class="rounded-full border border-emerald-300/60 px-6 py-3 text-sm font-semibold text-emerald-200 transition hover:border-emerald-200 hover:text-emerald-100">Bekijk auto's</a>
                        <a href="{{ route('contact') }}" class="rounded-full border border-white/30 px-6 py-3 text-sm font-semibold transition hover:border-cyan-300 hover:text-cyan-200">Plan een intake</a>
                    </div>
                    <div class="grid grid-cols-3 gap-3 pt-2 text-center text-sm">
                        <div class="rounded-2xl border border-white/15 bg-white/5 p-3">
                            <p class="text-2xl font-semibold text-amber-300">4</p>
                            <p class="text-slate-300">Instructeurs</p>
                        </div>
                        <div class="rounded-2xl border border-white/15 bg-white/5 p-3">
                            <p class="text-2xl font-semibold text-cyan-300">3</p>
                            <p class="text-slate-300">Lesauto&apos;s</p>
                        </div>
                        <div class="rounded-2xl border border-white/15 bg-white/5 p-3">
                            <p class="text-2xl font-semibold text-emerald-300">2</p>
                            <p class="text-slate-300">Elektrisch</p>
                        </div>
                    </div>
                </div>

                <div class="relative isolate animate-rise-in [animation-delay:140ms]">
                    <img
                        src="https://images.unsplash.com/photo-1487754180451-c456f719a1fc?auto=format&fit=crop&w=1200&q=80"
                        alt="Instructeur en leerling in lesauto"
                        class="h-full min-h-80 w-full rounded-3xl border border-white/20 object-cover shadow-2xl xl:max-h-[42rem]"
                    >
                    <div class="animate-float-soft absolute bottom-4 left-4 rounded-2xl border border-amber-200/30 bg-slate-900/90 p-4 shadow-xl">
                        <p class="text-xs uppercase tracking-[0.2em] text-amber-200">Gemiddelde score</p>
                        <p class="mt-1 text-2xl font-semibold text-white">9.1/10</p>
                    </div>
                    <div class="animate-float-soft absolute right-4 top-4 max-w-[14rem] rounded-2xl border border-cyan-200/30 bg-slate-900/90 p-4 shadow-xl [animation-delay:0.7s]">
                        <p class="text-xs uppercase tracking-[0.2em] text-cyan-200">Snelle start</p>
                        <p class="mt-1 text-sm text-white">Vaak binnen 5 dagen je eerste les</p>
                    </div>
                </div>
            </section>

            <section class="mx-auto w-full max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
                <h2 class="text-3xl font-semibold text-white sm:text-4xl">Waarom kiezen voor Vierkante Wielen?</h2>
                <div class="mt-8 grid gap-4 md:grid-cols-3">
                    <article class="rounded-2xl border border-white/15 bg-white/5 p-6">
                        <h3 class="text-lg font-semibold text-amber-200">Toegankelijk lesgeven</h3>
                        <p class="mt-2 text-sm leading-relaxed text-slate-300">Onze lessen sluiten aan op jouw tempo en mogelijkheden, met extra aandacht voor fysieke beperkingen.</p>
                    </article>
                    <article class="rounded-2xl border border-white/15 bg-white/5 p-6">
                        <h3 class="text-lg font-semibold text-cyan-200">Strakke planning</h3>
                        <p class="mt-2 text-sm leading-relaxed text-slate-300">Lesblokken op week-, dag- en lesniveau. Jij en je instructeur zien altijd dezelfde actuele planning.</p>
                    </article>
                    <article class="rounded-2xl border border-white/15 bg-white/5 p-6">
                        <h3 class="text-lg font-semibold text-emerald-200">Duurzaam wagenpark</h3>
                        <p class="mt-2 text-sm leading-relaxed text-slate-300">Twee elektrische lesauto&apos;s en een extra comfortabele lesauto voor specifieke leerwensen.</p>
                    </article>
                </div>
            </section>
            <section class="mx-auto w-full max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
                <div class="rounded-3xl border border-white/15 bg-gradient-to-br from-emerald-500/10 via-white/5 to-transparent p-8 md:p-12">
                    <div class="grid gap-8 md:grid-cols-2 md:items-center">
                        <div>
                            <h2 class="text-3xl font-semibold text-white sm:text-4xl">
                                Verken ons wagenpark
                            </h2>
                            <p class="mt-4 text-base leading-relaxed text-slate-300">
                                Wil je weten met welke auto jij je rijlessen gaat volgen? Bekijk alle beschikbare voertuigen met hun specificaties, transmissie en huidige beschikbaarheid.
                            </p>
                            <p class="mt-3 text-sm text-emerald-200">
                                ✓ Volledige auto-informatie<br>
                                ✓ Transmissie-details (handgeschakeld/automatisch)<br>
                                ✓ Beschikbaarheids-status
                            </p>
                            <a href="{{ route('autos.overzicht') }}" class="mt-6 inline-flex items-center rounded-full bg-emerald-400 px-6 py-3 text-sm font-semibold text-slate-950 transition hover:bg-emerald-300">
                                Bekijk auto-overzicht
                                <svg class="ml-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                </svg>
                            </a>
                        </div>
                        <div class="rounded-2xl bg-gradient-to-br from-slate-700/40 to-slate-900/40 p-6 border border-white/10">
                            <svg class="h-full w-full text-emerald-400/30" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M7 16a1 1 0 11-2 0 1 1 0 012 0zM19 16a1 1 0 11-2 0 1 1 0 012 0zM8 5a1 1 0 100-2 1 1 0 000 2zM21 9a3 3 0 11-6 0 3 3 0 016 0zM19.586 12.586l1.414-1.414A2 2 0 0018 10V8a2 2 0 00-2-2H4a2 2 0 00-2 2v8a2 2 0 002 2h12a2 2 0 002-2v-2h2a2 2 0 000-4h-1.414z" />
                            </svg>
                        </div>
                    </div>
                </div>
            </section>        </main>

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
