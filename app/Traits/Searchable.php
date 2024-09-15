<?php

namespace App\Traits;

use Illuminate\Http\Request;

trait Searchable
{
    /**
     * Generic search method for any model with pagination option.
     *
     * @param Request $request
     * @param \Illuminate\Database\Eloquent\Builder $modelQuery
     * @param array $searchColumns
     * @return \Illuminate\Http\JsonResponse
     */
    public function search(Request $request, $modelQuery, array $searchColumns)
    {
        $request->validate([
            'q' => 'nullable|string',
            'paginate' => 'nullable|boolean'
        ]);

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

        return response()->json($results);
    }
}
