<?php
namespace App\Services;

use App\Models\Region;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RegionService
{
    public function get(Request $request)
    {
        $query = Region::filter($request);
        
        $perPage = $request->query('per_page', 10);
        return $query->paginate($perPage);
    }

    public function createOrUpdate(array $data)
    {
        Log::info('Creating or updating a region', ['data' => $data]);

        if (isset($data['id'])) {
            return Region::updateOrCreate(['id' => $data['id']], $data);
        }

        // If no id, create a new region
        return Region::create($data);
    }

    public function update(Region $region, array $data)
    {
        Log::info('Updating region', ['id' => $region->id, 'data' => $data]);
        $region->update($data);
        return $region;
    }

    public function delete(Region $region)
    {
        Log::info('Deleting region', ['id' => $region->id]);
        $region->delete();
    }

    public function restore($id)
    {
        Log::info('Restoring region', ['id' => $id]);
        $region = Region::withTrashed()->findOrFail($id);
        $region->restore();
    }

    public function forceDelete($id)
    {
        Log::info('Permanently deleting region', ['id' => $id]);
        $region = Region::withTrashed()->findOrFail($id);
        $region->forceDelete();
    }
}
