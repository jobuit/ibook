@extends('layouts.app')
@include('nav')
@section('content')
<div class="container p-3">
    <div class="container-fluid mb-4">
        <div class="row">
            <div class="d-flex justify-content-end">
                <input type="text" class="form-control mr-2" name="busqueda" id="txtBuscar" value="" style="width: 300px;" placeholder="Busca por autor, titulo, tema..">
                <button type="button" name="" id="buscar" class="btn btn-primary">Buscar</button>
                @if(Auth::user()->account=='admin')
                    <button type="button" click="agregar" id="agregar" class="btn btn-primary ml-3">Agregar libro</button>
                @endif
            </div>
            <div class="col-md-6">
                @if(Auth::user()->account=='admin')
                    <h3 class="mt-2 text-right"><b>Modulo administrador</b></h3>
                @else
                    <i><h6 class="mt-2 text-right">(Recuerda que solo puedes alquilar 3 libros)</h6></i>
                @endif

            </div>
        </div>
    </div>

    <!-- Modal editar-->
    <div class="modal fade" id="modalEditar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">iBook</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col text-center">
                                <img alt='profile Pic' height='250' width='200' id="imgModalEditar">
                            </div>
                            <div class="col">
                                <form method="POST" action="{{ route('updateLibro') }}" enctype="multipart/form-data">
                                    @csrf
                                <div class="input-group input-group-sm mb-1" style="display: none;">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="inputGroup-sizing-sm">Id libro</span>
                                    </div>
                                    <input id="idLibroModalEditar" name="idLibroModalEditar" type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
                                </div>
                                    <div class="input-group input-group-sm mb-1" style="width: 50px;">
                                        <input type="file" id="imgLibro" name="imgLibro">
                                    </div>
                                <div class="input-group input-group-sm mb-1">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="inputGroup-sizing-sm">Id autor</span>
                                    </div>
                                    <input id="idAutorModalEditar" name="idAutorModalEditar" type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
                                </div>
                                <div class="input-group input-group-sm mb-1">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="inputGroup-sizing-sm">Titulo</span>
                                    </div>
                                    <input id="tituloModalEditar" name="tituloModalEditar" type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
                                </div>
                                <div class="input-group input-group-sm mb-1">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="inputGroup-sizing-sm">Tema</span>
                                    </div>
                                    <input id="temaModalEditar" name="temaModalEditar" type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
                                </div>
                                <div class="input-group input-group-sm mb-1">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="inputGroup-sizing-sm">Cantidad</span>
                                    </div>
                                    <input id="cantidadModalEditar" name="cantidadModalEditar" type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
                                </div>
                                <div class="input-group input-group-sm mb-1">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="inputGroup-sizing-sm">Precio</span>
                                    </div>
                                    <input id="precioModalEditar" name="precioModalEditar" type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
                                </div>
                                <div class="form-group">
                                    <label for="descripcionModalEditar" class="m-0 p-0">Descripcion:</label>
                                    <textarea id="descripcionModalEditar" name="descripcionModalEditar" class="form-control" rows="4"></textarea>
                                </div>
                                    <button type="submit" class="btn btn-primary" id="agregarLibro">
                                        {{ __('Actualizar') }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Alquilar-->
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


                        <div class="row m-3">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">Fecha de recibida</span>
                                </div>
                                <input type="date" id="fechaRecibida" class="form-control" aria-label="Username" aria-describedby="basic-addon1">
                            </div>

                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">Fecha de entrega</span>
                                </div>
                                <input type="date" id="fechaEntrega" class="form-control" aria-label="Username" aria-describedby="basic-addon1">
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

    <!-- Modal Autor-->
    <div class="modal fade" id="modalAutor" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">Autor</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col text-center">
                                <img alt='profile Pic' height='150' width='150' id="imgModalAutor">

                                <div class="row m-3" id="row_estrellas">
                                    <p class='p-0 m-0'>Califica este autor: </p>

                                </div>
                            </div>
                            <div class="col">
                                <p id="nombreModalAutor" class="m-0 p-0"></p>
                                <p id="telefonoModalAutor" class="m-0 p-0"></p>
                                <p id="correoModalAutor" class="m-0 p-0"></p>
                                <p id="descripcionModalAutor" class="m-0 p-0"></p>
                            </div>
                        </div>

                    </div>
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

        var idBook='';
        var idUser='<?php echo \Auth::user()->id?>';

        $("#buscar").on("click", function() {

            var txt = $('#txtBuscar').val();
            BuscarLibros(txt);

        });

        $("#agregar").on("click", function() {
            $("#modalEditar").modal();
            $("#agregarLibro").html('Agregar');

            $("#idLibroModalEditar").val("");
            $("#idAutorModalEditar").val("");
            $("#imgModalEditar").attr("src","/img/add_book.png");
            $("#tituloModalEditar").val("");
            $("#descripcionModalEditar").html("");
            $("#temaModalEditar").val("");
            $("#cantidadModalEditar").val("");
            $("#precioModalEditar").val("");
        });

        $("#alquilarButton").on("click", function() {

            var fechaEntrega= $("#fechaEntrega").val();
            var fechaRecibida= $("#fechaRecibida").val();

            if(fechaEntrega!=="" && fechaRecibida!==""){
                $.ajax({
                    url:"{{route('alquilarLibro')}}",
                    method:"get",
                    data:{idUser:idUser,idBook:idBook,fechaEntrega:fechaEntrega,fechaRecibida:fechaRecibida},
                    success:function(response)
                    {
                        location.reload();
                    }
                });
            }else{
                toastr.error("Debes llenar todos los campos");
            }

        });

        function Autor() {
            $("button").on("click", function() {
                var button = $(this).attr("click");
                if(button==='autor'){
                    var nomAutor = $(this).attr("id_autor");

                    $("#row_estrellas div").remove();

                    $.ajax({
                        url:"{{route('buscarAutor')}}",
                        method:"get",
                        data:{nomAutor:nomAutor},
                        success:function(response)
                        {
                            if($.trim(response)){
                                console.log(response);

                                $("#imgModalAutor").attr("src",response[0].imagen);
                                $("#nombreModalAutor").html("<b>Nombre: </b>"+nomAutor);
                                $("#telefonoModalAutor").html("<b>Telefono: </b>"+response[0].telefono);
                                $("#correoModalAutor").html("<b>Correo: </b>"+response[0].correo);
                                $("#descripcionModalAutor").html(response[0].descripcion)
                                $("#modalAutor").modal();

                                var newRows="<div>";
                                if(response[0].valoracion < 2.1){
                                    newRows += "<a click='valorar' href='javascript:void(0);'><img src='/img/star.png' height='25' width='25'><img src='/img/star2.png' height='25' width='25'><img src='/img/star2.png' height='25' width='25'><img src='/img/star2.png' height='25' width='25'><img src='/img/star2.png' height='25' width='25'></a>";
                                }else if(response[0].valoracion < 4.1){
                                    newRows += "<a click='valorar' href='javascript:void(0);'><img src='/img/star.png' height='25' width='25'><img src='/img/star.png' height='25' width='25'><img src='/img/star2.png' height='25' width='25'><img src='/img/star2.png' height='25' width='25'><img src='/img/star2.png' height='25' width='25'></a>";
                                }else if(response[0].valoracion < 6.1){
                                    newRows += "<a click='valorar' href='javascript:void(0);'><img src='/img/star.png' height='25' width='25'><img src='/img/star.png' height='25' width='25'><img src='/img/star.png' height='25' width='25'><img src='/img/star2.png' height='25' width='25'><img src='/img/star2.png' height='25' width='25'></a>";
                                }else if(response[0].valoracion < 8.1){
                                    newRows += "<a click='valorar' href='javascript:void(0);'><img src='/img/star.png' height='25' width='25'><img src='/img/star.png' height='25' width='25'><img src='/img/star.png' height='25' width='25'><img src='/img/star.png' height='25' width='25'><img src='/img/star2.png' height='25' width='25'></a>";
                                }else{
                                    newRows += "<a click='valorar' href='javascript:void(0);'><img src='/img/star.png' height='25' width='25'><img src='/img/star.png' height='25' width='25'><img src='/img/star.png' height='25' width='25'><img src='/img/star.png' height='25' width='25'><img src='/img/star.png' height='25' width='25'></a>";
                                }
                                newRows += "</div>";

                                $('#row_estrellas').append(newRows);
                            }

                        }
                    });

                }
            });
        }

        function Alquilar() {
            $("a").on("click", function() {
                var button = $(this).attr("click");
                if(button==='alquilar'){
                    idBook = $(this).attr("book_id");
                    var idTitulo = $(this).attr("book_title");
                    var idDescripcion = $(this).attr("book_descripcion");
                    var idImagen = $(this).attr("book_imagen");
                    var idPrecio = parseInt($(this).attr("book_precio"), 10);
                    var idTema = $(this).attr("book_tema");

                    $("#imgModal").attr("src",idImagen);
                    $("#tituloModal").html("<b>Titulo: </b>"+idTitulo);
                    $("#descripcionModal").html("<b>Descripcion: </b>"+idDescripcion);
                    $("#temaModal").html("<b>Tema: </b>"+idTema);
                    $("#precioModal").html("<b>Precio: </b> $"+Number(idPrecio.toFixed(1)).toLocaleString());
                    $("#modalAlquilar").modal();



                }else if(button==='valorar'){
                    toastr.success("Tu valoracion fue añadida.");
                }else if(button==='eliminar'){
                    idBook = $(this).attr("book_id");
                    $.ajax({
                        url:"{{route('eliminarLibro')}}",
                        method:"get",
                        data:{idBook:idBook},
                        success:function(response)
                        {
                            $("#book"+response).remove();
                            toastr.error("Libro eliminado correctamente.");
                        }
                    });
                }else if(button==='editar'){
                    $("#agregarLibro").html('Actualizar');

                    idBook = $(this).attr("book_id");
                    var idTitulo = $(this).attr("book_title");
                    var idDescripcion = $(this).attr("book_descripcion");
                    var idImagen = $(this).attr("book_imagen");
                    var idPrecio = parseInt($(this).attr("book_precio"), 10);
                    var idTema = $(this).attr("book_tema");
                    var idCantidad = $(this).attr("book_cantidad");
                    var idAutor= $(this).attr("book_autor_id");

                    $("#idLibroModalEditar").val(idBook);
                    $("#idAutorModalEditar").val(idAutor);
                    $("#imgModalEditar").attr("src",idImagen);
                    $("#tituloModalEditar").val(idTitulo);
                    $("#descripcionModalEditar").html(idDescripcion);
                    $("#temaModalEditar").val(idTema);
                    $("#cantidadModalEditar").val(idCantidad);
                    $("#precioModalEditar").val(idPrecio);
                    $("#modalEditar").modal();
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
                method:"get",
                data:{buscar:txt},
                success:function(response)
                {
                    if($.trim(response)){
                        var newRows = "";

                        if('<?php echo Auth::user()->account ?>' !== 'admin'){
                            var puedeAlquilar='<?php echo Auth::user()->num_reservas; ?>' < 3;
                            if(!puedeAlquilar){
                                $('#contenedorLista').append("<div style='width: 100%;' class='input-group ml-3'><p class='font-weight-bold p-2' style='background: red; color: white;'>Ya no puedes alquilar mas libros...</p></div>");
                            }
                        }

                        for (var i = 0; i < response.length; i++) {

                            newRows += "<div id='book"+response[i].id+"' class='col m-2' style='max-width: 270px;'><div class='card'>";

                            if('<?php echo Auth::user()->account ?>' === 'admin'){
                                newRows+="<a click='editar' book_id='"+response[i].id+"' book_autor_id='"+response[i].autor_id+"' book_title='"+response[i].titulo+"' book_tema='"+response[i].tema+"' book_descripcion='"+response[i].descripcion+"' book_imagen='"+response[i].imagen+"' book_precio='"+response[i].precio+"' book_cantidad='"+response[i].cantidad+"' class='p-2' href='javascript:void(0);' style='background: #569dff; position: absolute; border-radius: 50%; right: 2px; top: 2px; box-shadow: 3px 3px 3px #888888;'><img src='/img/edit.png' height='20' width='20'></a>"
                                newRows+="<a click='eliminar' book_id='"+response[i].id+"' class='p-2' href='javascript:void(0);' style='background: #ff3f3a; position: absolute; border-radius: 50%; right: 2px; top: 42px; box-shadow: 3px 3px 3px #888888;'><img src='/img/delete.png' height='20' width='20'></a>"
                            }else{
                                if(puedeAlquilar){
                                    if(response[i].cantidad===0){
                                        newRows+="<div><p class='text-center font-weight-bold' style='color: white; position: absolute; top: 46%; width: 100%; background: rgb(255,0,0);'>AGOTADO</p></div>";
                                    }else{
                                        newRows+="<a click='alquilar' book_id='"+response[i].id+"' book_title='"+response[i].titulo+"' book_tema='"+response[i].tema+"' book_descripcion='"+response[i].descripcion+"' book_imagen='"+response[i].imagen+"' book_precio='"+response[i].precio+"' class='p-2' href='javascript:void(0);' style='background: #569dff; position: absolute; border-radius: 50%; right: 2px; top: 2px; box-shadow: 3px 3px 3px #888888;'><img src='/img/buy.png' height='20' width='20'></a>"
                                    }
                                }
                            }

                            newRows+="<div class='container'>" +
                                "<div class='input-group'><p class='text-center font-weight-bold m-1 p-0 mr-5' style='width: 100%; margin-right: 25px;'>"+response[i].titulo+"</p></div>" +
                                "<a href='"+response[i].imagen+"' data-lightbox='libros' data-title='"+response[i].titulo+"'>"+
                                    "<img src='"+response[i].imagen+"' alt='profile Pic' height='250' width='200'></a>"+
                                "<div class='input-group'><small class='mr-2' style='color: green;'>Precio: $"+Number(response[i].precio.toFixed(1)).toLocaleString()+"</small></div>"+
                                    "<div class='input-group'><small class='mr-2'> Autor: <button type='button' class='btn btn-link m-0 p-0 btn-sm' click='autor' id_autor='"+response[i].nombre+"'>"+response[i].nombre+"</button></small></div>"+
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
                        Autor();
                    }
                }
            });

        }

    })
</script>
