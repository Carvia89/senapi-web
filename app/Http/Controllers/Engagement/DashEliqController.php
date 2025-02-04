<?php

namespace App\Http\Controllers\Engagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashEliqController extends Controller
{
    public function indexEliq()
    {
        return view('daf.layouts.dashboard');
    }

    public function indexCaisse()
    {
        return view('daf.layouts.dashboardCaisse');
    }
}
