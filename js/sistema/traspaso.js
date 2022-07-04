const url = "http://192.168.3.41:9095";//productiva
//const url = "https://localhost:44397";//prueba
$(document).ready(function(){
	$("#btn_buscar").click(async function (){
		$('#btn_Buscar').prop('disabled', true);
		$("#tablaDem tbody tr").remove();
		let dsm = $("#txt_Dsm").val();
		if(dsm){buscarDsm(dsm);}else{alert("Ingrese un valor");$('#btn_Buscar').prop('disabled', false);}
	});
	$("#btn_Validar").click(async function(){
		$('#btn_Validar').prop('disabled', true);
		$("#tablaDem tbody tr").remove();
		let dem = $("#txt_Dsm").val();
		validarTraspaso({"nroDsm": `${dem}`,"CodModulo":"009"});
	});
});
const buscarDsm = async(dsm)=>{
	try{
		const respuesta = await fetch(`${url}/api/rp_dsm/${dsm},009`);
		console.log (respuesta);
		if(respuesta.ok){
			$('#btn_Validar').prop('disabled', false);
			const datos = await respuesta.json();
			console.log(datos);
			datos.map(value=>{
				$("#tablaDem tbody").append('<tr>'+
						`<td style ="font-size:15px;"><center>${value.nroDsm}</center></td>`+
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
			$('#btn_Buscar').prop('disabled', false);
			const res = await respuesta.text();
			alert(res);
		}
	}catch(err){alert(err.message);}
}
const validarTraspaso = async (data)=>{
	//console.log(data);
	try{
		const respuesta = await fetch(`${url}/api/TraspasoMercaderia`,{
			method:'POST',
			body :JSON.stringify(data),
			headers:{ 'Accept':'application/json','Content-Type': 'application/json'}	
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


