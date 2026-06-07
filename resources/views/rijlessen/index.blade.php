<x-layouts.dashboard
    title="Rijlessen Overzicht"
    subtitle="Bekijk alle geplande en afgeronde rijlessen in het systeem."
    eyebrow="Dashboard"
    active="rijlessen"
>
    {{-- Happy scenario melding --}}
    @if(session('success'))
        <div class="rounded-2xl border border-emerald-300/40 bg-emerald-300/10 p-4 text-sm text-emerald-100">
            {{ session('success') }}
        </div>
    @endif

    {{-- Unhappy scenario: waarschuwing --}}
    @if(session('warning'))
        <div class="rounded-2xl border border-amber-300/40 bg-amber-300/10 p-4 text-sm text-amber-100">
            {{ session('warning') }}
        </div>
    @endif

    {{-- Unhappy scenario: foutmelding --}}
    @if(session('error'))
        <div class="rounded-2xl border border-rose-300/40 bg-rose-300/10 p-4 text-sm text-rose-100">
            {{ session('error') }}
        </div>
    @endif

    @if(!empty($rijlessen))
        <section class="overflow-hidden rounded-2xl border border-white/10 bg-slate-900/80 shadow-xl">
            <div class="overflow-x-auto">
                <table class="min-w-full text-left text-sm text-slate-200">
                    <thead class="bg-slate-800/90 text-slate-300">
                        <tr>
                            <th class="px-6 py-4 font-medium">#</th>
                            <th class="px-6 py-4 font-medium">Datum &amp; Tijd</th>
                            <th class="px-6 py-4 font-medium">Duur</th>
                            <th class="px-6 py-4 font-medium">Leerling</th>
                            <th class="px-6 py-4 font-medium">Instructeur</th>
                            <th class="px-6 py-4 font-medium">Voertuig</th>
                            <th class="px-6 py-4 font-medium">Lesdoel</th>
                            <th class="px-6 py-4 font-medium">Status</th>
                            <th class="px-6 py-4 font-medium">Acties</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/10 bg-slate-950/80">
                        @foreach($rijlessen as $rijles)
                            <tr class="transition hover:bg-slate-900/80">
                                <td class="px-6 py-4">{{ $rijles->Id }}</td>
                                <td class="px-6 py-4">{{ \Carbon\Carbon::parse($rijles->DatumTijd)->format('d-m-Y H:i') }}</td>
                                <td class="px-6 py-4">{{ $rijles->DuurMinuten }} min</td>
                                <td class="px-6 py-4">{{ $rijles->LeerlingNaam }}</td>
                                <td class="px-6 py-4">{{ $rijles->InstructeurNaam }}</td>
                                <td class="px-6 py-4">
                                    @if($rijles->VoertuigNaam)
                                        {{ $rijles->VoertuigNaam }}<br>
                                        <span class="text-xs text-slate-400">{{ $rijles->Kenteken }}</span>
                                    @else
                                        <span class="text-slate-500">Niet ingesteld</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">{{ $rijles->Lesdoel ?? '—' }}</td>
                                <td class="px-6 py-4">
                                    @php
                                        $badgeKleur = match($rijles->Status) {
                                            'Gepland'     => 'bg-blue-500/20 text-blue-200',
                                            'Gegeven'     => 'bg-emerald-500/20 text-emerald-200',
                                            'Geannuleerd' => 'bg-rose-500/20 text-rose-200',
                                            default       => 'bg-slate-500/20 text-slate-300',
                                        };
                                    @endphp
                                    <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold {{ $badgeKleur }}">
                                        {{ $rijles->Status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <a href="{{ route('rijlessen.show', $rijles->Id) }}"
                                       class="inline-flex items-center rounded-lg border border-white/10 bg-slate-800 px-3 py-1.5 text-xs font-medium text-slate-200 transition hover:bg-slate-700 hover:text-white">
                                        Bekijken
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>

    @else
        {{-- Lege staat --}}
        <div class="flex flex-col items-center justify-center rounded-2xl border border-white/10 bg-slate-900/80 py-16 text-slate-400">
            <svg class="mb-4 h-12 w-12 opacity-40" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
            </svg>
            <p class="text-sm">Er zijn geen rijlessen gevonden.</p>
        </div>
    @endif

</x-layouts.dashboard>
