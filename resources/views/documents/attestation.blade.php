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
        .footer { margin-top: 80px; }
        .footer .date { text-align: right; margin-right: 40px; margin-bottom: 60px; }
        .footer .signature { text-align: right; margin-right: 40px; }
        .footer .signature .line { border-top: 1px solid #333; width: 200px; margin-left: auto; margin-top: 50px; padding-top: 5px; text-align: center; }
        .stamp { text-align: center; margin-top: 30px; font-size: 11px; color: #777; border-top: 1px solid #ccc; padding-top: 15px; }
        .ref { font-size: 11px; color: #777; margin-bottom: 10px; }
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

    <div class="ref">
        Réf : ATT-{{ str_pad($student->id, 4, '0', STR_PAD_LEFT) }}/{{ date('Y') }}
    </div>

    <div class="title">
        <h2>Attestation d'inscription</h2>
    </div>

    <div class="body">
        <p>
            Le Directeur de l'établissement <span class="highlight">{{ $school->name }}</span> atteste que :
        </p>

        <p style="margin: 30px 0; padding: 15px; background: #f8f8f8; border-left: 4px solid #333;">
            <strong>{{ $student->last_name }} {{ $student->first_name }}</strong><br>
            @if($student->date_of_birth)Né(e) le : {{ \Carbon\Carbon::parse($student->date_of_birth)->format('d/m/Y') }}<br>@endif
            @if($student->gender)Sexe : {{ $student->gender === 'M' ? 'Masculin' : 'Féminin' }}<br>@endif
            Matricule : {{ $student->matricule ?? 'N/A' }}
        </p>

        <p>
            est régulièrement inscrit(e) dans notre établissement pour l'année scolaire
            <span class="highlight">{{ date('Y') - 1 }}/{{ date('Y') }}</span>,
            en classe de <span class="highlight">{{ $student->classroom->name ?? '-' }}</span>.
        </p>

        <p>
            En foi de quoi, la présente attestation est délivrée à l'intéressé(e) pour servir et valoir ce que de droit.
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
