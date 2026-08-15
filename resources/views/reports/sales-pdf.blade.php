<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Ventas</title>
    <style>
        body { font-family: sans-serif; font-size: 10px; margin: 20px; }
        h1 { text-align: center; font-size: 16px; margin-bottom: 5px; }
        .info { text-align: center; font-size: 11px; margin-bottom: 15px; color: #555; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ccc; padding: 4px 6px; text-align: left; }
        th { background: #2c3e50; color: #fff; font-size: 9px; }
        td { font-size: 9px; }
        .total-row { font-weight: bold; background: #ecf0f1; }
        .right { text-align: right; }
    </style>
</head>
<body>
    <h1>Reporte de Ventas</h1>
    <div class="info">
        @if($from && $to)
            Periodo: {{ $from }} al {{ $to }}
        @elseif($from)
            Desde: {{ $from }}
        @elseif($to)
            Hasta: {{ $to }}
        @else
            Todos los registros
        @endif
        | Generado: {{ now()->format('d/m/Y H:i') }}
    </div>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Fecha</th>
                <th>Codigo</th>
                <th>Cliente</th>
                <th>Servicio</th>
                <th>Tipo</th>
                <th>Plan</th>
                <th class="right">Total (Bs)</th>
            </tr>
        </thead>
        <tbody>
            @forelse($sales as $sale)
                <tr>
                    <td>{{ $sale->id }}</td>
                    <td>{{ $sale->date->format('d/m/Y') }}</td>
                    <td>{{ $sale->clientCode }}</td>
                    <td>{{ $sale->clientName }}</td>
                    <td>{{ $sale->serviceType }}</td>
                    <td>{{ $sale->requestType }}</td>
                    <td>{{ $sale->plan->code ?? '-' }}</td>
                    <td class="right">{{ number_format($sale->total, 2, '.', ',') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" style="text-align:center;">No hay ventas registradas.</td>
                </tr>
            @endforelse
            <tr class="total-row">
                <td colspan="7" class="right">TOTAL</td>
                <td class="right">{{ number_format($total, 2, '.', ',') }} Bs</td>
            </tr>
        </tbody>
    </table>
</body>
</html>
