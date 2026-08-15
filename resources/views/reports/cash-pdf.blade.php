<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Arqueo de Caja</title>
    <style>
        body { font-family: sans-serif; font-size: 11px; margin: 20px; }
        h1 { text-align: center; font-size: 16px; margin-bottom: 5px; }
        .info { text-align: center; font-size: 12px; margin-bottom: 15px; color: #555; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ccc; padding: 5px 8px; text-align: left; }
        th { background: #2c3e50; color: #fff; }
        .right { text-align: right; }
        .total-row { font-weight: bold; background: #ecf0f1; }
        .section-title { font-weight: bold; margin-top: 20px; font-size: 13px; }
    </style>
</head>
<body>
    <h1>Arqueo de Caja</h1>
    <div class="info">Fecha: {{ $date }} | Generado: {{ now()->format('d/m/Y H:i') }}</div>

    <div class="section-title">Denominaciones</div>
    <table>
        <thead>
            <tr>
                <th>Denominacion</th>
                <th>Cantidad</th>
                <th class="right">Subtotal (Bs)</th>
            </tr>
        </thead>
        <tbody>
            @if($cashCount)
                <tr><td>Bs 0.50</td><td>{{ $cashCount->coin_050 }}</td><td class="right">{{ number_format($cashCount->coin_050 * 0.50, 2) }}</td></tr>
                <tr><td>Bs 1</td><td>{{ $cashCount->coin_1 }}</td><td class="right">{{ number_format($cashCount->coin_1 * 1, 2) }}</td></tr>
                <tr><td>Bs 2</td><td>{{ $cashCount->coin_2 }}</td><td class="right">{{ number_format($cashCount->coin_2 * 2, 2) }}</td></tr>
                <tr><td>Bs 5</td><td>{{ $cashCount->coin_5 }}</td><td class="right">{{ number_format($cashCount->coin_5 * 5, 2) }}</td></tr>
                <tr><td>Bs 10</td><td>{{ $cashCount->bill_10 }}</td><td class="right">{{ number_format($cashCount->bill_10 * 10, 2) }}</td></tr>
                <tr><td>Bs 20</td><td>{{ $cashCount->bill_20 }}</td><td class="right">{{ number_format($cashCount->bill_20 * 20, 2) }}</td></tr>
                <tr><td>Bs 50</td><td>{{ $cashCount->bill_50 }}</td><td class="right">{{ number_format($cashCount->bill_50 * 50, 2) }}</td></tr>
                <tr><td>Bs 100</td><td>{{ $cashCount->bill_100 }}</td><td class="right">{{ number_format($cashCount->bill_100 * 100, 2) }}</td></tr>
                <tr><td>Bs 200</td><td>{{ $cashCount->bill_200 }}</td><td class="right">{{ number_format($cashCount->bill_200 * 200, 2) }}</td></tr>
                <tr class="total-row"><td colspan="2">TOTAL EFECTIVO</td><td class="right">{{ number_format($cashCount->total, 2) }} Bs</td></tr>
            @else
                <tr><td colspan="3" style="text-align:center;">Sin arqueo registrado para esta fecha.</td></tr>
            @endif
        </tbody>
    </table>

    @if($outflows->count())
        <div class="section-title">Egresos</div>
        <table>
            <thead>
                <tr>
                    <th>Persona</th>
                    <th>Concepto</th>
                    <th class="right">Monto (Bs)</th>
                </tr>
            </thead>
            <tbody>
                @foreach($outflows as $outflow)
                    <tr>
                        <td>{{ $outflow->personName }}</td>
                        <td>{{ $outflow->concept }}</td>
                        <td class="right">{{ number_format($outflow->amount, 2) }}</td>
                    </tr>
                @endforeach
                <tr class="total-row"><td colspan="2">TOTAL EGRESOS</td><td class="right">{{ number_format($outflowTotal, 2) }} Bs</td></tr>
            </tbody>
        </table>
    @endif

    <div class="section-title" style="margin-top:20px; font-size:14px; text-align:right;">
        EFECTIVO TOTAL: {{ number_format($efectivoTotal, 2) }} Bs
    </div>
</body>
</html>
