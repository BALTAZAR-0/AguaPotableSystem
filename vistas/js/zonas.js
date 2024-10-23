$('.table').on("click", ".btnEditarZona", function(){
	var idZona = $(this).attr('idZona');
	var nombreZona = $(this).attr('nombreZona');
	$('#editarIdZona').val(idZona);
	$('#editarNombre').val(nombreZona);
})

$('.table').on("click", ".btnEliminarZona", function(){
	var datos = $(this).attr('idZona');
	
	swal({
        title: '¿Está seguro de borrar la zona?',
        text: "¡Si no lo está puede cancelar la acción!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Si, borrar cliente!'
      }).then(function(result){
        if (result.value) {
          
            window.location = "index.php?ruta=zonas&idZona="+datos;
        }

  })

	/*

	 $.ajax({

	      url:"ajax/zonas.ajax.php",
	      method: "POST",
	      data: datos,
	      cache: false,
	      contentType: false,
	      processData: false,
	      dataType:"json",
	      success:function(respuesta){
	      }
  	});*/
})