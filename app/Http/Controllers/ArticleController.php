<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateArticleRequest;
use App\Http\Resources\ArticleResource;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    public function getArticles(): JsonResponse
    {
        return response()->json([
            'articles' => ArticleResource::collection(Article::all())
        ]);
    }


    public function storeOrUpdateArticle(CreateArticleRequest $request, ?int $id = null): JsonResponse
    {
        if ($id !== null) {
            $article = Article::findOrFail($id);
            $article->update($this->extractData($request, $article));
        } else {
            $article = Article::create($this->extractData($request, new Article()));
        }
        return response()->json([
            "article" => new ArticleResource($article)
        ]);
    }


    public function destroy(int $id): JsonResponse
    {
        $res = Article::find($id);
        $article = Article::find($id);


        if (!$article) {
            return response()->json([
                'message' => 'Article not found',
            ], 404);
        }

        if ($article->image) {
            Storage::disk("public")->delete($article->image);
        }

        $article->delete();

        return response()->json([
            'article' => new ArticleResource($res),
        ]);
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

