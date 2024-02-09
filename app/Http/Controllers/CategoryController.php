<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\JsonResponse;

class CategoryController extends Controller
{

    public function getCategories(): JsonResponse
    {
        $categories = Category::all();
        return response()->json([
            "categories" => CategoryResource::collection($categories)
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
