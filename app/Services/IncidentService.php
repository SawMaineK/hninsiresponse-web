<?php
namespace App\Services;

use App\Models\Incident;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class IncidentService
{
    public function get(Request $request)
    {
        $query = Incident::filter($request);
        if($request->has('aggregate')) {
            return $query;
        }
        $query->with(['township', 'city']);
        $perPage = $request->query('per_page', 10);
        return $query->paginate($perPage);
    }

    public function createOrUpdate(array $data)
    {
        Log::info('Creating or updating a incident', ['data' => $data]);

        if (isset($data['id'])) {
            return Incident::updateOrCreate(['id' => $data['id']], $data);
        }

        // If no id, create a new incident
        return Incident::create($data);
    }

    public function update(Incident $incident, array $data)
    {
        Log::info('Updating incident', ['id' => $incident->id, 'data' => $data]);
        $incident->update($data);
        return $incident;
    }

    public function delete(Incident $incident)
    {
        Log::info('Deleting incident', ['id' => $incident->id]);
        $incident->delete();
    }

    public function restore($id)
    {
        Log::info('Restoring incident', ['id' => $id]);
        $incident = Incident::withTrashed()->findOrFail($id);
        $incident->restore();
    }

    public function forceDelete($id)
    {
        Log::info('Permanently deleting incident', ['id' => $id]);
        $incident = Incident::withTrashed()->findOrFail($id);
        $incident->forceDelete();
    }
}
