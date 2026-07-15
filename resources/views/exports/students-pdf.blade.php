<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Élèves</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        h1 { color: #1e40af; font-size: 18px; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ddd; padding: 6px 8px; text-align: left; }
        th { background-color: #1e40af; color: white; font-size: 11px; }
        tr:nth-child(even) { background-color: #f9fafb; }
        .footer { margin-top: 20px; text-align: center; font-size: 10px; color: #666; }
    </style>
</head>
<body>
    <h1>Liste des élèves</h1>
    <p>Exporté le {{ now()->format('d/m/Y à H:i') }} — Total : {{ $students->count() }} élèves</p>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Prénom</th>
                <th>Nom</th>
                <th>Genre</th>
                <th>Classe</th>
                <th>Statut</th>
            </tr>
        </thead>
        <tbody>
            @foreach($students as $index => $student)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $student->first_name }}</td>
                    <td>{{ $student->last_name }}</td>
                    <td>{{ $student->gender }}</td>
                    <td>{{ $student->classroom->name ?? 'N/A' }}</td>
                    <td>{{ ucfirst($student->status) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">SchoolManager — Document généré automatiquement</div>
</body>
</html>
