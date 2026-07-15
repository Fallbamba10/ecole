<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Présences</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        h1 { color: #1e40af; font-size: 18px; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ddd; padding: 6px 8px; text-align: left; }
        th { background-color: #1e40af; color: white; font-size: 11px; }
        tr:nth-child(even) { background-color: #f9fafb; }
        .present { color: #16a34a; }
        .absent { color: #dc2626; }
        .retard { color: #d97706; }
        .footer { margin-top: 20px; text-align: center; font-size: 10px; color: #666; }
    </style>
</head>
<body>
    <h1>Registre de présences</h1>
    <p>Exporté le {{ now()->format('d/m/Y à H:i') }}</p>

    <table>
        <thead>
            <tr>
                <th>Élève</th>
                <th>Classe</th>
                <th>Date</th>
                <th>Statut</th>
            </tr>
        </thead>
        <tbody>
            @foreach($attendances as $attendance)
                <tr>
                    <td>{{ $attendance->student->full_name ?? 'N/A' }}</td>
                    <td>{{ $attendance->classroom->name ?? 'N/A' }}</td>
                    <td>{{ \Carbon\Carbon::parse($attendance->date)->format('d/m/Y') }}</td>
                    <td class="{{ $attendance->status }}">{{ ucfirst($attendance->status) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">SchoolManager — Document généré automatiquement</div>
</body>
</html>
