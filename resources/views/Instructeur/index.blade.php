<!DOCTYPE html>
<html lang="nl">
    <head>
        @include('partials.head')
    </head>
    <body class="bg-slate-950 text-slate-100">
        <div class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">
            <header class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-4xl font-semibold text-white">Instructeurs overzicht</h1>
                    <p class="mt-2 text-slate-300">Bekijk de instructeurs die momenteel actief zijn in het systeem.</p>
                </div>
                <a href="{{ route('home') }}" class="inline-flex items-center rounded-full border border-white/20 bg-slate-900 px-5 py-3 text-sm font-semibold text-white transition hover:border-cyan-300 hover:text-cyan-200">Terug naar Home</a>
            </header>

            @if (!empty($error))
                <div class="rounded-2xl border border-red-600/40 bg-red-500/10 p-6 text-red-100">
                    {{ $error }}
                </div>
            @else
                <div class="overflow-hidden rounded-3xl border border-white/10 bg-slate-900/80 shadow-xl">
                    <table class="min-w-full divide-y divide-slate-700 text-left text-sm text-slate-200">
                        <thead class="bg-slate-950/90 text-slate-300">
                            <tr>
                                <th class="px-6 py-4">Naam</th>
                                <th class="px-6 py-4">E-mail</th>
                                <th class="px-6 py-4">Telefoon</th>
                                <th class="px-6 py-4">Rijbewijsnummer</th>
                                <th class="px-6 py-4">Indienst</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-800 bg-slate-950/80">
                            @foreach ($instructeurs as $instructeur)
                                <tr class="hover:bg-slate-900/80">
                                    <td class="px-6 py-4">{{ $instructeur->VolledigeNaam }}</td>
                                    <td class="px-6 py-4">{{ $instructeur->Email }}</td>
                                    <td class="px-6 py-4">{{ $instructeur->Telefoonnummer }}</td>
                                    <td class="px-6 py-4">{{ $instructeur->Rijbewijsnummer }}</td>
                                    <td class="px-6 py-4">{{ \Illuminate\Support\Carbon::parse($instructeur->IndienstDatum)->format('d-m-Y') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </body>
</html>
