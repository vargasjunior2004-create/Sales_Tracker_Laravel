<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\ReportService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ReportController extends Controller
{
    public function __construct(
        protected ReportService $reportService
    ) {}

    public function pdf(Request $request): Response
    {
        $filters = $request->only(['from', 'to', 'requestType']);

        $pdf = $this->reportService->buildSalesPdf($filters);

        return $pdf->download('ventas_' . now()->format('Y-m-d') . '.pdf');
    }

    public function xlsx(Request $request)
    {
        $filters = $request->only(['from', 'to', 'requestType']);

        return $this->reportService->buildSalesXlsx($filters);
    }

    public function pdfLink(Request $request): JsonResponse
    {
        $filters = $request->only(['from', 'to', 'requestType']);
        $token = $this->reportService->signToken('/api/reports/pdf-public', 60);

        $params = http_build_query(array_merge($filters, ['token' => $token]));

        return response()->json([
            'url' => '/api/reports/pdf-public?' . $params,
            'token' => $token,
        ]);
    }

    public function xlsxLink(Request $request): JsonResponse
    {
        $filters = $request->only(['from', 'to', 'requestType']);
        $token = $this->reportService->signToken('/api/reports/xlsx-public', 60);

        $params = http_build_query(array_merge($filters, ['token' => $token]));

        return response()->json([
            'url' => '/api/reports/xlsx-public?' . $params,
            'token' => $token,
        ]);
    }

    public function pdfPublic(Request $request): Response
    {
        $token = $request->query('token');

        if (! $token || ! $this->reportService->unsignToken($token)) {
            return response()->json(['message' => 'Token invalido o expirado.'], 403);
        }

        $filters = $request->only(['from', 'to', 'requestType']);
        $pdf = $this->reportService->buildSalesPdf($filters);

        return $pdf->download('ventas_' . now()->format('Y-m-d') . '.pdf');
    }

    public function xlsxPublic(Request $request)
    {
        $token = $request->query('token');

        if (! $token || ! $this->reportService->unsignToken($token)) {
            return response()->json(['message' => 'Token invalido o expirado.'], 403);
        }

        $filters = $request->only(['from', 'to', 'requestType']);

        return $this->reportService->buildSalesXlsx($filters);
    }

    public function cashPdf(Request $request): Response
    {
        $date = $request->query('date', now()->format('Y-m-d'));
        $pdf = $this->reportService->buildCashPdf($date);

        return $pdf->download('efectivo_' . $date . '.pdf');
    }

    public function cashPdfLink(Request $request): JsonResponse
    {
        $date = $request->query('date', now()->format('Y-m-d'));
        $token = $this->reportService->signToken('/api/reports/cash-public', 60);

        return response()->json([
            'url' => '/api/reports/cash-public?date=' . $date . '&token=' . $token,
            'token' => $token,
        ]);
    }

    public function cashPdfPublic(Request $request): Response
    {
        $token = $request->query('token');

        if (! $token || ! $this->reportService->unsignToken($token)) {
            return response()->json(['message' => 'Token invalido o expirado.'], 403);
        }

        $date = $request->query('date', now()->format('Y-m-d'));
        $pdf = $this->reportService->buildCashPdf($date);

        return $pdf->download('efectivo_' . $date . '.pdf');
    }
}
