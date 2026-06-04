<x-layouts.site title="Contact">
    <main class="mx-auto w-full max-w-6xl px-4 py-12 sm:px-6 lg:px-8">
        <a href="{{ route('home') }}" class="inline-flex items-center text-sm text-cyan-300 transition hover:text-cyan-200">Terug naar home</a>
        <h1 class="mt-4 text-4xl font-semibold text-white">Contact</h1>
        <p class="mt-6 max-w-3xl leading-relaxed text-slate-300">
            Vraag informatie aan of plan direct een intake. We reageren doorgaans binnen 1 werkdag.
        </p>

        <div class="mt-10 grid gap-6 md:grid-cols-2">
            <div class="rounded-2xl border border-white/15 bg-white/5 p-6">
                <p class="text-sm uppercase tracking-wider text-slate-400">Adres</p>
                <p class="mt-1 text-white">Vondellaan 25, Rotterdam</p>
                <p class="mt-4 text-sm uppercase tracking-wider text-slate-400">Telefoon</p>
                <p class="mt-1 text-white">010 - 123 45 67</p>
                <p class="mt-4 text-sm uppercase tracking-wider text-slate-400">E-mail</p>
                <p class="mt-1 text-white">info@vierkantewielen.nl</p>
            </div>
            <form class="rounded-2xl border border-white/15 bg-white/5 p-6" method="POST" action="#">
                <label class="mb-2 block text-sm text-slate-300">Naam</label>
                <input type="text" class="w-full rounded-xl border border-white/20 bg-slate-900 px-4 py-2 text-white outline-none ring-cyan-300 transition focus:ring-2" placeholder="Jouw naam">
                <label class="mb-2 mt-4 block text-sm text-slate-300">E-mail</label>
                <input type="email" class="w-full rounded-xl border border-white/20 bg-slate-900 px-4 py-2 text-white outline-none ring-cyan-300 transition focus:ring-2" placeholder="jij@email.nl">
                <label class="mb-2 mt-4 block text-sm text-slate-300">Bericht</label>
                <textarea rows="4" class="w-full rounded-xl border border-white/20 bg-slate-900 px-4 py-2 text-white outline-none ring-cyan-300 transition focus:ring-2" placeholder="Je vraag of verzoek"></textarea>
                <button type="submit" class="mt-5 rounded-full bg-amber-400 px-5 py-2 font-semibold text-slate-900 transition hover:bg-amber-300">Versturen</button>
            </form>
        </div>
    </main>
</x-layouts.site>
