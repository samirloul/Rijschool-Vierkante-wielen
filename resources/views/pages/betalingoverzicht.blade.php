<x-layouts.dashboard
    title="Betaling Overzicht"
    subtitle="Bekijk en filter betalingen op datum en controleer direct de factuurgegevens, leerling en betaalmethode."
    eyebrow="Administratie"
    active="betalingen"
>
    @php
        $formulierOpen = old('factuur_id')
            || old('bedrag')
            || old('betaaldatum')
            || old('betaalmethode')
            || old('referentie')
            || $errors->has('factuur_id')
            || $errors->has('bedrag')
            || $errors->has('betaaldatum')
            || $errors->has('betaalmethode')
            || $errors->has('referentie');
    @endphp

    @if (session('status'))
        <div class="rounded-xl border border-emerald-300/40 bg-emerald-300/10 p-4 text-sm text-emerald-100">
            {{ session('status') }}
        </div>
    @endif

    @if (! empty($betalingOverzichtError))
        <div class="rounded-xl border border-rose-300/40 bg-rose-300/10 p-4 text-sm text-rose-100">
            {{ $betalingOverzichtError }}
        </div>
    @endif

    <section class="rounded-2xl border border-white/10 bg-slate-900/80 p-4 sm:p-6">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <div>
                <h3 class="text-lg font-semibold text-white">Nieuwe betaling</h3>
                <p class="text-sm text-slate-300">Klik op de knop om een nieuwe betaling te registreren.</p>
            </div>
            <button
                id="betaling-toevoegen-knop"
                type="button"
                class="rounded-lg bg-cyan-300 px-4 py-2 text-sm font-semibold text-slate-900 transition hover:bg-cyan-200"
                aria-controls="nieuw-betaling-formulier"
                aria-expanded="{{ $formulierOpen ? 'true' : 'false' }}"
            >
                Betaling toevoegen
            </button>
        </div>

        <form
            id="nieuw-betaling-formulier"
            method="POST"
            action="{{ route('betaling.overzicht.store') }}"
            @class([
                'mt-5 grid gap-4 md:grid-cols-2',
                'hidden' => ! $formulierOpen,
            ])
        >
            @csrf

            @if ($errors->has('factuur_id'))
                <div class="md:col-span-2 rounded-xl border border-rose-300/50 bg-rose-400/20 px-4 py-3 text-sm font-semibold text-rose-100">
                    Fout: {{ $errors->first('factuur_id') }}
                </div>
            @endif

            <label class="grid gap-2 text-sm text-slate-200">
                Factuur
                <select
                    name="factuur_id"
                    class="rounded-lg border border-white/20 bg-slate-800 px-3 py-2 text-slate-100 focus:border-cyan-300 focus:outline-none"
                    required
                >
                    <option value="">Selecteer een factuur</option>
                    @foreach (($factuurOpties ?? []) as $factuur)
                        <option value="{{ $factuur->Id }}" @selected((string) old('factuur_id') === (string) $factuur->Id)>
                            {{ $factuur->Factuurnummer }} - {{ trim($factuur->LeerlingNaam) }}
                            ({{ \Illuminate\Support\Carbon::parse($factuur->Factuurdatum)->format('d-m-Y') }} t/m {{ \Illuminate\Support\Carbon::parse($factuur->Vervaldatum)->format('d-m-Y') }})
                        </option>
                    @endforeach
                </select>
                @error('factuur_id')
                    <span class="text-xs text-rose-300">{{ $message }}</span>
                @enderror
            </label>

            <label class="grid gap-2 text-sm text-slate-200">
                Bedrag (EUR)
                <input
                    type="number"
                    name="bedrag"
                    value="{{ old('bedrag') }}"
                    min="0.01"
                    max="999999.99"
                    step="0.01"
                    class="rounded-lg border border-white/20 bg-slate-800 px-3 py-2 text-slate-100 placeholder:text-slate-400 focus:border-cyan-300 focus:outline-none"
                    placeholder="Bijv. 420.00"
                    required
                >
                @error('bedrag')
                    <span class="text-xs text-rose-300">{{ $message }}</span>
                @enderror
            </label>

            <label class="grid gap-2 text-sm text-slate-200">
                Betaaldatum
                <input
                    type="date"
                    name="betaaldatum"
                    value="{{ old('betaaldatum') }}"
                    class="rounded-lg border border-white/20 bg-slate-800 px-3 py-2 text-slate-100 focus:border-cyan-300 focus:outline-none"
                    required
                >
                @error('betaaldatum')
                    <span class="text-xs text-rose-300">{{ $message }}</span>
                @enderror
            </label>

            <label class="grid gap-2 text-sm text-slate-200">
                Betaalmethode
                <select
                    name="betaalmethode"
                    class="rounded-lg border border-white/20 bg-slate-800 px-3 py-2 text-slate-100 focus:border-cyan-300 focus:outline-none"
                    required
                >
                    <option value="">Selecteer methode</option>
                    @foreach (['Ideal', 'Creditcard', 'Contant', 'Overboeking'] as $methode)
                        <option value="{{ $methode }}" @selected(old('betaalmethode') === $methode)>{{ $methode }}</option>
                    @endforeach
                </select>
                @error('betaalmethode')
                    <span class="text-xs text-rose-300">{{ $message }}</span>
                @enderror
            </label>

            <label class="grid gap-2 text-sm text-slate-200 md:col-span-2">
                Referentie
                <input
                    type="text"
                    name="referentie"
                    value="{{ old('referentie') }}"
                    maxlength="50"
                    class="rounded-lg border border-white/20 bg-slate-800 px-3 py-2 text-slate-100 placeholder:text-slate-400 focus:border-cyan-300 focus:outline-none"
                    placeholder="Optioneel, bijv. iDEAL-20260622-001"
                >
                @error('referentie')
                    <span class="text-xs text-rose-300">{{ $message }}</span>
                @enderror
            </label>

            <div class="md:col-span-2">
                <button type="submit" class="rounded-lg bg-cyan-300 px-4 py-2 text-sm font-semibold text-slate-900 transition hover:bg-cyan-200">
                    Toevoegen
                </button>
            </div>
        </form>
    </section>

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

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const knop = document.getElementById('betaling-toevoegen-knop');
            const formulier = document.getElementById('nieuw-betaling-formulier');

            if (!knop || !formulier) {
                return;
            }

            knop.addEventListener('click', function () {
                formulier.classList.remove('hidden');
                knop.setAttribute('aria-expanded', 'true');
                const eersteInput = formulier.querySelector('select, input, textarea');
                if (eersteInput) {
                    eersteInput.focus();
                }
            });
        });
    </script>
</x-layouts.dashboard>
