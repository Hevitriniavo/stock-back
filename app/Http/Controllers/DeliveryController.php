<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCategoryRequest;
use App\Http\Requests\CreateDeliveryRequest;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\DeliveryResource;
use App\Models\Category;
use App\Models\Delivery;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DeliveryController extends Controller
{

    public function getDeliveries(Request $request): JsonResponse
    {
        $page = $request->input("per_page", 10);
        $deliveries = Delivery::paginate($page);
        return response()->json([
            "deliveries" => DeliveryResource::collection($deliveries),
            'pagination' => [
                'total' => $deliveries->total(),
                'per_page' => $deliveries->perPage(),
                'current_page' => $deliveries->currentPage(),
                'last_page' => $deliveries->lastPage(),
                'from' => $deliveries->firstItem(),
                'to' => $deliveries->lastItem(),
            ],
        ]);
    }


    public function getDelivery(int $id): JsonResponse
    {
        $delivery = Delivery::find($id);

        if (!$delivery) {
            return response()->json([
                'message' => 'Delivery not found',
            ], 404);
        }

        return response()->json([
            'delivery' => new DeliveryResource($delivery),
        ]);
    }

    public function storeOrUpdateDelivery(CreateDeliveryRequest $request, ?int $id = null): JsonResponse
    {
        $data = $request->validated();
        if ($id !== null) {
            $delivery = Delivery::findOrFail($id);
            $delivery->update($data);
        } else {
            $delivery = Delivery::create($data);
        }
        return response()->json([
            "delivery" => new DeliveryResource($delivery)
        ]);
    }


    public function destroy(int $id): JsonResponse
    {
        $delivery = Delivery::find($id);
        $res = Delivery::find($id);

        if (!$delivery) {
            return response()->json([
                'message' => 'Delivery not found',
            ], 404);
        }

        $delivery->delete();

        return response()->json([
            'delivery' => new DeliveryResource($res),
        ]);
    }
}
