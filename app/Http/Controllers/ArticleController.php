<?php

namespace App\Http\Controllers;

use App\Http\Resources\ArticleResource;
use App\Models\Article;
use Illuminate\Http\JsonResponse;

class ArticleController extends Controller
{

    public function getArticles(): JsonResponse
    {
        $articles = Article::all();
        return response()->json([
            'articles' => ArticleResource::collection($articles)
        ]);
    }

    public function getArticlesWithCategory(): JsonResponse
    {
        $articles = Article::with('category')->get();
        return response()->json([
            'articles' => ArticleResource::collection($articles)
        ]);
    }
}
