<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    public function getCategories(Request $request): JsonResponse
    {
        $page = $request->input("per_page", 10);
        $categories = Category::paginate($page);
        return response()->json([
            "categories" => CategoryResource::collection($categories),
            'pagination' => [
                'total' => $categories->total(),
                'per_page' => $categories->perPage(),
                'current_page' => $categories->currentPage(),
                'last_page' => $categories->lastPage(),
                'from' => $categories->firstItem(),
                'to' => $categories->lastItem(),
            ],
        ]);
    }


    public function getCategory(int $id): JsonResponse
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json([
                'message' => 'Category not found',
            ], 404);
        }

        return response()->json([
            'category' => new CategoryResource($category),
        ]);
    }

    public function storeOrUpdateCategory(CreateCategoryRequest $request, ?int $id = null): JsonResponse
    {
        $data = $request->validated();
        if ($id !== null) {
            $category = Category::findOrFail($id);
            $category->update($data);
        } else {
            $category = Category::create($data);
        }
        return response()->json([
            "category" => new CategoryResource($category)
        ]);
    }


    public function destroy(int $id): JsonResponse
    {
        $category = Category::find($id);
        $res = Category::find($id);

        if (!$category) {
            return response()->json([
                'message' => 'Category not found',
            ], 404);
        }

        $category->delete();

        return response()->json([
            'category' => new CategoryResource($res),
        ]);
    }
}
