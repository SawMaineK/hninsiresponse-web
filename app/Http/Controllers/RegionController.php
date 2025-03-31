<?php
namespace App\Http\Controllers;

use App\Models\Region;
use App\Http\Requests\RegionRequest;
use App\Services\RegionService;
use Illuminate\Http\Request;
use App\Http\Resources\RegionResource;
use Sawmainek\Apitoolz\Http\Controllers\APIToolzController;

class RegionController extends APIToolzController
{
    protected $regionService;
    public $slug = 'region';


    public function __construct(RegionService $regionService)
    {
        $this->model = new Region();
        $this->info = $this->makeInfo();
        $this->regionService = $regionService;
    }

   /**
     * @OA\Get(
     *     path="/api/region",
     *     summary="Get a list of region with dynamic filtering, sorting, pagination, and advanced search",
     *     tags={"Region"},
     *     @OA\Parameter(name="filter", in="query", description="Dynamic filtering with multiple fields (e.g., `status:active|age:gt:30`)", @OA\Schema(type="string")),
     *     @OA\Parameter(name="search", in="query", description="Full-text search (e.g., `keywords`)", @OA\Schema(type="string")),
     *     @OA\Parameter(name="sort_by", in="query", description="Sort the results by a specific field (e.g., `price` or `name`)", @OA\Schema(type="string", example="created_at")),
     *     @OA\Parameter(name="sort_dir", in="query", description="Direction of sorting (asc or desc)", @OA\Schema(type="string", enum={"asc", "desc"}, default="asc")),
     *     @OA\Parameter(name="page", in="query", description="Page number for pagination (default: 1)", @OA\Schema(type="integer", default=1)),
     *     @OA\Parameter(name="per_page", in="query", description="Number of items per page (default: 10)", @OA\Schema(type="integer", default=10)),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/RegionResource")),
     *             @OA\Property(property="meta", type="object",
     *                 @OA\Property(property="current_page", type="integer"),
     *                 @OA\Property(property="per_page", type="integer"),
     *                 @OA\Property(property="total", type="integer"),
     *                 @OA\Property(property="next_page_url", type="string", nullable=true),
     *                 @OA\Property(property="prev_page_url", type="string", nullable=true),
     *                 @OA\Property(property="last_page", type="integer")
     *             )
     *         )
     *     )
     * )
     */
    public function index(Request $request)
    {
        $results = $this->regionService->get($request);

        if (!$results) {
            return response()->json(['message' => 'Error fetching region list'], 500);
        }

        return response()->json([
            'data' => RegionResource::collection($results),
            'meta' => [
                'current_page' => $results->currentPage(),
                'per_page' => $results->perPage(),
                'total' => $results->total(),
                'next_page_url' => $results->nextPageUrl(),
                'prev_page_url' => $results->previousPageUrl(),
                'last_page' => $results->lastPage(),
            ]
        ]);
    }


    /**
     * @OA\Post(
     *     path="/api/region",
     *     summary="Store a new region",
     *     tags={"Region"},
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/RegionRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Region created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/RegionResource")
     *     )
     * )
     */
    public function store(RegionRequest $request)
    {
        $region = $this->regionService->createOrUpdate($request->validated());
        return $this->response(new RegionResource($region), 201);
    }

    /**
     * @OA\Get(
     *     path="/api/region/{id}",
     *     summary="Get a specific region",
     *     tags={"Region"},
     *     @OA\Parameter(in="path", name="id", required=true, description="Region ID"),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/RegionResource")
     *     )
     * )
     */
    public function show(Region $region)
    {
        return $this->response(new RegionResource($region));
    }

    /**
     * @OA\Put(
     *     path="/api/region/{id}",
     *     summary="Update a specific region",
     *     tags={"Region"},
     *     @OA\Parameter(in="path", name="id", required=true, description="Region ID"),
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/RegionRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Region updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/RegionResource")
     *     )
     * )
     */
    public function update(RegionRequest $request, Region $region)
    {
        $updatedRegion = $this->regionService->update($region, $request->validated());
        return $this->response(new RegionResource($updatedRegion));
    }

    /**
     * @OA\Delete(
     *     path="/api/region/{id}",
     *     summary="Delete a region",
     *     tags={"Region"},
     *     @OA\Parameter(in="path", name="id", required=true, description="Region ID"),
     *     @OA\Response(
     *         response=204,
     *         description="Region deleted successfully"
     *     )
     * )
     */
    public function destroy(Region $region)
    {
        $this->regionService->delete($region);
        return $this->response("The record has been deleted successfully.", 204);
    }

    /**
     * @OA\Put(
     *     path="/api/region/{id}/restore",
     *     summary="Restore a deleted region",
     *     tags={"Region"},
     *     @OA\Parameter(in="path", name="id", required=true, description="Region ID"),
     *     @OA\Response(
     *         response=200,
     *         description="Region restored successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="The record has been restored successfully."
     *             )
     *         )
     *     )
     * )
     */
    public function restore($id)
    {
        $this->regionService->restore($id);
        return $this->response("The record has been restored successfully.");
    }

    /**
     * @OA\Delete(
     *     path="/api/region/{id}/force-destroy",
     *     summary="Permanently delete a region",
     *     tags={"Region"},
     *     @OA\Parameter(in="path", name="id", required=true, description="Region ID"),
     *     @OA\Response(
     *         response=204,
     *         description="Region permanently deleted"
     *     )
     * )
     */
    public function forceDestroy($id)
    {
        $this->regionService->forceDelete($id);
        return $this->response("The record has been permanently deleted.", 204);
    }
}
