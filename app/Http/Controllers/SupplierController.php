<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateSupplierRequest;
use App\Http\Resources\SupplierResource;
use App\Models\Supplier;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class SupplierController extends Controller
{
    public function getSuppliers(Request $request):JsonResponse
    {

        $page = $request->input("per_page", 10);
        $suppliers = Supplier::paginate($page);
        return response()->json([
            'suppliers' => SupplierResource::collection($suppliers),
            'pagination' => [
                'total' => $suppliers->total(),
                'per_page' => $suppliers->perPage(),
                'current_page' => $suppliers->currentPage(),
                'last_page' => $suppliers->lastPage(),
                'from' => $suppliers->firstItem(),
                'to' => $suppliers->lastItem(),
            ],
        ]);
    }

    public function getSupplier(int $id): JsonResponse
    {
        $supplier = Supplier::find($id);

        if (!$supplier) {
            return response()->json([
                'message' => 'Supplier not found',
            ], 404);
        }

        return response()->json([
            'supplier' => new SupplierResource($supplier),
        ]);
    }

    public function storeOrUpdateSupplier(CreateSupplierRequest $request, $id = null): JsonResponse
    {
        if ($id !== null) {
            $supplier = Supplier::findOrFail($id);
            $supplier->update($this->extractData($request, $supplier));
        } else {
            $supplier = Supplier::create($this->extractData($request, new Supplier()));
        }
        return response()->json([
            "supplier" => new SupplierResource($supplier)
        ]);
    }

    private function extractData(CreateSupplierRequest $request, ?Supplier $supplier = null): array
    {
        $data = $request->validated();
        $image = $data['image'] ?? null;

        if ($image instanceof UploadedFile && !$image->getError()) {
            if ($supplier->image !== null) {
                Storage::disk("public")->delete($supplier->image);
            }
            $data["image"] = $image->store("suppliers", "public");
        }

        return $data;
    }


    public function destroy(int $id): JsonResponse
    {
        $supplier = Supplier::find($id);
        $res = Supplier::find($id);

        if (!$supplier) {
            return response()->json([
                'message' => 'Supplier not found',
            ], 404);
        }

        if ($supplier->image) {
            Storage::disk("public")->delete($supplier->image);
        }

        $supplier->delete();

        return response()->json([
            'supplier' => new SupplierResource($res),
        ]);
    }
}
