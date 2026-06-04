<x-layouts.dashboard
    title="Leerlingen Overzicht"
    subtitle="Bekijk alle leerlingen die momenteel actief zijn in het systeem."
    eyebrow="Dashboard"
    active="leerlingen"
>
    @if (!empty($error))
        <div class="rounded-2xl border border-rose-300/40 bg-rose-300/10 p-4 text-sm text-rose-100">
            {{ $error }}
        </div>
    @else
        <section class="overflow-hidden rounded-2xl border border-white/10 bg-slate-900/80 shadow-xl">
            <div class="overflow-x-auto">
                <table class="min-w-full text-left text-sm text-slate-200">
                    <thead class="bg-slate-800/90 text-slate-300">
                        <tr>
                            <th class="px-6 py-4 font-medium">Naam</th>
                            <th class="px-6 py-4 font-medium">E-mail</th>
                            <th class="px-6 py-4 font-medium">Telefoon</th>
                            <th class="px-6 py-4 font-medium">Rijbewijs</th>
                            <th class="px-6 py-4 font-medium">Beperking</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/10 bg-slate-950/80">
                        @forelse ($leerlingen as $leerling)
                            <tr class="transition hover:bg-slate-900/80">
                                <td class="px-6 py-4">{{ $leerling->VolledigeNaam }}</td>
                                <td class="px-6 py-4">{{ $leerling->Email }}</td>
                                <td class="px-6 py-4">{{ $leerling->Telefoonnummer ?? '-' }}</td>
                                <td class="px-6 py-4">{{ $leerling->RijbewijsCategorie }}</td>
                                <td class="px-6 py-4">
                                    @if ($leerling->HeeftBeperking)
                                        <span class="inline-flex items-center rounded-full bg-amber-500/20 px-3 py-1 text-xs font-semibold text-amber-200">
                                            {{ $leerling->OmschrijvingBeperking ?? 'Ja' }}
                                        </span>
                                    @else
                                        <span class="inline-flex items-center rounded-full bg-emerald-500/20 px-3 py-1 text-xs font-semibold text-emerald-200">
                                            Nee
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-6 text-center text-slate-300">Geen leerlingen gevonden</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    @endif
</x-layouts.dashboard>
