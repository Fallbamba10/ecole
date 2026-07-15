<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Paiements</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        h1 { color: #1e40af; font-size: 18px; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ddd; padding: 6px 8px; text-align: left; }
        th { background-color: #1e40af; color: white; font-size: 11px; }
        tr:nth-child(even) { background-color: #f9fafb; }
        .status-paye { color: #16a34a; font-weight: bold; }
        .status-en_attente { color: #d97706; font-weight: bold; }
        .status-en_retard { color: #dc2626; font-weight: bold; }
        .footer { margin-top: 20px; text-align: center; font-size: 10px; color: #666; }
    </style>
</head>
<body>
    <h1>Liste des paiements</h1>
    <p>Exporté le {{ now()->format('d/m/Y à H:i') }}</p>

    <table>
        <thead>
            <tr>
                <th>Élève</th>
                <th>Montant</th>
                <th>Type</th>
                <th>Méthode</th>
                <th>Statut</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($payments as $payment)
                <tr>
                    <td>{{ $payment->student->full_name ?? 'N/A' }}</td>
                    <td>{{ number_format($payment->amount, 0, ',', ' ') }} FCFA</td>
                    <td>{{ $payment->type }}</td>
                    <td>{{ $payment->payment_method }}</td>
                    <td class="status-{{ $payment->status }}">{{ $payment->status }}</td>
                    <td>{{ $payment->created_at->format('d/m/Y') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">SchoolManager — Document généré automatiquement</div>
</body>
</html>
