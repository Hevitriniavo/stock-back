<?php

namespace App\Http\Controllers;
use App\Http\Resources\CategoryWithArticleResource;
use App\Models\Category;
use Illuminate\Http\JsonResponse;

class CategoryWithArticleController extends Controller
{
    public function categoryWithArticle(): JsonResponse
    {
        return response()->json([
            'categories' => CategoryWithArticleResource::collection(Category::with('articles')->get())
        ]);
    }

    public function categoryWithArticleById(int $id): JsonResponse
    {
        $category = Category::with('articles')->find($id);

        if (!$category) {
            return response()->json(['message' => 'Category not found.'], 404);
        }

        return response()->json([
            'category' => new CategoryWithArticleResource($category)
        ]);
    }
}
