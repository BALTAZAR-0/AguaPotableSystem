$('#formInicioDni').submit(function(e){
	e.preventDefault();
	var datos = new FormData($('#formInicioDni')[0]);
	$.ajax({
		url: "ajax/inicio.ajax.php",
		method: "post",
		data: datos,
		contentType: false,
		processData: false,
		dataType: 'json',
		success: function(res){
			console.log(res);
			if(res.status == "success"){
				window.location = "servicio";
			}else {
				swal({
						  type: "error",
						  title: "¡No se encontro un usuario con este DPI!",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
							if (result.value) {

							window.location = "inicio";

							}
						})
			}
		}
	})

})