<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateTagAPIRequest;
use App\Http\Requests\API\UpdateTagAPIRequest;
use App\Models\Tag;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;

/**
 * Class TagController
 */

class TagAPIController extends AppBaseController
{
    /**
     * @OA\Get(
     *      path="/tags",
     *      summary="getTagList",
     *      tags={"Tag"},
     *      description="Get all Tags",
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
     *                  @OA\Items(ref="#/components/schemas/Tag")
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
        $query = Tag::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $tags = $query->get();

        return $this->sendResponse($tags->toArray(), 'Tags retrieved successfully');
    }

    /**
     * @OA\Post(
     *      path="/tags",
     *      summary="createTag",
     *      tags={"Tag"},
     *      description="Create Tag",
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Tag")
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
     *                  ref="#/components/schemas/Tag"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateTagAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var Tag $tag */
        $tag = Tag::create($input);

        return $this->sendResponse($tag->toArray(), 'Tag saved successfully');
    }

    /**
     * @OA\Get(
     *      path="/tags/{id}",
     *      summary="getTagItem",
     *      tags={"Tag"},
     *      description="Get Tag",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Tag",
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
     *                  ref="#/components/schemas/Tag"
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
        /** @var Tag $tag */
        $tag = Tag::find($id);

        if (empty($tag)) {
            return $this->sendError('Tag not found');
        }

        return $this->sendResponse($tag->toArray(), 'Tag retrieved successfully');
    }

    /**
     * @OA\Put(
     *      path="/tags/{id}",
     *      summary="updateTag",
     *      tags={"Tag"},
     *      description="Update Tag",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Tag",
     *           @OA\Schema(
     *             type="integer"
     *          ),
     *          required=true,
     *          in="path"
     *      ),
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Tag")
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
     *                  ref="#/components/schemas/Tag"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateTagAPIRequest $request): JsonResponse
    {
        /** @var Tag $tag */
        $tag = Tag::find($id);

        if (empty($tag)) {
            return $this->sendError('Tag not found');
        }

        $tag->fill($request->all());
        $tag->save();

        return $this->sendResponse($tag->toArray(), 'Tag updated successfully');
    }

    /**
     * @OA\Delete(
     *      path="/tags/{id}",
     *      summary="deleteTag",
     *      tags={"Tag"},
     *      description="Delete Tag",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Tag",
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
        /** @var Tag $tag */
        $tag = Tag::find($id);

        if (empty($tag)) {
            return $this->sendError('Tag not found');
        }

        $tag->delete();

        return $this->sendSuccess('Tag deleted successfully');
    }
}
