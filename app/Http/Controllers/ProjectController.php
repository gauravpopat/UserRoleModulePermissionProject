<?php

namespace App\Http\Controllers;

class ProjectController extends Controller
{
    public function list()
    {
        return ok("You have permission to get the list of project");
    }

    public function create()
    {
        return ok("You have permission to create project");
    }

    public function update()
    {
        return ok("You have permission to update project");
    }

    public function show()
    {
        return ok("You have permission to show project");
    }

    public function delete()
    {
        return ok("You have permission to delete project");
    }
}
