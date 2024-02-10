<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateArticleRequest;
use App\Http\Resources\ArticleResource;
use App\Models\Article;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    public function getArticles(Request $request): JsonResponse
    {
        $page = $request->input("per_page", 10);
        $articles = Article::paginate($page);
        return response()->json([
            "articles" => ArticleResource::collection($articles),
            'pagination' => [
                'total' => $articles->total(),
                'per_page' => $articles->perPage(),
                'current_page' => $articles->currentPage(),
                'last_page' => $articles->lastPage(),
                'from' => $articles->firstItem(),
                'to' => $articles->lastItem(),
            ],
        ]);
    }


    public function getArticle(int $id): JsonResponse
    {
        $article = Article::find($id);

        if (!$article) {
            return response()->json([
                'message' => 'Article not found',
            ], 404);
        }
        return response()->json([
            'article' => new ArticleResource($article)
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

