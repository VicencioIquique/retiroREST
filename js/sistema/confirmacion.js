$(document).ready(function(){
    $("#btn_buscar").click(function(){
        $("#tablaDem tbody tr").remove();      
        $.post("http://www.vicencioperfumerias.cl/confirmacion/confirmacionWP.php",{},function(res){
            var res = $.parseJSON(res);
            for(i=0;i<res.length;i++){
                $("#tablaDem tbody").append('<tr>'+
                    '<td style ="font-size:15px;"><center>'+res[i]['orden_compra']+'</center></td>'+
                    '<td style ="font-size:12px;"><center>'+res[i]['CodAutorizacion']+'</center></td>'+
                    '<td style ="font-size:15px;"><center>'+res[i]['TipoPago']+'</center></td>'+
                    '<td style ="font-size:15px;"><center>'+res[i]['Fecha']+'</center></td>'+
                    '<td style ="font-size:15px;"><center>'+res[i]['Cuotas']+'</center></td>'+
                    '<td style ="font-size:15px;"><center>'+res[i]['RESPUESTA']+'</center></td>'+
                    '</tr>');
                }
        });
    });
});




