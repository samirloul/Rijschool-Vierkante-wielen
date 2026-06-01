<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @php($title = 'Over Ons')
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-slate-950 text-slate-100">
        <main class="mx-auto w-full max-w-6xl px-4 py-12 sm:px-6 lg:px-8">
            <a href="{{ route('home') }}" class="inline-flex items-center text-sm text-cyan-300 transition hover:text-cyan-200">Terug naar home</a>
            <h1 class="mt-4 text-4xl font-semibold text-white">Over Rijschool Vierkante Wielen</h1>
            <p class="mt-6 max-w-3xl leading-relaxed text-slate-300">
                Wij begeleiden leerlingen met persoonlijke aandacht en heldere feedback. Onze doelgroep bestaat vooral uit jongeren,
                inclusief jongeren met een fysieke beperking. Elke les is opgebouwd rond veiligheid, vertrouwen en duidelijke leerdoelen.
            </p>

            <div class="mt-10 grid gap-4 md:grid-cols-2">
                <article class="rounded-2xl border border-white/15 bg-white/5 p-6">
                    <h2 class="text-xl font-semibold text-amber-200">Ons team</h2>
                    <p class="mt-2 text-slate-300">Vier ervaren instructeurs met aandacht voor coaching en verkeersinzicht.</p>
                </article>
                <article class="rounded-2xl border border-white/15 bg-white/5 p-6">
                    <h2 class="text-xl font-semibold text-cyan-200">Onze visie</h2>
                    <p class="mt-2 text-slate-300">Iedere leerling moet op een veilige en haalbare manier zelfstandig kunnen rijden.</p>
                </article>
            </div>
        </main>
    </body>
</html>
