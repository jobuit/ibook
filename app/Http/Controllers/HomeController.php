<?php

namespace App\Http\Controllers;

use App\Books;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $books = Books::all();
        return view('home')->with('books',$books);
    }

    public function buscarLibros(Request $request)	{

        $buscar=$request->input('buscar');
        \Log::warning($buscar);

        if($buscar!=''){
            $data = Books::where('titulo', 'LIKE', '%'. $buscar .'%')
                ->orWhere('tema', 'LIKE', '%'. $buscar .'%')
                ->orWhere('autor_id', 'LIKE', '%'. $buscar .'%')
                ->get();
        }else{
            $data = Books::all();
        }

        return ($data);
    }
}
