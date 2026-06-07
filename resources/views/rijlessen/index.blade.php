<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rijlessen Overzicht</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Rijlessen Overzicht</h1>
    </div>

    {{-- Happy scenario melding --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Sluiten"></button>
        </div>
    @endif

    {{-- Unhappy scenario: waarschuwing (geen lessen gevonden) --}}
    @if(session('warning'))
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('warning') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Sluiten"></button>
        </div>
    @endif

    {{-- Unhappy scenario: foutmelding --}}
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-x-circle-fill me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Sluiten"></button>
        </div>
    @endif

    {{-- Happy scenario: tabel met rijlessen --}}
    @if(!empty($rijlessen))
        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Datum &amp; Tijd</th>
                        <th>Duur</th>
                        <th>Leerling</th>
                        <th>Instructeur</th>
                        <th>Voertuig</th>
                        <th>Lesdoel</th>
                        <th>Status</th>
                        <th>Acties</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($rijlessen as $rijles)
                        <tr>
                            <td>{{ $rijles->Id }}</td>
                            <td>{{ \Carbon\Carbon::parse($rijles->DatumTijd)->format('d-m-Y H:i') }}</td>
                            <td>{{ $rijles->DuurMinuten }} min</td>
                            <td>{{ $rijles->LeerlingNaam }}</td>
                            <td>{{ $rijles->InstructeurNaam }}</td>
                            <td>
                                @if($rijles->VoertuigNaam)
                                    {{ $rijles->VoertuigNaam }}<br>
                                    <small class="text-muted">{{ $rijles->Kenteken }}</small>
                                @else
                                    <span class="text-muted">Niet ingesteld</span>
                                @endif
                            </td>
                            <td>{{ $rijles->Lesdoel ?? '—' }}</td>
                            <td>
                                @php
                                    $badgeKleur = match($rijles->Status) {
                                        'Gepland'     => 'primary',
                                        'Gegeven'     => 'success',
                                        'Geannuleerd' => 'danger',
                                        default       => 'secondary',
                                    };
                                @endphp
                                <span class="badge bg-{{ $badgeKleur }}">{{ $rijles->Status }}</span>
                            </td>
                            <td>
                                <a href="{{ route('rijlessen.show', $rijles->Id) }}"
                                   class="btn btn-sm btn-outline-primary">
                                    Bekijken
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    @else
        {{-- Unhappy scenario: lege staat --}}
        <div class="text-center py-5 text-muted">
            <i class="bi bi-calendar-x fs-1 d-block mb-3"></i>
            <p class="mb-0">Er zijn geen rijlessen gevonden.</p>
        </div>
    @endif

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
