<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Province;
use Illuminate\Http\Request; 
use Illuminate\Support\Facades\Http;

class CheckOngkirController extends Controller
{
    protected $API_KEY = 'a83a011b65ac191151038b2bfce9e640'; 

    // semua profinsi
    public function provinces()
    {
        $response = Http::withHeaders([
            'key' => $this->API_KEY
        ])->get('https://api.rajaongkir.com/starter/province');
        $provinces = $response['rajaongkir']['results'];
        return $provinces;
    }

    // spesifik provinsi
    public function province($id)
    {
        $response = Http::withHeaders([
            'key' => $this->API_KEY
        ])->get('https://api.rajaongkir.com/starter/province?id='.$id);
        $province = $response['rajaongkir']['results'];
        return $province['province'];
    }
 
    // semua kota
    public function cities($id)
    {
        $response = Http::withHeaders([
            'key' => $this->API_KEY
        ])->get('https://api.rajaongkir.com/starter/city?province='.$id);
        $cities = $response['rajaongkir']['results'];
        return $cities;
    }

    // spesifik kota
    public function city($id)
    {
        $response = Http::withHeaders([
            'key' => $this->API_KEY
        ])->get('https://api.rajaongkir.com/starter/city?id='.$id);
        $result = $response['rajaongkir']['results'];
        $city = [$result['type'],$result['city_name']];
        return implode(" ",$city);
    }

    // check ongkir
    public function checkOngkir(Request $request)
    {
        $response = Http::withHeaders([
            'key' => $this->API_KEY
        ])->post('https://api.rajaongkir.com/starter/cost', [
            'origin'            => $request->origin,
            'destination'       => $request->destination,
            'weight'            => $request->weight,
            'courier'           => $request->courier
        ]);
        $ongkir = $response['rajaongkir']['results'];
        return response()->json([
            'success' => true,
            'message' => 'Result Cost Ongkir',
            'data'    => $ongkir    
        ]);
    }
}