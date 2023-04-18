
@php    
use Illuminate\Support\Collection;
$id = collect($id);


@endphp

@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Datos del usuario</h1>
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
                <button class="btn btn-xs btn-default text-teal mx-1 shadow" title="Details">
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


@stop

@section('js')
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>    
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
@stop