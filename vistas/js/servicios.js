/*=============================================
EDITAR PERSONA
=============================================*/
$(".tablas").on("click", ".btnEditarServicio", function(){

	var idtipo_servicios = $(this).attr("idtipo_servicios");

	var datos = new FormData();
    datos.append("idtipo_servicios", idtipo_servicios);

    $.ajax({

      url:"ajax/servicios.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      dataType:"json",
      success:function(respuesta){

        //console.log(respuesta);
      
      	 $("#idtipo_servicios").val(respuesta["idtipo_servicios"]);	

	       $("#editarNombreServicio").val(respuesta["nombre"]);

         $("#editarTipoServicio").html(respuesta["descripcion"]);
         $("#editarTipoServicio").val(respuesta["descripcion"]);

	       $("#editarCatidadBolsas").val(respuesta["cantidad_bolsa"]);
	       $("#editarValorServicio").val(respuesta["valor_servicio"]);
                 
	  }

  	})

})




/*=============================================
ELIMINAR SERVIIO
=============================================*/
$(".tablas").on("click", ".btnEliminarServicio", function(){

	var idtipo_servicios = $(this).attr("idtipo_servicios");
	
	swal({
        title: '¿Está seguro de borrar el servicio?',
        text: "¡Si no lo está puede cancelar la acción!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Si, borrar servicio!'
      }).then(function(result){
        if (result.value) {
          
            window.location = "index.php?ruta=servicios&idtipo_servicios="+idtipo_servicios;
        }

  })

})




/*----------------------------------------
    Agregar servicios desde a ventana modal al Form
------------------------------------------*/

$("#servicio").click(function() {
  $("#modalAgregarServicio").modal("show");
  $("#modalAgregarServicio").attr('tipo', 'servicio');
});




$(".tablas").on('click', '.btnAgregarDatosS', function(event) {
  event.preventDefault();
  var idtipo_servicios = $(this).attr("idtipo_servicios");
  var tipo = $("#modalAgregarServicio").attr("tipo");

  let datos = new FormData();
    datos.append("idtipo_servicios", idtipo_servicios);

    $.ajax({

      url:"ajax/servicios.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      dataType:"json",
      success:function(respuesta){

        //console.log(respuesta);

        if(tipo === "servicio"){      
                      
            
            $("#nuevoTipoServicio").val(respuesta["nombre"]); 

            $("#modalAgregarServicio").modal('toggle');

            $("#nuevoDecripcionServ").val(respuesta["descripcion"]);
            $("#nuevoCantBolsa").val(respuesta["cantidad_bolsa"]);
            $("#nuevoValorServicio").val(`Q.${respuesta["valor_servicio"]}.00`);
            $("#idtipo_servicios").val(respuesta["idtipo_servicios"]);
           
               
       }
    }

    })

});

$("#tipoServicio").on('change', function(event) {
  event.preventDefault();

  //$("#estadoServicio").prop('selectedIndex',0);
  //$("#zonaServicio").prop('selectedIndex',0);

  let perfil = $("#perfilSession").val();

  let tipoServicios = $("#tipoServicio").val();
  let estadoServicios = $("#estadoServicio").val();
  let zonaServicios = $("#zonaServicio").val();
  
  let datos = new FormData();
  datos.append("tipoServicios", tipoServicios);
  datos.append("estadosServicios",estadoServicios);
  datos.append("zonaServicios",zonaServicios);

    $.ajax({
      url:"ajax/servicios.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      dataType:"json",
    })
    .done(function(response) {
      console.log(response);
      let filas = "";

      $.each(response, function(index, val) {
        
        let nombre = val["nombres"]+" "+val["apaterno"]+" "+val["amaterno"];
        let servicio = "";
        let estado = "";
        let controles = "";
        let idservicio = val["idservicios"];
        if (val["idtipo_servicios"] == 1) {
          servicio = "Domiciliar";
        }else{
          servicio = "Comercio";
        }

        if(val["estado"] == 0){
          estado = `<span class="badge bg-green">Pagado</span>`;
        }else if(val["estado"] == 1){
          estado = `<span class="badge bg-yellow">Pendiente</span>`;
        }else if(val["estado"] == 2){
          estado = `<span class="badge bg-black">Finalizado</span>`;          
        }

        controles = `<div> 
                      <button class="btn btn-info btnImprimirEstado" idservicios=${idservicio}>
                        <i class="fa fa-print"></i></button> 
                        <button class="btn btn-warning btnEditarPersona" idservicios=${idservicio}><i class="fa fa-eye"></i></button>
                    `;

        if(perfil == "Administrador"){
          controles += ` <button class="btn btn-danger btnEliminarContrato" idservicios=${idservicio}><i class="fa fa-trash"></i></button>`;
        }     

        controles += `</div>`;       
    
        filas += `<tr id="fila">
          <td class="text-center">${index+1}</td>
          <td class="text-center">${val["codigo"]}</td>
          <td class="text-center">${nombre}</td>
          <td class="text-center">${val["documento"]}</td>
          <td class="text-center">${val["zona"]}</td>
          <td class="text-center">${val["numromeses"]}</td>
          <td class="text-center">${servicio}</td>
          <td class="text-center">${val["fecha"]}</td>
          <td class="text-center">${estado}</td>
          <td class="text-center">${controles}</td>
        </tr>`;
      });

      $("#serviCont").empty();
      $(".serviConti").append(filas);


    })
    .fail(function() {
      console.log("error");
    })
    .always(function() {
      console.log("complete");
    });
    

  

});

$("#estadoServicio").on('change', function(event) {
  event.preventDefault();

  //$("#zonaServicio").prop('selectedIndex',0);
  let estadoServicios = $("#estadoServicio").val();
  let zonaServicios = $("#zonaServicio").val();
  let perfil = $('#perfilusuario').val();




  let datos = new FormData();
  datos.append("estadosServicios",estadoServicios);
  datos.append("zonaServicios",zonaServicios);



    $.ajax({
      url:"ajax/servicios.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      dataType:"json",
    })
    .done(function(response) {
      console.log(response);
      let filas = "";

      $.each(response, function(index, val) {
        
        let nombre = val["nombres"]+" "+val["apaterno"]+" "+val["amaterno"];
        let servicio = "";
        let estado = "";
        let controles = "";
        let idservicio = val["idservicio"];

        if(val["estado"] == 0){
          estado = `<span class="badge bg-green">Pagado</span>`;
        }else if(val["estado"] == 1){
          estado = `<span class="badge bg-yellow">Pendiente</span>`;
        }else if(val["estado"] == 2){
          estado = `<span class="badge bg-black">Finalizado</span>`;          
        }

        controles = `<div> 
                      <button class="btn btn-info btnImprimirEstado" idservicio=${idservicio}>
                        <i class="fa fa-print"></i></button> 
                        <button class="btn btn-warning btnEditarPersona" idservicio=${idservicio}><i class="fa fa-eye"></i></button>
                    `;

        if(perfil == "Administrador"){
          controles += ` <button class="btn btn-danger btnEliminarContrato" idservicio=${idservicio}><i class="fa fa-trash"></i></button>`;
        }     

        controles += `</div>`;   

        filas += `<tr id="fila">
          <td class="text-center">${index+1}</td>
          <td class="text-center">${val["codigo"]}</td>
          <td class="text-center">${nombre}</td>
          <td class="text-center">${val["nombrezona"]}</td>
          <td class="text-center">${val["direccion"]}</td>
          <td class="text-center">${val["codigomedidor"]}</td>
          <td class="text-center">${estado}</td>
          <td class="text-center">${controles}</td>
        </tr>`;
      });

      $("#serviCont").empty();
      $(".serviConti").append(filas);


    })
    .fail(function() {
      console.log("error");
    })
    .always(function() {
      console.log("complete");
    });
  

});


$("#zonaServicio").on('change', function(event) {
  event.preventDefault();

  let perfil = $("#perfilSession").val();

  let tipoServicios = $("#tipoServicio").val();
  let estadoServicios = $("#estadoServicio").val();
  let zonaServicios = $("#zonaServicio").val();

  let datos = new FormData();
  datos.append("tipoServicios", tipoServicios);
  datos.append("estadosServicios",estadoServicios);
  datos.append("zonaServicios",zonaServicios);

    $.ajax({
      url:"ajax/servicios.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      dataType:"json",
    })
    .done(function(response) {
      console.log(response);
      let filas = "";

      $.each(response, function(index, val) {
        
        let nombre = val["nombres"]+" "+val["apaterno"]+" "+val["amaterno"];
        let servicio = "";
        let estado = "";
        let controles = "";
        let idservicio = val["idservicio"];

        if(val["estado"] == 0){
          estado = `<span class="badge bg-green">Pagado</span>`;
        }else if(val["estado"] == 1){
          estado = `<span class="badge bg-yellow">Pendiente</span>`;
        }else if(val["estado"] == 2){
          estado = `<span class="badge bg-black">Finalizado</span>`;          
        }

        controles = `<div> 
                      <button class="btn btn-info btnImprimirEstado" idservicio=${idservicio}>
                        <i class="fa fa-print"></i></button> 
                        <button class="btn btn-warning btnEditarPersona" idservicio=${idservicio}><i class="fa fa-eye"></i></button>
                    `;

        if(perfil == "Administrador"){
          controles += ` <button class="btn btn-danger btnEliminarContrato" idservicio=${idservicio}><i class="fa fa-trash"></i></button>`;
        }     

        controles += `</div>`;   

        filas += `<tr id="fila">
          <td class="text-center">${index+1}</td>
          <td class="text-center">${val["codigo"]}</td>
          <td class="text-center">${nombre}</td>
          <td class="text-center">${val["nombrezona"]}</td>
          <td class="text-center">${val["direccion"]}</td>
          <td class="text-center">${val["codigomedidor"]}</td>
          <td class="text-center">${estado}</td>
          <td class="text-center">${controles}</td>
        </tr>`;
      });

      $("#serviCont").empty();
      $(".serviConti").append(filas);


    })
    .fail(function() {
      console.log("error");
    })
    .always(function() {
      console.log("complete");
    });
  

});

