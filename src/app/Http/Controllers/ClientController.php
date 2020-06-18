<?php

namespace App\Http\Controllers;

use App\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class CompanyController extends BaseController
{
    public function __construct()
    {
        $this->class = Company::class;
        $this->hash = Hash::class;
        $this->storage = Storage::class;
    }

    public function index()
    {
        return $this->class::with('company')->all();
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
