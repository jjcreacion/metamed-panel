$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });

      $('#tableUsers').DataTable();    

  });


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