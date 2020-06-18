<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CommonController extends Controller
{
    protected $class;
    protected $hash;

    public function __construct()
    {
        //
    }

    public function index()
    {
        return $this->class::all();
    }

    public function store(Request $request, $rules = [])
    {
        if ($rules) {
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json($validator->errors());
            }
        }

        if (isset($request['password'])) {
            $request['password'] = $this->hash::make($request['password']);
        }

        return $this->class::create($request->all());
    }

    public function show(int $id)
    {
        $resource = $this->class::find($id);
        if (is_null($resource)) {
            return response()->json('No Data', 204);
        }
        return response()->json($resource);
    }

    public function update(int $id, Request $request, $rules = [])
    {
        if ($rules) {
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json($validator->errors());
            }
        }

        if (isset($request['password'])) {
            $request['password'] = $this->hash::make($request['password']);
        }

        $resource = $this->class::find($id);
        if (is_null($resource)) {
            return response()->json('Resource not found', 404);
        }
        $resource->fill($request->all());
        $resource->save();

        return response()->json($resource, 200);
    }
}
