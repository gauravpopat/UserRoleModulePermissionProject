<?php

namespace App\Http\Controllers;

class EmployeeController extends Controller
{
    public function list()
    {
        return ok("You have permission to get the list of employee");
    }

    public function create()
    {
        return ok("You have permission to create employee");
    }

    public function update()
    {
        return ok("You have permission to update employee");
    }

    public function show()
    {
        return ok("You have permission to show employee");
    }

    public function delete()
    {
        return ok("You have permission to delete employee");
    }
}
