<?php

    namespace App\Http\Controllers;

    use App\Http\Requests\CreateUserRequest;
    use App\Http\Resources\UserResource;
    use App\Models\User;
    use Illuminate\Http\JsonResponse;
    use Illuminate\Http\UploadedFile;
    use Illuminate\Support\Facades\Storage;

    class UserController extends Controller
    {

        public function getUsers():JsonResponse
        {
            $users = User::all();
            return response()->json([
               'users' => UserResource::collection($users)
            ]);
        }

        public function getUser(int $id): JsonResponse
        {
            $user = User::find($id);

            if (!$user) {
                return response()->json([
                    'message' => 'User not found',
                ], 404);
            }

            return response()->json([
                'user' => new UserResource($user),
            ]);
        }

        public function storeOrUpdateSupplier(CreateUserRequest $request, $id = null): JsonResponse
        {
            if ($id !== null) {
                $user = User::findOrFail($id);
                $user->update($this->extractData($request, $user));
            } else {
                $user = User::create($this->extractData($request, new User()));
            }
            return response()->json([
                "user" => new UserResource($user)
            ]);
        }

        public function extractData(CreateUserRequest $request, ?User $user = null): array
        {
            $data = $request->validated();
            $image = $data['image'] ?? null;

            if ($image instanceof UploadedFile && !$image->getError()) {
                if ($user->image !== null) {
                    Storage::disk("public")->delete($user->image);
                }
                $data["image"] = $image->store("profiles", "public");
            }

            return $data;
        }


        public function destroy(int $id): JsonResponse
        {
            $user = User::find($id);
            $res = User::find($id);

            if (!$user) {
                return response()->json([
                    'message' => 'User not found',
                ], 404);
            }

            if ($user->image) {
                Storage::disk("public")->delete($user->image);
            }

            $user->delete();

            return response()->json([
                'user' => new UserResource($res),
            ]);
        }
    }
