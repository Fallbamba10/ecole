<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reçu de paiement</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; margin: 0; padding: 20px; }
        .header { text-align: center; border-bottom: 2px solid #1e40af; padding-bottom: 15px; margin-bottom: 20px; }
        .header h1 { color: #1e40af; font-size: 20px; margin: 0; }
        .header p { color: #666; margin: 5px 0 0; font-size: 11px; }
        .receipt-title { text-align: center; font-size: 16px; font-weight: bold; text-transform: uppercase; margin: 20px 0; color: #333; letter-spacing: 2px; }
        .receipt-number { text-align: right; font-size: 11px; color: #666; margin-bottom: 20px; }
        .info-table { width: 100%; margin-bottom: 20px; }
        .info-table td { padding: 6px 10px; vertical-align: top; }
        .info-table .label { font-weight: bold; color: #555; width: 140px; }
        .info-table .value { color: #333; }
        .amount-box { background-color: #f0f7ff; border: 2px solid #1e40af; border-radius: 8px; padding: 15px; text-align: center; margin: 25px 0; }
        .amount-box .amount { font-size: 28px; font-weight: bold; color: #1e40af; }
        .amount-box .amount-text { font-size: 11px; color: #666; margin-top: 5px; }
        .details-table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        .details-table th, .details-table td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        .details-table th { background-color: #1e40af; color: white; font-size: 11px; }
        .footer { margin-top: 40px; border-top: 1px solid #ddd; padding-top: 15px; }
        .footer .signature { float: right; text-align: center; width: 200px; }
        .footer .signature .line { border-top: 1px solid #333; margin-top: 50px; padding-top: 5px; font-size: 11px; }
        .stamp { text-align: center; margin-top: 30px; }
        .stamp .paid { display: inline-block; border: 3px solid #16a34a; color: #16a34a; font-size: 18px; font-weight: bold; padding: 5px 20px; transform: rotate(-5deg); letter-spacing: 3px; }
        .mention { font-size: 9px; color: #999; text-align: center; margin-top: 30px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ $school->name }}</h1>
        <p>{{ $school->address }} | Tél: {{ $school->phone }} | {{ $school->email }}</p>
    </div>

    <div class="receipt-title">Reçu de paiement</div>

    <div class="receipt-number">
        N° : REC-{{ str_pad($payment->id, 5, '0', STR_PAD_LEFT) }} | Date : {{ $payment->created_at->format('d/m/Y') }}
    </div>

    <table class="info-table">
        <tr>
            <td class="label">Élève :</td>
            <td class="value">{{ $payment->student->full_name }}</td>
        </tr>
        <tr>
            <td class="label">Classe :</td>
            <td class="value">{{ $payment->student->classroom->name ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td class="label">Parent / Tuteur :</td>
            <td class="value">{{ $payment->student->parent_name ?? '-' }}</td>
        </tr>
    </table>

    <table class="details-table">
        <thead>
            <tr>
                <th>Désignation</th>
                <th>Méthode</th>
                <th>Montant</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ ucfirst(str_replace('_', ' ', $payment->type)) }}</td>
                <td>{{ ucfirst(str_replace('_', ' ', $payment->payment_method)) }}</td>
                <td><strong>{{ number_format($payment->amount, 0, ',', ' ') }} FCFA</strong></td>
            </tr>
        </tbody>
    </table>

    <div class="amount-box">
        <div class="amount">{{ number_format($payment->amount, 0, ',', ' ') }} FCFA</div>
        <div class="amount-text">Montant total reçu</div>
    </div>

    @if($payment->status === 'paye')
        <div class="stamp">
            <span class="paid">PAYÉ</span>
        </div>
    @endif

    <div class="footer">
        <div class="signature">
            <div class="line">Signature & Cachet</div>
        </div>
        <div style="clear: both;"></div>
    </div>

    <div class="mention">
        Ce reçu est généré électroniquement par SchoolManager. Il fait foi de paiement.
    </div>
</body>
</html>
