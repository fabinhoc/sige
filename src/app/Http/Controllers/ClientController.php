<?php

namespace App\Http\Controllers;

use App\Client;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ClientController extends BaseController
{
    public function __construct()
    {
        $this->class = Client::class;
        $this->hash = Hash::class;
        $this->storage = Storage::class;
    }

    public function index()
    {
        return $this->class::with('company')->paginate(10);
    }    

    public function show($id)
    {
        $resource = $this->class::with('company')->find($id);
        if (is_null($resource)) {
            return response()->json('No Data', 204);
        }
        return response()->json($resource);
    }
}
