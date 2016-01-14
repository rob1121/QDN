<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use App\Employee;
use App\Account;
use App\Models\Info;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return Response
     */
    public function index()
    {
        // $account = Account::where('access_level','admin')->get();

        if (Auth::user()) {
            $qdn = Info::all();
            return view('home', compact('qdn'));
        }
        return view('welcome');

    }
}
