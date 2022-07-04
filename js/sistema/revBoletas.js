$(document).ready(function(){
	$("#btn_Buscar").click(function(){
		$("#tablaRevisarBoletas tbody tr").remove();
		var numeroDocto =$("#numeroDocto").val();
		var fecha = $("#fecha").val();
		var bodega ='009'; //cambiar a 009
		var workstation =3; //cambiar a 3
		$.post("scripts/cargarBoletas.php",{numeroDocto:numeroDocto,fecha:fecha,bodega:bodega,workstation:workstation},function(res){
			var resProductos = $.parseJSON(res);
			for(i=0;i<resProductos.length;i++){
				$("#tablaRevisarBoletas tbody").append('<tr>'+
					'<td style ="font-size:15px;"><center>'+resProductos[i]['tipoDocto']+'</center></td>'+
					'<td style ="font-size:12px;"><center>'+resProductos[i]['numeroDocto']+'</center></td>'+
					'<td style ="font-size:15px;"><center>'+resProductos[i]['fechaDocto']+'</center></td>'+
					'<td style ="font-size:15px;"><center>'+resProductos[i]['monto']+'</center></td>'+
					'<td><center><button class="btnDetalle btn btn-warning glyphicon glyphicon-pencil" data-toggle="modal" data-target="#modalDetalleBoleta"></button></center></td>'+
					'<td><center><button class="btnPago btn btn-info glyphicon glyphicon-credit-card" data-toggle="modal" data-target="#modalPagoBoleta"></button></center></td>'+
					'</tr>');
				}
		});
	});
});

$(document).on('click', 'button.btnDetalle', function () {
	indiceEditar = $(this).closest("tr").index();
	$("#tablaDetalle tbody tr").remove();
	var numeroDocto =$("#tablaRevisarBoletas tbody tr:eq("+(indiceEditar)+")").find("td").eq(1).text();
	var bodega ='009';    //cambiar a 009
	var workstation = 3;  //cambiar a 3
	var tipoDocto = 1;
	$.post("scripts/obtenerDetalleVenta.php",{numeroDocto:numeroDocto,bodega:bodega,workstation:workstation,tipoDocto:tipoDocto},function(res){
			var resDetalle = $.parseJSON(res);
			for(i=0;i<resDetalle.length;i++){
				$("#tablaDetalle tbody").append('<tr>'+ 
					'<td style ="font-size:15px;"><center>'+resDetalle[i]['Secuencia']+'</center></td>'+
					'<td style ="font-size:12px;"><center>'+resDetalle[i]['TipoDocto']+'</center></td>'+
					'<td style ="font-size:15px;"><center>'+resDetalle[i]['NumeroDocto']+'</center></td>'+
					'<td style ="font-size:15px;"><center>'+resDetalle[i]['Sku']+'</center></td>'+
					'<td style ="font-size:15px;"><center>'+resDetalle[i]['Descripcion']+'</center></td>'+
					'<td style ="font-size:15px;"><center>'+resDetalle[i]['Cantidad']+'</center></td>'+
					'<td style ="font-size:15px;"><center>'+resDetalle[i]['Descuento']+'</center></td>'+
					'<td style ="font-size:15px;"><center>'+resDetalle[i]['PrecioOriginal']+'</center></td>'+
					'<td style ="font-size:15px;"><center>'+resDetalle[i]['PrecioFinal']+'</center></td>'+
					//'<td style ="font-size:15px;"><center>'+resDetalle[i]['Vendedor']+'</center></td>'+
					'</tr>');
				}
	});
});
$(document).on('click', 'button.btnPago', function () {
	indiceEditar = $(this).closest("tr").index();
	$("#tablaPago tbody tr").remove();
	var numeroDocto =$("#tablaRevisarBoletas tbody tr:eq("+(indiceEditar)+")").find("td").eq(1).text();
	var bodega ='009';
	var workstation = 3;
	var tipoDocto = 1;
	$.post("scripts/obtenerPago.php",{numeroDocto:numeroDocto,bodega:bodega,workstation:workstation,tipoDocto:tipoDocto},function(res){
			var resPago = $.parseJSON(res);
			for(i=0;i<resPago.length;i++){
				$("#tablaPago tbody").append('<tr>'+
					'<td style ="font-size:15px;"><center>'+resPago[i]['Secuencia']+'</center></td>'+
					'<td style ="font-size:15px;"><center>'+resPago[i]['TipoDocto']+'</center></td>'+
					'<td style ="font-size:15px;"><center>'+resPago[i]['NumeroDocto']+'</center></td>'+
					'<td style ="font-size:15px;"><center>'+resPago[i]['TipoPago']+'</center></td>'+
					'<td style ="font-size:12px;"><center>'+resPago[i]['Cuotas']+'</center></td>'+
					'<td style ="font-size:15px;"><center>'+resPago[i]['FechaDoc']+'</center></td>'+
					'<td style ="font-size:15px;"><center>'+resPago[i]['Monto']+'</center></td>'+
					'<td style ="font-size:15px;"><center>'+resPago[i]['NumTarjeta']+'</center></td>'+
					'<td style ="font-size:15px;"><center>'+resPago[i]['CodAut']+'</center></td>'+
					'</tr>');
				}
	});
});