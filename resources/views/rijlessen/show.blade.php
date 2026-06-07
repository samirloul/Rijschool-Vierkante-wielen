<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rijles Detail</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Rijles Detail</h1>
        <a href="{{ route('rijlessen.index') }}" class="btn btn-outline-secondary">
            &larr; Terug naar overzicht
        </a>
    </div>

    {{-- Unhappy scenario: foutmelding --}}
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-x-circle-fill me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Sluiten"></button>
        </div>
    @endif

    {{-- Happy scenario: detailkaarten --}}
    <div class="row g-4">

        {{-- Lesgegevens --}}
        <div class="col-12 col-md-6">
            <div class="card h-100">
                <div class="card-header fw-bold">Lesgegevens</div>
                <div class="card-body">
                    <dl class="row mb-0">
                        <dt class="col-5">Datum &amp; Tijd</dt>
                        <dd class="col-7">{{ \Carbon\Carbon::parse($rijles->DatumTijd)->format('d-m-Y H:i') }}</dd>

                        <dt class="col-5">Duur</dt>
                        <dd class="col-7">{{ $rijles->DuurMinuten }} minuten</dd>

                        <dt class="col-5">Lesdoel</dt>
                        <dd class="col-7">{{ $rijles->Lesdoel ?? '—' }}</dd>

                        <dt class="col-5">Onderwerp</dt>
                        <dd class="col-7">{{ $rijles->TeBehandelenOnderwerp ?? '—' }}</dd>

                        <dt class="col-5">Status</dt>
                        <dd class="col-7">
                            @php
                                $badgeKleur = match($rijles->Status) {
                                    'Gepland'     => 'primary',
                                    'Gegeven'     => 'success',
                                    'Geannuleerd' => 'danger',
                                    default       => 'secondary',
                                };
                            @endphp
                            <span class="badge bg-{{ $badgeKleur }}">{{ $rijles->Status }}</span>
                        </dd>

                        @if($rijles->AnnuleringsReden)
                            <dt class="col-5">Annuleringsreden</dt>
                            <dd class="col-7">{{ $rijles->AnnuleringsReden }}</dd>
                        @endif
                    </dl>
                </div>
            </div>
        </div>

        {{-- Betrokkenen --}}
        <div class="col-12 col-md-6">
            <div class="card h-100">
                <div class="card-header fw-bold">Betrokkenen</div>
                <div class="card-body">
                    <dl class="row mb-0">
                        <dt class="col-5">Leerling</dt>
                        <dd class="col-7">
                            {{ $rijles->LeerlingNaam }}<br>
                            <small class="text-muted">{{ $rijles->LeerlingEmail }}</small>
                        </dd>

                        <dt class="col-5">Instructeur</dt>
                        <dd class="col-7">
                            {{ $rijles->InstructeurNaam }}<br>
                            <small class="text-muted">{{ $rijles->InstructeurEmail }}</small>
                        </dd>
                    </dl>
                </div>
            </div>
        </div>

        {{-- Voertuig --}}
        <div class="col-12 col-md-6">
            <div class="card h-100">
                <div class="card-header fw-bold">Voertuig</div>
                <div class="card-body">
                    @if($rijles->VoertuigMerk)
                        <dl class="row mb-0">
                            <dt class="col-5">Merk &amp; Type</dt>
                            <dd class="col-7">{{ $rijles->VoertuigMerk }} {{ $rijles->VoertuigType }}</dd>

                            <dt class="col-5">Kenteken</dt>
                            <dd class="col-7">{{ $rijles->Kenteken }}</dd>

                            <dt class="col-5">Elektrisch</dt>
                            <dd class="col-7">{{ $rijles->IsElektrisch ? 'Ja' : 'Nee' }}</dd>
                        </dl>
                    @else
                        <p class="text-muted mb-0">Geen voertuig gekoppeld.</p>
                    @endif
                </div>
            </div>
        </div>

        {{-- Ophaaladres --}}
        <div class="col-12 col-md-6">
            <div class="card h-100">
                <div class="card-header fw-bold">Ophaaladres</div>
                <div class="card-body">
                    @if($rijles->OphaalStraat)
                        <address class="mb-0">
                            {{ $rijles->OphaalStraat }} {{ $rijles->OphaalHuisnummer }}<br>
                            {{ $rijles->OphaalPostcode }} {{ $rijles->OphaalStad }}
                        </address>
                    @else
                        <p class="text-muted mb-0">Geen ophaaladres ingesteld.</p>
                    @endif
                </div>
            </div>
        </div>

    </div>{{-- end .row --}}
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
