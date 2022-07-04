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
                    <h2><span class="glyphicon glyphicon-print"></span> Reporte Caja</h2>
                </div>                   
                <!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap"> 
					<div>
						<div class="form-group col-lg-2">
								<label>Periodo </label>
								<input type="date" class="form-control" id="fecha" name="fecha">
						</div>
						<div class="form-group col-lg-4">
								<button id ="btn_pdf"class="btn btn-md btn-primary col-lg-5" style ='margin-top: 20px;'type="button" >Generar</button>
						</div>
					</div>
                </div>
                <!-- END PAGE CONTENT WRAPPER -->                
            </div>            
            <!-- END PAGE CONTENT -->
        </div>
        <!-- END PAGE CONTAINER -->          

    <!-- START SCRIPTS -->
        <!-- START PLUGINS -->
        <script type="text/javascript" src="js/plugins/jquery/jquery.min.js"></script>
        <script type="text/javascript" src="js/plugins/jquery/jquery-ui.min.js"></script>
        <script type="text/javascript" src="js/plugins/bootstrap/bootstrap.min.js"></script>  
		<script type="text/javascript" src="js/plugins/pdf/jspdf1.5.3.js"></script> 		
		<script type="text/javascript" src="js/plugins/pdf/jspdf.plugin.autotable.min.js"></script> 					
		<script type="text/javascript" src="js/sistema/reporteCaja.js"></script>               
        <!-- END PLUGINS -->     
        <!-- START TEMPLATE -->
        <script type="text/javascript" src="js/plugins.js"></script>        
        <script type="text/javascript" src="js/actions.js"></script>        
        <!-- END TEMPLATE -->
    <!-- END SCRIPTS -->         
    </body>
</html>






