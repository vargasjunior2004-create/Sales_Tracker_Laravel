<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SaleCreateRequest;
use App\Http\Requests\SaleUpdateRequest;
use App\Http\Resources\SaleResource;
use App\Models\Customer;
use App\Models\Sale;
use App\Models\Plan;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Sale::with(['plan', 'createdBy', 'lastEditedBy']);

        if ($request->filled('from')) {
            $query->where('date', '>=', $request->from);
        }

        if ($request->filled('to')) {
            $query->where('date', '<=', $request->to);
        }

        if ($request->filled('requestType')) {
            $query->where('requestType', $request->requestType);
        }

        $sales = $query->orderByDesc('date')->orderByDesc('id')->get();

        return response()->json(SaleResource::collection($sales)->resolve());
    }

    public function store(SaleCreateRequest $request): JsonResponse
    {
        $planId = $request->input('planId') ?? $request->input('plan_id');
        $plan = Plan::findOrFail($planId);

        if ($plan->type !== $request->serviceType) {
            return response()->json(['message' => 'El tipo de plan no coincide con el tipo de servicio.'], 422);
        }

        if ($plan->legacy && $request->requestType !== 'retiro') {
            return response()->json(['message' => 'Los planes legacy solo estan disponibles para retiros.'], 422);
        }

        $customer = null;
        if ($request->filled('clientCode')) {
            $customer = Customer::firstOrCreate(
                ['code' => $request->clientCode],
                ['name' => $request->clientName]
            );
        }

        $sale = Sale::create([
            'date' => $request->date,
            'clientCode' => $request->clientCode,
            'clientName' => $request->clientName,
            'customer_id' => $customer?->id,
            'serviceType' => $request->serviceType,
            'requestType' => $request->requestType ?? 'nuevo_contrato',
            'changeReason' => $request->changeReason ?? '',
            'planFrom' => $request->planFrom ?? '',
            'totalFrom' => $request->totalFrom,
            'notes' => $request->notes ?? '',
            'total' => $plan->total,
            'plan_id' => $plan->id,
            'createdBy_id' => $request->user()->id,
        ]);

        $sale->load(['plan', 'createdBy']);

        return response()->json(new SaleResource($sale), 201);
    }

    public function update(SaleUpdateRequest $request, Sale $sale): JsonResponse
    {
        $data = $request->validated();

        $planId = $data['plan_id'] ?? $data['planId'] ?? null;
        if ($planId) {
            $plan = Plan::findOrFail($planId);
            $serviceType = $data['serviceType'] ?? $sale->serviceType;

            if ($plan->type !== $serviceType) {
                return response()->json(['message' => 'El tipo de plan no coincide con el tipo de servicio.'], 422);
            }

            $requestType = $data['requestType'] ?? $sale->requestType;
            if ($plan->legacy && $requestType !== 'retiro') {
                return response()->json(['message' => 'Los planes legacy solo estan disponibles para retiros.'], 422);
            }

            $data['total'] = $plan->total;
        }

        if (isset($data['clientCode'])) {
            $customer = Customer::firstOrCreate(
                ['code' => $data['clientCode']],
                ['name' => $data['clientName'] ?? $sale->clientName]
            );
            $data['customer_id'] = $customer->id;
        }

        $data['lastEditedBy_id'] = $request->user()->id;
        $data['lastEditedAt'] = Carbon::now();

        $sale->update($data);
        $sale->load(['plan', 'createdBy', 'lastEditedBy']);

        return response()->json(new SaleResource($sale));
    }
}
