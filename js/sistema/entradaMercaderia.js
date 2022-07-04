const url = "http://192.168.3.41:9095";//productiva
//const url = "https://localhost:44397";//prueba
$(document).ready(function(){
	$("#btn_buscar").click(function(){
		$("#tablaDem tbody tr").remove();
		let dem = $("#txt_Dem").val();
		if(dem){buscarDem(dem);}else{alert("Ingrese un valor");}
	});
	$("#btn_Validar").click(function(){
		$("#tablaDem tbody tr").remove();
		let dem = $("#txt_Dem").val();
		if(dem){validarEntrada(dem);}else{alert("Ingrese un valor");}
	});
});

const buscarDem = async(dem)=>{
	try{
		const respuesta = await fetch(`${url}/api/rp_dem/${dem}`);
		console.log (respuesta);
		if(respuesta.ok){
			$('#btn_Validar').prop('disabled', false);
			const datos = await respuesta.json();
			console.log(datos);
			datos.map(value=>{
				$("#tablaDem tbody").append('<tr>'+
						`<td style ="font-size:15px;"><center>${value.nroDem}</center></td>`+
						`<td style ="font-size:15px;"><center>${value.torigen}</center></td>`+
						`<td style ="font-size:15px;"><center>${value.codModulo}</center></td>`+
						`<td style ="font-size:15px;"><center>${value.codigoProducto}</center></td>`+
						`<td style ="font-size:15px;"><center>${value.descripcionProducto}</center></td>`+
						`<td style ="font-size:15px;"><center>${value.cantidad}</center></td>`+
						`<td style ="font-size:15px;"><center>${value.estado}</center></td>`+
						'</tr>');
			});
		}
		else{
			const res = await respuesta.text();
			alert(res);
		}
	}catch(err){alert(err.message);}
}

const validarEntrada = async (dem)=>{
	//console.log(data);
	try{
		const respuesta = await fetch(`${url}/api/rp_dem/${dem}`,{
			method:'PUT'
		});
		console.log(respuesta);
		if(respuesta.ok){
			const datos = await respuesta.json();
			console.log(datos);
			datos.map(value=>{
				console.log(value);
				$("#tablaDem tbody").append('<tr>'+
				`<td style ="font-size:15px;"><center>${value.nroDem}</center></td>`+
				`<td style ="font-size:15px;"><center>${value.torigen}</center></td>`+
				`<td style ="font-size:15px;"><center>${value.codModulo}</center></td>`+
				`<td style ="font-size:15px;"><center>${value.codigoProducto}</center></td>`+
				`<td style ="font-size:15px;"><center>${value.descripcionProducto}</center></td>`+
				`<td style ="font-size:15px;"><center>${value.cantidad}</center></td>`+
				`<td style ="font-size:15px;"><center>Completado</center></td>`+
				'</tr>');			
			});
		}else{
			const res = await respuesta.text();
			alert(res);
		}
	}catch(err){alert(err.message);}

}
