<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCustomerRequest;
use App\Http\Resources\CustomerResource;
use App\Http\Resources\UserResource;
use App\Models\Customer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class CustomerController extends Controller
{

    public function getCustomers(Request $request): JsonResponse
    {
        $page = $request->input("per_page", 10);
        $customers = Customer::paginate($page);
        return response()->json([
            'customers' => UserResource::collection($customers->items()),
            'pagination' => [
                'total' => $customers->total(),
                'per_page' => $customers->perPage(),
                'current_page' => $customers->currentPage(),
                'last_page' => $customers->lastPage(),
                'from' => $customers->firstItem(),
                'to' => $customers->lastItem(),
            ],
        ]);
    }


    public function getCustomer(int $id): JsonResponse
    {
        $customer = Customer::find($id);

        if (!$customer) {
            return response()->json([
                'message' => 'customer not found',
            ], 404);
        }

        return response()->json([
            'customer' => new CustomerResource($customer),
        ]);
    }

    public function storeOrUpdateCustomer(CreateCustomerRequest $request, ?int $id = null): JsonResponse
    {
        if ($id !== null) {
            $customer = Customer::findOrFail($id);
            $customer->update($this->extractData($request, $customer));
        } else {
            $customer = Customer::create($this->extractData($request, new Customer()));
        }
        return response()->json([
            "customer" => new CustomerResource($customer)
        ]);
    }

    private function extractData(CreateCustomerRequest $request, ?Customer $customer = null): array
    {
        $data = $request->validated();
        $image = $data['image'] ?? null;

        if ($image instanceof UploadedFile && !$image->getError()) {
            if ($customer->image !== null) {
                Storage::disk("public")->delete($customer->image);
            }
            $data["image"] = $image->store("customers", "public");
        }

        return $data;
    }


    public function destroy(int $id): JsonResponse
    {
        $customer = Customer::find($id);
        $res = Customer::find($id);

        if (!$customer) {
            return response()->json([
                'message' => 'Customer not found',
            ], 404);
        }

        if ($customer->image) {
            Storage::disk("public")->delete($customer->image);
        }

        $customer->delete();

        return response()->json([
            'customer' => new CustomerResource($res),
        ]);
    }
}
