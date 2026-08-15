<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PlanRequest;
use App\Http\Resources\PlanPublicResource;
use App\Http\Resources\PlanResource;
use App\Models\Plan;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    public function index(): JsonResponse
    {
        $plans = Plan::orderBy('type')->orderBy('code')->get();

        return response()->json(PlanResource::collection($plans)->resolve());
    }

    public function active(): JsonResponse
    {
        $plans = Plan::where('active', true)->orderBy('type')->orderBy('code')->get();

        return response()->json(PlanPublicResource::collection($plans)->resolve());
    }

    public function store(PlanRequest $request): JsonResponse
    {
        $plan = Plan::create($request->validated());

        return response()->json(new PlanResource($plan), 201);
    }

    public function update(PlanRequest $request, Plan $plan): JsonResponse
    {
        $plan->update($request->validated());

        return response()->json(new PlanResource($plan));
    }
}
