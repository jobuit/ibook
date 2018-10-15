@extends('layouts.app')
@include('nav')
@section('content')
    <div class="container p-3">

        <!-- Modal -->
        <div class="modal fade" id="modalAlquilar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalLabel">Retornar libro</h5>
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
                                    <p id="tituloModal" class="m-0 p-0"></p>
                                    <p id="temaModal" class="m-0 p-0"></p>
                                    <p id="descripcionModal" class="m-0 p-0"></p>
                                </div>
                            </div>


                            <div class="row m-3" id="row_estrellas">
                                <p class='align-self-center'>Califica este libro: </p>

                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-primary" id="retornarButton">Aceptar</button>
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

        var reservaId="";

        BuscarLibros();

        $("#retornarButton").on("click", function() {
            $.ajax({
                url:"{{route('retornarLibro')}}",
                method:"get",
                data:{reservaId:reservaId},
                success:function(response)
                {
                    location.reload();
                }
            });
        });

        function Valorar(){
            $("a").on("click", function() {
                var button = $(this).attr("click");
                if(button==='valorar'){
                    toastr.success("Tu valoracion fue añadida.");
                }
            });
        }

        function Retornar() {
            $("button").on("click", function() {

                var button = $(this).attr("click");
                if(button==='retornar'){
                    $("#row_estrellas div").remove();

                    reservaId = $(this).attr("reserva_id");
                    var idTitulo = $(this).attr("book_title");
                    var idDescripcion = $(this).attr("book_descripcion");
                    var idImagen = $(this).attr("book_imagen");
                    var idTema = $(this).attr("book_tema");
                    var valoracion = parseInt($(this).attr("book_valoracion"), 10);

                    $("#imgModal").attr("src",idImagen);
                    $("#tituloModal").html("<b>Titulo: </b>"+idTitulo);
                    $("#descripcionModal").html("<b>Descripcion: </b>"+idDescripcion);
                    $("#temaModal").html("<b>Tema: </b>"+idTema);


                    var newRows="<div>";
                    if(valoracion < 2.1){
                        newRows += "<a click='valorar' href='javascript:void(0);'><img src='/img/star.png' height='25' width='25'><img src='/img/star2.png' height='25' width='25'><img src='/img/star2.png' height='25' width='25'><img src='/img/star2.png' height='25' width='25'><img src='/img/star2.png' height='25' width='25'></a>";
                    }else if(valoracion < 4.1){
                        newRows += "<a click='valorar' href='javascript:void(0);'><img src='/img/star.png' height='25' width='25'><img src='/img/star.png' height='25' width='25'><img src='/img/star2.png' height='25' width='25'><img src='/img/star2.png' height='25' width='25'><img src='/img/star2.png' height='25' width='25'></a>";
                    }else if(valoracion < 6.1){
                        newRows += "<a click='valorar' href='javascript:void(0);'><img src='/img/star.png' height='25' width='25'><img src='/img/star.png' height='25' width='25'><img src='/img/star.png' height='25' width='25'><img src='/img/star2.png' height='25' width='25'><img src='/img/star2.png' height='25' width='25'></a>";
                    }else if(valoracion < 8.1){
                        newRows += "<a click='valorar' href='javascript:void(0);'><img src='/img/star.png' height='25' width='25'><img src='/img/star.png' height='25' width='25'><img src='/img/star.png' height='25' width='25'><img src='/img/star.png' height='25' width='25'><img src='/img/star2.png' height='25' width='25'></a>";
                    }else{
                        newRows += "<a click='valorar' href='javascript:void(0);'><img src='/img/star.png' height='25' width='25'><img src='/img/star.png' height='25' width='25'><img src='/img/star.png' height='25' width='25'><img src='/img/star.png' height='25' width='25'><img src='/img/star.png' height='25' width='25'></a>";
                    }
                    newRows += "</div>";

                    $('#row_estrellas').append(newRows);

                    $("#modalAlquilar").modal();

                    Valorar();
                }

            });
        }

        function BuscarLibros() {

            $("#contenedorLista div").remove();

            $.ajax({
                url:"{{route('buscarAlquilados')}}",
                method:"get",
                data:{buscar:""},
                success:function(response)
                {

                    if($.trim(response)){
                        var newRows = "";

                        for (var i = 0; i < response.length; i++) {

                            newRows += "<div class='col m-2' style='max-width: 270px;'><div class='card'>" +
                                "<div class='input-group text-center' ><small class='mr-2 text-center' style='width: 100%;'>Fecha de reserva: "+response[i].created_at+"</small></div>"+
                                "<div class='input-group'><small class='mr-2 text-center' style='width: 100%;'>Fecha de entrega: "+response[i].fecha_entrega+"</small></div>";

                            newRows+="<div class='container'>" +
                                "<div class='input-group'><p class='text-center font-weight-bold m-1 p-0 mr-5' style='width: 100%; margin-right: 25px;'>"+response[i].titulo+"</p></div>" +
                                "<a href='"+response[i].imagen+"' data-lightbox='libros' data-title='"+response[i].titulo+"'>"+
                                "<img src='"+response[i].imagen+"' alt='profile Pic' height='250' width='200'></a>"+
                                "<div class='input-group'><small class='mr-2' style='color: green;'>Precio: $"+Number(response[i].precio.toFixed(1)).toLocaleString()+"</small></div>"+
                                "<div class='input-group'><small class='mr-2'>Tema: "+response[i].tema+"</small></div>"+
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

                            newRows += "<button click='retornar' type='button' class='btn btn-primary btn-sm btn-block m-2' reserva_id='"+response[i].id+"' book_title='"+response[i].titulo+"' book_tema='"+response[i].tema+"' book_descripcion='"+response[i].descripcion+"' book_imagen='"+response[i].imagen+"' book_valoracion='"+response[i].valoracion+"'>Retornar libro</button></div></div></div></div>";

                        }

                        $('#contenedorLista').append(newRows);

                        Retornar();

                    }
                }
            });

        }

    })
</script>
