<?php

namespace App\Modules\Booking\Controllers;

use App\Modules\Booking\Models\Booking;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BookingController extends Controller
{
    public function getList(){

    }

    public function postList(Request $request){
        Booking::create(array(
            'fullname' => $request->fullname,
            'phone' => $request->phone,
            'email' => $request->email,
            'link' => $request->link,
            'week' => $request->week,
            'hour' => $request->hour,
            'status' => 0,
        ));

        return \redirect()->to(url('/?success#frm_booking'));
    }
}