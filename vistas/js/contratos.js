$("#generarcronograma").on('click', function(event) {
	event.preventDefault();

	let valor = $("#nuevoValorServicio").val();
	let desc = $("#nuevoDecripcionServ").val();

	const meses = $("#nuevoMeses").val() -1;

	
	//let nfecha = f.getFullYear() + "-" + (f.getMonth() +3) + "-" +f.getDate();

	//Esta es para qque genere el cronograma de pago del dia la contrata + 1
	//<td>${f.getFullYear() + "-" + (f.getMonth() +1) + "-" +f.getDate()}</td>


	
	let concepto = "";
	console.log(meses);
	//Esta es como estaba
	//for (var i = 1; i <= meses; i++) {
	for (var i = 0; i <= meses; i++) {	
		console.log(i);
		var f = new Date();
		f.setMonth(f.getMonth()+i);
		concepto += `<tr id="fila">
					<td>${i+1}</td>
					<td>${valor}</td>
					<td>${desc}</td>
					<td>${f.getFullYear() + "-" + ("0" + (f.getMonth() +1)).slice(-2) + "-" + ("0" + (f.getDate(),1)).slice(-2)}</td>
					<td><span class="badge bg" style="background-color: #00a65a;">Activado</span></td>
				</tr>`;
	}
	console.log("msg");
	
	$("#tablebody").empty();			

	$(".vistaCronograma").append(concepto);		
});



$(".d").click(function() {
  $("#modalEditarContrato").modal("show");

});


$(".btnEditarPersona").on('click', function(event) {
	event.preventDefault();
	var idserviciosCobro = $(this).attr("idservicios");
    

    var datos = new FormData();
    datos.append("idserviciosCobro", idserviciosCobro);


    $.ajax({
    	url:"ajax/contratos.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      dataType:"json",
    })
    .done(function(response) {
    	console.log(response);
    	var count = 1;
    	var estado = "";
    	$("#tablebody1").empty();
    	$.each(response, function(index, val) {
    			if (val["estado"] == 0){
    				estado = "<span class='badge bg-yellow'>Pendiente</span>";
    			}else if (val["estado"] == 1){
    				estado = "<span class='badge bg-green'>Pagado</span>";
    			}else if (val["estado"] == 2) {
    				estado = "<span class='badge bg-red'>Vencido</span>";
    			}
              $(".tablaContratos").append(`<tr id="fila">
					<td>${count}</td>
					<td>${val["fechas_pagos"]}</td>
					<td>${val["monto"]}</td>
					<td>${estado}</td>	
				</tr>

              	`);
              count++;
         });
    	$("#modalEditarContrato").modal("show");


    })
    .fail(function() {
    	console.log("error");
    })
    .always(function() {
    	console.log("complete");
    });
    
});






	
	
	$(".tablas").on("click", ".btnGenerarCobro", function(){
		//$(".btnEliminarContrato").on('click', function(event) {
			event.preventDefault();
			var idserviciosCobro = $(this).attr("idservicios");
			var idpersonas = $(this).attr("idserviciosPer");

			
			$('#codigoRecibo').attr('value', idserviciosCobro)
			$('#idpersona').attr('value', idpersonas)
			//console.log(idserviciosCobro);
			var datos = new FormData();
			datos.append("codigo", idserviciosCobro);

			$.ajax({

				url:"ajax/contratos.ajax.php",
				method: "POST",
				data: datos,
				cache: false,
				contentType: false,
				processData: false,
				dataType:"json",
				success:function(respuesta){
					$("#lecturaMedidoranterior").val(respuesta["totalM3"]);

					//console.log(respuesta["totalM3"]);
				}

			});
			
				
			
		});
	

























$(".tablas").on("click", ".btnEliminarContrato", function(){
//$(".btnEliminarContrato").on('click', function(event) {
	event.preventDefault();
	var idserviciosCobro = $(this).attr("idservicios");    
console.log(idserviciosCobro);
    var datos = new FormData();
    datos.append("idserviciosEliminar", idserviciosCobro);
	
    swal({
		
		text: "Desea eliminar el contrato? No se podra recuperar.",
		type: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Eliminar'
	}).then((result) => {
		if (result.value) {

			$.ajax({
		    	url:"ajax/contratos.ajax.php",
		      method: "POST",
		      data: datos,
		      cache: false,
		      contentType: false,
		      processData: false,
		      dataType:"json",
		    })
		    .done(function(response) {
		    	console.log(response);
		    	if(response == "ok"){
					swal({
						type: "success",
						title: "La lectura ha sido eliminado",
						showConfirmButton: true,
						confirmButtonText: "Cerrar"
						}).then(function(result){
							if (result.value) {
								window.location = "contratos";

										}
						});

				}else if (response == "error") {
					swal({
						type: "error",
						title: "La lectura no puede ser eliminado",
						showConfirmButton: true,
						confirmButtonText: "Cerrar"
						}).then(function(result){
							if (result.value) {


										}
						});
				}	    

		    })
		    .fail(function() {
		    	console.log("error");
		    })
		    .always(function() {
		    	console.log("complete");
		    });

								    
			}
	})    	
    
});


$(".tablas").on("click", ".btnDetalleContrato", function(){
//$(".btnDetalleContrato").click(function(event) {
  event.preventDefault();
  var idservicios = $(this).attr('idservicios');

  $.ajax({
    url: 'ajax/contratos.ajax.php',
    type: 'POST',
    dataType: 'json',
    data: {"editarServicio": idservicios},
  })
  .done(function(success) {
    //console.log("aqui ",success);

    detalleContrato(success);
  })
  .fail(function() {
    console.log("error");
  })
  .always(function() {
    console.log("complete");
  });
  



});


function detalleContrato(response) {
  
    $.ajax({
      url: 'vistas/modulos/proceso.php',
      type: 'POST',
      data: {"arregloD": JSON.stringify(response)},
      success: function() {
        //console.log(response)
        window.location.href = "detalle-contrato";
      },
      error: function(error) {
        console.log("error");
      },
    })
  
}


/*=============================================
IMPRIMIR ESTADO DE CUENTA
=============================================*/

$(".tablas").on("click", ".btnImprimirEstado", function(){

	var idservicios = $(this).attr("idservicio");

	window.open("extensiones/tcpdf1/pdf/detalle-contratos.php?id="+idservicios, "_blank");

});

//imprimir recibo de pago
$(document).on("click", ".btnImprimirRecibo", function(e){

	var idrecibo = $(this).attr("idrecibo");

	window.open("extensiones/tcpdf1/pdf/recibo-pago.php?idrecibo="+idrecibo, "_blank");

});

$(".reportePDF").on('click', function(event) {
	event.preventDefault();

	let estadoServicios = $("#estadoServicio").val();
	let zonaServicios = $("#zonaServicio").val();

	window.open("extensiones/tcpdf1/pdf/servicios-cuentas.php?estado="+estadoServicios+"&zona="+zonaServicios, "_blank");
	
});














//////////// jaime




// $(".tablas").on("click", ".btnGenerarCobro", function(){
// 	//$(".btnEliminarContrato").on('click', function(event) {
// 		//event.preventDefault();
// 		var idserviciosCobro = $(this).attr("idservicios");    
// 	console.log(idserviciosCobro);
// 		var datos = new FormData();
// 		datos.append("idserviciosEliminar", idserviciosCobro);
		
// 		swal({
			
// 			text: "Desea eliminar el contrato? No se podra recuperar.",
// 			type: 'warning',
// 			showCancelButton: true,
// 			confirmButtonColor: '#3085d6',
// 			cancelButtonColor: '#d33',
// 			confirmButtonText: 'Eliminar'
// 		}).then((result) => {
// 			if (result.value) {
	
// 				$.ajax({
// 					url:"ajax/contratos.ajax.php",
// 				  method: "POST",
// 				  data: datos,
// 				  cache: false,
// 				  contentType: false,
// 				  processData: false,
// 				  dataType:"json",
// 				})
// 				.done(function(response) {
// 					console.log(response);
// 					if(response == "ok"){
// 						swal({
// 							type: "success",
// 							title: "La lectura ha sido eliminado",
// 							showConfirmButton: true,
// 							confirmButtonText: "Cerrar"
// 							}).then(function(result){
// 								if (result.value) {
// 									window.location = "contratos";
	
// 											}
// 							});
	
// 					}else if (response == "error") {
// 						swal({
// 							type: "error",
// 							title: "La lectura no puede ser eliminado",
// 							showConfirmButton: true,
// 							confirmButtonText: "Cerrar"
// 							}).then(function(result){
// 								if (result.value) {
	
	
// 											}
// 							});
// 					}	    
	
// 				})
// 				.fail(function() {
// 					console.log("error");
// 				})
// 				.always(function() {
// 					console.log("complete");
// 				});
	
										
// 				}
// 		})    	
		
// 	});
	



// $(".tablas").on("click", ".btngenerarCobro", function(){
// 	//$(".btnDetalleContrato").click(function(event) {
// 	  event.preventDefault();
// 	  var idservicios = $(this).attr('idservicios');
// 	console.log(idservicios);
	
	
	
	
// 	});