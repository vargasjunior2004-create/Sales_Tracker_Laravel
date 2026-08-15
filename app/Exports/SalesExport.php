<?php

namespace App\Exports;

use App\Models\Sale;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SalesExport implements FromQuery, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    protected Builder $query;

    public function __construct(Builder $query)
    {
        $this->query = $query;
    }

    public function query(): Builder
    {
        return $this->query;
    }

    public function headings(): array
    {
        return ['#', 'Fecha', 'Codigo', 'Cliente', 'Servicio', 'Tipo', 'Plan', 'Total (Bs)'];
    }

    public function map($sale): array
    {
        return [
            $sale->id,
            $sale->date->format('d/m/Y'),
            $sale->clientCode,
            $sale->clientName,
            $sale->serviceType,
            $sale->requestType,
            $sale->plan->code ?? '-',
            $sale->total,
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => ['font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF'], 'fill' => ['fillType' => 'solid', 'color' => ['rgb' => '2C3E50']]]],
        ];
    }
}
