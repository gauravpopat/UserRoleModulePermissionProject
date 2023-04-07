<?php

namespace App\Http\Controllers;

use App\Models\Module;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Traits\ListingApiTrait;

class ModuleController extends Controller
{
    use ListingApiTrait;
    //Module list
    public function list()
    {
        $this->ListingValidation();
        $query = Module::query();
        $searchable_fields = ['name'];
        $data = $this->filterSearchPagination($query, $searchable_fields);
        return ok('User Data', [
            'modules' => $data['query']->get(),
            'count' => $data['count']
        ]);
    }

    //Create module
    public function create(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'name'          => 'required|unique:modules,name|max:50',
            'description'   => 'required'
        ]);

        if ($validation->fails())
            return error('Validation Error', $validation->errors(), 'validation');

        $module = Module::create($request->only(['name', 'description']));
        return ok('Module Added', $module);
    }

    //Update module by ID
    public function update($id, Request $request)
    {
        $module = Module::findOrFail($id);

        $validation = Validator::make($request->all(), [
            'name'          => 'required|max:50|unique:modules,name,' . $module->id,
            'description'   => 'required'
        ]);

        if ($validation->fails())
            return error('Validation Error', $validation->errors(), 'validation');

        $module->update($request->all());

        return ok('Module Updated Successfully');
    }

    //Delete module by ID
    public function delete($id)
    {
        $module = Module::findOrFail($id); //find the module
        $module->permissions()->detach(); // detach the permissions of that module
        $module->delete(); //delete the module
        return ok('Module Deleted Successfully');
    }

    //Show particular module
    public function show($id)
    {
        $module = Module::findOrFail($id)->load('permissions');
        return ok('Module detail', $module);
    }
}
