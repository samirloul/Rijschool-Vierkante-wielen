<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @php($title = 'Lespakketten')
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-slate-950 text-slate-100">
        <main class="mx-auto w-full max-w-6xl px-4 py-12 sm:px-6 lg:px-8">
            <a href="{{ route('home') }}" class="inline-flex items-center text-sm text-cyan-300 transition hover:text-cyan-200">Terug naar home</a>
            <h1 class="mt-4 text-4xl font-semibold text-white">Lespakketten</h1>
            <p class="mt-6 max-w-3xl leading-relaxed text-slate-300">
                Kies het pakket dat past bij jouw startniveau. Aanpassingen voor fysieke ondersteuning zijn altijd bespreekbaar.
            </p>

            <div class="mt-10 grid gap-4 md:grid-cols-3">
                <article class="rounded-2xl border border-white/15 bg-white/5 p-6">
                    <h2 class="text-xl font-semibold text-amber-200">Start</h2>
                    <p class="mt-2 text-slate-300">20 lessen, tussentijdse evaluatie en online voortgang.</p>
                    <p class="mt-4 text-2xl font-semibold text-white">EUR 1195</p>
                </article>
                <article class="rounded-2xl border border-cyan-300/40 bg-cyan-500/10 p-6">
                    <h2 class="text-xl font-semibold text-cyan-200">Comfort</h2>
                    <p class="mt-2 text-slate-300">30 lessen, proefexamen en flexibele lesblokken.</p>
                    <p class="mt-4 text-2xl font-semibold text-white">EUR 1695</p>
                </article>
                <article class="rounded-2xl border border-white/15 bg-white/5 p-6">
                    <h2 class="text-xl font-semibold text-emerald-200">Intensief</h2>
                    <p class="mt-2 text-slate-300">40 lessen, examenbegeleiding en extra coaching.</p>
                    <p class="mt-4 text-2xl font-semibold text-white">EUR 2195</p>
                </article>
            </div>
        </main>
    </body>
</html>
