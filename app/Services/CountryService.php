<?php
namespace App\Services;

use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CountryService
{
    public function get(Request $request)
    {
        $query = Country::filter($request);
        
        $perPage = $request->query('per_page', 10);
        return $query->paginate($perPage);
    }

    public function createOrUpdate(array $data)
    {
        Log::info('Creating or updating a country', ['data' => $data]);

        if (isset($data['id'])) {
            return Country::updateOrCreate(['id' => $data['id']], $data);
        }

        // If no id, create a new country
        return Country::create($data);
    }

    public function update(Country $country, array $data)
    {
        Log::info('Updating country', ['id' => $country->id, 'data' => $data]);
        $country->update($data);
        return $country;
    }

    public function delete(Country $country)
    {
        Log::info('Deleting country', ['id' => $country->id]);
        $country->delete();
    }

    public function restore($id)
    {
        Log::info('Restoring country', ['id' => $id]);
        $country = Country::withTrashed()->findOrFail($id);
        $country->restore();
    }

    public function forceDelete($id)
    {
        Log::info('Permanently deleting country', ['id' => $id]);
        $country = Country::withTrashed()->findOrFail($id);
        $country->forceDelete();
    }
}
