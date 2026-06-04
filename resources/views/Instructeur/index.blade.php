<x-layouts.dashboard
    title="Instructeurs Overzicht"
    subtitle="Bekijk de instructeurs die momenteel actief zijn in het systeem."
    eyebrow="Dashboard"
    active="instructeurs"
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
                            <th class="px-6 py-4 font-medium">Rijbewijsnummer</th>
                            <th class="px-6 py-4 font-medium">Indienst</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/10 bg-slate-950/80">
                        @forelse ($instructeurs as $instructeur)
                            <tr class="transition hover:bg-slate-900/80">
                                <td class="px-6 py-4">{{ $instructeur->VolledigeNaam }}</td>
                                <td class="px-6 py-4">{{ $instructeur->Email }}</td>
                                <td class="px-6 py-4">{{ $instructeur->Telefoonnummer ?? '-' }}</td>
                                <td class="px-6 py-4">{{ $instructeur->Rijbewijsnummer }}</td>
                                <td class="px-6 py-4">{{ \Illuminate\Support\Carbon::parse($instructeur->IndienstDatum)->format('d-m-Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-6 text-center text-slate-300">Geen instructeurs gevonden</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    @endif
</x-layouts.dashboard>
