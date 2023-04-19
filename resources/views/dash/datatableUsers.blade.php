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
   