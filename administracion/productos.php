<?php
 session_start();
 $varsesion=$_SESSION['usuario'];
 if($varsesion==null||$varsesion==''){
	 die( "<h1>  error 404 not found </h1>");
 }

?>
<!DOCTYPE HTML>
<!--
	Spectral by HTML5 UP
	html5up.net | @ajlkn
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>
	<head>
		<title>Productos</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<!--[if lte IE 8]><script src="assets/js/ie/html5shiv.js"></script><![endif]-->
		<link rel="stylesheet" href="assets/./css/main.css" />
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" >

		<!--[if lte IE 8]><link rel="stylesheet" href="assets/css/ie8.css" /><![endif]-->
		<!--[if lte IE 9]><link rel="stylesheet" href="assets/css/ie9.css" /><![endif]-->
		<script>
		function editar(_this) {
		var id=_this.parentNode.parentNode.getElementsByTagName('td')[0].getElementsByTagName('p')[0].innerHTML;
	
		window.open('editarproducto.php' + "?id=" +id,"_blank");

		
		}
		function eliminar(_this) {
		var id=_this.parentNode.parentNode.getElementsByTagName('td')[0].getElementsByTagName('p')[0].innerHTML;
		var opcion='productos';
		var accion='eliminar';
		if(!confirm('está seguro de eliminar este registro de producto '+id)){
			return;
		}
		$.ajax({
			url:'crud.php',
			type:'POST',
			data:{id,accion,opcion},
			success:function (respuesta){
				alert(respuesta);
				
			}
		})
		$(_this).parent().parent().fadeOut("fast", function () { $(this).remove(); });	
		}
		</script>
	</head>
	<body>
		<!-- Page Wrapper -->
			<div id="page-wrapper">

				<!-- Header -->
					<header id="header">
						<h1><a href="">Productos</a></h1>
						<nav id="nav">
							<ul>
								<li class="special">
									<a href="#menu" class="menuToggle"><span>Menu</span></a>
									<div id="menu">
										<ul>
										<li><a href="../cotizador.php">Cotizador</a></li>
								        <li><a href="estadisticas.php">Estadísticas</a></li>
										   <li><a href="proveedores.php">proveedores</a></li>
										   <li><a href="clientes.php">Clientes</a></li>
								        <li><a href="../index.php">cerrar sesión</a></li>
										</ul>
									</div>
								</li>
							</ul>
						</nav>
					</header>
				<!-- Main -->
					<article id="main">
						<header style="padding-top: 50px; padding-bottom: 50px;" >
							<h2>Aceros 8 de julio</h2>
							<p>Productos Totales</p>
						</header>
						<section class="wrapper style5">
							<div class="inner">
								<section>
									

									<form method="post" action="conecta.php">
										

										<div class="table-wrapper">
												<h2 style="text-align: center">Listado De Productos</h2>
												<div class="row uniform">
												<div class="2u 12u$(xsmall)">
														<label for="rango_page" > Listar
														<input type="number" id ="rango_page" value="20" step="20" style="color: black;" min="20" max="120" ></label>
														
												
												
											</div>
											<div class="6u 12u$(xsmall)" >
													
												
												
														
														
											
											
										</div>
											<!--<div class="0u 12u$(xsmall)" >
													
													<input id="buscarProducto" type="button" value="Buscar" ">
												
														
														
											
											
										</div>
											<div class="2u 12u$(xsmall)" >
													
													
												
															<input type="text" placeholder="nombre" id="buscar"  >
														
											
											
										</div>-->
										</div>
										<br><br>
											<table id="tabla_factura">
												<thead>
													<tr>
									                   
														<th>ID</th>
														<th>NOMBRE</th>														
														<th>MEDIDA</th>
														<th>ESPESOR</th>
														<th>PESO</th>
                                                        <th>PRECIO</th>
                                                        <th>TRAMOS</th>
                                                        <th>METROS</th>
                                                       
                                                       
                                                      
													</tr>
												</thead>
												<tbody id="content_table">
													
												</tbody>
												<!--<tfoot>
													<tr>
														<td colspan="2"></td>
														
														<td id="total_precio">0.00</td>
														<td id="total_subtotales">0.00</td>
														<td id="total_impuesto">0.00</td>
														<td id="total_total">0.00</td>
														<td></td>
													</tr>
												</tfoot>-->
											</table>
											<div class="12u$" id="contenedorPaginacion"> 
												
											
											</div>
										</div>
									<!---->	
										
									</form>
								</section>
								<br> 
								<br>
								<br>
							</div>
						</section>
					</article>

				<!-- Footer -->
					<footer id="footer">
						<ul class="icons">
							
						</ul>
						<ul class="copyright">
							
					</footer>
			</div>

		<!-- Scripts -->
			<script src="../assets/js/jquery.min.js"></script>
			<script src="../assets/js/jquery.scrollex.min.js"></script>
			<script src="../assets/js/jquery.scrolly.min.js"></script>
			<script src="../assets/js/skel.min.js"></script>
			<script src="../assets/js/util.js"></script>
			<!--[if lte I../]><script src="assets/js/ie/respond.min.js"></script><![endif]-->
			<script src="../assets/js/main.js"></script>
			<script src="js/productos.js"></script>

	</body>
</html>