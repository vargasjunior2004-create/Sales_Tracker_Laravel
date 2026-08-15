<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CashCountRequest;
use App\Http\Resources\CashCountResource;
use App\Http\Resources\OutflowResource;
use App\Models\CashCount;
use App\Models\Outflow;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CashCountController extends Controller
{
    public function show(Request $request): JsonResponse
    {
        $date = $request->query('date', now()->format('Y-m-d'));

        $cashCount = CashCount::with(['createdBy'])
            ->where('date', $date)
            ->first();

        $outflows = Outflow::with(['createdBy'])->where('date', $date)->get();

        $totalOutflows = Outflow::where('date', $date)->sum('amount');

        return response()->json([
            'cashCount' => $cashCount ? (new CashCountResource($cashCount))->resolve() : null,
            'outflows' => OutflowResource::collection($outflows)->resolve(),
            'totalOutflows' => (float) $totalOutflows,
        ]);
    }

    public function store(CashCountRequest $request): JsonResponse
    {
        $data = $request->validated();

        $cashCount = CashCount::updateOrCreate(
            ['date' => $data['date']],
            [
                'coin_050' => $data['coin_050'] ?? 0,
                'coin_1' => $data['coin_1'] ?? 0,
                'coin_2' => $data['coin_2'] ?? 0,
                'coin_5' => $data['coin_5'] ?? 0,
                'bill_10' => $data['bill_10'] ?? 0,
                'bill_20' => $data['bill_20'] ?? 0,
                'bill_50' => $data['bill_50'] ?? 0,
                'bill_100' => $data['bill_100'] ?? 0,
                'bill_200' => $data['bill_200'] ?? 0,
                'createdBy_id' => $request->user()->id,
            ]
        );

        $cashCount->load(['createdBy']);

        return response()->json((new CashCountResource($cashCount))->resolve());
    }
}
