let realizarCobro = false;
let igvServicio = 0;

var pagosSeleccionados;
var valoresPagos;
var cont=0;
let idservicio;
const meses = new Array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");



$(".tablas").on('click', '.btnAgregarDatos', function(event) {
  event.preventDefault();
  var idPersonaServicio = $(this).attr("idPersonaServicio");
  var tipo = $("#modalAgregarPersona").attr("tipo");

  var datos = new FormData();
    datos.append("idPersonaServicio", idPersonaServicio);

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

            $("#nuevoNombreCliente").val(respuesta[0]["nombres"] +" "+ respuesta[0]["apaterno"] +" "+ respuesta[0]["amaterno"]);
            
            $("#modalAgregarPersona").modal('toggle');

            $("#nuevoDocumento").val(respuesta[0]["documento"]);
            $("#nuevoTelefono").val(respuesta[0]["telefono"]);
            $("#nuevoCodigoR").val(respuesta[0]["codigo"]);
            $("#idpersona").val(respuesta[0]["idpersona"]);


            mostrarCobroServicios(respuesta[0]['idservicio']);
            
               
       }
    }

    })

});

$(".btnGenerarCobro").click(function() {
  $("#modalGenerarCobro").modal("show");
  idservicio = $(this).attr('idservicio');
  var fechaActual = new Date();
  fechaActual = (fechaActual.getMonth()+1) + " - " + fechaActual.getFullYear();
  $("#mesFacturado").val(fechaActual);



});

// calculo el cambio que pertenece al cliente
$(".btn-calcularCambio").click(function(){
  var valorPaga = parseFloat($('#valorPaga').val());
  var nuevoCambio = $('#nuevoCambio');

  if($('#totalPagar').length > 0){
    var valorTotal = $('#totalPagar').text();

    //Antes de Modificar estuvo asi
    //if(valorTotal > 0 && valorPaga > valorTotal){
    if(valorTotal > 0 && valorPaga >= valorTotal){
      valorTotal = valorPaga - valorTotal;
      nuevoCambio.html(`${formatoNumero(valorTotal)}`);
      realizarCobro = true;
    } else {
      nuevoCambio.html(`${formatoNumero(0)}`);
      realizarCobro = false;
    }
  }
  
})






// evento al calcular un cobro
$("#calcularCobro").click(function(e) {
  e.preventDefault();
  var lectura = $('#lecturaMedidor').val();
  var lecturaAterior = $('#lecturaMedidoranterior').val();

 var consumoMesTotal = lectura - lecturaAterior;

  /*var valorConsumo = consumoMesTotal * 0.30;

  var Subtotal = consumoMesTotal * 0.30;*/

  var fechaVence = $('#nuevoFechaVencimiento').val();
  var formulario = $('#formularioReciboContrato')[0];
  var idpersona = $('#idpersona').val();
  console.log(idpersona);
  /*var ndate = new Date(fechaVence);
  var newFecha = meses[`${ndate.getMonth()}`]+" - "+ndate.getFullYear();*/
  var formData = new FormData($('#formularioReciboContrato')[0]);
  formData.append('consultarServicioId', idservicio);
  

  $.ajax({
            url: 'ajax/cobros.ajax.php',
            type: 'post',
            data: formData,
            dataType:"json",
            contentType: false,
            processData: false,
            success: function(res){
              var contenedor = $('.recibo-pago');
              if(res.status == "success"){
                $('.boton-imprimir-recibo').html(`<button class="btn btn-info btnImprimirRecibo" idrecibo="${res.recibo}">
                              <i class="fa fa-print"></i>
                          </button>`);
                
                var mostrarRecibo = `<h3>Recibo generado con exito...</h3>
                            <h5 for=""><B>CÓDIGO CLIENTE:</B>  &nbsp;&nbsp;  <span>${res.datos.codigo}</span></h5>
                            <h5 for=""><B>MES FACTURADO:</B>  &nbsp;&nbsp; <span>${res.datos.month_billed}</span></h5>
                            <h5 for=""><B>CONSUMO DEL MES:</B> &nbsp;&nbsp;  <span>${consumoMesTotal}</span></h5>
                            <h5 for=""><B>VALOR CONSUMO:</B>   &nbsp;&nbsp; <span>${res.datos.valorM3}</span></h5>
                            <h5 for=""><B>SUBTOTAL:</B>  &nbsp;&nbsp;  <span>${res.datos.subtotal}</span></h5>
                            <h5 for=""><B>CARGO FIJO :</B> &nbsp;&nbsp;  <span>${res.datos.cargofijo}</span></h5>
                            <h5 for=""><B>OTROS COBROS :</B>  &nbsp;&nbsp;  <span>${res.datos.otroscobros}</span></h5>
                            <h5 for=""><B>MORA : </B> &nbsp;&nbsp;  <span>0.0</span></h5>
                            <h5 for=""><B>TOTAL : Q. </B>  &nbsp;&nbsp;  <span>${res.datos.totalpagar}</span></h5>

                            <label for="">Pague Hasta: <span>${res.datos.date_expires}</span></label>`;
              } else {
                var mostrarRecibo = `<h5>Error al procesar el pago...</h5>
                            <p>${res.message}</p>`;
              }

              contenedor.html(mostrarRecibo);
              
                console.log(res);

            }, 
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                console.log(XMLHttpRequest);
            }
        });
});


$('.btn-salir').click(function(e) {
  window.location = "contratos";
});

$(document).on('change', '#numeroIncrorrecto', function(){
  if($('#numeroIncrorrecto').prop('checked')){
    $('#nro_transacion').prop('disabled', false);
  } else {
    $('#nro_transacion').prop('disabled', true);
  }
})

// evento al clickiar un checkbox en crear-cobros
$(document).on('change', ".check-pago", function(){
  pagosSeleccionados = [];
  valoresPagos = [];
  let usuario = $('#IdUsuario').val();
  let d = new Date();
    let fecha =  d.getFullYear()+ "-" + [d.getMonth()+1] + "-" + d.getDate();
    var idSer = 0;
    var newTotalM3 = 0;
    var newValorM3 = 0;
    var newSubTotal = 0;
    var newIgv = 0;
    var newCargoFijo = 0;
    var newOtrosCobros = 0;
    var newMora = 0;
    var newTotal = 0;

    // cada vez que hay un cambio in habilito la parte de hacer pagos
    $('#nuevoCambio').html(`${formatoNumero(0)}`);
    realizarCobro = false;

  //recorro cada item seleccionado
  $("input[type=checkbox]:checked").each(function(){
        //cada elemento seleccionado
        var totalM3 = $(this).data('totalm3');
        var valorM3 = $(this).data('valorm3');
        var subtotal = $(this).data('subtotal');
        var total = $(this).data('total');

        var igv = $(this).data('igv');
        idSer = $(this).data('idservicio');
        var cargofijo = $(this).data('cargofijo');
        var otroscobros = $(this).data('otroscobros');
        var mora = $(this).data('mora');
        
        newTotalM3 += totalM3;
        newValorM3 = (parseFloat(newValorM3) + parseFloat(valorM3));
        newSubTotal = (parseFloat(newSubTotal) + parseFloat(subtotal));
        newIgv = (parseFloat(newIgv) + parseFloat(igv));
        newCargoFijo = (parseFloat(newCargoFijo) + parseFloat(cargofijo));
        newOtrosCobros = (parseFloat(newOtrosCobros) + parseFloat(otroscobros));
        newMora += parseFloat(mora);
        newTotal = (parseFloat(newTotal) + parseFloat(total));
       
        //[0]idPago, [1]totalM3, [2]valorM3, [3]cargofijo, [4]otroscobros, [5]mora, [6]idusuario

        pagosSeleccionados.push([$(this).val(), totalM3, valorM3, cargofijo, otroscobros, mora]);
    });

  //[0]newtotalm3, [1]newvalorm3, [2]newsubtotal, [3]newigv, [4]newcargofijo, [5]newotroscobros, [6]newmora, [7]newtotal, [8]idservicio, [9]idusuario, [10]fecha
    valoresPagos.push([newTotalM3, newValorM3, newSubTotal, newIgv, newCargoFijo, newOtrosCobros, newMora, newTotal, idSer, usuario, fecha]);

    calcularTotal(newTotalM3, newValorM3, newSubTotal, newIgv, newCargoFijo, newOtrosCobros, newMora, newTotal);
  console.log(pagosSeleccionados)
})



$(".btnAgregarConcepto").on('click', function(event) {
  event.preventDefault();
  var idcronograma_pago = $("#meses").val();

  var datos = new FormData();
    datos.append("idcronograma_pago", idcronograma_pago);

    let servicio = $("#servicios option:selected").text();  
  let mesPago = $("#meses option:selected").text();

  
  

    $.ajax({
      url: "ajax/cobros.ajax.php",
       method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      dataType:"json",
    })
    .done(function(response) {

      let conceptoPago = response["nombre"] +" "+response["descripcion"]; 
      let subtotal = response["monto"];
      let vencido = response["estado"];
      let idcronograma_pago = response["idcronograma_pago"];

    let recargo = 0;

      if(response["estado_servicio"] == 1){
        recargo = 1;
      }



    cambiarRecargos();  
      let concepto = "";
    concepto += `<tr class="filas" id="fila${cont}">
            <td style="display:none;">${idcronograma_pago}</td>
            <td>${servicio}</td>
            <td>${conceptoPago}</td>
            <td>${mesPago}</td>
            <td>Q.${subtotal}.00</td>
            <td>Q.${subtotal}.00</td>
            <td><button class="btn btn-danger" onclick=btnEliminarConcepto(${cont}); type="button">X</button></td>  
            <td style="display:none;">${recargo}</td>
          </tr>`;
    if (recargo == 1){
      concepto += `<tr class="filaRecargo" id="fila${cont}" >           
            <td style="display:none;"></td>
            <td></td>
            <td>Recargos</td>
            <td></td>
            <td></td>
            <td>Q.5.00</td>
            <td><button class="btn btn-danger" onclick=btnEliminarConcepto(${cont}); type="button">X</button></td>  
            <td style="display:none;"></td>
          </tr>`;
    }       

    $(".detalle").append(concepto);
    cont++; 

    calcularTotal();  

    })
    .fail(function() {
      console.log("error");
    })
    .always(function() {
      console.log("complete");
    });
    

});


function btnEliminarConcepto(indice){
    $("#fila" + indice).remove();
    calcularTotal();
  }

function cambiarRecargos(){
  $(".filaRecargo").remove();
}  


   function calcularTotal(totalm3=0, valorm3=0, subtotal=0, igv=0, cargofijo=0, otroscobros=0, mora=0, total=0){

    $('#cronogramapagofooter').empty();
    $('#detallePago').empty();

  footer = `  <th>Totales</th>
                <th>${totalm3}</th>
                <th>${formatoNumero(valorm3)}</th>
                <th>${formatoNumero(subtotal)}</th>
                <th>${formatoNumero(igv)}</th>
                <th>${formatoNumero(cargofijo)}</th>
                <th>${formatoNumero(otroscobros)}</th>
                <th>${formatoNumero(mora)}</th>
                <th><h4 id="totalh">${formatoNumero(total)}</h4></th>
                <th></th> `;
    $('#cronogramapagofooter').append(footer);

    detalleC = `<h5>SUB TOTAL: &nbsp  &nbsp &nbsp <span>${formatoNumero(subtotal)}</span></h5>
                <h5>igv(${igvServicio.split('.')[1]}%): &nbsp  &nbsp &nbsp <span>${formatoNumero(igv)}</span></h5>
                <h5>CARGO FIJO: &nbsp  &nbsp &nbsp <span>${formatoNumero(cargofijo)}</span></h5>
                <h5>OTROS COBROS: &nbsp  &nbsp &nbsp <span>${formatoNumero(otroscobros)}</span></h5>
                <h5>MORA: &nbsp  &nbsp &nbsp <span>${formatoNumero(mora)}</span></h5>
                <h5>TOTAL PAGAR: &nbsp  &nbsp &nbsp <span id="totalPagar">${formatoNumero(total)}</span></h5>`;

    $('#detallePago').append(detalleC);
    
  }




  $(".guardarCobro").on('click', function(event) {
    event.preventDefault();

  if(realizarCobro) {
    var valorPaga = parseFloat($('#valorPaga').val());
    var nuevoCambio = parseFloat($('#nuevoCambio').text());

    //[11]valorpaga, [12]nuevocambio, [13]arrayPagosSeleccionados
    valoresPagos[0].push(valorPaga, nuevoCambio, pagosSeleccionados );

    $.ajax({
        url: 'ajax/cobros.ajax.php',
        type: 'POST',
        data: {'arreglo': JSON.stringify(valoresPagos)},
        success: function(response) {
            
            if(response == "ok"){

                swal({
                  type: "success",
                  title: "El cobro fue guardado correctamente",
                  showConfirmButton: true,
                  confirmButtonText: "Cerrar"
                  }).then(function(result){
                    if (result.value) {
                        
                    window.location = "cobros";

                    }
              })
            }
        },
          error: function(error) {
              console.log("error");
          },
    }); 

  } else {
    swal({
                  type: "error",
                  title: "¡Por vavor calcular el cambio antes de continuar!",
                  showConfirmButton: true,
                  confirmButtonText: "Cerrar"
                  }).then(function(result){
                  if (result.value) {

                  window.location = "crear-cobros";

                  }
                })
  }

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
          <td><button type="button" class="btn btn-danger" onclick=btnEliminarCobro(${val["idcronograma_pago"]});><i class="fa fa-trash"></i></button></td> 
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


$(".btnEliminarContrato").on('click', function(event) {
  event.preventDefault();
  var idserviciosCobro = $(this).attr("idservicios");    

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

// $(".tablas").on("click", ".btnEliminarCobros", function(){
// //$(".btnEliminarCobros").on('click', function(event) {
//  event.preventDefault();

//  var idCobros = $(this).attr("idcobros");

//  var datos = new FormData();
//     datos.append("idcronograma", idCobros);

//      swal({
    
//    text: "Desea eliminar el Cobro? No se podra recuperar.",
//    type: 'warning',
//    showCancelButton: true,
//    confirmButtonColor: '#3085d6',
//    cancelButtonColor: '#d33',
//    confirmButtonText: 'Eliminar'
//  }).then((result) => {
//    if (result.value) {

//      $.ajax({
//          url:'ajax/cobros.ajax.php',
//          method: "POST",
//          data: datos,
//          cache: false,
//          contentType: false,
//          processData: false,
//          dataType:"json",
//        })
//        .done(function(response) {

//          //console.log("aqui",response);
          
//          if(response == "ok"){
//          swal({
//            type: "success",
//            title: "El Cobro ha sido eliminado",
//            showConfirmButton: true,
//            confirmButtonText: "Cerrar"
//            }).then(function(result){
//              if (result.value) {
//                window.location= "cobros";

//                    }
//            });

//        }else if (response == "error") {
//          swal({
//            type: "error",
//            title: "El cobro no puede ser eliminado",
//            showConfirmButton: true,
//            confirmButtonText: "Cerrar"
//            }).then(function(result){
//              if (result.value) {


//                    }
//            });
//        }   

//        })
//        .fail(function() {
//          console.log("error");
//        })
//        .always(function() {
//          console.log("complete");
//        });

                    
//      }
//  }) 

    

// });


$(".tablas").on("click", ".btnDetalleCobro", function(){
//$(".btnDetalleCobro").click(function(event) {
  event.preventDefault();
  var idcobros = $(this).attr('iddetalle');
 //console.log("hiiiii",idcobros);
  $.ajax({
    url: 'ajax/cobros.ajax.php',
    type: 'POST',
    dataType: 'json',
    data: {"editarCobros": idcobros},
  })
  .done(function(success) {
    //console.log("aqui ",success);
    detalleCobro(success);
  })
  .fail(function() {
    console.log("error");
  })
  .always(function() {
    console.log("complete");
  });
  



});


function detalleCobro(response) {
  
    $.ajax({
      url: 'vistas/modulos/proceso.php',
      type: 'POST',
      data: {"arregloC": JSON.stringify(response)},
      success: function() {
        //console.log(response)
        console.log(response);
        window.location.href = "detalle-cobro";
        //calcularTotal();
      },
      error: function(error) {
        console.log("error");
      },
    })
  
}

$(".tablas").on('click', '.btnImprimirComprobanteC', function(event) {
  event.preventDefault();

  var iddetalle = $(this).attr('iddetalle');

  window.open("extensiones/tcpdf1/pdf/recibo-detalle-cobro.php?id="+iddetalle, "_blank");
  //window.open("extensiones/tcpdf/pdf/ticket.php?idcobros="+idcobros, "_blank");
});



/*=============================================
ELIMINAR COBROS O DESACTIVAR
=============================================*/
// $(".tablas").on("click", ".btnEliminarCobros", function(){

//  var idcobros = $(this).attr("idcobros");
//  var estadoCobro = $(this).attr("estadoCobro");

//  var datos = new FormData();
//    datos.append("activarId", idcobros);
//    datos.append("desactivarCobros", estadoCobro);

//    $.ajax({

//    url:"ajax/cobros.ajax.php",
//    method: "POST",
//    data: datos,
//    cache: false,
//       contentType: false,
//       processData: false,
//       success: function(respuesta){      

    
//        if(estadoCobro == "0"){


//          swal({
//            type: "error",
//            title: "La cobranza fue eliminado correctamente",
//            showConfirmButton: true,
//            confirmButtonText: "Cerrar"
//            }).then(function(result){
//              if (result.value) {
//                window.location = "cobros";

//                    }
//            });

//        }else{
//          swal({
//            type: "success",
//            title: "La cobranza fue restaurado correctamente",
//            showConfirmButton: true,
//            confirmButtonText: "Cerrar"
//            }).then(function(result){
//              if (result.value) {

//                window.location = "cobros";
//                    }
//            });
//        } 


          

//       }

//    }) 

// })



/*=============================================
ELIMINAR COBROS Y RESTAURAR COBROS
=============================================*/
$(".tablas").on("click", ".btnEliminarCobros", function(){

  var idcobros = $(this).attr("idcobros");
  var estadoCobro = $(this).attr("estadoCobro");

  if(estadoCobro == "0"){
  
    swal({
          title: '¿Está seguro de eliminar el cobro?',
          text: "¡Si no lo está puede cancelar la acción!",
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          cancelButtonText: 'Cancelar',
          confirmButtonText: 'Si, eliminar cobro!'
        }).then(function(result){
          if (result.value) {
            
              var datos = new FormData();
        datos.append("activarId", idcobros);
          datos.append("desactivarCobros", estadoCobro);

          $.ajax({

            url:"ajax/cobros.ajax.php",
            method: "POST",
            data: datos,
            cache: false,
              contentType: false,
              processData: false,
              success: function(respuesta){
            swal({
              type: "error",
              title: "El cobro fue eliminado correctamente",
              showConfirmButton: true,
              confirmButtonText: "Cerrar"
              }).then(function(result){
                if (result.value) {
                  window.location = "cobros";

                }
              });                 

              }

          }) 
          }

      })

  }else{

    swal({
          title: '¿Está seguro de restaurar el cobro?',
          text: "¡Si no lo está puede cancelar la acción!",
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          cancelButtonText: 'Cancelar',
          confirmButtonText: 'Si, restaurar cobro!'
        }).then(function(result){
          if (result.value) {
            
              var datos = new FormData();
        datos.append("activarId", idcobros);
          datos.append("desactivarCobros", estadoCobro);

          $.ajax({

            url:"ajax/cobros.ajax.php",
            method: "POST",
            data: datos,
            cache: false,
              contentType: false,
              processData: false,
              success: function(respuesta){
            swal({
              type: "success",
              title: "El cobro fue restaurado correctamente",
              showConfirmButton: true,
              confirmButtonText: "Cerrar"
              }).then(function(result){
                if (result.value) {
                  window.location = "cobros";

                }
              });                 

              }

          }) 
          }

      })

  }



})


$('.btnAceptarPago').click(function(){
  idDetalle = $(this).attr('iddetalle');
  nroTransacion = $(this).attr('nro_transacion');
  $('#nro_transacion').val(nroTransacion);
  
  $('#aceptarIdDetalle').val(idDetalle);
})

$('#formAceptarPago').submit(function(e){
  e.preventDefault();
  var formdata = new FormData($('#formAceptarPago')[0]);

  $.ajax({
    url: 'ajax/cobros.ajax.php',
    type: 'POST',
    data: formdata,
    contentType: false,
    processData: false,
    dataType: 'json',
    success: function(res){
      console.log(res);
      if(res.status == "success"){
        swal({
              type: "success",
              title: "El contrato de servicio ha sido actualizado correctamente",
              showConfirmButton: true,
              confirmButtonText: "Cerrar"
              }).then(function(result){
                  if (result.value) {

                  window.location = "cobros";

                  }
                })
      } else {
          swal({
              type: "error",
              title: "¡Este pago no puede ser aceptado!",
              text: `${ res.message }`,
              showConfirmButton: true,
              confirmButtonText: "Cerrar"
              }).then(function(result){
              if (result.value) {

              window.location = "cobros";

              }
            })
      }
    }
  })
})

$('.btn-rechazar-pago').click(function(){
  var idDetalle = $('#aceptarIdDetalle').val();
    var formdata = new FormData();
    formdata.append('rechazar_pago', idDetalle);
    
    alert(idDetalle);
  $.ajax({
    url: 'ajax/cobros.ajax.php',
    type: 'POST',
    data: formdata,
    contentType: false,
    processData: false,
    success: function(res){
      console.log(res);
      if(res == "ok"){
          swal({
            type: "success",
            title: "Pago rechazado con exito",
            showConfirmButton: true,
            confirmButtonText: "Cerrar"
            }).then(function(result){
              if (result.value) {
                   location.reload();
                   
                    }
            });

        }else if (res == "error") {
          swal({
            type: "error",
            title: "Error al cancelar el contrato",
            showConfirmButton: true,
            confirmButtonText: "Cerrar"
            }).then(function(result){
              if (result.value) {

                      location.reload();
                    }
            });

      }
    }
  })
})


// mostramos todos los cobros pendiente de un servicio pertenecientes a un usuario
function mostrarCobroServicios(idservicio){
  var datos = new FormData();
    datos.append("idservicio", idservicio);

    const meses = new Array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

  $.ajax({
    url:"ajax/cobros.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      dataType:"json",
  })
  .done(function(res) {
    
    $("#cronogramapago").empty();
    $.each(res, function(index, response) {
      console.log(response);
                 
    let conceptoPago = response["nombres"];
    let ndate = new Date(response["fecharecibo"]);
    //let ndate = new Date(response[0]["date_to"]+"T00:00:00");
    let mes = response.month_billed;      

    let subtotal = response["subtotal"];
      let igv = response["igv"];


      let cargofijo = response["cargofijo"];
      let otroscobros = response["otroscobros"];

/*
       let mesA = new Date();
      let mesActual = meses[mesA.getMonth()] +" - "+mesA.getFullYear();
      if(mes != mesActual){
        if(ndate.getFullYear() == mesA.getFullYear()){
            if(ndate.getMonth() < mesA.getMonth()){
              var fFecha1 = Date.UTC(ndate.getDate(),ndate.getMonth(),ndate.getFullYear());
               var fFecha2 = Date.UTC(mesA.getDate(),mesA.getMonth(),mesA.getFullYear());
               var dif = fFecha2 - fFecha1;
              var dias = Math.floor(dif / (1000 * 60 * 60 * 24));
               alert("mes anterior "+(ndate.getDate() + "-"+ndate.getMonth()+"-"+ndate.getFullYear())+" mes actuar "+(mesA.getDate()+"-"+mesA.getMonth()+"-"+mesA.getFullYear())+ " dias transcurridos "+dias);
            }
        }
        //alert(mesActual);  

      } */

        
      //alert(response['moratiposervicio']);
      let mora = response["mora"];
      let total = response["totalpagar"];
      igvServicio = response["igvservicio"];

      let idcronograma_pago = response["idcronograma_pago"];

      let idRecibo = response.idrecibo;
      let idServicio = response.idservicio;
     
    let totalM3 = response.totalM3;
    let valorM3 = response.valorM3;

     //agrego la mora si la factura esta vencida
     var moratiposervicio = response.moratiposervicio;
     var fechaExpira = response.date_expires;
     var fe = new Date();
     fechaActual = fe.getDate()+"/"+(fe.getMonth()+1) + "/"+fe.getFullYear();
   
     fechaExpira = fechaExpira.split(" ")[0].split("-").reverse().join("/");
     if(Date.parse(fechaActual) > Date.parse(fechaExpira)){
         var diasVencidos = restaFechas(fechaExpira, fechaActual);
         if(diasVencidos > 0){
           mora = formatoNumero(moratiposervicio * diasVencidos);
         } else {
           mora = formatoNumero(0);
         }
          
     } else {
       mora = formatoNumero(0);
     }
    
    let concepto = "";
    concepto += `<tr class="filas" id="fila${cont}" >           
            <td>${mes}</td>
            <td>${totalM3}</td>
            <td>${valorM3}</td>
            <td>${subtotal}</td>
            <td>${igv}</td>
            <td>${cargofijo}</td>
            <td>${otroscobros}</td>
            <td>${mora}</td>
            <td>${total}</td>
            <td>
            <input type="checkbox" name="cb-autos" class="check-pago" value="${idRecibo}" data-totalm3="${totalM3}" data-valorm3="${valorM3}" data-idservicio="${idServicio}" data-cargofijo="${cargofijo}" data-otroscobros="${otroscobros}" data-mora="${mora}" data-igv="${igv}" data-subtotal="${subtotal}" data-total="${total}"><br>
            </td>
            
          </tr>`;
  

    $("#cronogramapago").append(concepto);
    cont++; 
    calcularTotal();  

    });

  })
  .fail(function(response) {
    //console.log(response);
  })
  .always(function(response) {
    //console.log(response);
  });
}

// Función para calcular los días transcurridos entre dos fechas
restaFechas = function(f1,f2)
 {
 var aFecha1 = f1.split('/');
 var aFecha2 = f2.split('/');
 var fFecha1 = Date.UTC(aFecha1[2],aFecha1[1]-1,aFecha1[0]);
 var fFecha2 = Date.UTC(aFecha2[2],aFecha2[1]-1,aFecha2[0]);
 var dif = fFecha2 - fFecha1;
 var dias = Math.floor(dif / (1000 * 60 * 60 * 24));
 return dias;
 }

function formatoNumero(nStr)
{
  nStr += '';
  x = nStr.split('.');
  x1 = x[0];
  x2 = x[1] ? "."+x[1].substr(0,2) : '.00';
  var rgx = /(\d+)(\d{3})/;
  while (rgx.test(x1)) {
    x1 = x1.replace(rgx, '$1' + ',' + '$2');
  }
  return x1 + x2;
}

