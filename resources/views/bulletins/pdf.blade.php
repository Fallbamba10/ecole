<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Bulletin - {{ $student->full_name }}</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #333;
            margin: 20px;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #333;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }
        .header h1 {
            font-size: 20px;
            margin: 0;
        }
        .header p {
            margin: 5px 0 0;
            color: #666;
        }
        .info {
            margin-bottom: 20px;
        }
        .info table {
            width: 100%;
        }
        .info td {
            padding: 3px 0;
        }
        .grades-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .grades-table th {
            background-color: #f3f4f6;
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
            font-size: 11px;
            text-transform: uppercase;
        }
        .grades-table th:first-child {
            text-align: left;
        }
        .grades-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }
        .grades-table td:first-child {
            text-align: left;
            font-weight: bold;
        }
        .average-box {
            border: 2px solid #333;
            padding: 15px;
            text-align: center;
            margin-top: 20px;
        }
        .average-box .label {
            font-size: 14px;
            font-weight: bold;
        }
        .average-box .value {
            font-size: 24px;
            font-weight: bold;
            margin-top: 5px;
        }
        .good { color: #16a34a; }
        .bad { color: #dc2626; }
        .footer {
            margin-top: 40px;
            text-align: right;
            font-size: 11px;
            color: #666;
        }
        .signatures {
            margin-top: 40px;
            display: table;
            width: 100%;
        }
        .signatures .col {
            display: table-cell;
            width: 50%;
            text-align: center;
        }
        .signatures .line {
            margin-top: 40px;
            border-top: 1px solid #333;
            display: inline-block;
            width: 150px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>BULLETIN DE NOTES</h1>
        <p>{{ $period }}</p>
    </div>

    <div class="info">
        <table>
            <tr>
                <td><strong>Élève :</strong> {{ $student->full_name }}</td>
                <td style="text-align: right;"><strong>Année :</strong> 2025-2026</td>
            </tr>
            <tr>
                <td><strong>Classe :</strong> {{ $student->classroom->name ?? '-' }}</td>
                <td style="text-align: right;"></td>
            </tr>
        </table>
    </div>

    <table class="grades-table">
        <thead>
            <tr>
                <th>Matière</th>
                <th>Coefficient</th>
                <th>Notes obtenues</th>
                <th>Moyenne</th>
            </tr>
        </thead>
        <tbody>
            @foreach($results as $result)
                <tr>
                    <td>{{ $result['subject']->name }}</td>
                    <td>{{ $result['subject']->coefficient }}</td>
                    <td>
                        @foreach($result['grades'] as $grade)
                            {{ $grade->value }}/{{ $grade->max_value }}{{ !$loop->last ? ', ' : '' }}
                        @endforeach
                        @if($result['grades']->isEmpty())
                            -
                        @endif
                    </td>
                    <td>
                        @if($result['average'] !== null)
                            <span class="{{ $result['average'] >= 10 ? 'good' : 'bad' }}">
                                {{ $result['average'] }}/20
                            </span>
                        @else
                            -
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="average-box">
        <div class="label">MOYENNE GÉNÉRALE</div>
        @if($generalAverage !== null)
            <div class="value {{ $generalAverage >= 10 ? 'good' : 'bad' }}">{{ $generalAverage }} / 20</div>
        @else
            <div class="value">Pas de notes</div>
        @endif
    </div>

    <div class="signatures">
        <div class="col">
            <p>Le Directeur</p>
            <div class="line"></div>
        </div>
        <div class="col">
            <p>Le Professeur Principal</p>
            <div class="line"></div>
        </div>
    </div>

    <div class="footer">
        Document généré le {{ now()->format('d/m/Y') }}
    </div>
</body>
</html>
