<?php

namespace App\Services;

use App\Models\CashCount;
use App\Models\Outflow;
use App\Models\Sale;
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use App\Exports\SalesExport;

class ReportService
{
    protected function pdf(): \Barryvdh\DomPDF\PDF
    {
        return app(\Barryvdh\DomPDF\PDF::class);
    }

    protected function excel(): \Maatwebsite\Excel\Excel
    {
        return app(\Maatwebsite\Excel\Excel::class);
    }

    public function buildSalesPdf(array $filters): \Barryvdh\DomPDF\PDF
    {
        $sales = $this->getSalesQuery($filters)->get();

        $pdf = $this->pdf()->loadView('reports.sales-pdf', [
            'sales' => $sales,
            'from' => $filters['from'] ?? null,
            'to' => $filters['to'] ?? null,
            'total' => $sales->sum('total'),
        ]);

        $pdf->setPaper('a4', 'landscape');

        return $pdf;
    }

    public function buildSalesXlsx(array $filters)
    {
        $query = $this->getSalesQuery($filters);

        return $this->excel()->download(new SalesExport($query), 'ventas_' . Carbon::now()->format('Y-m-d') . '.xlsx');
    }

    public function buildCashPdf(string $date): \Barryvdh\DomPDF\PDF
    {
        $cashCount = CashCount::with('outflows', 'createdBy')
            ->where('date', $date)
            ->first();

        $outflowTotal = Outflow::where('date', $date)->sum('amount');
        $efectivoTotal = ($cashCount?->total ?? 0) + $outflowTotal;

        $pdf = $this->pdf()->loadView('reports.cash-pdf', [
            'cashCount' => $cashCount,
            'outflows' => $cashCount?->outflows ?? collect(),
            'outflowTotal' => $outflowTotal,
            'efectivoTotal' => $efectivoTotal,
            'date' => $date,
        ]);

        $pdf->setPaper('a4', 'portrait');

        return $pdf;
    }

    public function signToken(string $path, int $minutes = 60): string
    {
        $payload = json_encode([
            'path' => $path,
            'exp' => Carbon::now()->addMinutes($minutes)->timestamp,
        ]);

        return Crypt::encryptString($payload);
    }

    public function unsignToken(string $token): ?string
    {
        try {
            $payload = json_decode(Crypt::decryptString($token), true);

            if (! $payload || Carbon::now()->timestamp > $payload['exp']) {
                return null;
            }

            return $payload['path'];
        } catch (\Exception $e) {
            return null;
        }
    }

    protected function getSalesQuery(array $filters)
    {
        $query = Sale::with(['plan', 'createdBy', 'lastEditedBy']);

        if (! empty($filters['from'])) {
            $query->where('date', '>=', $filters['from']);
        }

        if (! empty($filters['to'])) {
            $query->where('date', '<=', $filters['to']);
        }

        if (! empty($filters['requestType'])) {
            $query->where('requestType', $filters['requestType']);
        }

        return $query->orderByDesc('date')->orderByDesc('id');
    }
}
