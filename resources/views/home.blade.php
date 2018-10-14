@extends('layouts.app')
@include('nav')
@section('content')
<div class="container p-3">
    <div class="container-fluid mb-4">
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

    <!-- Modal -->
    <div class="modal fade" id="modalAlquilar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">Alquilar libro</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col text-center">
                                <img alt='profile Pic' height='250' width='200' id="imgModal">
                            </div>
                            <div class="col">
                                <p id="precioModal" style="color: green;" class="text-right"></p>
                                <p id="tituloModal" class="m-0 p-0"></p>
                                <p id="temaModal" class="m-0 p-0"></p>
                                <p id="descripcionModal" class="m-0 p-0"></p>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" id="alquilarButton">Aceptar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="row" id="contenedorLista">

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

        $("#alquilarButton").on("click", function() {



        });

        function Alquilar() {
            $("a").on("click", function() {
                var button = $(this).attr("click");
                if(button==='alquilar'){
                    var idBook = $(this).attr("book_id");
                    var idTitulo = $(this).attr("book_title");
                    var idDescripcion = $(this).attr("book_descripcion");
                    var idImagen = $(this).attr("book_imagen");
                    var idPrecio = parseInt($(this).attr("book_precio"), 10);
                    var idTema = $(this).attr("book_tema");
                    console.log(idImagen+"->"+'<?php echo \Auth::user()->id?>');

                    $("#imgModal").attr("src",idImagen);
                    $("#tituloModal").html("<b>Titulo: </b>"+idTitulo);
                    $("#descripcionModal").html("<b>Descripcion: </b>"+idDescripcion);
                    $("#temaModal").html("<b>Tema: </b>"+idTema);
                    $("#precioModal").html("<b>Precio: </b> $"+Number(idPrecio.toFixed(1)).toLocaleString());
                    $("#modalAlquilar").modal();

                }else if(button==='valorar'){
                    toastr.success("Tu valoracion fue añadida.");
                }
            });
        }

        function BuscarLibros(txt) {

            /*toastr.success("success");
            toastr.warning("warining");
            toastr.info("info");
            toastr.error("error");*/

            $("#contenedorLista div").remove();

            $.ajax({
                url:"{{route('buscarLibros')}}",
                mehtod:"get",
                data:{buscar:txt},
                success:function(response)
                {
                    if($.trim(response)){
                        var newRows = "";

                        for (var i = 0; i < response.length; i++) {

                            newRows += "<div class='col m-2' style='max-width: 270px;'><div class='card'>";
                            if(response[i].cantidad===0){
                                newRows+="<div><p class='text-center font-weight-bold' style='color: white; position: absolute; top: 46%; width: 100%; background: rgb(255,0,0);'>AGOTADO</p></div>";
                            }else{
                                newRows+="<a click='alquilar' book_id='"+response[i].id+"' book_title='"+response[i].titulo+"' book_tema='"+response[i].tema+"' book_descripcion='"+response[i].descripcion+"' book_imagen='"+response[i].imagen+"' book_precio='"+response[i].precio+"' class='p-2' href='javascript:void(0);' style='background: #569dff; position: absolute; border-radius: 50%; right: 2px; top: 2px; box-shadow: 3px 3px 3px #888888;'><img src='/img/buy.png' height='25' width='25'></a>"
                            }
                            newRows+="<div class='container'>" +
                                "<div class='input-group'><p class='text-center font-weight-bold m-1 p-0 mr-5' style='width: 100%; margin-right: 25px;'>"+response[i].titulo+"</p></div>" +
                                "<a href='"+response[i].imagen+"' data-lightbox='libros' data-title='"+response[i].titulo+"'>"+
                                    "<img src='"+response[i].imagen+"' alt='profile Pic' height='250' width='200'></a>"+
                                "<div class='input-group'><small class='mr-2' style='color: green;'>Precio: $"+Number(response[i].precio.toFixed(1)).toLocaleString()+"</small></div>"+
                                    "<div class='input-group'><small class='mr-2'> Autor: <a href='#' >"+response[i].nombre+"</a></small></div>"+
                                    "<div class='input-group'><small class='mr-2'>Tema: "+response[i].tema+"</small></div>"+
                                    "<div class='input-group'><small class='mr-2'>Disponible: "+response[i].cantidad+"</small></div>"+
                                    "<div class='input-group'><small class='mr-2'>Puntuacion prom: "+response[i].valoracion+"</small>";
                                    if(response[i].valoracion < 2.1){
                                        newRows += "<a click='valorar' href='javascript:void(0);'><img src='/img/star.png' height='15' width='15'><img src='/img/star2.png' height='15' width='15'><img src='/img/star2.png' height='15' width='15'><img src='/img/star2.png' height='15' width='15'><img src='/img/star2.png' height='15' width='15'></a>";
                                    }else if(response[i].valoracion < 4.1){
                                        newRows += "<a click='valorar' href='javascript:void(0);'><img src='/img/star.png' height='15' width='15'><img src='/img/star.png' height='15' width='15'><img src='/img/star2.png' height='15' width='15'><img src='/img/star2.png' height='15' width='15'><img src='/img/star2.png' height='15' width='15'></a>";
                                    }else if(response[i].valoracion < 6.1){
                                        newRows += "<a click='valorar' href='javascript:void(0);'><img src='/img/star.png' height='15' width='15'><img src='/img/star.png' height='15' width='15'><img src='/img/star.png' height='15' width='15'><img src='/img/star2.png' height='15' width='15'><img src='/img/star2.png' height='15' width='15'></a>";
                                    }else if(response[i].valoracion < 8.1){
                                        newRows += "<a click='valorar' href='javascript:void(0);'><img src='/img/star.png' height='15' width='15'><img src='/img/star.png' height='15' width='15'><img src='/img/star.png' height='15' width='15'><img src='/img/star.png' height='15' width='15'><img src='/img/star2.png' height='15' width='15'></a>";
                                    }else{
                                        newRows += "<a click='valorar' href='javascript:void(0);'><img src='/img/star.png' height='15' width='15'><img src='/img/star.png' height='15' width='15'><img src='/img/star.png' height='15' width='15'><img src='/img/star.png' height='15' width='15'><img src='/img/star.png' height='15' width='15'></a>";
                                    }

                                newRows +="<div class='input-group'><small class='mr-2' style='overflow: hidden;text-overflow: ellipsis;display: -webkit-box;line-height: 16px; max-height: 47px;-webkit-line-clamp: 2;-webkit-box-orient: vertical;'>"+response[i].descripcion+"</small><small><a href='#'> ver mas</a></small></div></div></div></div></div>";

                        }

                        $('#contenedorLista').append(newRows);

                        Alquilar();
                    }
                }
            });

        }

    })
</script>
