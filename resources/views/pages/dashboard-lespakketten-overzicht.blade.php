<x-layouts.dashboard
    title="Rijlespakketten Overzicht"
    subtitle="Interne beheerderspagina met alle pakketten uit de database."
    eyebrow="Dashboard"
    active="packages"
>
    @php
        $formulierOpen = old('pakket_nummer')
            || old('naam')
            || old('aantal_lessen')
            || old('prijs')
            || old('omschrijving')
            || $errors->has('pakket_nummer')
            || $errors->has('naam')
            || $errors->has('aantal_lessen')
            || $errors->has('prijs')
            || $errors->has('omschrijving');
    @endphp

    @if (session('status'))
        <div class="rounded-xl border border-emerald-300/40 bg-emerald-300/10 p-4 text-sm text-emerald-100">
            {{ session('status') }}
        </div>
    @endif

    @if (! empty($lespakkettenOverzichtError))
        <div class="rounded-xl border border-rose-300/40 bg-rose-300/10 p-4 text-sm text-rose-100">
            {{ $lespakkettenOverzichtError }}
        </div>
    @endif

    <section class="rounded-2xl border border-white/10 bg-slate-900/80 p-4 sm:p-6">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <div>
                <h3 class="text-lg font-semibold text-white">Nieuw rijlespakket</h3>
                <p class="text-sm text-slate-300">Gebruik de knop hieronder om een nieuw pakket toe te voegen.</p>
            </div>
            <button
                id="pakket-toevoegen-knop"
                type="button"
                class="rounded-lg bg-cyan-300 px-4 py-2 text-sm font-semibold text-slate-900 transition hover:bg-cyan-200"
                aria-controls="nieuw-pakket-formulier"
                aria-expanded="{{ $formulierOpen ? 'true' : 'false' }}"
            >
                Pakket toevoegen
            </button>
        </div>

        <form
            id="nieuw-pakket-formulier"
            method="POST"
            action="{{ route('dashboard.packages.store') }}"
            @class([
                'mt-5 grid gap-4 md:grid-cols-2',
                'hidden' => ! $formulierOpen,
            ])
        >
            @csrf

            @if ($errors->has('pakket_nummer'))
                <div class="md:col-span-2 rounded-xl border border-rose-300/50 bg-rose-400/20 px-4 py-3 text-sm font-semibold text-rose-100">
                    Fout: {{ $errors->first('pakket_nummer') }}
                </div>
            @endif

            <label class="grid gap-2 text-sm text-slate-200">
                Pakketnummer
                <input
                    type="number"
                    name="pakket_nummer"
                    value="{{ old('pakket_nummer') }}"
                    min="1"
                    step="1"
                    class="rounded-lg border border-white/20 bg-slate-800 px-3 py-2 text-slate-100 placeholder:text-slate-400 focus:border-cyan-300 focus:outline-none"
                    placeholder="Bijv. 9"
                    required
                >
                @error('pakket_nummer')
                    <span class="text-xs text-rose-300">{{ $message }}</span>
                @enderror
            </label>

            <label class="grid gap-2 text-sm text-slate-200">
                Naam
                <input
                    type="text"
                    name="naam"
                    value="{{ old('naam') }}"
                    maxlength="60"
                    class="rounded-lg border border-white/20 bg-slate-800 px-3 py-2 text-slate-100 placeholder:text-slate-400 focus:border-cyan-300 focus:outline-none"
                    placeholder="Bijv. Examenklaar pakket"
                    required
                >
                @error('naam')
                    <span class="text-xs text-rose-300">{{ $message }}</span>
                @enderror
            </label>

            <label class="grid gap-2 text-sm text-slate-200">
                Aantal lessen
                <input
                    type="number"
                    name="aantal_lessen"
                    value="{{ old('aantal_lessen') }}"
                    min="1"
                    max="999"
                    step="1"
                    class="rounded-lg border border-white/20 bg-slate-800 px-3 py-2 text-slate-100 placeholder:text-slate-400 focus:border-cyan-300 focus:outline-none"
                    placeholder="Bijv. 15"
                    required
                >
                @error('aantal_lessen')
                    <span class="text-xs text-rose-300">{{ $message }}</span>
                @enderror
            </label>

            <label class="grid gap-2 text-sm text-slate-200">
                Prijs (EUR)
                <input
                    type="number"
                    name="prijs"
                    value="{{ old('prijs') }}"
                    min="0.01"
                    max="999999.99"
                    step="0.01"
                    class="rounded-lg border border-white/20 bg-slate-800 px-3 py-2 text-slate-100 placeholder:text-slate-400 focus:border-cyan-300 focus:outline-none"
                    placeholder="Bijv. 599.00"
                    required
                >
                @error('prijs')
                    <span class="text-xs text-rose-300">{{ $message }}</span>
                @enderror
            </label>

            <label class="grid gap-2 text-sm text-slate-200 md:col-span-2">
                Omschrijving
                <textarea
                    name="omschrijving"
                    rows="3"
                    maxlength="250"
                    class="rounded-lg border border-white/20 bg-slate-800 px-3 py-2 text-slate-100 placeholder:text-slate-400 focus:border-cyan-300 focus:outline-none"
                    placeholder="Korte beschrijving van dit pakket"
                >{{ old('omschrijving') }}</textarea>
                @error('omschrijving')
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

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const knop = document.getElementById('pakket-toevoegen-knop');
            const formulier = document.getElementById('nieuw-pakket-formulier');

            if (!knop || !formulier) {
                return;
            }

            knop.addEventListener('click', function () {
                formulier.classList.remove('hidden');
                knop.setAttribute('aria-expanded', 'true');
                const eersteInput = formulier.querySelector('input, textarea, select');
                if (eersteInput) {
                    eersteInput.focus();
                }
            });
        });
    </script>

    <section class="overflow-hidden rounded-2xl border border-white/10 bg-slate-900/80">
        <div class="overflow-x-auto">
            <table class="min-w-full text-left text-sm">
                <thead class="bg-slate-800/90 text-slate-200">
                    <tr>
                        <th class="px-4 py-3 font-medium">Nummer</th>
                        <th class="px-4 py-3 font-medium">Pakket</th>
                        <th class="px-4 py-3 font-medium">Aantal lessen</th>
                        <th class="px-4 py-3 font-medium">Prijs</th>
                        <th class="px-4 py-3 font-medium">Gekoppelde leerlingen</th>
                        <th class="px-4 py-3 font-medium">Omschrijving</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/10 text-slate-200">
                    @forelse ($lespakketten as $lespakket)
                        <tr>
                            <td class="px-4 py-3">{{ $lespakket->Id }}</td>
                            <td class="px-4 py-3">{{ $lespakket->Naam }}</td>
                            <td class="px-4 py-3">{{ $lespakket->AantalLessen }}</td>
                            <td class="px-4 py-3">EUR {{ number_format((float) $lespakket->Prijs, 2, ',', '.') }}</td>
                            <td class="px-4 py-3">{{ (int) ($lespakket->AantalGekoppeldeLeerlingen ?? 0) }}</td>
                            <td class="px-4 py-3">{{ $lespakket->Omschrijving ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-6 text-center text-slate-300">Geen Rijlespakketten gevonden.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
</x-layouts.dashboard>
