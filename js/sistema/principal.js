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
var comprobacionBoleta =false;
var tipoPagoBoleta; // para identificar en la impresion de la boleta si es credito 3 o debito 4
var fechaCreacion;
var numeroPedido;
let flag;
$(document).ready(function(){
	$("#gif").hide();
	var total =0;
	$("#btn_buscar").click(async function(){
		$("#gif").show(); // gif de carga
		total =0;
		var idCompra = $("#txt_idPedido").val();
		
		try {
			
			const resp = await axios.get(`http://192.168.3.41:8008/api/orders?reference=${idCompra}`);
			
			const orders = resp.data;
			
			const pago = JSON.parse(Object.values(orders.orders[0].ps_webpay_rest_transaction));
			const detalle = (orders.orders[0].ps_order_details);
            console.log(detalle);
			const direccion = (orders.orders[0].ps_address);
			const cliente = (orders.orders[0].ps_customer);
			
            if (orders == null) {
				alert("Error al obtener Datos de Compra");
				$("#gif").hide();
			}else{
				let rutFormat = formatearRut(direccion.dni);
				console.log();
				if (orders.orders[0].current_state == 3) {
					if (detalle[0].product_ean13 == null) {
						alert("Error al obtener Productos");
						$("#gif").hide();
					}else{
						limpiarTabla();
						// Cliente y Direccion
						$("#lblRut").text(rutFormat);
						$("#lblNombre").text(direccion.firstname + " " + direccion.lastname);
						$("#lblCiudad").text(direccion.city);
						$("#lblDireccion").text(direccion.address1);
						$("#lblEmail").text(cliente.email);
						$("#lblFono").text(direccion.vat_number);
	
						//Pagos
	
						if(pago.paymentTypeCode=='VD'|| pago.paymentTypeCode=='' ){
							$("#tipoTarjeta").text("Débito");
							tipoPagoBoleta =4;
							$("#cuotas").text(pago.installmentsNumber);
							}else{
							$("#tipoTarjeta").text("Crédito");
							if (pago.installmentsNumber==0 || pago.installmentsNumber==""){
								$("#cuotas").text(1);
							}else{													
								$("#cuotas").text(pago.installmentsNumber);
							}
							tipoPagoBoleta =3;
						}
							$("#numeroTarjeta").text(pago.cardDetail.card_number);
							$("#codAut").text(pago.authorizationCode);
						
							//Detalle Orden

							let stockArray = detalle.map(async (producto, i) =>{
								const res = await $.post('scripts/apiPrestaShop/obtenerStock.php', {sku: producto.product_ean13, upc: producto.product_upc})
								// console.log(res); //res;
								return JSON.parse(res)[0]
							})
							stockArray = await Promise.all(stockArray);
							
							// const prom = await Promise.all(

								detalle.forEach( (det, idx) => {
									// console.log(det.product_ean13)
									try {
		
									// const stocki = await $.post('scripts/apiPrestaShop/obtenerStock.php', {sku: det.product_ean13, upc: det.product_upc}, function(resStock){
									// 	let stock = JSON.parse(resStock);
									// 	console.log("flag" + stock[0].stock);
									// 	return stock
									// })
									
									total = total + Math.round(Number(det.total_price_tax_incl))//*Number(det.product_quantity);
									tablaProdVOrig[idx]= Math.round(Number(det.unit_price_tax_incl));
									var color;
									
									if(Number(det.product_quantity) > stockArray[idx].stock){
										color = 'red'; //marco en rojo lo que no tiene stock
										flag = true; // deshabilito el boton imprimir para evitar impresion erronea.
									}else {
										color ='#B0F36E';
									}
									$("#tabla tbody").append('<tr>'+
										'<td style ="font-size:15px;background-color:'+color+'"><center>'+det.product_ean13+'</center></td>'+
										'<td style ="font-size:12px;background-color:'+color+'"><center>'+det.product_name+'</center></td>'+
										//'<td style ="font-size:15px;"><center>'+resProductos[i]['marca']+'</center></td>'+
										'<td style ="font-size:15px;background-color:'+color+'"><center>'+det.product_quantity+'</center></td>'+
										'<td style ="font-size:15px;background-color:'+color+'"><center>'+Number(det.total_price_tax_incl)+'</center></td>'+
										'<td style ="font-size:15px;background-color:'+color+'"><center>'+stockArray[idx].stock+'</center></td>'+
										'</tr>');

									numeroPedido = orders.orders[0].id_order;
									fechaCreacion = orders.orders[0].date_add;
									if (flag) {
										$('#btn_Imprimir').attr("disabled", true);
									} else {
		
										$("#btn_Imprimir").attr( "disabled", false );
									}
									$("#txt_total").text(Number(orders.orders[0].total_paid));					
									$("#txt_totalFlete").text(Number(orders.orders[0].total_shipping));
									$("#gif").hide();
								
								// console.log(idx + " " + tablaProdVOrig[idx]);
									
								} catch (error) {
									console.error(error);
								}
								
																
								}) //aqui
								console.log("TOTAL: " + total)
							
						flag = false;			
					}
				} else {
					alert("Este pedido ya fue impreso.")
					$("#gif").hide();
				}
				
			}
            
        } catch (error) {
            console.log(error);
            return [];
        }
		// $.post("scripts/apiPrestaShop/obtenerCliente.php",{id:idCompra},function(resCliente){

		// 	var resCliente = $.parseJSON(resCliente);
		// 	if(resCliente == null){
		// 		alert("Error al obtener Datos Clientes");
		// 		$("#gif").hide();
		// 	}else{
		// 				var rutFormat = formatearRut(resCliente['rut']);
		// 				//$.post("scripts/obtenerClienteRP.php",{rut:rutFormat},function(resClienteRp){
		// 					//var resClienteRp = $.parseJSON(resClienteRp);
		// 					$.post("scripts/apiPrestaShop/obtenerPedidosPS.php",{id:idCompra},function(res){
		// 						var resProductos = $.parseJSON(res);
		// 						if(resProductos[0]['sku'] ==null){
		// 							alert("Error al obtener Productos");
		// 							$("#gif").hide();
		// 						}else{
		// 							$.post("scripts/apiPrestaShop/obtenerTransporte.php",{id:idCompra},function(resFlete){
		// 								limpiarTabla();
		// 								$("#imgTicket").show();
		// 								$("#btnAgregarCliente").hide();
		// 								$("#btn_Imprimir").attr( "disabled", false );
		// 								var carro = resCliente['carro'];
		// 								numeroPedido = resCliente['nPedido'];
		// 								fechaCreacion = resCliente['fechaPedido'];
		// 								//---------------------------------OBTENER LOSPAGOS (BD PRESTA SHOP)---------------------------------------------------------
		// 								$.post("http://www.vicencioperfumerias.cl/confirmacion/ConsultaPagos.php",{carro:carro},function(resLogPagos){
		// 									var resLogPagos = $.parseJSON(resLogPagos);
		// 									if(resLogPagos[0]['TipoPago']=='Venta Debito'|| resLogPagos[0]['TipoPago']=="" ){
		// 									$("#tipoTarjeta").text("Debito");
		// 									tipoPagoBoleta =4;
		// 									$("#cuotas").text(resLogPagos[0]['Cuotas']);
		// 									}else{
		// 									$("#tipoTarjeta").text("Credito");
		// 									if (resLogPagos[0]['Cuotas']==0 || resLogPagos[0]['Cuotas']==""){
		// 										$("#cuotas").text(1);
		// 									}else{													
		// 										$("#cuotas").text(resLogPagos[0]['Cuotas']);
		// 									}
		// 									tipoPagoBoleta =3;
		// 									}
		// 									$("#numeroTarjeta").text(resLogPagos[0]['numeroTarjeta']);
		// 									$("#codAut").text(resLogPagos[0]['CodAutorizacion']);
																	
		// 								});
		// 								//---------------------------------------------------------------------------------------------
		// 								$("#lblRut").text(rutFormat);
		// 								$("#lblNombre").text(resCliente['nombre']+' '+resCliente['apellido']);
		// 								$("#lblCiudad").text(resCliente['ciudad']);
		// 								$("#lblDireccion").text(resCliente['direccion1']);
		// 								$("#lblEmail").text(resCliente['email']);
		// 								$("#lblFono").text(resCliente['fono']);
		// 								for(i=0;i<resProductos.length;i++){											
		// 									total = total + parseInt(resProductos[i]['precio'])*parseInt(resProductos[i]['cantidad']);
		// 									tablaProdVOrig[i]= resProductos[i]['precio'];
		// 									var color;
		// 									if(parseInt(resProductos[i]['cantidad'])>parseInt(resProductos[i]['stock'])){
		// 									 color = 'red';
		// 									}else {
		// 									color ='#B0F36E';
		// 									}
		// 									$("#tabla tbody").append('<tr>'+
		// 									'<td style ="font-size:15px;background-color:'+color+';"><center>'+resProductos[i]['sku']+'</center></td>'+
		// 									'<td style ="font-size:12px;background-color:'+color+';"><center>'+resProductos[i]['descripcion']+'</center></td>'+
		// 									//'<td style ="font-size:15px;"><center>'+resProductos[i]['marca']+'</center></td>'+
		// 									'<td style ="font-size:15px;background-color:'+color+';"><center>'+resProductos[i]['cantidad']+'</center></td>'+
		// 									'<td style ="font-size:15px;background-color:'+color+';"><center>'+parseInt(resProductos[i]['precio'])*parseInt(resProductos[i]['cantidad'])+'</center></td>'+
		// 									'<td style ="font-size:15px;background-color:'+color+';"><center>'+resProductos[i]['stock']+'</center></td>'+
		// 									'</tr>');
		// 								}								
		// 								$("#txt_total").text(total);									
		// 								var resFlete = $.parseJSON(resFlete);
		// 								$("#txt_totalFlete").text(resFlete['flete']);
		// 								$("#gif").hide();
		// 							});
		// 						}
		// 					});
		// 				//});
		// 			//}
		// 		//});
		// 	}
		// });
	});
	$("#btnAgregarCliente").click(function(){
		var rut = $("#lblRut").text();
		var nombres = $("#lblNombre").text();
		var ciudad = $("#lblCiudad").text();
		var direccion =$("#lblDireccion").text();
		var email = $("#lblEmail").text();
		var fono = $("#lblFono").text();
		$.post("scripts/agregarUsuario.php",{rut:rut,nombres:nombres,direccion:direccion,ciudad:ciudad,email:email,fono:fono},function(res){
			if (res ==4){
				$("#imgTicket").show();
				$("#btnAgregarCliente").hide();
				$("#btn_Imprimir").attr( "disabled", false );
			}else if(res ==3){
				alert("problema al agregar cliente");
			}else{
				alert(res);
			}
		});
	});
//--------------------------------------------------------------------IMPRIMIR BOLETA-------------------------------------------------------------------
	$("#btn_Imprimir").click(function(){
		$('#btnSubmit').attr("disabled", true);
		asignarArticulosVectores(); // los articulos cargados en la tabla asignarlos a respectivos vectores pra post inserccion
		var fechaDocto = obtenerFechaAMDHMSM();
		var fechaID = fechaDocto.replace(':','');
		fechaID = fechaID.replace(':','');
		fechaID = fechaID.replace('-','');
		fechaID = fechaID.replace('-','');
		fechaID = fechaID.replace(' ','');  //se deja la fecha y hora alcual sin puntos ni guion
		var tipoDocto ='1';
		//---------------------------------------------------------------FISCAL------------------------------------------------------------------------------
		var itemProductos ='';
		for (var i =0;i<tablaProdCodigo.length;i++){ // asignar productos a un string para poder imprimirlos en la Fiscal
			console.log(i + " " + tablaProdVOrig[i]);
			itemProductos = itemProductos
								+'<Item>'+'<Codigo></Codigo>'+
								'<Descripcion>'+tablaProdCodigo[i]+' '+tablaProdDescripcion[i]+'</Descripcion>'+
								'<Precio>'+tablaProdVOrig[i]+'</Precio>'+
								'<Cantidad>'+tablaProdCantidad[i]+'</Cantidad>'+
								'<MonDescuento>'+tablaProdDscto[i]+'</MonDescuento>'+
								'<DesDescuento>'+tablaProdDscto[i]+'</DesDescuento>'+
								'<Total>'+tablaProdVFinal[i]+'</Total>'+
								'</Item>';
							}
							console.log("itemProductos " + itemProductos);
		var xml  = ('<Cabecera>'+
									'<Cliente>'+
										'<Rut>'+$("#lblRut").text()+'</Rut>'+
										'<Nombre>'+$("#lblNombre").text()+'</Nombre>'+
									'</Cliente>'+
									'<Vendedor>'+
										'<Rut></Rut>'+
										'<Nombre></Nombre>'+
									'</Vendedor>'+
									'<Montos>'+
										'<SubTotal>'+total+'</SubTotal>'+
										'<MonDescuento>0</MonDescuento>'+
										'<DesDescuento>0</DesDescuento>'+
										'<Total>'+total+'</Total>'+
									'</Montos>'+
								'</Cabecera>'+
								'<Detalle>'+itemProductos+'</Detalle>'+
								'<Pagos>'+
									'<Item>'+
										'<Tipo>'+tipoPagoBoleta+'</Tipo>'+
										'<Descripcion>'+$("#tipoTarjeta").text()+'</Descripcion>'+
										'<Monto>'+total+'</Monto>'+
									'</Item>'+
								'</Pagos>'+
							'</Fiscal>'+
							'<NoFiscal>'+
							'<Comentarios>'+'COSTO DE ENVIO :$ '+$("#txt_totalFlete").text()+
							'<Texto>Numero de Referencia : '+$("#txt_idPedido").val()+'</Texto>'+
							'<Texto>Numero de Pedido : '+numeroPedido+'</Texto>'+
							'</Comentarios>'+
							'</NoFiscal>'+
						'</Documento>');
						// console.log(xml);
	$.post("http://localhost/puntoVentaXML/crearXMLBoleta.php",{ID:'boleta'+fechaID,xml:xml},function(){});
//-------------------------------------------------------------------------FISCAL------------------------------------------------------------------------
		var interval = setInterval(function(){
			if(comprobacionBoleta){
				return;
			}
			$.post("http://localhost/puntoVentaXML/obtenerXMLBoleta.php",{ID:'boleta'+fechaID},function(resXML){
				console.log("entro", resXML);
				var resXML = $.parseJSON(resXML);	
				comprobacionBoleta = true;
				
				var codigoXML = resXML['Codigo'];
				var mensajeXML = resXML['Mensaje'];
				var folio = resXML['Folio'];
				var totalXML =  ($(resXML).find('Fiscal').find('Pagos').find('Item').find('Monto').text()); //listo
				if(codigoXML =='0'){
//--------------------------------------------------------------------------------------------------------------------------------------------------------
					var ID = tipoDocto + workstation + bodega +  folio + fechaID;
					var jsonBoletaDetalle = {
						tablaProdAluSplit:tablaProdCodigo,
						bodega:bodega,
						tablaProdCantidadSplit:tablaProdCantidad,
						boletaTipoDocto:'1',
						tipoDocto:'1',
						numeroDocto:folio, // pendiente
						tablaProdDsctoSplit:tablaProdDscto,
						tablaProdVOrigSplit:tablaProdVOrig,
						tablaProdVendedorSplit:tablaProdVendedor,
						tablaProdVFinalSplit:tablaProdVFinal,
						factor:0,
						workstation:workstation,
						ID:ID,
						numListaPrecio: '',
						tablaProdNumSplit:tablaProdNum,
						codigoBarra:tablaProdCodigo,
						tablaProdIDPreventaSplit:tablaProdIDPreventa,
						totalImpuesto:'Taxable',
						porcentajeImpuesto:0,
						aux:0,
						attr:'',
						codPromo:0							
					};
					var jsonBoletaCabecera = {
						bodega:bodega,
						workstation:workstation,
						tipoDocto:tipoDocto,
						numeroDocto:folio,
						fechaDocto:fechaDocto,
						totNeto:total, //Total tablaProdVFinalSplit
						totDescuento:0,
						totIva:0,
						total:total, //Total tablaProdVFinalSplit
						rutCliente:$("#lblRut").text(),
						rutDespacho:$("#lblRut").text(),
						cajera: '126',
						//retencionDL18219 -> Calculado en insertarBoleta.php
						//tipoCambio -> Obtenido en insertarBoleta.php
						//CIF -> Calculado en insertarBoleta.php
						//totNetoRetencion -> Calcular insertarBoleta.php (Total - RetencionDL)
						vendedorNumero:'126', //Vendedor único asignado en vprincipal (en la cabecera no se necesita el arreglo de vendedores)
						estado:0,
						numeroDoctoRef: '',
						fechaDoctoRef: '',
						ID:ID,
						fechaCreacion :fechaCreacion,
						//serie -> Equivalencia de SAP
						retencionCarnes:$("#txt_totalFlete").text(),
						netoRetencionCarnes:0,
						//shipToAdress2 -> Pendiente
						billToCompany:$("#txt_idPedido").val(),
						//shipToFName -> Pendiente
						type:0,
						Status:2,
						baseEntry:''
					};
					//console.log("tablaProdAluSplit " + jsonBoletaDetalle.tablaProdAluSplit);
					//console.log("tablaProdVOrigSplit " + jsonBoletaDetalle.tablaProdVOrigSplit);
						var cdCuent;
						var tipoPag;
						var desc4;
						if($("#tipoTarjeta").text()=='Débito'){
							cdCuent='WP_TD';
							tipoPag='WEBPAYDEBITO';
							desc4 ='1';
						}else if ($("#tipoTarjeta").text()=='Crédito'){
							cdCuent='WP_TC';
							tipoPag='WEBPAYCREDITO';
							desc4 ='2';
						}
					var jsonBoletaPagos = {
						bodega:bodega,
						tipoDocto:tipoDocto,
						numeroDocto:folio,
						//secuencia: calculada en insertarBoleta.php
						tipoPago:tipoPag,
						NumeroDoc:$("#cuotas").text(),
						fechaDoc:fechaDocto,
						monto:total+parseInt($("#txt_totalFlete").text()),
						desc1:cdCuent,
						desc2:$("#numeroTarjeta").text(),
						desc3:$("#codAut").text(),
						desc4:desc4,
						CdCuenta:cdCuent,
						workstation:workstation,
						ID:ID,
						fechaCheque:''
					};
					var aux = 0;
					var idCompra = $("#txt_idPedido").val();
					console.log(jsonBoletaPagos);
					alert(jsonBoletaPagos);
					
//---------------------------------------------------------------------------------------------------------------------------------------------------------
						$.post("scripts/insertarBoleta.php",{jsonBoletaDetalle:jsonBoletaDetalle, jsonBoletaCabecera: jsonBoletaCabecera, jsonBoletaPagos:jsonBoletaPagos},function(res){
							// console.log((res));
							if(res == 1){
								$.post("scripts/apiPrestaShop/actualizarPedido.php",{idCompra : idCompra},function(res){
									//alert(res);
								});
								
								alert("La boleta se insertó correctamente");
								location.reload();
							}else{
								alert("Error en la inserción de la boleta");
							}
						});
						
				}else if(codigoXML == '401' || codigoXML == '100'){
					alert('Código1: '+codigoXML+' Mensaje: '+mensajeXML + ' - Por favor compruebe la conexión de la impresora al equipo e intente imprimir la boleta nuevamente');
					comprobacionBoleta = true;
				}else{
					alert('Código2: '+codigoXML+' Mensaje: '+mensajeXML);
					comprobacionBoleta = true;
				}
			});
		},1000);
//-------------------------------------------------------------------------------- FIN IMPRIMIR BOLETA -------------------------------------------------------------------------
	}); // imprimir boleta cierre
}); // document ready cierre


function asignarArticulosVectores(){
	var tamTabla = $("#tabla tbody tr").length;
	for(var i=0;i<tamTabla;i++){
		tablaProdCodigo[i]=$("#tabla tbody tr:eq("+i+")").find("td").eq(0).text();
		tablaProdDescripcion[i]=$("#tabla tbody tr:eq("+i+")").find("td").eq(1).text();
		tablaProdCantidad[i] = $("#tabla tbody tr:eq("+i+")").find("td").eq(2).text();
		tablaProdDscto[i]= 0;
		tablaProdVendedor [i]= '126';
		tablaProdVFinal [i]= $("#tabla tbody tr:eq("+i+")").find("td").eq(3).text();
		tablaProdIDPreventa[i] = '';
		tablaProdNum[i] = '';
	}
}
function limpiarTabla(){
	$("#tabla tbody tr").remove();
	$("#lblRut").text("");
	$("#lblNombre").text("");
	tablaProdCodigo = [];
	tablaProdDescripcion = [];
	tablaProdMarca = [];
	tablaProdCantidad = [];
	tablaProdDscto = [];
	tablaProdVOrig = [];
	tablaProdVendedor = [];
	tablaProdVFinal = [];
	tablaProdIDPreventa = [];
	tablaProdNum = [];
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
function download(filename, text) {
	var pom = document.createElement('a'); //Creación de elemento 'a' para incorporar atributos para descargar
	pom.setAttribute('href', 'data:text/xml;charset=utf-8,' + encodeURIComponent(text)); // agregar atributo href con el contenido del tipo MIME de xml y la estructura en sí
	pom.setAttribute('download', filename+'.xml'); //agregar atributo de tipo download y el nombre del archivo que se desea
	if (document.createEvent) { //creación de evento para la inicalización del elemento 'a'
		var event = document.createEvent('MouseEvents');
		event.initEvent('click', true, true);
		pom.dispatchEvent(event);
	}
	else {
		pom.click();
	}
}
function formatearRut(rut){ // agregar guion si no lo tiene... si lo tiene no lo agrega y lo deja igual
	tamano = parseInt(rut.length);
	if(rut[tamano-2] =='-'){
		return rut;
	}else{
	  var nuevoRut;
	  nuevoRut = rut.substr(0,tamano-1)+"-"+rut.substr(tamano-1,1);
	  return nuevoRut;
	}
}