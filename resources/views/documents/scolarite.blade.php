<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: 'DejaVu Sans', sans-serif; font-size: 14px; color: #333; }
        .header { text-align: center; margin-bottom: 40px; border-bottom: 3px double #333; padding-bottom: 20px; }
        .header h1 { font-size: 22px; margin: 0; text-transform: uppercase; }
        .header p { margin: 3px 0; color: #555; }
        .title { text-align: center; margin: 50px 0 40px; }
        .title h2 { font-size: 24px; text-decoration: underline; text-transform: uppercase; letter-spacing: 2px; }
        .body { line-height: 2; margin: 0 40px; text-align: justify; }
        .body .highlight { font-weight: bold; text-decoration: underline; }
        .info-table { width: 100%; margin: 20px 0; border-collapse: collapse; }
        .info-table td { padding: 8px 12px; border: 1px solid #ddd; }
        .info-table td:first-child { background: #f5f5f5; font-weight: bold; width: 35%; }
        .footer { margin-top: 80px; }
        .footer .date { text-align: right; margin-right: 40px; margin-bottom: 60px; }
        .footer .signature { text-align: right; margin-right: 40px; }
        .footer .signature .line { border-top: 1px solid #333; width: 200px; margin-left: auto; margin-top: 50px; padding-top: 5px; text-align: center; }
        .stamp { text-align: center; margin-top: 30px; font-size: 11px; color: #777; border-top: 1px solid #ccc; padding-top: 15px; }
    </style>
</head>
<body>
    <div class="header">
        @if($school->logo)
            <img src="{{ storage_path('app/public/' . $school->logo) }}" style="height: 60px; margin-bottom: 10px;">
        @endif
        <h1>{{ $school->name }}</h1>
        @if($school->address)<p>{{ $school->address }}</p>@endif
        @if($school->phone)<p>Tél : {{ $school->phone }}</p>@endif
        @if($school->email)<p>Email : {{ $school->email }}</p>@endif
    </div>

    <div class="title">
        <h2>Certificat de scolarité</h2>
    </div>

    <div class="body">
        <p>
            Le Directeur de l'établissement <span class="highlight">{{ $school->name }}</span> certifie que l'élève
            dont les informations figurent ci-dessous est régulièrement inscrit(e) et fréquente effectivement
            notre établissement au titre de l'année scolaire <span class="highlight">{{ date('Y') - 1 }}/{{ date('Y') }}</span>.
        </p>

        <table class="info-table">
            <tr>
                <td>Nom et prénom</td>
                <td>{{ $student->last_name }} {{ $student->first_name }}</td>
            </tr>
            @if($student->date_of_birth)
            <tr>
                <td>Date de naissance</td>
                <td>{{ \Carbon\Carbon::parse($student->date_of_birth)->format('d/m/Y') }}</td>
            </tr>
            @endif
            @if($student->place_of_birth)
            <tr>
                <td>Lieu de naissance</td>
                <td>{{ $student->place_of_birth }}</td>
            </tr>
            @endif
            <tr>
                <td>Sexe</td>
                <td>{{ $student->gender === 'M' ? 'Masculin' : 'Féminin' }}</td>
            </tr>
            <tr>
                <td>Classe</td>
                <td>{{ $student->classroom->name ?? '-' }}</td>
            </tr>
            <tr>
                <td>Matricule</td>
                <td>{{ $student->matricule ?? 'N/A' }}</td>
            </tr>
            @if($student->parent_name)
            <tr>
                <td>Parent / Tuteur</td>
                <td>{{ $student->parent_name }}</td>
            </tr>
            @endif
        </table>

        <p>
            Ce certificat est délivré à l'intéressé(e) pour servir et valoir ce que de droit.
        </p>
    </div>

    <div class="footer">
        <div class="date">
            Fait à {{ $school->city ?? '____________' }}, le {{ now()->format('d/m/Y') }}
        </div>
        <div class="signature">
            <p>Le Directeur</p>
            <div class="line">Signature et cachet</div>
        </div>
    </div>

    <div class="stamp">
        Document généré le {{ now()->format('d/m/Y à H:i') }} - {{ $school->name }}
    </div>
</body>
</html>
