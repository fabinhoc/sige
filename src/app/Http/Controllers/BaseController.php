<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Support\Jsonable;

abstract class BaseController
{
    protected $class;
    protected $hash;

    public function __construct()
    {
        //
    }

    public function index()
    {
        return $this->class::paginate(10);
    }

    public function store(Request $request, $rules = [])
    {
        if ($rules) {
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json(["errors" => $validator->errors()]);
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
                return response()->json(["errors" => $validator->errors()]);
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

    public function destroy($id)
    {
        $resource = $this->class::findOrFail($id);
        if ($resource) {
            $resource->delete($id);
            return response()->json($resource, 200);
        }

        return response()->json('Resource not responding correctly', 400);
    }
}
