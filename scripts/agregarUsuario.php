<?php 
	session_start();
	require_once("../clases/conexionocdb.php"); // se hace referencia a la clase conexion que contiene los parametros para entrar a sql server
	$rut = $_POST['rut'];
	$nombres = $_POST['nombres'];
	$fechaIngreso = date('Y-m-d H:i:s'); //Obtener fecha actual del servidor para FechaCreacion
	$direccion = $_POST['direccion'];
	$apellidoPaterno ='';
	$ciudad = $_POST['ciudad'];
	$fono = $_POST['fono'];
	$email = $_POST['email'];
	$agregarUsuario = "INSERT INTO [RP_VICENCIO].[dbo].[Clientes]
								  ( RUT, 
									Nombres,
									Direccion,
									Ciudad,
									Fecha_Nacimiento,
									Fecha_Ingreso,
									Comuna,
									Fono
									Email,
									Sexo,
									Nacionalidad
									)
							VALUES('".$rut."',
									'".$nombres."',
									'".$direccion."',
									'".$ciudad."',
									'1930-01-01',
									'2020-01-20 19:07:30.000',
									'".$ciudad."',
									'".$fono."',
									'".$email."',
									'Masculino',
									'CHILE')";
	$rsAgregarUsuario = odbc_exec( $conn, $agregarUsuario );
	if (!$rsAgregarUsuario){  //si la fila esta vacia no entra
		echo( "Error en la consulta Agregar Usuario" );
	}	
	if($rsAgregarUsuario){
		echo 4; //Usuario agregado correctamente
	}else{
		echo 3; //Problema al agregar
	}
?>