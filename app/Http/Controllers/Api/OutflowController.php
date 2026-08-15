<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\OutflowRequest;
use App\Http\Resources\OutflowResource;
use App\Models\Outflow;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OutflowController extends Controller
{
    public function store(OutflowRequest $request): JsonResponse
    {
        $outflow = Outflow::create([
            'date' => $request->date,
            'personName' => $request->personName,
            'amount' => $request->amount,
            'concept' => $request->concept ?? '',
            'createdBy_id' => $request->user()->id,
        ]);

        $d = $outflow->date;
        $totalOutflows = Outflow::where('date', $d)->sum('amount');

        return response()->json([
            'outflow' => (new OutflowResource($outflow))->resolve(),
            'totalOutflows' => (float) $totalOutflows,
        ], 201);
    }

    public function destroy(Request $request, Outflow $outflow): JsonResponse
    {
        $d = $outflow->date;
        $outflow->delete();

        $totalOutflows = Outflow::where('date', $d)->sum('amount');

        return response()->json(['totalOutflows' => (float) $totalOutflows]);
    }
}
