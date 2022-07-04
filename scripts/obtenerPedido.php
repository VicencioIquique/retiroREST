<?php
require("../clases/conexion.php");
$id=$_POST["id"];


	$sql = "SELECT carro.sku,producto.nombre,marca.marca,carro.cantidad,producto.precio,usuarios.rut as rut,concat(detalle_cliente.nombres,' ',detalle_cliente.apellido_p)as nombres 
	FROM compras as compras 
	left JOIN carro_detalle as carro on compras.idcarro = carro.idcarro 
	left join producto on carro.idproducto = producto.id 
	left join marca on producto.marca = marca.id 
	left join usuarios on usuarios.id =compras.idusuario 
	left join detalle_cliente on detalle_cliente.id_usuario =usuarios.id 
	WHERE compras.id ='".$id."'";
	
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
	}
    // output data of each row
    while($row = $result->fetch_assoc()) {
		$res[] = array(
			"sku"=>$row['sku'],
			"descripcion"=>$row['nombre'],
			"marca"=>$row['marca'],	
			"cantidad"=>$row['cantidad'],
			"precio"=>$row['precio'],
			"rut"=>$row['rut'],	
			"nombre"=>$row['nombres'],
		);
    }
	echo json_encode($res);
	
?>