<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

trait Searchable
{
    /**
     * Generic search method for any model with pagination option and resource transformation.
     *
     * @param Request $request
     * @param \Illuminate\Database\Eloquent\Builder $modelQuery
     * @param array $searchColumns
     * @param string $resourceClass  // The resource class to be used for transformation
     * @return \Illuminate\Http\JsonResponse
     */
    public function search(Request $request, $modelQuery, array $searchColumns, string $resourceClass)
    {
        // Validate search query and pagination flag
        $request->validate([
            'q' => 'nullable|string',
            'paginate' => 'nullable|boolean'
        ]);

        // Get search query and pagination flag from the request
        $searchQuery = $request->input('q');
        $isPaginated = $request->input('paginate', false);

        // Apply search filters dynamically for the specified columns
        $modelQuery = $modelQuery->when($searchQuery, function ($query, $searchQuery) use ($searchColumns) {
            foreach ($searchColumns as $column) {
                $query->orWhere($column, 'like', '%' . $searchQuery . '%');
            }
            return $query;
        });

        // Handle pagination or return all results
        if ($isPaginated) {
            $results = $modelQuery->paginate(5);
        } else {
            $results = $modelQuery->get();
        }

        // Return results transformed by the given resource class
        return response()->json($resourceClass::collection($results));
    }
}
