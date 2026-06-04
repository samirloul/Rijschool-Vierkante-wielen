<x-layouts.dashboard
    title="Betaling Overzicht"
    subtitle="Bekijk en filter betalingen op datum en controleer direct de factuurgegevens, leerling en betaalmethode."
    eyebrow="Administratie"
    active="betalingen"
>
    @if (! empty($betalingOverzichtError))
        <div class="rounded-xl border border-rose-300/40 bg-rose-300/10 p-4 text-sm text-rose-100">
            {{ $betalingOverzichtError }}
        </div>
    @endif

    <form method="GET" action="{{ route('betaling.overzicht') }}" class="grid gap-3 rounded-2xl border border-white/10 bg-slate-900/80 p-4 md:grid-cols-4">
        <div>
            <label for="vanaf" class="mb-1 block text-xs uppercase tracking-wider text-slate-300">Vanaf</label>
            <input id="vanaf" name="vanaf" type="date" value="{{ $vanaf }}" class="w-full rounded-lg border border-white/20 bg-slate-800 px-3 py-2 text-sm text-white outline-none ring-cyan-300 transition focus:ring-2">
        </div>
        <div>
            <label for="tot" class="mb-1 block text-xs uppercase tracking-wider text-slate-300">Tot</label>
            <input id="tot" name="tot" type="date" value="{{ $tot }}" class="w-full rounded-lg border border-white/20 bg-slate-800 px-3 py-2 text-sm text-white outline-none ring-cyan-300 transition focus:ring-2">
        </div>
        <div class="md:col-span-2 flex items-end gap-2">
            <button type="submit" class="rounded-lg bg-cyan-300 px-4 py-2 text-sm font-semibold text-slate-900 transition hover:bg-cyan-200">Filter</button>
            <a href="{{ route('betaling.overzicht') }}" class="rounded-lg border border-white/20 px-4 py-2 text-sm transition hover:border-cyan-300 hover:text-cyan-200">Reset</a>
        </div>
    </form>

    <section class="overflow-hidden rounded-2xl border border-white/10 bg-slate-900/80">
        <div class="overflow-x-auto">
            <table class="min-w-full text-left text-sm">
                <thead class="bg-slate-800/90 text-slate-200">
                    <tr>
                        <th class="px-4 py-3 font-medium">Factuurnummer</th>
                        <th class="px-4 py-3 font-medium">Leerling</th>
                        <th class="px-4 py-3 font-medium">Email</th>
                        <th class="px-4 py-3 font-medium">Bedrag</th>
                        <th class="px-4 py-3 font-medium">Betaaldatum</th>
                        <th class="px-4 py-3 font-medium">Methode</th>
                        <th class="px-4 py-3 font-medium">Referentie</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/10 text-slate-200">
                    @forelse ($betalingen as $betaling)
                        <tr>
                            <td class="px-4 py-3">{{ $betaling->Factuurnummer }}</td>
                            <td class="px-4 py-3">{{ $betaling->LeerlingNaam }}</td>
                            <td class="px-4 py-3">{{ $betaling->Email }}</td>
                            <td class="px-4 py-3">EUR {{ number_format((float) $betaling->Bedrag, 2, ',', '.') }}</td>
                            <td class="px-4 py-3">{{ \Illuminate\Support\Carbon::parse($betaling->Betaaldatum)->format('d-m-Y') }}</td>
                            <td class="px-4 py-3">{{ $betaling->Betaalmethode }}</td>
                            <td class="px-4 py-3">{{ $betaling->Referentie ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-6 text-center text-slate-300">Geen Betaling gevonden</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
</x-layouts.dashboard>
