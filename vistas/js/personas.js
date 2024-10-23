/*=============================================
EDITAR PERSONA
=============================================*/
$(".tablas").on("click", ".btnEditarPersona", function(){

	var idPersona = $(this).attr("idPersona");

	var datos = new FormData();
    datos.append("idPersona", idPersona);

    $.ajax({

      url:"ajax/personas.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      dataType:"json",
      success:function(respuesta){

      
      	 $("#idpersona").val(respuesta["idpersona"]);	       
	       $("#editarNombres").val(respuesta["nombres"]);
	       $("#editarApellidoPaterno").val(respuesta["apaterno"]);
	       $("#editarApellidoMaterno").val(respuesta["amaterno"]);
         $("#editarDocumento").val(respuesta["documento"]);

         if(respuesta["sexo"] == "M"){
            $("#editarSexoM").iCheck('check');
         }else if (respuesta["sexo"] == "F") {
            $("#editarSexoF").iCheck('check');
         }   

         $("#editarFechaNacimiento").val(respuesta["fecha_nacimiento"]); 

         $("#editarTelefono").val(respuesta["telefono"]); 

         //$("#editarZona").html(respuesta["idZona"]);
         var zona = respuesta["idZona"];
          $("#editarZona option[value='"+ zona +"']").attr("selected",true);
          //$('#editarZona option:contains('+zona+')').attr('selected', true);
         //$("#editarZona").val(respuesta["idZona"]);

         $("#editarDireccion").val(respuesta["direccion"]);
         $("#editarEmail").val(respuesta["email"]);  

                 
	  }

  	})

})




/*=============================================
ELIMINAR PERSONA
=============================================*/
$(".tablas").on("click", ".btnEliminarPersona", function(){

	var idPersona = $(this).attr("idPersona");
	
	swal({
        title: '¿Está seguro de borrar el cliente?',
        text: "¡Si no lo está puede cancelar la acción!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Si, borrar cliente!'
      }).then(function(result){
        if (result.value) {
          
            window.location = "index.php?ruta=personas&idPersona="+idPersona;
        }

  })

})


/*=============================================
REVISAR SI LA PERSONA YA ESTÁ REGISTRADO
=============================================*/

$("#nuevoDocumento").change(function(){

  $(".alert").remove();

  var persona = $(this).val();

  var datos = new FormData();
  datos.append("validarPersona", persona);

   $.ajax({
      url:"ajax/personas.ajax.php",
      method:"POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json",
      success:function(respuesta){
        
        if(respuesta){

          $("#nuevoDocumento").parent().after('<div class="alert alert-warning">Este cliente ya existe en la base de datos</div>');

          $("#nuevoDocumento").val("");

        }

      }

  })
})


/*----------------------------------------
    Agregar clientes desde a ventana modal al Form
------------------------------------------*/

$("#cliente").click(function() {
  $("#modalAgregarPersona").modal("show");
  $("#modalAgregarPersona").attr('tipo', 'contrata');
});



$(".tablas").on('click', '.btnAgregarDatosContrato', function(event) {
  event.preventDefault();
  var idPersonaContrato = $(this).attr("idPersonaContrato");  
  var tipo = $("#modalAgregarPersona").attr("tipo");

  var datos = new FormData();
    datos.append("idPersonaContrato", idPersonaContrato);

    $.ajax({

      url:"ajax/personas.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      dataType:"json",
      success:function(respuesta){

        console.log(respuesta);

       
        if(tipo === "contrata"){

            $("#nuevoNombreCliente").val(respuesta["nombres"] +" "+ respuesta["apaterno"] +" "+ respuesta["amaterno"]);
            
            $("#modalAgregarPersona").modal('toggle');

            $("#nuevoDocumento").val(respuesta["documento"]);
            $("#numeroMedidor").val(respuesta["telefono"]);
            $("#idpersona").val(respuesta["idpersona"]);
            $("#nuevoDni").val(respuesta["documento"]);
            $("#nuevoCodigo").val(respuesta["fecha_nacimiento"]);
            


            /*
            $("#servicios").empty();
            $("#servicios").append('<option value="0">Seleccionar</option>'); 

            $.each(respuesta, function(index, val) {
              $("#servicios").append(`<option value=${val['idservicios']}>${val['codigo']} </option>`);
            });*/
           
               
       }
    }

    })

});
