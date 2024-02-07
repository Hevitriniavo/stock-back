<?php

namespace App\Http\Controllers;

use App\Http\Resources\ArticleResource;
use App\Http\Resources\ArticleResourceWithCategory;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent\Builder;

class ArticleController extends Controller
{
    public function getArticles(Request $request): JsonResponse
    {
        $perPage = $request->input('per_page', 10);
        $articles = $this->filterArticles($request)->paginate($perPage);
        return response()->json([
            'articles' => ArticleResource::collection($articles)
        ]);
    }

    public function getArticlesWithCategory(Request $request): JsonResponse
    {
        $perPage = $request->input('per_page', 10);
        $query = $this->filterArticles($request);
        $categoryName = $request->input('category_name');
        if ($categoryName !== null) {
            $query->whereHas('category', function ($query) use ($categoryName) {
                $query->whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($categoryName) . '%']);
            });
        }

        $articles = $query->paginate($perPage);
        return response()->json([
            'articles' => ArticleResourceWithCategory::collection($articles)
        ]);
    }


    private function filterArticles(Request $request): Builder
    {
        $minPrice = $request->input('min_price');
        $maxPrice = $request->input('max_price');
        $name = $request->input('name');
        $query = Article::with('category');

        if ($minPrice !== null) {
            $query->where('unit_price', '>=', $minPrice);
        }

        if ($maxPrice !== null) {
            $query->where('unit_price', '<=', $maxPrice);
        }

        if ($name !== null) {
            $query->whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($name) . '%']);
        }

        return $query;
    }
}

