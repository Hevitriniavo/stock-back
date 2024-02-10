<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateArticleRequest;
use App\Http\Resources\ArticleResource;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

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


    public function storeOrUpdateArticle(CreateArticleRequest $request, ?int $id = null): JsonResponse
    {
           var_dump($request->validated());
        return response()->json([
            "article" => 'ok'
        ]);
    }





    public function destroy(int $id): JsonResponse
    {
        $article = Article::find($id);
        $res = Article::find($id);

        if (!$article) {
            return response()->json([
                'message' => 'Article not found',
            ], 404);
        }

        $article->delete();

        return response()->json([
            'article' => new Article($res),
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

    private function extractData(CreateArticleRequest $request, ?Article $article = null): array
    {
        $data = $request->all();
        $image = $data['image'] ?? null;

        if ($image instanceof UploadedFile && !$image->getError()) {
            if ($article->image !== null) {
                Storage::disk("public")->delete($article->image);
            }
            $data["image"] = $image->store("articles", "public");
        }

        return $data;
    }
}

