<?php

namespace App\Http\Controllers;

use App\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CompanyController extends CommonController
{
    public function __construct()
    {
        $this->class = Company::class;
        $this->hash = Hash::class;
    }
}
