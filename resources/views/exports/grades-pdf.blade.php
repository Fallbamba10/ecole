<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Notes</title>
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
    <h1>Relevé des notes</h1>
    <p>Exporté le {{ now()->format('d/m/Y à H:i') }}</p>

    <table>
        <thead>
            <tr>
                <th>Élève</th>
                <th>Matière</th>
                <th>Note</th>
                <th>Sur</th>
                <th>Type</th>
                <th>Période</th>
            </tr>
        </thead>
        <tbody>
            @foreach($grades as $grade)
                <tr>
                    <td>{{ $grade->student->full_name ?? 'N/A' }}</td>
                    <td>{{ $grade->subject->name ?? 'N/A' }}</td>
                    <td><strong>{{ $grade->value }}</strong></td>
                    <td>{{ $grade->max_value }}</td>
                    <td>{{ $grade->type }}</td>
                    <td>{{ $grade->period }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">SchoolManager — Document généré automatiquement</div>
</body>
</html>
