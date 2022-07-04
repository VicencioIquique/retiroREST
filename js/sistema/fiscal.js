$(document).ready(function(){
	$("#abrirPeriodo").click(function(){
		var comprobacion = false; //Variable para comprobar si se ha obtenido el XML de respuesta, si es así deja de buscar este
		//Generar XML para abrir periodo fiscal
		$.post("http://localhost/puntoVentaXml/crearXMLAbrirPeriodo.php",{},function(){});
		var interval = setInterval(function(){
				if(comprobacion){
					return;
				}
				$.post("http://localhost/puntoVentaXML/obtenerXMLBoleta.php",{ID:'abrirPeriodo'},function(resXML){
						var resXML = $.parseJSON(resXML);
						comprobacion=true;
						var Codigo = resXML['Codigo'];
						var Mensaje = resXML['Mensaje'];
						var Folio = resXML['Folio'];
						if(Mensaje != '000'){
							alert(Mensaje);
						}else{
							alert("Periodo fiscal abierto correctamente");
						}	
					
				});
		},1000);
	});
	$("#informeX").click(function(){
		var comprobacion = false; //Variable para comprobar si se ha obtenido el XML de respuesta, si es así deja de buscar este
		$.post("http://localhost/puntoventaXml/crearXMLInformeX.php",{},function(){});
		var interval = setInterval(function(){
				if(comprobacion){
					return;
				}
				$.post("http://localhost/puntoVentaXML/obtenerXMLBoleta.php",{ID:'informeX'},function(resXML){
					var resXML = $.parseJSON(resXML);
					comprobacion=true; // parar el intervalo
					var Codigo = resXML['Codigo'];
					var Mensaje = resXML['Mensaje'];
					var Folio = resXML['Folio'];
					if(Mensaje != '000'){
						alert(Mensaje);
					}else{
						alert("Informe X generado correctamente");
					}	
				});
		},1000);
	});
	$("#cerrarPeriodo").click(function(){
		var mensaje = confirm("¿Está seguro que desea cerrar el periodo fiscal?");
		if (mensaje){
			var comprobacion = false; //Variable para comprobar si se ha obtenido el XML de respuesta, si es así deja de buscar este
			$.post("http://localhost/puntoventaXML/crearXMLCerrarPeriodo.php",{},function(){});
			var interval = setInterval(function(){
					if(comprobacion){
						return;
					}
					$.post("http://localhost/puntoVentaXML/obtenerXMLBoleta.php",{ID:'CerrarPeriodo'},function(resXML){
							var resXML = $.parseJSON(resXML);
							comprobacion=true; // parar el intervalo
							var Codigo = resXML['Codigo'];
							var Mensaje = resXML['Mensaje'];
							var Folio = resXML['Folio'];
							if(Mensaje != '000'){
								alert(Mensaje);
							}else{
								alert("Periodo fiscal cerrado correctamente");
							}	
					});
			},1000);
		}
	});
});

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