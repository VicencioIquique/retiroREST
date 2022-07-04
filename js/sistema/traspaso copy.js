$(document).ready(function(){
	$("#btn_buscar").click(function(){
		$('#btn_Validar').prop('disabled', false);
		$("#tablaDem tbody tr").remove();
		$.post("scripts/cargarDsm.php",{nroDsm:$("#txt_Dsm").val()},function(res){
			var resProductos = $.parseJSON(res);
			for(i=0;i<resProductos.length;i++){
				$("#tablaDem tbody").append('<tr>'+
					'<td style ="font-size:15px;"><center>'+resProductos[i]['CodigoProducto']+'</center></td>'+
					'<td style ="font-size:12px;"><center>'+resProductos[i]['DescripcionProducto']+'</center></td>'+
					'<td style ="font-size:15px;"><center>'+resProductos[i]['Cantidad']+'</center></td>'+
					'<td style ="font-size:15px;"><center>'+resProductos[i]['Estado']+'</center></td>'+
					'</tr>');
                }
                $('#txt_Dsm').prop('disabled', true);
		});
	});

	$("#btn_Validar").click(function(){
		$('#btn_Validar').prop('disabled', true);
		$("#tablaDem tbody tr").remove();
		$.post("scripts/validarTraspaso.php",{nroDsm:$("#txt_Dsm").val()},function(){});
		$.post("scripts/cargarDsm.php",{nroDsm:$("#txt_Dsm").val()},function(res){
			var resProductos = $.parseJSON(res);
			for(i=0;i<resProductos.length;i++){
				$("#tablaDem tbody").append('<tr>'+
					'<td style ="font-size:15px;"><center>'+resProductos[i]['CodigoProducto']+'</center></td>'+
					'<td style ="font-size:12px;"><center>'+resProductos[i]['DescripcionProducto']+'</center></td>'+
					'<td style ="font-size:15px;"><center>'+resProductos[i]['Cantidad']+'</center></td>'+
					'<td style ="font-size:15px;"><center>'+resProductos[i]['Estado']+'</center></td>'+
					'</tr>');
                }
		});
	});

});