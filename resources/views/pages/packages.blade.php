<x-layouts.site title="Rijlespakketten Overzicht">
    <main class="mx-auto w-full max-w-6xl px-4 py-12 sm:px-6 lg:px-8">
        <a href="{{ route('home') }}" class="inline-flex items-center text-sm text-cyan-300 transition hover:text-cyan-200">Terug naar home</a>
        <h1 class="mt-4 text-4xl font-semibold text-white">Kies jouw rijlespakket</h1>
        <p class="mt-6 max-w-3xl leading-relaxed text-slate-300">
            Voor klanten: kies hieronder een passend pakket. In je persoonlijke dashboard staat het interne overzicht voor beheer.
        </p>

        @if (! empty($lespakkettenOverzichtError))
            <div class="mt-6 rounded-xl border border-rose-300/40 bg-rose-300/10 p-4 text-sm text-rose-100">
                {{ $lespakkettenOverzichtError }}
            </div>
        @endif

        @if ($lespakketten)
            <section class="mt-10 grid gap-4 md:grid-cols-2 xl:grid-cols-3">
                @foreach ($lespakketten as $lespakket)
                    <article class="rounded-2xl border border-white/15 bg-slate-900/80 p-6">
                        <p class="text-xs uppercase tracking-[0.18em] text-cyan-200">Rijlespakket</p>
                        <h2 class="mt-2 text-xl font-semibold text-white">{{ $lespakket->Naam }}</h2>
                        <p class="mt-2 text-sm text-slate-300">{{ $lespakket->Omschrijving ?? 'Pakket zonder extra omschrijving.' }}</p>
                        <div class="mt-5 flex items-end justify-between gap-4">
                            <div>
                                <p class="text-xs uppercase tracking-[0.12em] text-slate-400">Aantal lessen</p>
                                <p class="text-lg font-semibold text-white">{{ $lespakket->AantalLessen }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-xs uppercase tracking-[0.12em] text-slate-400">Prijs</p>
                                <p class="text-2xl font-semibold text-amber-200">EUR {{ number_format((float) $lespakket->Prijs, 2, ',', '.') }}</p>
                            </div>
                        </div>
                        <button type="button" class="mt-6 w-full rounded-xl bg-cyan-300 px-4 py-2 text-sm font-semibold text-slate-900 transition hover:bg-cyan-200">
                            Kies dit pakket
                        </button>
                    </article>
                @endforeach
            </section>
        @else
            <section class="mt-10 rounded-2xl border border-white/10 bg-slate-900/80 p-6 text-center text-slate-300">
                Geen Rijlespakketten gevonden.
            </section>
        @endif
    </main>
</x-layouts.site>
