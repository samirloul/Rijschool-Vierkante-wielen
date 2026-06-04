<x-layouts.dashboard
    title="Mijn Dashboard"
    subtitle="Hier zie je in een oogopslag je lessen, opmerkingen en acties. Dit dashboard is volledig eigen ontwerp en kan door teamleden per user story verder uitgebreid worden."
    eyebrow="Persoonlijk"
    active="dashboard"
>
    <section class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
        <article class="rounded-2xl border border-cyan-200/30 bg-cyan-300/10 p-5">
            <p class="text-sm text-cyan-100">Lessen deze week</p>
            <p class="mt-2 text-3xl font-semibold text-white">6</p>
        </article>
        <article class="rounded-2xl border border-amber-200/30 bg-amber-300/10 p-5">
            <p class="text-sm text-amber-100">Open taken</p>
            <p class="mt-2 text-3xl font-semibold text-white">4</p>
        </article>
        <article class="rounded-2xl border border-emerald-200/30 bg-emerald-300/10 p-5">
            <p class="text-sm text-emerald-100">Tegoed lessen</p>
            <p class="mt-2 text-3xl font-semibold text-white">14</p>
        </article>
        <article class="rounded-2xl border border-fuchsia-200/30 bg-fuchsia-300/10 p-5">
            <p class="text-sm text-fuchsia-100">Nieuwe meldingen</p>
            <p class="mt-2 text-3xl font-semibold text-white">3</p>
        </article>
    </section>

    <section class="grid gap-4 xl:grid-cols-3">
        <article id="planning" class="rounded-2xl border border-white/10 bg-slate-900/80 p-5 xl:col-span-2">
            <h3 class="text-lg font-semibold text-white">Planning Vandaag</h3>
            <div class="mt-4 space-y-3">
                <div class="rounded-xl border border-white/10 bg-slate-800/70 p-4">
                    <p class="text-sm font-semibold text-white">09:00 - 10:30 | Les met Iris van Dijk</p>
                    <p class="mt-1 text-sm text-slate-300">Ophaaladres: Marconistraat 14, Rotterdam</p>
                    <p class="text-sm text-slate-300">Doel: Kijktechniek en rustig invoegen op de snelweg</p>
                </div>
                <div class="rounded-xl border border-white/10 bg-slate-800/70 p-4">
                    <p class="text-sm font-semibold text-white">11:00 - 12:30 | Les met Sami El Azzouzi</p>
                    <p class="mt-1 text-sm text-slate-300">Ophaaladres: Schiedamseweg 210, Rotterdam</p>
                    <p class="text-sm text-slate-300">Doel: Bijzondere verrichtingen en bochtentechniek</p>
                </div>
            </div>
        </article>

        <article id="acties" class="rounded-2xl border border-white/10 bg-slate-900/80 p-5">
            <h3 class="text-lg font-semibold text-white">Snelle Acties</h3>
            <div class="mt-4 flex flex-col gap-2 text-sm">
                <button class="rounded-xl border border-cyan-300/40 bg-cyan-300/10 px-4 py-2 text-left font-medium text-cyan-100 transition hover:bg-cyan-300/20">Les wijzigen</button>
                <button class="rounded-xl border border-amber-300/40 bg-amber-300/10 px-4 py-2 text-left font-medium text-amber-100 transition hover:bg-amber-300/20">Les annuleren</button>
                <button class="rounded-xl border border-rose-300/40 bg-rose-300/10 px-4 py-2 text-left font-medium text-rose-100 transition hover:bg-rose-300/20">Ziekmelding doorgeven</button>
                <button class="rounded-xl border border-emerald-300/40 bg-emerald-300/10 px-4 py-2 text-left font-medium text-emerald-100 transition hover:bg-emerald-300/20">Praktijkexamen aanvragen</button>
            </div>
        </article>
    </section>

    <section class="grid gap-4 lg:grid-cols-2">
        <article id="mededelingen" class="rounded-2xl border border-white/10 bg-slate-900/80 p-5">
            <h3 class="text-lg font-semibold text-white">Mededelingen</h3>
            <ul class="mt-4 space-y-3 text-sm text-slate-300">
                <li class="rounded-xl border border-white/10 bg-slate-800/70 p-4">Vrijdag 16:00: extra theorie-uitleg in lokaal B.</li>
                <li class="rounded-xl border border-white/10 bg-slate-800/70 p-4">Nieuwe elektrische lesauto beschikbaar vanaf maandag.</li>
                <li class="rounded-xl border border-white/10 bg-slate-800/70 p-4">Controleer je profielgegevens en ophaaladres voor komende week.</li>
            </ul>
        </article>

        <article id="team" class="rounded-2xl border border-white/10 bg-slate-900/80 p-5">
            <h3 class="text-lg font-semibold text-white">Team Gebruik</h3>
            <p class="mt-3 text-sm text-slate-300">
                Deze basis is modulair opgebouwd: teamleden kunnen per user story blokken toevoegen zoals facturatie,
                roosterbeheer, leerlingstatus of wagenparkbeheer.
            </p>
            <div class="mt-4 grid gap-2 text-sm">
                <div class="rounded-xl border border-white/10 bg-slate-800/70 px-4 py-3">User Story blok: Lesplanning</div>
                <div class="rounded-xl border border-white/10 bg-slate-800/70 px-4 py-3">User Story blok: Facturatie</div>
                <div class="rounded-xl border border-white/10 bg-slate-800/70 px-4 py-3">User Story blok: Ziekmeldingen</div>
                <div class="rounded-xl border border-white/10 bg-slate-800/70 px-4 py-3">User Story blok: Examenresultaten</div>
            </div>
        </article>
    </section>
</x-layouts.dashboard>
