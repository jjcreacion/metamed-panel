
@php    
use Illuminate\Support\Collection;
$usersfinal = collect($usersfb);
$usersarray = json_decode($usersfinal, true);



$heads = [
    'ID',
    'Name',
    ['label' => 'Created', 'width' => 40],
    ['label' => 'Actions', 'no-export' => true, 'width' => 5],
];

$cont = 1;

@endphp

@php        
$config['dom'] = '<"row" <"col-sm-7" B> <"col-sm-5 d-flex justify-content-end" i> >
                  <"row" <"col-12" tr> >
                  <"row" <"col-sm-12 d-flex justify-content-start" f> >';
$config['paging'] = false;
$config["lengthMenu"] = [ 10, 50, 100, 500];
@endphp


@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard Metamed</h1>
@stop

@section('content')

<x-adminlte-datatable id="table1" :heads="$heads">
    @foreach($usersarray as $key => $data)
        <tr>
            <td>{{ $key + 1 }}</td>
            <td>{{ $data["email"] }}</td>
            <td>{{ $data["metadata"]["createdAt"]["date"] }}</td>
            <td>
            <nobr>
            <button class="btn btn-xs btn-default text-primary mx-1 shadow" title="Edit">
            <i class="fa fa-lg fa-fw fa-pen"></i></button>
            <button class="btn btn-xs btn-default text-danger mx-1 shadow" title="Delete">
            <i class="fa fa-lg fa-fw fa-trash"></i></button>
            <button class="btn btn-xs btn-default text-teal mx-1 shadow" title="Details">
            <i class="fa fa-lg fa-fw fa-eye"></i></button>  
            </nobr>
        </tr>
    @endforeach
</x-adminlte-datatable>


<x-adminlte-datatable id="table8" :heads="$heads" head-theme="dark" class="bg-teal" :config="$config"
    striped hoverable with-buttons/>

@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop