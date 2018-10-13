@extends('layouts.app')
@include('nav')
@section('content')
<div class="container p-3">
    <div class="container-fluid">
        <div class="row">
            <div class="d-flex justify-content-end">
                <input type="text" class="form-control mr-2" name="busqueda" id="txtBuscar" value="" style="width: 300px;" placeholder="Busca por autor, titulo, tema..">
                <button type="button" name="" id="buscar" class="btn btn-primary">Buscar</button>
            </div>
            <div class="col-md-7">
                <i><h6 class="mt-2 text-right">(Recuerda que solo puedes alquilar 3 libros)</h6></i>
            </div>
        </div>
    </div>

    <div class="row" id="contenedorLista">
        <!--@foreach ($books as $book)
            <div class="col m-2" style="max-width: 270px;">
                <div class="card">
                    <div class="container">
                    <div class="input-group"><p class="text-center" style="width: 100%">{{$book->titulo}}</p></div>
                        <a href="{{URL::asset($book->imagen)}}" data-lightbox="{{$book->imagen}}" data-title="{{$book->titulo}}">
                            <img src="{{URL::asset($book->imagen)}}" alt="profile Pic" height="250" width="200">
                        </a>
                    <div class="input-group">
                        <small class="mr-2"> Autor: <a href="#" >{{App\Autores::find($book->autor_id)->nombre}} </a></small>
                    </div>
                        <div class="input-group">
                            <small class="mr-2">Tema: {{$book->tema}} </small>
                        </div>
                        <div class="input-group">
                            <small class="mr-2">Disponible: {{$book->cantidad}} </small>
                        </div>

                        <div class="input-group">
                            <small class="mr-2">Puntuacion prom: {{$book->valoracion}} </small>
                    @if( $book->valoracion < 2.1 )
                            <img src="{{URL::asset('/img/star.png')}}" height="15" width="15">
                            <img src="{{URL::asset('/img/star2.png')}}" height="15" width="15">
                            <img src="{{URL::asset('/img/star2.png')}}" height="15" width="15">
                            <img src="{{URL::asset('/img/star2.png')}}" height="15" width="15">
                            <img src="{{URL::asset('/img/star2.png')}}" height="15" width="15">
                    @elseif($book->valoracion < 4.1)
                                <img src="{{URL::asset('/img/star.png')}}" height="15" width="15">
                                <img src="{{URL::asset('/img/star.png')}}" height="15" width="15">
                                <img src="{{URL::asset('/img/star2.png')}}" height="15" width="15">
                                <img src="{{URL::asset('/img/star2.png')}}" height="15" width="15">
                                <img src="{{URL::asset('/img/star2.png')}}" height="15" width="15">
                    @elseif($book->valoracion < 6.1)
                                <img src="{{URL::asset('/img/star.png')}}" height="15" width="15">
                                <img src="{{URL::asset('/img/star.png')}}" height="15" width="15">
                                <img src="{{URL::asset('/img/star.png')}}" height="15" width="15">
                                <img src="{{URL::asset('/img/star2.png')}}" height="15" width="15">
                                <img src="{{URL::asset('/img/star2.png')}}" height="15" width="15">

                        @elseif($book->valoracion < 8.1)
                                <img src="{{URL::asset('/img/star.png')}}" height="15" width="15">
                                <img src="{{URL::asset('/img/star.png')}}" height="15" width="15">
                                <img src="{{URL::asset('/img/star.png')}}" height="15" width="15">
                                <img src="{{URL::asset('/img/star.png')}}" height="15" width="15">
                                <img src="{{URL::asset('/img/star2.png')}}" height="15" width="15">

                        @else
                                <img src="{{URL::asset('/img/star.png')}}" height="15" width="15">
                                <img src="{{URL::asset('/img/star.png')}}" height="15" width="15">
                                <img src="{{URL::asset('/img/star.png')}}" height="15" width="15">
                                <img src="{{URL::asset('/img/star.png')}}" height="15" width="15">
                                <img src="{{URL::asset('/img/star.png')}}" height="15" width="15">
                        @endif
                        </div>

                        <div class="input-group">
                            <small class="mr-2">{{$book->descripcion}} </small>
                        </div>

                    </div>
                </div>
            </div>
        @endforeach
            -->
    </div>
</div>
@endsection

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {

        BuscarLibros('');

        $("#buscar").on("click", function() {

            var txt = $('#txtBuscar').val();
            BuscarLibros(txt);

        });

        function BuscarLibros(txt) {

            $("#contenedorLista div").remove();

            $.ajax({
                url:"{{route('buscarLibros')}}",
                mehtod:"get",
                data:{buscar:txt},
                success:function(response)
                {
                    // console.log(response);

                    if($.trim(response)){
                        var newRows = "";

                        for (var i = 0; i < response.length; i++) {

                            newRows += "<div class='col m-2' style='max-width: 270px;'><div class='card'><div class='container'>" +
                                "<div class='input-group'><p class='text-center' style='width: 100%'>"+response[i].titulo+"</p></div>"+
                                "<a href='"+response[i].imagen+"' data-lightbox='$book->imagen' data-title='"+response[i].titulo+"'>"+
                                    "<img src='"+response[i].imagen+"' alt='profile Pic' height='250' width='200'></a>"+
                                    "<div class='input-group'><small class='mr-2'> Autor: <a href='#' >"+response[i].autor_id+"</a></small></div>"+
                                    "<div class='input-group'><small class='mr-2'>Tema: "+response[i].titulo+"</small></div>"+
                                    "<div class='input-group'><small class='mr-2'>Disponible: "+response[i].cantidad+"</small></div>"+
                                    "<div class='input-group'><small class='mr-2'>Puntuacion prom: "+response[i].valoracion+"</small>";
                                    if(response[i].valoracion < 2.1){
                                        newRows += "<img src='/img/star.png' height='15' width='15'><img src='/img/star2.png' height='15' width='15'><img src='/img/star2.png' height='15' width='15'><img src='/img/star2.png' height='15' width='15'><img src='/img/star2.png' height='15' width='15'>";
                                    }else if(response[i].valoracion < 4.1){
                                        newRows += "<img src='/img/star.png' height='15' width='15'><img src='/img/star.png' height='15' width='15'><img src='/img/star2.png' height='15' width='15'><img src='/img/star2.png' height='15' width='15'><img src='/img/star2.png' height='15' width='15'>";
                                    }else if(response[i].valoracion < 6.1){
                                        newRows += "<img src='/img/star.png' height='15' width='15'><img src='/img/star.png' height='15' width='15'><img src='/img/star.png' height='15' width='15'><img src='/img/star2.png' height='15' width='15'><img src='/img/star2.png' height='15' width='15'>";
                                    }else if(response[i].valoracion < 8.1){
                                        newRows += "<img src='/img/star.png' height='15' width='15'><img src='/img/star.png' height='15' width='15'><img src='/img/star.png' height='15' width='15'><img src='/img/star.png' height='15' width='15'><img src='/img/star2.png' height='15' width='15'>";
                                    }else{
                                        newRows += "<img src='/img/star.png' height='15' width='15'><img src='/img/star.png' height='15' width='15'><img src='/img/star.png' height='15' width='15'><img src='/img/star.png' height='15' width='15'><img src='/img/star.png' height='15' width='15'>";
                                    }

                                newRows +="<div class='input-group'><small class='mr-2'>"+response[i].descripcion+"</small> </div></div></div></div></div>";

                        }

                        $('#contenedorLista').append(newRows);
                    }
                }
            });

        }

    })
</script>
