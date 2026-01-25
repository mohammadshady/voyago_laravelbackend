<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\CityResource;
use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CityController extends Controller
{
    public function index(Request $request)
    {
        $query = City::query();

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                ->orWhere('english_name', 'like', "%$search%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $cities = $query->latest()->paginate(4);

        if ($cities->total() > 0) {
            return response()->json([
                'status' => 'success',
                'data' => CityResource::collection($cities),
                'links' => [
                    'first' => $cities->url(1),
                    'last' => $cities->url($cities->lastPage()),
                    'prev' => $cities->previousPageUrl(),
                    'next' => $cities->nextPageUrl(),
                ],
                'meta' => [
                    'current_page' => $cities->currentPage(),
                    'from' => $cities->firstItem(),
                    'last_page' => $cities->lastPage(),
                    'per_page' => $cities->perPage(),
                    'to' => $cities->lastItem(),
                    'total' => $cities->total(),
                ],
            ]);
        } else {
            return response()->json([
                'status' => 'failure',
                'error' => 'No cities found',
                'data' => [],
            ]);
        }
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'         => 'required|string|max:255',
            'english_name' => 'required|string|max:255',
            'status'       => 'required|in:active,inactive',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $city = City::create($request->all());

        return response()->json([
            'status'  => 'success',
            'message' => 'City created successfully',
            'data'    => new CityResource($city)
        ], 201);
    }

    public function show( $id)
    {
        $city = City::find($id);
        if (!$city) {
            return response()->json([
                'message' => 'City not found'
            ], 404);
        }

        return new CityResource($city);
    }

    public function update(Request $request, $id)
    {
        $city = City::find($id);

        if (!$city) {
            return response()->json([
                'message' => 'City not found'
            ], 404);
        }
        
        $validator = Validator::make($request->all(), [
            'name'         => 'sometimes|required|string|max:255',
            'english_name' => 'sometimes|required|string|max:255',
            'status'       => 'sometimes|required|in:active,inactive',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $data = $validator->validated();
        $city->update($data);

        return response()->json([
            'status'  => 'success',
            'message' => 'City updated successfully',
            'data'    => new CityResource($city)
        ]);
    }

    public function destroy($id)
    {
        $city = City::find($id);

        if (!$city) {
            return response()->json([
                'message' => 'City not found'
            ], 404);
        }

        $city->delete();
        return response()->json([
            'status'  => 'success',
            'message' => 'City deleted successfully'
        ]);
    }
}

