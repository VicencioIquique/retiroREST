$(document).ready(function(){
	$.post("scripts/apiPrestaShop/listarPedidos.php",{},function(res){
		var res = $.parseJSON(res);
		for(i=0;i<res.length;i++){
			$("#tabla tbody").append('<tr>'+
				'<td style ="font-size:15px;"><center>'+res[i]['id']+'</center></td>'+
				'<td style ="font-size:12px;"><center>'+res[i]['referencia']+'</center></td>'+
				'<td><center><button class="btnEstado btn btn-warning" data-toggle="modal">ENTREGADO</button></center></td>'+
				'</tr>');
			}
	});
});


$(document).on('click', 'button.btnEstado', function () {
	var indice = $(this).closest("tr").index(); // asigna el indice de la columna
	var pedido = $("#tabla tbody tr:eq("+(indice)+")").find("td").eq(0).text(); 
	$.post("scripts/apiPrestaShop/entregado.php",{idCompra : pedido},function(res){
		$.post("scripts/apiPrestaShop/listarPedidos.php",{},function(res){
			var res = $.parseJSON(res);
			$("#tabla tbody tr").remove();
			for(i=0;i<res.length;i++){
				$("#tabla tbody").append('<tr>'+
					'<td style ="font-size:15px;"><center>'+res[i]['id']+'</center></td>'+
					'<td style ="font-size:12px;"><center>'+res[i]['referencia']+'</center></td>'+
					'<td><center><button class="btnEstado btn btn-warning" data-toggle="modal">ENTREGADO</button></center></td>'+
					'</tr>');
				}
		});
	});


});