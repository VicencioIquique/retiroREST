var tablaProdCodigo = [];
var tablaProdDescripcion = [];
var tablaProdMarca = [];
var tablaProdCantidad = [];
var tablaProdDscto = [];
var tablaProdVOrig = [];
var tablaProdVendedor = [];
var tablaProdVFinal = [];
var tablaProdIDPreventa = [];
var tablaProdNum = [];
var bodega ='009'; // bodega para Punto Retiro
var workstation ='3';
var tipoDocto ='1'
var ip ='192.168.1.4'; // se usar para buscar en ip bodegas la ultima nota de credito
$(document).ready(function(){
	$.post("scripts/obtenerFolio.php",{ip:ip},function(res){
		$("#txt_Folio").text(parseInt(res)+1);
	});
	$("#btn_buscar").click(function(){
		var total =0;
		var numeroDocto = $("#txt_numeroDocto").val();
		$.post("scripts/obtenerNotaCredito.php",{numeroDocto:numeroDocto,bodega:bodega,workstation:workstation,tipoDocto:tipoDocto},function(res){
			var resNC = $.parseJSON(res);
			//alert(resNC[0]['ID']);
			$.post("scripts/obtenerNotaCreditoPagos.php",{ID:resNC[0]['ID']},function(resP){
				var resPagos = $.parseJSON(resP);
				//alert(resPagos[0]['NumeroDoc']);
				//resetearCampos();
				$("#btn_Imprimir").attr( "disabled", false );
				$("#lblID").text(resNC[0]['ID']);
				$("#lblFecha").text(resNC[0]['FechaDocto'].substring(0,19));
				$("#lblRut").text(resNC[0]['RUT']);
				$("#lblTipoPago").text(resPagos[0]['TipoPago']);
				$("#lblCuotas").text(resPagos[0]['NumeroDoc']);
				$("#lblNTarjeta").text(resPagos[0]['desc2']);
				for(i=0;i<resNC.length;i++){
					total = total + parseInt(resNC[i]['PrecioExtendido']);
					$("#tablaProductos tbody").append('<tr>'+ 
					'<td style ="font-size:15px;"><center>'+resNC[i]['ALU']+'</center></td>'+
					'<td style ="font-size:12px;"><center>'+resNC[i]['DESC2']+'</center></td>'+
					'<td style ="font-size:15px;"><center>'+resNC[i]['DESC3']+'</center></td>'+
					'<td style ="font-size:15px;"><center>'+resNC[i]['Cantidad']+'</center></td>'+
					'<td style ="font-size:15px;"><center>'+resNC[i]['PrecioExtendido']+'</center></td>'+
					'</tr>');
				}
				$("#txt_total").text(total);
			});
		});
	});
	$("#btn_Imprimir").click(function(){
		asignarArticulosVectores();
		var fechaDocto = obtenerFechaAMDHMSM();
		var fechaID = fechaDocto.replace(':','');
		fechaID = fechaID.replace(':','');
		fechaID = fechaID.replace('-','');
		fechaID = fechaID.replace('-','');
		fechaID = fechaID.replace(' ','');
		var tipoDocto ='3';	
		var ID = tipoDocto + workstation + bodega +  $("#txt_Folio").text() + fechaID;	
		var jsonBoletaDetalle = {
			tablaProdAluSplit:tablaProdCodigo,
			bodega:bodega,
			tablaProdCantidadSplit:tablaProdCantidad,
			boletaTipoDocto:tipoDocto,
			tipoDocto:tipoDocto,
			numeroDocto:$("#txt_Folio").text(),
			tablaProdDsctoSplit:tablaProdDscto,
			tablaProdVOrigSplit:tablaProdVOrig,
			tablaProdVendedorSplit:tablaProdVendedor,
			tablaProdVFinalSplit:tablaProdVFinal,
			factor:0,
			workstation:workstation,
			ID:ID,
			numListaPrecio: 1,
			tablaProdNumSplit:tablaProdNum,
			codigoBarra:tablaProdCodigo,
			tablaProdIDPreventaSplit:'',
			totalImpuesto:'Taxable',
			porcentajeImpuesto:0,
			aux:0,
			attr:'',
			codPromo:0							
			};
		var jsonBoletaCabecera = {
			numeroDoctoNC:$("#txt_Folio").text(),
			tipoDoctoNC:tipoDocto,
			bodega:bodega,
			workstation:workstation,
			tipoDocto:tipoDocto,
			numeroDocto:$("#txt_Folio").text(),
			fechaDocto:fechaDocto,
			totNeto:$("#txt_Total").text(), //Total tablaProdVFinalSplit
			totDescuento:0,
			totIva:0,
			total:$("#txt_Total").text(), //Total tablaProdVFinalSplit
			rutCliente:$("#lblRut").text(),
			rutDespacho:$("#lblRut").text(),
			cajera: '80',
			//retencionDL18219 -> Calculado en insertarBoleta.php
			//tipoCambio -> Obtenido en insertarBoleta.php
			//CIF -> Calculado en insertarBoleta.php
			//totNetoRetencion -> Calcular insertarBoleta.php (Total - RetencionDL)
			vendedorNumero:tablaProdVendedor[0], //Vendedor único asignado en vprincipal (en la cabecera no se necesita el arreglo de vendedores)
			estado:0,
			numeroDoctoRef:ID,
			fechaDoctoRef: fechaDocto,
			ID:ID,
			//fechaCreacion -> Obtenida en insertarBoleta.php
			//serie -> Equivalencia de SAP
			retencionCarnes:0,
			netoRetencionCarnes:0,
			//shipToAdress2 -> Pendiente
			billToCompany:'',
			//shipToFName -> Pendiente
			type:0,
			Status:2,
			baseEntry:''
			};
		var jsonBoletaPagos = {
			bodega:bodega,
			tipoDocto:tipoDocto,
			numeroDocto:$("#txt_Folio").text(),
			//secuencia: calculada en insertarBoleta.php
			tipoPago:'CreditStore',
			NumeroDoc:$("#txt_Folio").text(),
			fechaDoc:fechaDocto,
			monto:$("#txt_Total").text(),
			desc1:'',
			desc2:'',
			desc3:'',
			desc4:'',
			CdCuenta:'03',
			workstation:workstation,
			ID:ID,
			fechaCheque:''
			};
		//alert(jsonBoletaDetalle['numeroDoctoNC']);
		/*$.post("scripts/insertarBoletaNC.php",{jsonBoletaDetalle:jsonBoletaDetalle, jsonBoletaCabecera: jsonBoletaCabecera, jsonBoletaPagos:jsonBoletaPagos, workstationNC:workstation},function(res){
			alert(res);
		});*/
	});
});
function resetearCampos(){
	$("#tablaProductos tbody tr").remove();
	$("#lblID").text("");
	$("#lblFecha").text("");
	$("#lblRut").text("");
	$("#lblTipoPago").text("");
	$("#lblCuotas").text("");
	$("#lblNTarjeta").text("");
}
function asignarArticulosVectores(){
	var tamTabla = $("#tablaProductos tbody tr").length;
	for(var i=0;i<tamTabla;i++){
		tablaProdCodigo[i]=$("#tablaProductos tbody tr:eq("+i+")").find("td").eq(0).text();
		tablaProdDescripcion[i]=$("#tablaProductos tbody tr:eq("+i+")").find("td").eq(1).text();
		tablaProdMarca[i]=$("#tablaProductos tbody tr:eq("+i+")").find("td").eq(2).text();
		tablaProdCantidad[i] = $("#tablaProductos tbody tr:eq("+i+")").find("td").eq(3).text();
		tablaProdDscto[i]= 0;
		tablaProdVendedor [i]= '';
		tablaProdVFinal [i]= $("#tablaProductos tbody tr:eq("+i+")").find("td").eq(4).text();
		tablaProdIDPreventa[i] = '';
		tablaProdNum[i] = '';
		console.log(tablaProdCodigo[i]);
		console.log(tablaProdDescripcion[i]);
		console.log(tablaProdMarca[i]);
		console.log(tablaProdDscto[i]);
		console.log(tablaProdVendedor[i]);
		console.log(tablaProdVFinal[i]);
		console.log(tablaProdNum[i]);
	}
}
function obtenerFechaAMDHMSM(){
	var d = new Date(); //obtener fecha y hora del host
	var mes = d.getMonth()+1; //obtener mes actual
	var dia = d.getDate(); //obtener dia
	var fechaActual = d.getFullYear() +'-'+ (mes<10 ? '0' : '') + mes+'-' + (dia<10 ? '0' : '') + dia;
	/*FIN FUNCION PARA CARGAR LA FECHA*/
	//FUNCION PARA CARGAR LA HORA
	var hora = d.getHours(); //obtener hora
	var minuto = d.getMinutes(); //obtener minuto
	var segundo = d.getSeconds(); //obtener segundo
	var time = (hora<10 ? '0' : '') + hora +':'+ (minuto<10 ? '0' : '')+ minuto +':'+ (segundo<10 ? '0' : '') + segundo;
	return fechaActual+' '+time;	
}