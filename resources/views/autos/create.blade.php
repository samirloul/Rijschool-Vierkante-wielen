<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
	<head>
		@include('partials.head')
	</head>
	<body class="bg-slate-950 text-slate-100">
		<div class="absolute inset-0 -z-10 opacity-70">
			<div class="absolute inset-x-0 top-0 h-[38rem] bg-gradient-to-b from-amber-500/35 via-cyan-500/20 to-transparent"></div>
			<div class="absolute -left-20 top-48 h-96 w-96 rounded-full bg-cyan-400/25 blur-3xl"></div>
			<div class="absolute -right-20 top-20 h-96 w-96 rounded-full bg-amber-300/25 blur-3xl"></div>
			<div class="pattern-grid absolute inset-0"></div>
		</div>

		<header class="sticky top-0 z-30 border-b border-white/10 bg-slate-950/85 backdrop-blur">
			<div class="mx-auto flex w-full max-w-7xl items-center justify-between px-4 py-4 sm:px-6 lg:px-8">
				<a href="{{ route('home') }}" class="text-lg font-semibold tracking-wide text-amber-300">Rijschool Vierkante Wielen</a>
				<nav class="hidden items-center gap-6 text-sm text-slate-200 md:flex">
					<a href="{{ route('home') }}" class="transition hover:text-amber-300">Home</a>
					<a href="{{ route('autos.overzicht') }}" class="transition hover:text-amber-300">Auto's</a>
				</nav>
			</div>
		</header>

		<main>
			<div class="min-h-screen bg-gradient-to-b from-slate-950 to-slate-900 py-12 px-4 sm:px-6 lg:px-8">
				<div class="mx-auto max-w-3xl">
					<h1 class="text-4xl font-bold text-white">Auto Toevoegen</h1>
					<p class="mt-2 text-slate-300">Voeg een nieuwe auto toe aan het systeem.</p>

					@if (session('error'))
						<div class="mt-6 rounded-lg border border-red-500/40 bg-red-500/10 p-4 text-red-200">
							{{ session('error') }}
						</div>
					@endif

					<form method="POST" action="{{ route('autos.store') }}" novalidate class="mt-8 rounded-2xl border border-white/10 bg-slate-900/70 p-6 shadow-xl backdrop-blur">
						@csrf

						<div class="grid gap-5">
							<div>
								<label for="merk" class="mb-2 block text-sm font-medium text-slate-200">Merknaam</label>
								<input
									id="merk"
									name="merk"
									type="text"
									value="{{ old('merk') }}"
									class="w-full rounded-lg border border-slate-700 bg-slate-950 px-3 py-2 text-white focus:border-amber-400 focus:outline-none"
									required
								>
							</div>

							<div>
								<label for="model" class="mb-2 block text-sm font-medium text-slate-200">Model</label>
								<input
									id="model"
									name="model"
									type="text"
									value="{{ old('model') }}"
									class="w-full rounded-lg border border-slate-700 bg-slate-950 px-3 py-2 text-white focus:border-amber-400 focus:outline-none"
									required
								>
							</div>

							<div>
								<label for="transmissie" class="mb-2 block text-sm font-medium text-slate-200">Transmissie</label>
								<select
									id="transmissie"
									name="transmissie"
									class="w-full rounded-lg border border-slate-700 bg-slate-950 px-3 py-2 text-white focus:border-amber-400 focus:outline-none"
									required
								>
									<option value="">Kies transmissie</option>
									<option value="handgeschakeld" @selected(old('transmissie') === 'handgeschakeld')>Handgeschakeld</option>
									<option value="automatisch" @selected(old('transmissie') === 'automatisch')>Automatisch</option>
								</select>
							</div>

							<div>
								<label for="beschikbaarheid" class="mb-2 block text-sm font-medium text-slate-200">Beschikbaarheid</label>
								<select
									id="beschikbaarheid"
									name="beschikbaarheid"
									class="w-full rounded-lg border border-slate-700 bg-slate-950 px-3 py-2 text-white focus:border-amber-400 focus:outline-none"
									required
								>
									<option value="">Kies beschikbaarheid</option>
									<option value="beschikbaar" @selected(old('beschikbaarheid') === 'beschikbaar')>Beschikbaar</option>
									<option value="niet_beschikbaar" @selected(old('beschikbaarheid') === 'niet_beschikbaar')>Niet beschikbaar</option>
								</select>
							</div>
						</div>

						<div class="mt-8 flex items-center gap-3">
							<button
								type="submit"
								class="inline-flex items-center rounded-full bg-amber-400 px-5 py-2.5 font-semibold text-slate-900 transition hover:bg-amber-300"
							>
								Opslaan
							</button>
							<a href="{{ route('autos.overzicht') }}" class="text-sm text-slate-300 transition hover:text-white">Terug naar overzicht</a>
						</div>
					</form>
				</div>
			</div>
		</main>
	</body>
</html>
