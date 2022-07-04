<!DOCTYPE html>
<html lang="en">
    <head>        
        <!-- META SECTION -->
        <title>PUNTO DE RETIRO</title>            
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
		
        
        <link rel="icon" href="favicon.ico" type="image/x-icon" />
        <!-- END META SECTION -->
        
        <!-- CSS INCLUDE -->        
        <link rel="stylesheet" type="text/css" id="theme" href="css/theme-default.css"/>
        <!-- EOF CSS INCLUDE -->
    </head>
    <body>
        <!-- START PAGE CONTAINER -->
        <div class="page-container">
            <!-- START PAGE SIDEBAR -->
           <?php include 'sidebar.php'; ?>
            <!-- END PAGE SIDEBAR -->
            
            <!-- PAGE CONTENT -->
            <div class="page-content">
                
                <!-- START X-NAVIGATION VERTICAL -->
                <ul class="x-navigation x-navigation-horizontal x-navigation-panel">
                    <!-- TOGGLE NAVIGATION -->
                    <li class="xn-icon-button">
                        <a href="#" class="x-navigation-minimize"><span class="fa fa-dedent"></span></a>
                    </li>
                    <!-- END TOGGLE NAVIGATION -->                    
                </ul>
                <!-- END X-NAVIGATION VERTICAL -->                     
                
                <!-- START BREADCRUMB -->

                <!-- END BREADCRUMB -->                
                
                <div class="page-title">                    
                    <h2><span class="glyphicon glyphicon-print"></span> Revision de Boletas</h2>
                </div>                   
                
                <!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap"> 
					<div>
						<div class="form-group col-lg-2">
								<label>Periodo </label>
								<input type="date" class="form-control" id="fecha" name="fecha">
						</div>
						<div class="form-group col-lg-2">
								<label>Número de documento</label>
								<input type="text" class="form-control col-lg-12" id="numeroDocto" name="numeroDocto">
						</div>
						<div class="form-group col-lg-4">
								<button id ="btn_Buscar"class="btn btn-md btn-primary col-lg-5" style ='margin-top: 20px;'type="button" >Buscar</button>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-12 colTablaRevisarBoleta" style ='height:100px; height:500px;overflow: scroll;'>
							<table id="tablaRevisarBoletas" class="table">
								<thead>
									<tr>
										<th><center>Tipo documento</center></th>
										<th><center>Numero documento</center></th>
										<th><center>Fecha</center></th>
										<th><center>Monto</center></th>
										<th><center>Detalle</center></th>
										<th><center>Pago</center></th>
									</tr>
								</thead>
								<tbody>
								</tbody>
							</table>
						</div>
					</div>
					<div class="modal fade" id="modalDetalleBoleta" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"style ='margin-top:10%;'>
					  <div class="modal-dialog modal-lg">
							<div class="modal-content">
								<div class="modal-body" >
								<table id="tablaDetalle" class="table">
									<thead>
										<tr>
											<th><center>Secuencia</center></th>
											<th><center>Tipo documento</center></th>
											<th><center>Número Documento</center></th>
											<th><center>Sku</center></th>
											<th><center>Descripcion</center></th>
                                            <th><center>Cantidad</center></th>
											<th><center>Descuento</center></th>
											<th><center>PrecioOriginal</center></th>
											<th><center>PrecioFinal</center></th>
											<!-- <th><center>Vendedor</center></th> -->
										</tr>
									</thead>
									<tbody>
									</tbody>
								</table>
								</div>											
							</div>
						</div>
					</div>
					<div class="modal fade" id="modalPagoBoleta" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"style ='margin-top:10%;'>
					  <div class="modal-dialog modal-lg">
							<div class="modal-content">
								<div class="modal-body" >
								<table id="tablaPago" class="table">
									<thead>
										<tr>
											<th><center>Secuencia</center></th>
											<th><center>Tipo documento</center></th>
											<th><center>Número Documento</center></th>
											<th><center>Tipo Pago</center></th>
											<th><center>Cuotas</center></th>
											<th><center>FechaDoc</center></th>
											<th><center>Monto</center></th>
											<th><center>NumTarjeta</center></th>
											<th><center>Codigo Autorización</center></th>
										</tr>
									</thead>
									<tbody>
									</tbody>
								</table>
								</div>											
							</div>
						</div>
					</div>
                </div>
                <!-- END PAGE CONTENT WRAPPER -->                
            </div>            
            <!-- END PAGE CONTENT -->
        </div>
        <!-- END PAGE CONTAINER -->

        <!-- MESSAGE BOX-->
        <div class="message-box animated fadeIn" data-sound="alert" id="mb-signout">
            <div class="mb-container">
                <div class="mb-middle">
                    <div class="mb-title"><span class="fa fa-sign-out"></span> Log <strong>Out</strong> ?</div>
                    <div class="mb-content">
                        <p>Are you sure you want to log out?</p>                    
                        <p>Press No if youwant to continue work. Press Yes to logout current user.</p>
                    </div>
                    <div class="mb-footer">
                        <div class="pull-right">
                            <a href="pages-login.html" class="btn btn-success btn-lg">Yes</a>
                            <button class="btn btn-default btn-lg mb-control-close">No</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END MESSAGE BOX-->

        <!-- START PRELOADS -->
        <audio id="audio-alert" src="audio/alert.mp3" preload="auto"></audio>
        <audio id="audio-fail" src="audio/fail.mp3" preload="auto"></audio>
        <!-- END PRELOADS -->                 
        
    <!-- START SCRIPTS -->
        <!-- START PLUGINS -->
        <script type="text/javascript" src="js/plugins/jquery/jquery.min.js"></script>
        <script type="text/javascript" src="js/plugins/jquery/jquery-ui.min.js"></script>
        <script type="text/javascript" src="js/plugins/bootstrap/bootstrap.min.js"></script>  
		<script type="text/javascript" src="js/sistema/revBoletas.js"></script> 		
               
        <!-- END PLUGINS -->

        <!-- THIS PAGE PLUGINS -->

        <!-- END PAGE PLUGINS -->         

        <!-- START TEMPLATE -->
        <script type="text/javascript" src="js/plugins.js"></script>        
        <script type="text/javascript" src="js/actions.js"></script>        
        <!-- END TEMPLATE -->
    <!-- END SCRIPTS -->         
    </body>
</html>






