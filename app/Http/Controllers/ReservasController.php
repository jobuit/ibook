<?php

namespace App\Http\Controllers;

use App\Books;
use App\Reservas;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ReservasController extends Controller
{
    public function index()
    {
        return view('reservas');
    }

    public function buscarAlquilados()	{

        $id=Auth::user()->id;
        $data = DB::table('reservas')->where('user_id', '=', $id)
            ->join('books','reservas.book_id','=','books.id')
            ->select('reservas.id','reservas.fecha_recogeran', 'reservas.fecha_entrega', 'reservas.created_at','books.titulo','books.imagen','books.tema','books.cantidad','books.valoracion','books.descripcion','books.precio')
            ->get();

        return ($data);
    }

    public function retornarLibro(Request $request){

        $idReserva=$request->input('reservaId');
        $reserva=Reservas::find($idReserva);

        $idUser=$reserva->user_id;
        $idBook=$reserva->book_id;

        User::whereId($idUser)->decrement('num_reservas', 1);
        Books::whereId($idBook)->increment('cantidad', 1);


        Reservas::find($idReserva)->delete();

        return $idReserva;

    }
}
