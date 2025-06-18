<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $title }}</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 10px;
            margin: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }
        .header h1 {
            margin: 0;
            color: #333;
            font-size: 18px;
        }
        .header p {
            margin: 5px 0;
            color: #666;
            font-size: 12px;
        }
        .info {
            margin-bottom: 15px;
            font-size: 11px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th {
            background-color: #f8f9fa;
            color: #333;
            font-weight: bold;
            padding: 8px 6px;
            text-align: left;
            border: 1px solid #dee2e6;
            font-size: 9px;
        }
        td {
            padding: 6px;
            border: 1px solid #dee2e6;
            font-size: 9px;
            vertical-align: top;
        }
        tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        .no-data {
            text-align: center;
            font-style: italic;
            color: #666;
            padding: 20px;
        }
        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 8px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
        .page-break {
            page-break-before: always;
        }
        @page {
            margin: 20px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ $title }}</h1>
        <p>{{ $dateRange }}</p>
        <p>Généré le {{ now()->format('d/m/Y à H:i:s') }}</p>
    </div>

    @if(empty($data))
        <div class="no-data">
            <p>Aucune donnée disponible pour les critères sélectionnés.</p>
        </div>
    @else
        <div class="info">
            <strong>Nombre total d'enregistrements:</strong> {{ count($data) }}
        </div>

        <table>
            <thead>
                <tr>
                    @foreach($headers as $header)
                        <th>{{ $header }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach($data as $row)
                    <tr>
                        @foreach($row as $cell)
                            <td>
                                @if(is_object($cell) && get_class($cell) === 'DateTime')
                                    {{ $cell->format('d/m/Y H:i') }}
                                @elseif($cell instanceof \Carbon\Carbon)
                                    {{ $cell->format('d/m/Y H:i') }}
                                @else
                                    {{ $cell ?? '-' }}
                                @endif
                            </td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <div class="footer">
        <p>Export généré par le système - Page {{ $loop->iteration ?? 1 }}</p>
    </div>
</body>
</html>
