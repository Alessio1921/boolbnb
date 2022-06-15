<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Model\Apartment;
use Illuminate\Support\Facades\Http;

class ApartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $apartments = Apartment::paginate(12);
        return view('user.apartments.index', compact("apartments"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('user.apartments.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required', 'string', 'min:20','max:255'],
            'image' => ['required'],
            'image.*' => 'mimes:jpeg,png,jpg,gif,svg|max:2048',
            'description' => ['required', 'string','min:20','max:65000'],
            'n_rooms' => ['required', 'number','min:1'],
            'n_bedrooms' => ['required', 'number','min:1'],
            'n_bathrooms' => ['required', 'number','min:1'],
            'guests' => ['required', 'number','min:1'],
            'n_beds' => ['required', 'number','min:1'],
            'price' => ['required', 'number','min:1'],
            'address' => ['required', 'string','min:3'],
            'address_number' => ['required', 'string','min:1'],
            'address_city' => ['required', 'string','min:3'],

        ],
        [
            "required" => "Non puoi inserire un Appartamento senza :attribute.",
        ]);

        $data = $request->all();
        if($request['visible'] != null){
            $data['visible'] = 1;
        }

        else{
            $data['visible'] = 0;
        }

        if($request['available'] != null){
            $data['available'] = 1;
        }
        else{
            $data['available'] = 0;
        }
        $tempAddress = $data['address'].' '.$data['address_number'].' '.$data['address_city'];
        // dd($tempAddress);
        $newAddress = str_replace(" ", "%20", $tempAddress);
        $response = Http::get('https://api.tomtom.com/search/2/geocode/' . $newAddress . '.json?storeResult=false&view=Unified&key='.env("APP_KEYMAPS"));
        $dataResponse = json_decode($response->body(), true);
        $newApartment = new Apartment();
        $newApartment->title = $data["title"];
        $newApartment->user_id = Auth::user()->id;
        $newApartment->image = Storage::put('uploads',$data["image"]);
        $newApartment->description = $data["description"];
        $newApartment->n_rooms = $data["n_rooms"];
        $newApartment->n_bedrooms = $data["n_bedrooms"];
        $newApartment->n_beds = $data["n_beds"];
        $newApartment->n_bathrooms = $data["n_bathrooms"];
        $newApartment->guests = $data["guests"];
        $newApartment->visible = $data["visible"];
        $newApartment->available = $data["available"];
        $newApartment->price = $data["price"];
        $newApartment->square_meters = $data["square_meters"];
        $newApartment->lat = $dataResponse["results"][0]["position"]["lat"];
        $newApartment->long = $dataResponse["results"][0]["position"]["lon"];
        $newApartment->address = $tempAddress;
        $newApartment->save();
        return redirect()->route('apartment.show', ["apartment" => $newApartment]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Apartment $apartment)
    {
        return view('user.apartments.show', compact('apartment'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Apartment $apartment)
    {
        return view('user.apartments.edit', compact('apartment'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Apartment $apartment)
    {
        $data = $request->all();
<<<<<<< HEAD

=======

        if($request['visible'] != null)
            $data['visible'] = 1;
        else
            $data['visible'] = 0;

        if($request['available'] != null)
            $data['available'] = 1;
        else
            $data['available'] = 0;

>>>>>>> cdd7fa806c10c2b177de628b9f7d037ca53b5e15
        $newAddress = str_replace(" ", "%20", $data["address"]);
        $response = Http::get('https://api.tomtom.com/search/2/geocode/' . $newAddress . '.json?storeResult=false&view=Unified&key='.env("APP_KEYMAPS"));
        $dataResponse = json_decode($response->body(), true);

        $apartment->title = $data["title"];
        $apartment->user_id = Auth::user()->id;
        if(isset($data["image"])){
            $apartment->image = Storage::put('uploads',$data["image"]);
        }
        $apartment->description = $data["description"];
        $apartment->n_rooms = $data["n_rooms"];
        $apartment->n_bedrooms = $data["n_bedrooms"];
        $apartment->n_beds = $data["n_beds"];
        $apartment->n_bathrooms = $data["n_bathrooms"];
        $apartment->guests = $data["guests"];
        if(isset($data["visible"]))
        $apartment->visible = $data["visible"];
        if(isset($data["available"]))
        $apartment->available = $data["available"];
        $apartment->price = $data["price"];
        $apartment->square_meters = $data["square_meters"];
        $apartment->lat = $dataResponse["results"][0]["position"]["lat"];
        $apartment->long = $dataResponse["results"][0]["position"]["lon"];
        $apartment->address = $data["address"];
        $apartment->save();

        return redirect('home');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Apartment $apartment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Apartment $apartment)
    {
        $apartment->delete();

        return redirect()->route('guest.home')->with('deleted-message', 'The selected apartment has been deleted');
    }
}
