<?php

namespace App\Http\Controllers;

use App\Books;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

        if($buscar!=''){
            $data = Books::where('titulo', 'LIKE', '%'. $buscar .'%')
                ->orWhere('tema', 'LIKE', '%'. $buscar .'%')
                ->join('autores','books.autor_id','=','autores.id')
                ->orWhere('autores.nombre', 'LIKE', '%'. $buscar .'%')
                ->select('books.id','books.titulo','books.imagen','books.tema','books.cantidad','books.valoracion','books.descripcion','books.precio','autores.nombre')
                ->get();
        }else{
            $data = DB::table('books')
                ->join('autores','books.autor_id','=','autores.id')
                ->select('books.id','books.titulo','books.imagen','books.tema','books.cantidad','books.valoracion','books.descripcion','books.precio','autores.nombre')
                ->get();

        }

        return ($data);
    }
}
