<x-layouts.dashboard
    title="Rijlespakketten Overzicht"
    subtitle="Interne beheerderspagina met alle pakketten uit de database."
    eyebrow="Dashboard"
    active="packages"
>
    @if (! empty($lespakkettenOverzichtError))
        <div class="rounded-xl border border-rose-300/40 bg-rose-300/10 p-4 text-sm text-rose-100">
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
</x-layouts.dashboard>
