<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\AdminResource;
use App\Models\Admin;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $query = Admin::query();

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                ->orWhere('english_name', 'like', "%$search%");
            });
        }

        $admins = $query->latest()->paginate(4);

        //return CityResource::collection($cities);
        if ($admins->count() > 0) {
            return response()->json([
                'status' => 'success',
                'data' => AdminResource::collection($admins),
                'links' => [
                    'first' => $admins->url(1),
                    'last' => $admins->url($admins->lastPage()),
                    'prev' => $admins->previousPageUrl(),
                    'next' => $admins->nextPageUrl(),
                ],
                'meta' => [
                    'current_page' => $admins->currentPage(),
                    'from' => $admins->firstItem(),
                    'last_page' => $admins->lastPage(),
                    'per_page' => $admins->perPage(),
                    'to' => $admins->lastItem(),
                    'total' => $admins->total(),
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
        
    }

    public function show( $id)
    {
       
    }

    public function update(Request $request, $id)
    {
       
    }

    public function destroy($id)
    {
       
    }
}

