var btn_pagados = $('.btn-adeudosPagados');
var btn_vigentes = $('.btn-adeudosVigentes');
var deudasPendientes = $('.deudasPendientes');
var deudasPagadas = $('.deudasPagadas');

var valoresPagos;
var pagosSeleccionados = [];

btn_pagados.click(function(){
	btn_vigentes.removeClass('active');
	if(deudasPagadas.hasClass('d-none')){
		deudasPagadas.removeClass('d-none');
		deudasPendientes.addClass('d-none');
		
	}
})

btn_vigentes.click(function(){
	if(deudasPendientes.hasClass('d-none')){
		deudasPendientes.removeClass('d-none');
		deudasPagadas.addClass('d-none');
	}
})

$('.check-cobro').change(function(){
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
});

//imprimir recibo de pago
$(document).on("click", ".btnImprimirRecibo", function(e){

  var iddetallerecibo = $(this).attr("idrecibo");
  window.open("extensiones/tcpdf1/pdf/recibo-detalle-cobro.php?id="+iddetallerecibo, "_blank");

});

$(document).on("click", ".btn-aceptar", function(){
  location.reload();
})

$('.btn-gurdarPago').click(function(){
	var idTransacion = $('#idtransacion').val();
	if(idTransacion != ''){
		if(pagosSeleccionados.length != 0){
			valoresPagos[0].push(pagosSeleccionados, idTransacion);

			$.ajax({
				url: 'ajax/cobros.ajax.php',
				type: 'POST',
				data: {'crearDetallePago': JSON.stringify(valoresPagos)},
        dataType: 'json',
				success: function(res){
					console.log(res);
          var nombreCliente = $('#nombresCliente').text();
          var numeroMedidor = $('#numeroMedidor').text();
          $('#modalMostrarRecibo').modal('toggle');
          var mostrarRecibo = "";
          var contenedor = $('.recibo-pago');
          if(res.status == "success"){
          
              
                
                $('.boton-imprimir-recibo').html(`<button class="btn btn-info btnImprimirRecibo" idrecibo="${res.datos_recibo.iddetallepago}">
                              <i class="fa fa-print"></i>
                          </button>`);
                /*
<h5 for="">Codigo Recibo: &nbsp;&nbsp;  <span>${res.datos.codigo}</span></h5>
                 */
                
                mostrarRecibo = `
                <div class"col-md-12">
                  <h3>Su pago sera verificado en el transcurso del día</h3>
                  <h5>Nombre: &nbsp;&nbsp; <span>${nombreCliente}</span></h5>
                  <h5>Numero Medidor: &nbsp;&nbsp; <span>${numeroMedidor}</span></h5>
                </div>
                <div class"col-md-12">
                  <h5>Recuerda que el comprobante de pago debe 
                  de coincidir con el valor del recibo en caso contrario su pago sera rechazado.
                  <br>
                  Si por algun motivo su pago fue rechazado por favor comuniquece con nosotros o acerquese a la oficina
                  </h5>
                  <h5>Valor del recibo = ${res.datos_detalle.totalpagar}</h5>
                </div>
                `;
             } else {
               mostrarRecibo = `
                <div class"col-md-12">
                  <h3>Error al procesar el pago</h3>
                  <h5>${res.message}</h5>
                </div>
                <div class"col-md-12">
                  <h5>Si esta teniendo problemas con su pago por favor comuniquece con nosotros.
                  </h5>
                 
                </div>
                `;
             }

                contenedor.html(mostrarRecibo);
				    }
			  })
		}
	}
	
	//

	
})



   function calcularTotal(totalm3=0, valorm3=0, subtotal=0, igv=0, cargofijo=0, otroscobros=0, mora=0, total=0){

   	$('#cronogramapagofooter').empty();
   	$('#detallePago').empty();
   	var igvServicio = $('#conf-igv').val();

	footer = ` 	<th>Totales</th>
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