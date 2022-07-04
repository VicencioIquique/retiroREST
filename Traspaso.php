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
                    <h2><span class="glyphicon glyphicon-print"></span> TRASPASO </h2>
                </div>                   
                
                <!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap">   
					<div class="col-md-12">
						<div class="col-lg-6" style ='margin-bottom:2%;'>
								<input class ='col-lg-4' id="txt_Dsm"type="text" placeholder="Codigo" required="" autofocus="true" style ="height:30px;font-size:20px;">
								<button id ="btn_buscar"class="btn btn-md btn-primary col-lg-offset-1 col-lg-3" type="button" style =""> <span class="glyphicon glyphicon-search"></span>Buscar</button>
								 <!-- <img class ='col-lg-3' style ='margin-top:-20px;'src="img/loading.gif" id ="gif"> -->  
						</div>

                        <div class="col-lg-6" style ='margin-bottom:2%;'>
								<button id ="btn_Validar"class="btn btn-md btn-info col-lg-offset-1 col-lg-3" type="button" style ="" disabled> <span class="">Validar</span></button>
						</div>
						
						<div class=" row col-lg-12">
							<div>	
								<table id="tablaDem" class="table tablaProductos" >
									<thead>
										<tr>
                                            <th><center>Nro</center></th>
                                            <th><center>Origen</center></th>
                                            <th><center>Destino</center></th>
											<th><center>SKU</center></th>
											<th><center>Producto</center></th>
											<th><center>Cantidad</center></th>
											<th><center>Estado</center></th>	
											<th></th>
										</tr>
									</thead>
									<tbody>
									</tbody>
								</table>
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
        
    <!-- START SCRIPTS -->
        <!-- START PLUGINS -->
        <script type="text/javascript" src="js/plugins/jquery/jquery.min.js"></script>
        <script type="text/javascript" src="js/plugins/jquery/jquery-ui.min.js"></script>
        <script type="text/javascript" src="js/plugins/bootstrap/bootstrap.min.js"></script>              
        <script type="text/javascript" src="js/sistema/traspaso.js"></script>              
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






