<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function returnResponse()
    {
        return ok('You have access for this page');
    }
}
