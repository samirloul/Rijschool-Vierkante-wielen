@props([
    'title' => null,
    'subtitle' => null,
])

<div class="flex h-full w-full flex-1 flex-col gap-6 rounded-xl">
    @if ($title)
        <section class="animate-rise-in overflow-hidden rounded-2xl border border-zinc-200 bg-gradient-to-r from-amber-100 to-cyan-100 p-6 dark:border-zinc-700 dark:from-amber-500/20 dark:to-cyan-500/20">
            <p class="text-xs font-semibold uppercase tracking-[0.16em] text-zinc-600 dark:text-zinc-300">Welkom terug</p>
            <h1 class="mt-2 text-2xl font-semibold text-zinc-900 dark:text-white">{{ $title }}</h1>
            @if ($subtitle)
                <p class="mt-2 max-w-2xl text-sm text-zinc-700 dark:text-zinc-200">{{ $subtitle }}</p>
            @endif
        </section>
    @endif

    {{ $slot }}
</div>
