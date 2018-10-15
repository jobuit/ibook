<?php

namespace App\Http\Controllers;

use App\Autores;
use App\Books;
use App\Reservas;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;

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
                ->select('books.id','books.autor_id','books.titulo','books.imagen','books.tema','books.cantidad','books.valoracion','books.descripcion','books.precio','autores.nombre')
                ->get();
        }else{
            $data = DB::table('books')
                ->join('autores','books.autor_id','=','autores.id')
                ->select('books.id','books.autor_id','books.titulo','books.imagen','books.tema','books.cantidad','books.valoracion','books.descripcion','books.precio','autores.nombre')
                ->get();

        }

        return ($data);
    }

    public function updateLibro(Request $request)	{

        if($request->input('idLibroModalEditar')!=""){
            $book = Books::find($request->input('idLibroModalEditar'));
        }else{
            $book = new Books();
            $book->valoracion="0";

            $img=$request->file('imgLibro');
            $destinationPath=public_path('/img/libros');
            $img->move($destinationPath,$img->getClientOriginalName());

            $book->imagen="/img/libros/".$img->getClientOriginalName();
        }

        $book->autor_id = $request->input('idAutorModalEditar');
        $book->titulo = $request->input('tituloModalEditar');
        $book->descripcion = $request->input('descripcionModalEditar');
        $book->tema = $request->input('temaModalEditar');
        $book->cantidad = $request->input('cantidadModalEditar');
        $book->precio = $request->input('precioModalEditar');

        $book->save();

        return Redirect::back();

    }

    public function buscarAutor(Request $request)	{

        $autor=$request->input('nomAutor');

        if($autor!=''){
            $data = Autores::where('nombre', '=', $autor)
                ->select('descripcion','imagen','telefono','correo','valoracion')
                ->get();
            return ($data);
        }

        return null;
    }

    public function eliminarLibro(Request $request)	{

        $id = $request->input('idBook');
        Books::find($id)->delete();
        return $id;
    }

    public function alquilarLibro(Request $request){

        $idUser=$request->input('idUser');
        $idBook=$request->input('idBook');
        $fechaEntrega=$request->input('fechaEntrega');
        $fechaRecibida=$request->input('fechaRecibida');

        Reservas::create([
            'book_id' => $idBook,
            'user_id' => $idUser,
            'fecha_recogeran' => $fechaEntrega,
            'fecha_entrega' => $fechaRecibida,
        ]);

        User::whereId($idUser)->increment('num_reservas', 1);
        Books::whereId($idBook)->decrement('cantidad', 1);
    }
}


