<x-layouts.dashboard
    title="Rijles Detail"
    subtitle="Gedetailleerde informatie over de geselecteerde rijles."
    eyebrow="Dashboard"
    active="rijlessen"
>
    <div class="mb-6">
        <a href="{{ route('rijlessen.index') }}"
           class="inline-flex items-center gap-2 text-sm text-slate-400 transition hover:text-slate-200">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
            </svg>
            Terug naar overzicht
        </a>
    </div>

    {{-- Unhappy scenario: foutmelding --}}
    @if(session('error'))
        <div class="mb-6 rounded-2xl border border-rose-300/40 bg-rose-300/10 p-4 text-sm text-rose-100">
            {{ session('error') }}
        </div>
    @endif

    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">

        {{-- Lesgegevens --}}
        <section class="overflow-hidden rounded-2xl border border-white/10 bg-slate-900/80 shadow-xl">
            <div class="border-b border-white/10 bg-slate-800/90 px-6 py-4 text-sm font-medium text-slate-300">
                Lesgegevens
            </div>
            <div class="px-6 py-4">
                <dl class="space-y-3 text-sm">
                    <div class="flex justify-between gap-4">
                        <dt class="text-slate-400">Datum &amp; Tijd</dt>
                        <dd class="text-slate-200">{{ \Carbon\Carbon::parse($rijles->DatumTijd)->format('d-m-Y H:i') }}</dd>
                    </div>
                    <div class="flex justify-between gap-4">
                        <dt class="text-slate-400">Duur</dt>
                        <dd class="text-slate-200">{{ $rijles->DuurMinuten }} minuten</dd>
                    </div>
                    <div class="flex justify-between gap-4">
                        <dt class="text-slate-400">Lesdoel</dt>
                        <dd class="text-slate-200">{{ $rijles->Lesdoel ?? '—' }}</dd>
                    </div>
                    <div class="flex justify-between gap-4">
                        <dt class="text-slate-400">Onderwerp</dt>
                        <dd class="text-slate-200">{{ $rijles->TeBehandelenOnderwerp ?? '—' }}</dd>
                    </div>
                    <div class="flex justify-between gap-4">
                        <dt class="text-slate-400">Status</dt>
                        <dd>
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
                        </dd>
                    </div>
                    @if($rijles->AnnuleringsReden)
                        <div class="flex justify-between gap-4">
                            <dt class="text-slate-400">Annuleringsreden</dt>
                            <dd class="text-slate-200">{{ $rijles->AnnuleringsReden }}</dd>
                        </div>
                    @endif
                </dl>
            </div>
        </section>

        {{-- Betrokkenen --}}
        <section class="overflow-hidden rounded-2xl border border-white/10 bg-slate-900/80 shadow-xl">
            <div class="border-b border-white/10 bg-slate-800/90 px-6 py-4 text-sm font-medium text-slate-300">
                Betrokkenen
            </div>
            <div class="px-6 py-4">
                <dl class="space-y-3 text-sm">
                    <div class="flex justify-between gap-4">
                        <dt class="text-slate-400">Leerling</dt>
                        <dd class="text-right text-slate-200">
                            {{ $rijles->LeerlingNaam }}<br>
                            <span class="text-xs text-slate-400">{{ $rijles->LeerlingEmail }}</span>
                        </dd>
                    </div>
                    <div class="flex justify-between gap-4">
                        <dt class="text-slate-400">Instructeur</dt>
                        <dd class="text-right text-slate-200">
                            {{ $rijles->InstructeurNaam }}<br>
                            <span class="text-xs text-slate-400">{{ $rijles->InstructeurEmail }}</span>
                        </dd>
                    </div>
                </dl>
            </div>
        </section>

        {{-- Voertuig --}}
        <section class="overflow-hidden rounded-2xl border border-white/10 bg-slate-900/80 shadow-xl">
            <div class="border-b border-white/10 bg-slate-800/90 px-6 py-4 text-sm font-medium text-slate-300">
                Voertuig
            </div>
            <div class="px-6 py-4">
                @if($rijles->VoertuigMerk)
                    <dl class="space-y-3 text-sm">
                        <div class="flex justify-between gap-4">
                            <dt class="text-slate-400">Merk &amp; Type</dt>
                            <dd class="text-slate-200">{{ $rijles->VoertuigMerk }} {{ $rijles->VoertuigType }}</dd>
                        </div>
                        <div class="flex justify-between gap-4">
                            <dt class="text-slate-400">Kenteken</dt>
                            <dd class="text-slate-200">{{ $rijles->Kenteken }}</dd>
                        </div>
                        <div class="flex justify-between gap-4">
                            <dt class="text-slate-400">Elektrisch</dt>
                            <dd>
                                @if($rijles->IsElektrisch)
                                    <span class="inline-flex items-center rounded-full bg-emerald-500/20 px-3 py-1 text-xs font-semibold text-emerald-200">Ja</span>
                                @else
                                    <span class="inline-flex items-center rounded-full bg-slate-500/20 px-3 py-1 text-xs font-semibold text-slate-300">Nee</span>
                                @endif
                            </dd>
                        </div>
                    </dl>
                @else
                    <p class="text-sm text-slate-500">Geen voertuig gekoppeld.</p>
                @endif
            </div>
        </section>

        {{-- Ophaaladres --}}
        <section class="overflow-hidden rounded-2xl border border-white/10 bg-slate-900/80 shadow-xl">
            <div class="border-b border-white/10 bg-slate-800/90 px-6 py-4 text-sm font-medium text-slate-300">
                Ophaaladres
            </div>
            <div class="px-6 py-4">
                @if($rijles->OphaalStraat)
                    <address class="text-sm not-italic text-slate-200">
                        {{ $rijles->OphaalStraat }} {{ $rijles->OphaalHuisnummer }}<br>
                        {{ $rijles->OphaalPostcode }} {{ $rijles->OphaalStad }}
                    </address>
                @else
                    <p class="text-sm text-slate-500">Geen ophaaladres ingesteld.</p>
                @endif
            </div>
        </section>

    </div>

</x-layouts.dashboard>
