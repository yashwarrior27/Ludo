<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function Index()
    {
        try
        {
           return view('admin.pages.dashboard.index');
        }
        catch(\Exception $e)
        {
            return $this->ErrorMessage($e);
        }
    }
}
