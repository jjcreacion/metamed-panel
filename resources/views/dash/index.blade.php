
@php    
use Illuminate\Support\Collection;
$usersfinal = collect($usersfb);
$usersarray = json_decode($usersfinal, true);

$cont = 1;

@endphp

@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard Metamed</h1>
@stop

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

<table id="tableUsers" class="table table-striped" style="width:100%">
    <thead>
        <tr>
            <td>Nº</td>
            <td>USUARIO</td>
            <td>REGISTRO</td>
            <td>ACCIONES</td>
        </tr>        
    </thead>
    <tbody>
        @foreach($usersarray as $key => $data)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $data["email"] }}</td>
                <td>{{ $data["metadata"]["createdAt"]["date"] }}</td>
                <td>
                <nobr>
                <button class="btn btn-xs btn-default text-primary mx-1 shadow" id='{{ $data["uid"] }}' onclick="cargarDatos(this.id)" title="Edit" data-toggle="modal" data-target="#modalEdit">
                <i class="fa fa-lg fa-fw fa-pen"></i></button>
                <button class="btn btn-xs btn-default text-danger mx-1 shadow" id='{{ $data["email"] }}' onclick="confirmar(this.id)" title="Delete" data-toggle="modal" >
                <i class="fa fa-lg fa-fw fa-trash"></i></button>
                <button class="btn btn-xs btn-default text-teal mx-1 shadow" id='{{ $data["uid"] }}' onclick="mostrarDatos(this.id)" title="Details">
                <i class="fa fa-lg fa-fw fa-eye"></i></button>  
                </nobr>
            </tr>
        @endforeach
    </tbody>
        <tfoot>
        <tr>
            <td>Nº</td>
            <td>USUARIO</td>
            <td>REGISTRO</td>
            <td>ACCIONES</td>
        </tr>      
        </tfoot>
    </table>   



<!-- Modal Editar -->
<div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
  <form>
   <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Editar Usuario</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <div class="form-group">
            <label for="exampleInputEmail1">UID</label>
            <input type="email" class="form-control" id="userEdit" aria-describedby="emailHelp" placeholder="Enter email" disabled>
        </div>
        <div class="form-group">    
            <label for="exampleInputEmail1">Email/Teléfono</label>
            <input type="email" class="form-control" id="email" aria-describedby="emailHelp" placeholder="Enter email"  required>
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">Contraseña</label>
            <input type="password" class="form-control" id="password" placeholder="Password"  required>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" onclick="editar()">Guardar Cambios</button>
      </div>
    </div>
    </form>
  </div>
</div>    

<!-- Modal Eliminar -->
<div class="modal fade" id="modalDelete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
  <form>
   <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Seguro que desea eliminar el siguiente usuario?</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
            <label for="exampleInputEmail1">Email/Teléfono</label>
            <input type="email" class="form-control" id="userDelete" aria-describedby="emailHelp" disabled>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-danger" onclick="eliminar(this.id)" >Eliminar Usuario</button>
      </div>
    </div>
    </form>
  </div>
</div>    

@stop

@section('js')
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
        
        $(document).ready(function () {
          
          $('#tableUsers').DataTable({
            "ajax":{
              "url":"/allusers",
              "dataSrc":"",
            },
            "columns":[

            ]
          });
          
          $('#tableUsers').DataTable();

          $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
          });

        });

        mostrarDatos(id){
          location.href="mostrardatos/"+id;
        }

        function confirmar(user) {
          var ModalEdit = new bootstrap.Modal(modalDelete, {}).show();
          $('#userDelete').val(user);
        }

        function cargarDatos(user) {
          $('#userEdit').val(user);
          $('#email').val('');
          $("#password").val('');
          var ModalEdit = new bootstrap.Modal(modalEdit, {}).show();
         
          $.ajax({
            type:'POST',
            url:'/getuser',
            data: { id: user },
            dataType: "JSON",
            success: function (data) {
                $('#email').val(data.email);
                $("#password").val('1234567890');
            },
            });

       }
       
       function editar(){
        
        let id = $('#userEdit').val();
        let email = $('#email').val();
        let password = $('#password').val();

        $.ajax({
            type:'POST',
            url:'/updateuser',
            data: { id: id, email: email, password: password},
            }).done(function(res){
             
              $("#modalEdit .close").click()
              if(res){
                swal({
                  icon: "success", 
                  title: "Usuario actualizado con éxito!",
                  timer: 3000
                });
                location.reload();
              }
              else{
                swal({
                  icon: "error", 
                  title: "Error al actualizar usuario...",
                  timer: 3000
                });
              }
            

            });
       }

        function eliminar(){
          let temp = $('#userDelete').val(); 
        
          $.ajax({
            type:'POST',
            url:'/deleteuser',
            data: { email: temp },
            }).done(function(res){
              
              $("#modalDelete .close").click()
              if(res){
                swal({
                  icon: "success", 
                  title: "Usuario eliminado con éxito!",
                  timer: 3000
                });
                location.reload();
              }
              else{
                swal({
                  icon: "error", 
                  title: "Error en eliminar usuario...",
                  timer: 3000
                });
              }
            
            });
        }
    </script>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
@stop