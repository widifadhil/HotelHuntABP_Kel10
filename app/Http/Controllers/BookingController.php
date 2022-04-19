<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Customer;
use App\Models\RoomType;
use App\Models\Hotel;
use App\Models\Booking;

class BookingController extends Controller
{
    public function findh()
    {
        return view('pages.findh', [
            "title" => "Find Hotel"
        ]);
    }
    public function hdetail()
    {
        return view('pages.hdetail', [
            "title" => "Detail Hotel"
        ]);
    }
    public function book()
    {
        return view('pages.book', [
            "title" => "Booking"
        ]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = RoomType::all();
        return view('pages.booking.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $hotels = Hotel::all();
        $customer = Customer::all();
        return view('pages.booking.create', ['data' => $customer]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $request->validate([
        //     'customer_id' => 'required',
        //     'room_id' => 'required',
        //     'checkin_date' => 'required',
        //     'checkout_date' => 'required',
        //     'total_adults' => 'required',
        //     // 'hotels_id' => 'required',
        // ]);


        $data = new Booking;
        $data->customer_id = $request->cs_id;
        $data->room_id = $request->room_id;
        $data->checkin_date = $request->checkin_date;
        $data->checkout_date = $request->checkout_date;
        $data->total_adults = $request->total_adult;
        $data->total_children = $request->total_children;
        // $data->hotel_id = $request->hl_id;


        $data->save();
        return redirect('admin/booking/create')->with('success', 'Data has been added.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    // check available rooms
    function available_rooms(Request $request, $checkin_date)
    {
        $arooms = DB::SELECT("SELECT * FROM rooms WHERE id NOT IN (SELECT room_id FROM bookings WHERE '$checkin_date' BETWEEN checkin_date AND checkout_date)");

        $data = [];
        foreach ($arooms as $room) {
            $roomTypes = RoomType::find($room->room_type_id);
            $data[] = ['room' => $room, 'roomtype' => $roomTypes];
        }

        return response()->json(['data' => $data]);
    }
}
