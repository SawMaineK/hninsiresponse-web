<?php
namespace App\Http\Controllers;

use App\Models\Country;
use App\Http\Requests\CountryRequest;
use App\Services\CountryService;
use Illuminate\Http\Request;
use App\Http\Resources\CountryResource;
use Sawmainek\Apitoolz\Http\Controllers\APIToolzController;

class CountryController extends APIToolzController
{
    protected $countryService;
    public $slug = 'country';


    public function __construct(CountryService $countryService)
    {
        $this->model = new Country();
        $this->info = $this->makeInfo();
        $this->countryService = $countryService;
    }

   /**
     * @OA\Get(
     *     path="/api/country",
     *     summary="Get a list of country with dynamic filtering, sorting, pagination, and advanced search",
     *     tags={"Country"},
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
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/CountryResource")),
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
        $results = $this->countryService->get($request);

        if (!$results) {
            return response()->json(['message' => 'Error fetching country list'], 500);
        }

        return response()->json([
            'data' => CountryResource::collection($results),
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
     *     path="/api/country",
     *     summary="Store a new country",
     *     tags={"Country"},
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/CountryRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Country created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/CountryResource")
     *     )
     * )
     */
    public function store(CountryRequest $request)
    {
        $country = $this->countryService->createOrUpdate($this->validateData($request));
        return $this->response(new CountryResource($country), 201);
    }

    /**
     * @OA\Get(
     *     path="/api/country/{id}",
     *     summary="Get a specific country",
     *     tags={"Country"},
     *     @OA\Parameter(in="path", name="id", required=true, description="Country ID"),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/CountryResource")
     *     )
     * )
     */
    public function show(Country $country)
    {
        return $this->response(new CountryResource($country));
    }

    /**
     * @OA\Put(
     *     path="/api/country/{id}",
     *     summary="Update a specific country",
     *     tags={"Country"},
     *     @OA\Parameter(in="path", name="id", required=true, description="Country ID"),
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/CountryRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Country updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/CountryResource")
     *     )
     * )
     */
    public function update(CountryRequest $request, Country $country)
    {
        $updatedCountry = $this->countryService->update($country, $request->validated());
        return $this->response(new CountryResource($updatedCountry));
    }

    /**
     * @OA\Delete(
     *     path="/api/country/{id}",
     *     summary="Delete a country",
     *     tags={"Country"},
     *     @OA\Parameter(in="path", name="id", required=true, description="Country ID"),
     *     @OA\Response(
     *         response=204,
     *         description="Country deleted successfully"
     *     )
     * )
     */
    public function destroy(Country $country)
    {
        $this->countryService->delete($country);
        return $this->response("The record has been deleted successfully.", 204);
    }

    /**
     * @OA\Put(
     *     path="/api/country/{id}/restore",
     *     summary="Restore a deleted country",
     *     tags={"Country"},
     *     @OA\Parameter(in="path", name="id", required=true, description="Country ID"),
     *     @OA\Response(
     *         response=200,
     *         description="Country restored successfully",
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
        $this->countryService->restore($id);
        return $this->response("The record has been restored successfully.");
    }

    /**
     * @OA\Delete(
     *     path="/api/country/{id}/force-destroy",
     *     summary="Permanently delete a country",
     *     tags={"Country"},
     *     @OA\Parameter(in="path", name="id", required=true, description="Country ID"),
     *     @OA\Response(
     *         response=204,
     *         description="Country permanently deleted"
     *     )
     * )
     */
    public function forceDestroy($id)
    {
        $this->countryService->forceDelete($id);
        return $this->response("The record has been permanently deleted.", 204);
    }
}
