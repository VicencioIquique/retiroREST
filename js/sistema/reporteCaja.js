$(document).ready(function(){
	$("#btn_pdf").click(function(){
		var fecha = $("#fecha").val();
		$.post("scripts/obtenerReporteCaja.php",{fecha:fecha},function(res){
			
			var total=0;
			var totalCredito=0;
			var totalTransferencia=0;
			var totalDebito=0;
			var totalProd=0;
			var totalFlete=0;
			var res = $.parseJSON(res);
			var doc = new jsPDF('l','pt','letter');
			var fontSize = 8;
			doc.setFont("times", "normal");
			doc.setFontSize(fontSize);
			doc.text(20, 30, "MODULO: E-COMMERCE");
			doc.text(20, 20, "CAJA: ");
			doc.text(45, 20, "3");
			doc.text(350, 30, "INFORME DE CAJA - ");
			doc.text(430, 30, "E-COMMERCE");
			doc.text(20, 40, "DIA DE INFORME:");
			doc.text(90, 40, fecha);
			doc.text(700, 30,"Pagina 1");	

			var margen =20;
			doc.setFont("times", "bold");
			doc.text(margen+20, 80, "Tipo de documento");
			doc.text(margen+100, 80, "Pedido");
			doc.text(margen+200, 80, "Numero Documento");
			doc.text(margen+280, 80, "Total");
			doc.text(margen+320, 80, "Web Pay Debito");
			doc.text(margen+400, 80, "Web Pay Credito");
			doc.text(margen+475, 80, "Transferencia");
			doc.text(margen+540, 80, "Productos");
			doc.text(margen+600, 80, "Flete");
			//FIN CABECERA REPORTE//
			//VALORES DEL REPORTE//
			var altura;
			for(i=0;i<res.length;i++){			
				var pagina = Math.trunc(i/42)+1;
				altura =i;
				if (pagina>1){
					altura = altura -42*(pagina-1);
				}
				if (i % 42==0 && pagina >1){
					doc.addPage();
					doc.text(700, 30,"Pagina "+ pagina);		
					var margen =20;
					doc.setFont("times", "bold");
					doc.text(margen+20, 80, "Tipo de documento");
					doc.text(margen+100, 80, "Pedido");
					doc.text(margen+200, 80, "Numero Documento");
					doc.text(margen+280, 80, "Total");
					doc.text(margen+320, 80, "Web Pay Debito");
					doc.text(margen+400, 80, "Web Pay Credito");
					doc.text(margen+475, 80, "Transferencia");
					doc.text(margen+540, 80, "Productos");
					doc.text(margen+600, 80, "Flete");
					
				}
				doc.setFont("times", "normal");
				doc.text(margen+25, 100+12*altura,res[i]['tipoDocto']);
				doc.text(margen+100, 100+12*altura,res[i]['pedido']);
				doc.text(margen+220, 100+12*altura,res[i]['numerodocto']);
				doc.text(margen+280, 100+12*altura,"$"+format(res[i]['total'].toString()));
				doc.text(margen+335, 100+12*altura,"$"+format(res[i]['wpDebito'].toString()));
				doc.text(margen+420, 100+12*altura,"$"+format(res[i]['wpCredito'].toString()));
				doc.text(margen+490, 100+12*altura,"$"+format(res[i]['Transferencia'].toString()));
				doc.text(margen+545, 100+12*altura,"$"+format(res[i]['productos'].toString()));
				doc.text(margen+600, 100+12*altura,"$"+format(res[i]['flete'].toString()));
				var ultimo=100+12*altura;
				total =total+ res[i]['total'];
				totalCredito=totalCredito+res[i]['wpCredito'];
			 	totalTransferencia=totalTransferencia+res[i]['Transferencia'];
			 	totalDebito=totalDebito+res[i]['wpDebito'];
			 	totalProd=totalProd+res[i]['productos'];
			 	totalFlete=totalFlete+res[i]['flete'];
			}

			//FIN VALORES REPORTE
			//VALORES TOTALES
				doc.setFont("times", "bold");
				doc.text(margen+280, ultimo+40, "Total");
				doc.text(margen+320, ultimo+40, "Web Pay Debito");
				doc.text(margen+400, ultimo+40, "Web Pay Credito");
				doc.text(margen+475, ultimo+40, "Transferencia");
				doc.text(margen+540, ultimo+40, "Productos");
				doc.text(margen+600, ultimo+40, "Flete");

				doc.setFont("times", "normal");
				doc.text(margen+280, ultimo+55,  "$"+format(total.toString()));
				doc.text(margen+335, ultimo+55,  "$"+format(totalDebito.toString()));
				doc.text(margen+420, ultimo+55,  "$"+format(totalCredito.toString()));
				doc.text(margen+490, ultimo+55,  "$"+format(totalTransferencia.toString()));
				doc.text(margen+545, ultimo+55,  "$"+format(totalProd.toString()));
				doc.text(margen+600, ultimo+55,  "$"+format(totalFlete.toString()));
			//FIN VALORES TOTALES
			doc.save('Reporte_E_COMMERCE'+fecha+'pdf');
		});
		
	});
});

function format(nStr)
{
	nStr += '';
	var x = nStr.split('.');
	var x1 = x[0];
	var x2 = x.length > 1 ? '.' + x[1] : '';
	var rgx = /(\d+)(\d{3})/;
	while (rgx.test(x1)) {
		x1 = x1.replace(rgx, '$1' + '.' + '$2');
	}
	return x1 + x2;
}