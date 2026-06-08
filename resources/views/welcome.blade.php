<x-layouts.site title="Rijschool Vierkante Wielen">
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
                        <a href="{{ route('instructeurs.index') }}" class="rounded-full border border-cyan-300 px-6 py-3 text-sm font-semibold text-cyan-200 transition hover:bg-cyan-300/10">Bekijk instructeurs</a>
                        <a href="{{ route('leerlingen.index') }}" class="rounded-full border border-white/30 px-6 py-3 text-sm font-semibold text-white transition hover:border-cyan-300 hover:text-cyan-200">Bekijk leerlingen</a>
                        <a href="{{ route('rijlessen.index') }}" class="rounded-full border border-white/30 px-6 py-3 text-sm font-semibold text-white transition hover:border-cyan-300 hover:text-cyan-200">Bekijk rijlessen</a>
                        <a href="{{ route('contact') }}" class="rounded-full border border-white/30 px-6 py-3 text-sm font-semibold transition hover:border-cyan-300 hover:text-cyan-200">Plan een intake</a>
                        <a href="{{ route('autos.overzicht') }}" class="rounded-full border border-emerald-300/60 px-6 py-3 text-sm font-semibold text-emerald-200 transition hover:border-emerald-200 hover:text-emerald-100">Bekijk auto's</a>
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
    </main>
</x-layouts.site>