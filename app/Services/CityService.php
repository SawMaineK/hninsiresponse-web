<?php
namespace App\Services;

use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CityService
{
    public function get(Request $request)
    {
        $query = City::filter($request);
        
        $perPage = $request->query('per_page', 10);
        return $query->paginate($perPage);
    }

    public function createOrUpdate(array $data)
    {
        Log::info('Creating or updating a city', ['data' => $data]);

        if (isset($data['id'])) {
            return City::updateOrCreate(['id' => $data['id']], $data);
        }

        // If no id, create a new city
        return City::create($data);
    }

    public function update(City $city, array $data)
    {
        Log::info('Updating city', ['id' => $city->id, 'data' => $data]);
        $city->update($data);
        return $city;
    }

    public function delete(City $city)
    {
        Log::info('Deleting city', ['id' => $city->id]);
        $city->delete();
    }

    public function restore($id)
    {
        Log::info('Restoring city', ['id' => $id]);
        $city = City::withTrashed()->findOrFail($id);
        $city->restore();
    }

    public function forceDelete($id)
    {
        Log::info('Permanently deleting city', ['id' => $id]);
        $city = City::withTrashed()->findOrFail($id);
        $city->forceDelete();
    }
}
