<?php
namespace App\Http\Controllers;

use App\Models\City;
use App\Http\Requests\CityRequest;
use App\Services\CityService;
use Illuminate\Http\Request;
use App\Http\Resources\CityResource;
use Sawmainek\Apitoolz\Http\Controllers\APIToolzController;

class CityController extends APIToolzController
{
    protected $cityService;
    public $slug = 'city';


    public function __construct(CityService $cityService)
    {
        $this->model = new City();
        $this->info = $this->makeInfo();
        $this->cityService = $cityService;
    }

   /**
     * @OA\Get(
     *     path="/api/city",
     *     summary="Get a list of city with dynamic filtering, sorting, pagination, and advanced search",
     *     tags={"City"},
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
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/CityResource")),
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
        $results = $this->cityService->get($request);

        if (!$results) {
            return response()->json(['message' => 'Error fetching city list'], 500);
        }

        return response()->json([
            'data' => CityResource::collection($results),
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
     *     path="/api/city",
     *     summary="Store a new city",
     *     tags={"City"},
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/CityRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="City created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/CityResource")
     *     )
     * )
     */
    public function store(CityRequest $request)
    {
        $city = $this->cityService->createOrUpdate($request->validated());
        return $this->response(new CityResource($city), 201);
    }

    /**
     * @OA\Get(
     *     path="/api/city/{id}",
     *     summary="Get a specific city",
     *     tags={"City"},
     *     @OA\Parameter(in="path", name="id", required=true, description="City ID"),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/CityResource")
     *     )
     * )
     */
    public function show(City $city)
    {
        return $this->response(new CityResource($city));
    }

    /**
     * @OA\Put(
     *     path="/api/city/{id}",
     *     summary="Update a specific city",
     *     tags={"City"},
     *     @OA\Parameter(in="path", name="id", required=true, description="City ID"),
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/CityRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="City updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/CityResource")
     *     )
     * )
     */
    public function update(CityRequest $request, City $city)
    {
        $updatedCity = $this->cityService->update($city, $request->validated());
        return $this->response(new CityResource($updatedCity));
    }

    /**
     * @OA\Delete(
     *     path="/api/city/{id}",
     *     summary="Delete a city",
     *     tags={"City"},
     *     @OA\Parameter(in="path", name="id", required=true, description="City ID"),
     *     @OA\Response(
     *         response=204,
     *         description="City deleted successfully"
     *     )
     * )
     */
    public function destroy(City $city)
    {
        $this->cityService->delete($city);
        return $this->response("The record has been deleted successfully.", 204);
    }

    /**
     * @OA\Put(
     *     path="/api/city/{id}/restore",
     *     summary="Restore a deleted city",
     *     tags={"City"},
     *     @OA\Parameter(in="path", name="id", required=true, description="City ID"),
     *     @OA\Response(
     *         response=200,
     *         description="City restored successfully",
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
        $this->cityService->restore($id);
        return $this->response("The record has been restored successfully.");
    }

    /**
     * @OA\Delete(
     *     path="/api/city/{id}/force-destroy",
     *     summary="Permanently delete a city",
     *     tags={"City"},
     *     @OA\Parameter(in="path", name="id", required=true, description="City ID"),
     *     @OA\Response(
     *         response=204,
     *         description="City permanently deleted"
     *     )
     * )
     */
    public function forceDestroy($id)
    {
        $this->cityService->forceDelete($id);
        return $this->response("The record has been permanently deleted.", 204);
    }
}
