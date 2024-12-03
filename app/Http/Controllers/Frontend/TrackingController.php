<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;

class TrackingController extends Controller
{
    public function tracking()
    {
        return view('frontend.tracking');
    }
}
