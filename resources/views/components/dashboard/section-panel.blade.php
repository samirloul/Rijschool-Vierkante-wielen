@props([
    'title' => null,
    'colSpan' => false,
])

<article @class([
    'rounded-2xl border border-zinc-200 bg-white p-5 dark:border-zinc-700 dark:bg-zinc-900',
    'lg:col-span-2' => $colSpan,
])>
    @if ($title)
        <h2 class="text-lg font-semibold text-zinc-900 dark:text-white">{{ $title }}</h2>
    @endif

    <div @class(['mt-4' => $title])>
        {{ $slot }}
    </div>
</article>
