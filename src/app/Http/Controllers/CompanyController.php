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

    public function store(Request $request, $rules = []) 
    {
        $rules = [
            'email' => 'required|unique:companies|email',
            'website' => 'required',
            'name' => 'required'
        ];

        $file = $request->file('logo');
        if ($request->hasFile('logo')) {
            $rules['logo'] = 'file|mimes:jpeg,bmp,png,jpg';
            $url = $file->store('public');
        } else {
            $url = '';
        }

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(["errors" => $validator->errors()]);
        }
       
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'website' => $request->website,
            'logo' => $url
        ];
    
        return $this->class::create($data);
    }

    public function update($id, Request $request, $rules = []) 
    {
        $requestData = $request->all();
        
        if ($request->hasFile('logo')) {
            $rules = [
                'logo' => 'file|mimes:jpeg,bmp,png,jpg'
            ];
            $validator = Validator::make($request->all(), $rules);
            
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()]);
            }

            $file = $request->file('logo');
            $url = $file->store('public');
            $requestData['logo'] = $url;
        }

        $resource = $this->class::find($id);
        
        if (is_null($resource)) {
            return response()->json('Resource not found', 404);
        }
        $imagePath = $resource->logo;

        $resource->fill($requestData);
        $response = $resource->save();
        
        if (!$response) {
            return response()->json('Resource not modified', 304);
        }
        
        if ($request->hasFile('logo')) {
            $this->storage::delete($imagePath);
        }

        return response()->json($resource, 200);
    }

    public function image($file)
    {

        $content = $this->storage::disk('public')->get($file);
        return response($content)
                    ->header('Content-Type','image/png')
                    ->header('Pragma','public')
                    ->header('Content-Disposition','inline; filename="qrcodeimg.png"')
                    ->header('Cache-Control','max-age=60, must-revalidate');;
    }
}
