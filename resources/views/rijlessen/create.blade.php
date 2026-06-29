<x-layouts.dashboard
    title="Les Toevoegen"
    subtitle="Plan een nieuwe rijles in het systeem."
    eyebrow="Dashboard"
    active="rijlessen"
>
    {{-- Terugknop --}}
    <div class="mb-6">
        <a href="{{ route('rijlessen.index') }}"
           class="inline-flex items-center gap-2 text-sm text-slate-400 transition hover:text-slate-200">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
            </svg>
            Terug naar overzicht
        </a>
    </div>

    {{-- Foutmelding --}}
    @if(session('error'))
        <div class="mb-6 rounded-2xl border border-rose-300/40 bg-rose-300/10 p-4 text-sm text-rose-100">
            {{ session('error') }}
        </div>
    @endif

    <section class="overflow-hidden rounded-2xl border border-white/10 bg-slate-900/80 shadow-xl">
        <div class="border-b border-white/10 bg-slate-800/90 px-6 py-4 text-sm font-medium text-slate-300">
            Lesgegevens invullen
        </div>

        <form action="{{ route('rijlessen.store') }}" method="POST" class="px-6 py-6">
            @csrf

            <div class="space-y-5">

                {{-- Leerling --}}
                <div>
                    <label for="leerling_id" class="mb-1.5 block text-sm font-medium text-slate-300">
                        Leerling <span class="text-rose-400">*</span>
                    </label>
                    <select
                        id="leerling_id"
                        name="leerling_id"
                        class="w-full rounded-xl border px-4 py-2.5 text-sm text-slate-200 bg-slate-800 transition
                               focus:outline-none focus:ring-2
                               @error('leerling_id') border-rose-500/60 focus:ring-rose-500/40
                               @else border-white/10 focus:ring-blue-500/40 @enderror"
                    >
                        <option value="" disabled {{ old('leerling_id') ? '' : 'selected' }}>Kies een leerling</option>
                        @foreach($leerlingen as $leerling)
                            <option value="{{ $leerling->Id }}" {{ old('leerling_id') == $leerling->Id ? 'selected' : '' }}>
                                {{ $leerling->Naam }}
                            </option>
                        @endforeach
                    </select>
                    @error('leerling_id')
                        <p class="mt-1.5 text-xs text-rose-400">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Instructeur --}}
                <div>
                    <label for="instructeur_id" class="mb-1.5 block text-sm font-medium text-slate-300">
                        Instructeur <span class="text-rose-400">*</span>
                    </label>
                    <select
                        id="instructeur_id"
                        name="instructeur_id"
                        class="w-full rounded-xl border px-4 py-2.5 text-sm text-slate-200 bg-slate-800 transition
                               focus:outline-none focus:ring-2
                               @error('instructeur_id') border-rose-500/60 focus:ring-rose-500/40
                               @else border-white/10 focus:ring-blue-500/40 @enderror"
                    >
                        <option value="" disabled {{ old('instructeur_id') ? '' : 'selected' }}>Kies een instructeur</option>
                        @foreach($instructeurs as $instructeur)
                            <option value="{{ $instructeur->Id }}" {{ old('instructeur_id') == $instructeur->Id ? 'selected' : '' }}>
                                {{ $instructeur->Naam }}
                            </option>
                        @endforeach
                    </select>
                    @error('instructeur_id')
                        <p class="mt-1.5 text-xs text-rose-400">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Voertuig --}}
                <div>
                    <label for="voertuig_id" class="mb-1.5 block text-sm font-medium text-slate-300">
                        Voertuig <span class="text-rose-400">*</span>
                    </label>
                    <select
                        id="voertuig_id"
                        name="voertuig_id"
                        class="w-full rounded-xl border px-4 py-2.5 text-sm text-slate-200 bg-slate-800 transition
                               focus:outline-none focus:ring-2
                               @error('voertuig_id') border-rose-500/60 focus:ring-rose-500/40
                               @else border-white/10 focus:ring-blue-500/40 @enderror"
                    >
                        <option value="" disabled {{ old('voertuig_id') ? '' : 'selected' }}>Kies een voertuig</option>
                        @foreach($voertuigen as $voertuig)
                            <option value="{{ $voertuig->Id }}" {{ old('voertuig_id') == $voertuig->Id ? 'selected' : '' }}>
                                {{ $voertuig->Naam }}
                            </option>
                        @endforeach
                    </select>
                    @error('voertuig_id')
                        <p class="mt-1.5 text-xs text-rose-400">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Datum & Tijd --}}
                <div>
                    <label for="datum_tijd" class="mb-1.5 block text-sm font-medium text-slate-300">
                        Datum &amp; Tijd <span class="text-rose-400">*</span>
                    </label>
                    <input
                        type="datetime-local"
                        id="datum_tijd"
                        name="datum_tijd"
                        value="{{ old('datum_tijd') }}"
                        min="{{ now()->addMinutes(5)->format('Y-m-d\TH:i') }}"
                        class="w-full rounded-xl border px-4 py-2.5 text-sm text-slate-200 bg-slate-800 transition
                               focus:outline-none focus:ring-2
                               @error('datum_tijd') border-rose-500/60 focus:ring-rose-500/40
                               @else border-white/10 focus:ring-blue-500/40 @enderror"
                    >
                    @error('datum_tijd')
                        <p class="mt-1.5 text-xs text-rose-400">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Tijdsduur --}}
                <div>
                    <label for="duur_minuten" class="mb-1.5 block text-sm font-medium text-slate-300">
                        Tijdsduur <span class="text-rose-400">*</span>
                    </label>
                    <select
                        id="duur_minuten"
                        name="duur_minuten"
                        class="w-full rounded-xl border px-4 py-2.5 text-sm text-slate-200 bg-slate-800 transition
                               focus:outline-none focus:ring-2
                               @error('duur_minuten') border-rose-500/60 focus:ring-rose-500/40
                               @else border-white/10 focus:ring-blue-500/40 @enderror"
                    >
                        <option value="" disabled {{ old('duur_minuten') ? '' : 'selected' }}>Kies een duur</option>
                        @foreach([30, 45, 60, 90, 120] as $minuten)
                            <option value="{{ $minuten }}" {{ old('duur_minuten') == $minuten ? 'selected' : '' }}>
                                {{ $minuten }} minuten
                            </option>
                        @endforeach
                    </select>
                    @error('duur_minuten')
                        <p class="mt-1.5 text-xs text-rose-400">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Ophaaladres --}}
                <fieldset>
                    <legend class="mb-3 text-sm font-medium text-slate-300">
                        Ophaaladres <span class="text-rose-400">*</span>
                    </legend>

                    <div class="space-y-3">

                        {{-- Straat + Huisnummer --}}
                        <div class="grid grid-cols-3 gap-3">
                            <div class="col-span-2">
                                <label for="ophaal_straat" class="mb-1.5 block text-xs text-slate-400">Straat</label>
                                <input
                                    type="text"
                                    id="ophaal_straat"
                                    name="ophaal_straat"
                                    value="{{ old('ophaal_straat') }}"
                                    placeholder="Hoofdstraat"
                                    maxlength="60"
                                    class="w-full rounded-xl border px-4 py-2.5 text-sm text-slate-200 bg-slate-800 placeholder-slate-500 transition
                                           focus:outline-none focus:ring-2
                                           @error('ophaal_straat') border-rose-500/60 focus:ring-rose-500/40
                                           @else border-white/10 focus:ring-blue-500/40 @enderror"
                                >
                                @error('ophaal_straat')
                                    <p class="mt-1.5 text-xs text-rose-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="ophaal_huisnummer" class="mb-1.5 block text-xs text-slate-400">Huisnummer</label>
                                <input
                                    type="text"
                                    id="ophaal_huisnummer"
                                    name="ophaal_huisnummer"
                                    value="{{ old('ophaal_huisnummer') }}"
                                    placeholder="12A"
                                    maxlength="10"
                                    class="w-full rounded-xl border px-4 py-2.5 text-sm text-slate-200 bg-slate-800 placeholder-slate-500 transition
                                           focus:outline-none focus:ring-2
                                           @error('ophaal_huisnummer') border-rose-500/60 focus:ring-rose-500/40
                                           @else border-white/10 focus:ring-blue-500/40 @enderror"
                                >
                                @error('ophaal_huisnummer')
                                    <p class="mt-1.5 text-xs text-rose-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- Postcode + Stad --}}
                        <div class="grid grid-cols-3 gap-3">
                            <div>
                                <label for="ophaal_postcode" class="mb-1.5 block text-xs text-slate-400">Postcode</label>
                                <input
                                    type="text"
                                    id="ophaal_postcode"
                                    name="ophaal_postcode"
                                    value="{{ old('ophaal_postcode') }}"
                                    placeholder="5141AB"
                                    maxlength="10"
                                    class="w-full rounded-xl border px-4 py-2.5 text-sm text-slate-200 bg-slate-800 placeholder-slate-500 transition
                                           focus:outline-none focus:ring-2
                                           @error('ophaal_postcode') border-rose-500/60 focus:ring-rose-500/40
                                           @else border-white/10 focus:ring-blue-500/40 @enderror"
                                >
                                @error('ophaal_postcode')
                                    <p class="mt-1.5 text-xs text-rose-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="col-span-2">
                                <label for="ophaal_stad" class="mb-1.5 block text-xs text-slate-400">Stad</label>
                                <input
                                    type="text"
                                    id="ophaal_stad"
                                    name="ophaal_stad"
                                    value="{{ old('ophaal_stad') }}"
                                    placeholder="Waalwijk"
                                    maxlength="40"
                                    class="w-full rounded-xl border px-4 py-2.5 text-sm text-slate-200 bg-slate-800 placeholder-slate-500 transition
                                           focus:outline-none focus:ring-2
                                           @error('ophaal_stad') border-rose-500/60 focus:ring-rose-500/40
                                           @else border-white/10 focus:ring-blue-500/40 @enderror"
                                >
                                @error('ophaal_stad')
                                    <p class="mt-1.5 text-xs text-rose-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                    </div>
                </fieldset>

            </div>

            {{-- Formulier-acties --}}
            <div class="mt-8 flex items-center justify-end gap-3">
                <a href="{{ route('rijlessen.index') }}"
                   class="rounded-xl border border-white/10 bg-slate-800 px-5 py-2.5 text-sm font-medium text-slate-300 transition hover:bg-slate-700 hover:text-white">
                    Annuleren
                </a>
                <button
                    type="submit"
                    class="inline-flex items-center gap-2 rounded-xl bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white shadow transition hover:bg-blue-500 active:scale-95">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    Les toevoegen
                </button>
            </div>
        </form>
    </section>

</x-layouts.dashboard>
