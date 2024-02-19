<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreatePostAPIRequest;
use App\Http\Requests\API\UpdatePostAPIRequest;
use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;

/**
 * Class PostController
 */

class PostAPIController extends AppBaseController
{
    /**
     * @OA\Get(
     *      path="/posts",
     *      summary="getPostList",
     *      tags={"Post"},
     *      description="Get all Posts",
     *      @OA\Response(
     *          response=200,
     *          description="successful operation",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @OA\Property(
     *                  property="data",
     *                  type="array",
     *                  @OA\Items(ref="#/components/schemas/Post")
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function index(Request $request): JsonResponse
    {
        $query = Post::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $posts = $query->get();

        return $this->sendResponse($posts->toArray(), 'Posts retrieved successfully');
    }

    /**
     * @OA\Post(
     *      path="/posts",
     *      summary="createPost",
     *      tags={"Post"},
     *      description="Create Post",
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Post")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @OA\Property(
     *                  property="data",
     *                  ref="#/components/schemas/Post"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreatePostAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var Post $post */
        $post = Post::create($input);

        return $this->sendResponse($post->toArray(), 'Post saved successfully');
    }

    /**
     * @OA\Get(
     *      path="/posts/{id}",
     *      summary="getPostItem",
     *      tags={"Post"},
     *      description="Get Post",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Post",
     *           @OA\Schema(
     *             type="integer"
     *          ),
     *          required=true,
     *          in="path"
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @OA\Property(
     *                  property="data",
     *                  ref="#/components/schemas/Post"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function show($id): JsonResponse
    {
        /** @var Post $post */
        $post = Post::find($id);

        if (empty($post)) {
            return $this->sendError('Post not found');
        }

        return $this->sendResponse($post->toArray(), 'Post retrieved successfully');
    }

    /**
     * @OA\Put(
     *      path="/posts/{id}",
     *      summary="updatePost",
     *      tags={"Post"},
     *      description="Update Post",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Post",
     *           @OA\Schema(
     *             type="integer"
     *          ),
     *          required=true,
     *          in="path"
     *      ),
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Post")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @OA\Property(
     *                  property="data",
     *                  ref="#/components/schemas/Post"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdatePostAPIRequest $request): JsonResponse
    {
        /** @var Post $post */
        $post = Post::find($id);

        if (empty($post)) {
            return $this->sendError('Post not found');
        }

        $post->fill($request->all());
        $post->save();

        return $this->sendResponse($post->toArray(), 'Post updated successfully');
    }

    /**
     * @OA\Delete(
     *      path="/posts/{id}",
     *      summary="deletePost",
     *      tags={"Post"},
     *      description="Delete Post",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Post",
     *           @OA\Schema(
     *             type="integer"
     *          ),
     *          required=true,
     *          in="path"
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @OA\Property(
     *                  property="data",
     *                  type="string"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function destroy($id): JsonResponse
    {
        /** @var Post $post */
        $post = Post::find($id);

        if (empty($post)) {
            return $this->sendError('Post not found');
        }

        $post->delete();

        return $this->sendSuccess('Post deleted successfully');
    }
}
