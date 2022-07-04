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
                    <h2><span class="glyphicon glyphicon-print"></span> Entrega de  Pedido</h2>
                </div>                   
                
                <!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap">
                    <div class="row">
                        <div class="col-md-12">
							<div class="col-lg-6" style ='margin-bottom:2%;'>
									<input class ='col-lg-4' id="txt_idPedido"type="text" placeholder="Codigo" required="" autofocus="true" style ="height:30px;font-size:20px;">
									<button id ="btn_buscar"class="btn btn-md btn-primary col-lg-offset-1 col-lg-3" type="button" style =""> <span class="glyphicon glyphicon-search"></span>Buscar</button>
									<img class ='col-lg-3' style ='margin-top:-20px;'src="img/loading.gif" id ="gif">
							</div>
							<div class="col-lg-6" style ='margin-top:0%;'>
								<button disabled id ="btn_Imprimir"class=" btn-primary btn col-lg-6" type="button" style ="height:50px;font-size:25px;">Imprimir</button>
							</div> 
                            <div class="panel panel-default">
							<div class="panel-heading">Datos Pedido</div>
                                <div class="panel-body">
									<div class="container">								
										<div class ='col-lg-6'>
											<div class="panel panel-default" style ='margin-top:2%'>
												<div class="panel-heading"> <span class="glyphicon glyphicon-user"></span> Cliente <button id ='btnAgregarCliente' hidden><img style ='height :30px;' src="img/addUser.png"/></button>
												<img id ='imgTicket' hidden style ='height :20px;' id="mi_imagen"  src="img/ticket_verde.png"/></div>
												<div class="panel-body"> 
													<div class ='col-lg-7'>
														<h4><span class="label label-default"> RUT :</span><span id ='lblRut'class="label label-default"></span></h4>
														<h4><span class="label label-default"> NOMBRE :</span><span id ='lblNombre'class="label label-default"></span></h4>
														<h4><span class="label label-default"> DIRECCION :</span><span id ='lblDireccion'class="label label-default"></span></h4>
													</div>
													<div class ='col-lg-5'>
														<h4><span class="label label-default"> CIUDAD :</span><span id ='lblCiudad'class="label label-default"></span></h4>
														<h4><span class="label label-default"> EMAIL :</span><span id ='lblEmail'class="label label-default"></span></h4>
														<h4><span class="label label-default"> FONO :</span><span id ='lblFono'class="label label-default"></span></h4>
													</div>
												</div>
											</div>
										</div>
										<div class ='col-lg-0'>
												<button id ='btnAgregarCliente' hidden><img style ='height :70px;' src="img/addUser.png"/></button>
												<img id ='imgTicket' hidden style ='height :70px;' id="mi_imagen"  src="img/ticket_verde.png"/>
										</div>
										<div class ='col-lg-6'>
											<div class="panel panel-default" style ='margin-top:2%'>
												<div class="panel-heading"> <span class="glyphicon glyphicon-credit-card"></span>Pago</div>
												<div class="panel-body">
												<div class ='col-lg-6'>
													<h4><span class="label label-default"> TIPO TARJETA :</span><span id ='tipoTarjeta' class="label label-default"></span></h4>
													<h4><span class="label label-default"> NUMERO TARJETA :</span><span id ='numeroTarjeta' class="label label-default"></span></h4>
												</div>
												<div class ='col-lg-6'>
													<h4><span class="label label-default"> CUOTAS :</span><span id ='cuotas' class="label label-default"></span></h4>
													<h4><span class="label label-default"> COD AUT :</span><span id ='codAut' class="label label-default"></span></h4>
												</div>
												</div>
											</div>
										</div>
										<div class=" row col-lg-12">
											<div>	
												<table id="tabla" class="table tablaProductos" >
													<thead>
														<tr>
															<th><center>Codigo</center></th>
															<th><center>Producto / Descripción</center></th>
															<th hidden><center>Marca</center></th>
															<th><center>Cantidad</center></th>													
															<th><center>Valor</center></th>
															<th><center>STOCK</center></th>															
															<th></th>
														</tr>
													</thead>
													<tbody>
													</tbody>
												</table>
											</div>
										</div>
										<div class="col-lg-6">
											<form class="form-horizontal margenInfoLocal">
												<div class="form-group">
													<label style = "font-size :30px;" class="control-label etiquetaFormulario" for="exampleInputEmail1">TOTAL $</label>
													<label type="text" style = "font-size :30px;" class=" control-label totalPrincipal" id="txt_total" name="total"></label><br>
													<label style = "font-size :30px;" class="control-label etiquetaFormulario" for="exampleInputEmail1">FLETE $</label>
													<label type="text" style = "font-size :30px;" class=" control-label totalPrincipal" id="txt_totalFlete" name="totalFlete"></label>
												</div>
											</form>
										</div>		
									</div>
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
        <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>     
        <script type="text/javascript" src="js/sistema/principal.js"></script>    
               
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






