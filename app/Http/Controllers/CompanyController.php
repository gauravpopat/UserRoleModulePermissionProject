<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Traits\ListingApiTrait;

class CompanyController extends Controller
{
    use ListingApiTrait;
    //list of companies
    public function list()
    {
        $this->ListingValidation();
        $query = Company::query();
        $searchable_fields = ['name','type','location'];
        $data = $this->filterSearchPagination($query, $searchable_fields);
        return ok('User Data', [
            'company'   => $data['query']->get(),
            'count'     => $data['count']
        ]);
    }

    //Create Company
    public function create(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'name'      => 'required|max:50|unique:companies,name',
            'location'  => 'required|max:50',
            'is_active' => 'in:1,0',
            'type'      => 'required|in:it,non-it'
        ]);

        if ($validation->fails())
            return error('Validation Error', $validation->errors());

        $company = Company::create($request->all());
        return ok('Company Created Successfully', $company);
    }

    //Update company by id
    public function update($id, Request $request)
    {
        $company = Company::findOrFail($id);
        $validation = Validator::make($request->all(), [
            'name'      => 'required|max:50|unique:companies,name,'.$company->id,
            'location'  => 'required',
            'is_active' => 'in:1,0',
            'type'      => 'required|in:it,non-it'
        ]);

        if ($validation->fails())
            return error('Validation Error', $validation->errors(), 'Validation');

        $company->update($request->all());
        return ok('Company Updated Successfully');
    }

    //Show Company
    public function show($id)
    {
        $company = Company::findOrFail($id);
        return ok('Company', $company);
    }

    //Delete company
    public function delete($id)
    {
        Company::findOrFail($id)->delete();
        return ok('Company Deleted Successfully');
    }
}
