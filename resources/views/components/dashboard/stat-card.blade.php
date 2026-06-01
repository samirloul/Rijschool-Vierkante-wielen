@props([
    'label',
    'value',
])

<article class="rounded-2xl border border-zinc-200 bg-white p-5 dark:border-zinc-700 dark:bg-zinc-900">
    <p class="text-sm text-zinc-500 dark:text-zinc-400">{{ $label }}</p>
    <p class="mt-2 text-3xl font-semibold text-zinc-900 dark:text-white">{{ $value }}</p>
</article>
