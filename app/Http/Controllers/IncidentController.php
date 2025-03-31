<?php
namespace App\Http\Controllers;

use App\Models\Incident;
use App\Http\Requests\IncidentRequest;
use App\Services\IncidentService;
use Illuminate\Http\Request;
use App\Http\Resources\IncidentResource;
use Sawmainek\Apitoolz\Http\Controllers\APIToolzController;

class IncidentController extends APIToolzController
{
    protected $incidentService;
    public $slug = 'incident';


    public function __construct(IncidentService $incidentService)
    {
        $this->model = new Incident();
        $this->info = $this->makeInfo();
        $this->incidentService = $incidentService;
    }

   /**
     * @OA\Get(
     *     path="/api/incident",
     *     summary="Get a list of incident with dynamic filtering, sorting, pagination, and advanced search",
     *     tags={"Incident"},
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
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/IncidentResource")),
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
        $results = $this->incidentService->get($request);

        if (!$results) {
            return response()->json(['message' => 'Error fetching incident list'], 500);
        }

        return response()->json([
            'data' => IncidentResource::collection($results),
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
     *     path="/api/incident",
     *     summary="Store a new incident",
     *     tags={"Incident"},
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/IncidentRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Incident created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/IncidentResource")
     *     )
     * )
     */
    public function store(IncidentRequest $request)
    {
        $incident = $this->incidentService->createOrUpdate($this->validateData($request));
        return $this->response(new IncidentResource($incident), 201);
    }

    /**
     * @OA\Get(
     *     path="/api/incident/{id}",
     *     summary="Get a specific incident",
     *     tags={"Incident"},
     *     @OA\Parameter(in="path", name="id", required=true, description="Incident ID"),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/IncidentResource")
     *     )
     * )
     */
    public function show(Incident $incident)
    {
        return $this->response(new IncidentResource($incident));
    }

    /**
     * @OA\Put(
     *     path="/api/incident/{id}",
     *     summary="Update a specific incident",
     *     tags={"Incident"},
     *     @OA\Parameter(in="path", name="id", required=true, description="Incident ID"),
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/IncidentRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Incident updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/IncidentResource")
     *     )
     * )
     */
    public function update(IncidentRequest $request, Incident $incident)
    {
        $updatedIncident = $this->incidentService->update($incident, $request->validated());
        return $this->response(new IncidentResource($updatedIncident));
    }

    /**
     * @OA\Delete(
     *     path="/api/incident/{id}",
     *     summary="Delete a incident",
     *     tags={"Incident"},
     *     @OA\Parameter(in="path", name="id", required=true, description="Incident ID"),
     *     @OA\Response(
     *         response=204,
     *         description="Incident deleted successfully"
     *     )
     * )
     */
    public function destroy(Incident $incident)
    {
        $this->incidentService->delete($incident);
        return $this->response("The record has been deleted successfully.", 204);
    }

    /**
     * @OA\Put(
     *     path="/api/incident/{id}/restore",
     *     summary="Restore a deleted incident",
     *     tags={"Incident"},
     *     @OA\Parameter(in="path", name="id", required=true, description="Incident ID"),
     *     @OA\Response(
     *         response=200,
     *         description="Incident restored successfully",
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
        $this->incidentService->restore($id);
        return $this->response("The record has been restored successfully.");
    }

    /**
     * @OA\Delete(
     *     path="/api/incident/{id}/force-destroy",
     *     summary="Permanently delete a incident",
     *     tags={"Incident"},
     *     @OA\Parameter(in="path", name="id", required=true, description="Incident ID"),
     *     @OA\Response(
     *         response=204,
     *         description="Incident permanently deleted"
     *     )
     * )
     */
    public function forceDestroy($id)
    {
        $this->incidentService->forceDelete($id);
        return $this->response("The record has been permanently deleted.", 204);
    }
}
