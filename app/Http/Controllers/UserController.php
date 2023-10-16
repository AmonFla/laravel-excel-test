<?php

namespace App\Http\Controllers;

use App\Imports\UserImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    public function import()
    {
        Excel::import(new UserImport, 'users.xls');
        return redirect('/')->with('success', 'All good');
    }
}
