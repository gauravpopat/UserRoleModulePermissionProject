<?php

namespace App\Traits;

trait ListingApiTrait
{

    public function ListingValidation()
    {
        $this->validate(request(), [
            'Page'          => 'integer',
            'PerPage'       => 'integer',
            'is_active'     => 'boolean',
            'search'        => 'nullable',
            'only_trashed'  => 'integer'
        ]);
        return true;
    }

    public function filterSearchPagination($query, $searchable_fields)
    {
        /*For filtering by is_active field*/
        if (isset(request()->is_active)) {
            $query = $query->where('isActive', request()->is_active);
        }
        /* Get deleted record only */
        if (request()->only_trashed) {
            $query = $query->onlyTrashed();
        }
        /* Search with searchable fields */
        if (request()->search) {
            $search = request()->search;
            $query  = $query->where(function ($q) use ($search, $searchable_fields) {
                /* adding searchable fields to orwhere condition */
                foreach ($searchable_fields as $searchable_field) {
                    $q->orWhere($searchable_field, 'like', "%$search%");
                }
            });
        }
        /* Pagination */
        $count          = $query->count();
        if (request()->page && request()->perPage) {
            $page       = request()->page;
            $perPage    = request()->perPage;
            $query      = $query->skip($perPage * ($page - 1))->take($perPage);
        }
        return ['query' => $query, 'count' => $count];
    }
}
