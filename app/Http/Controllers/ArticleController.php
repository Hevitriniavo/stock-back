<?php

namespace App\Http\Controllers;

use App\Http\Resources\ArticleResource;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent\Builder;

class ArticleController extends Controller
{
    public function getArticles(Request $request): JsonResponse
    {
        $articles = $this->filterArticles($request)->get();
        return response()->json([
            'articles' => ArticleResource::collection($articles)
        ]);
    }

    public function getArticlesWithCategory(Request $request): JsonResponse
    {
        $query = $this->filterArticles($request);
        $categoryName = $request->input('category_name');

        if ($categoryName !== null) {
            $query->whereHas('category', function ($query) use ($categoryName) {
                $query->whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($categoryName) . '%']);
            });
        }

        $articles = $query->get();
        return response()->json([
            'articles' => ArticleResource::collection($articles)
        ]);
    }


    private function filterArticles(Request $request): Builder
    {
        $query = Article::with('category');
        $minPrice = $request->input('min_price');
        $maxPrice = $request->input('max_price');
        $name = $request->input('name');

        if ($minPrice !== null) {
            $query->where('unit_price', '>=', $minPrice);
        }

        if ($maxPrice !== null) {
            $query->where('unit_price', '<=', $maxPrice);
        }

        if ($name !== null) {
            $query->where('name', 'like', "%$name%");
        }

        return $query;
    }
}

