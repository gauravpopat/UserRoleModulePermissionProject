<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function returnResponse()
    {
        ok('You have access for this page');
    }
}
