<?php

include 'conecta.php';
session_start();
$varsession=$_SESSION['usuario'];
$time = time();
$porcentajeDescuento=$_GET['porcentajeDescuento'];
$fecha= date("y-m-d", $time);
$serie=trim($_GET['serie']);
$nombre=$_GET['nombreCliente'];
$descuento=$_GET['descuento'];
$pago=$_POST['pago'];
$hora=$time;
$credito=$_POST['credito'];
$datoDes;
if($descuento!='0'){
 $datoDes='<tr>
          <td colspan="2"></td>
          <td colspan="2">DESCUENTO</td>
          <td>'.number_format(floatval($descuento), 2, '.', '').'</td>
        </tr>';
}else{
  $datoDes=' ';
}
$queryUsuario=$dbConexion->query("select * from usuarios where usuario='$varsession'");

 foreach($queryUsuario  as $user){
         $idUser=$user['id'];
 }
if($nombre=='Nombre Cliente'){
  die('<h1>se necesita elegir un cliente para generar la cotización</h1>');
}
$sqlQuery="select * from  cotizaciontemporal where eliminado='no'  and usuario='$varsession'";
  $query = $dbConexion->query($sqlQuery);
  if($query->num_rows==0){
    die('<h1>no hay datos para generar cotización asegurese de generar la tabla de productos</h1>');
  }
  $queryCliente=$dbConexion->query("select *from clientes where nombre='$nombre' or nombre_agente='$nombre'");
  
  $result2=$dbConexion->query('select * from  historialventas order by numero desc limit 1');
  foreach($result2 as $r){
    $numero= $r['numero']+1;
  }
  if(empty($numero)){
    $numero=1;
  }
$plantilla='

<body>
  <header class="clearfix">
  <div class="division">
    <div id="company">
      <img src="impresion/img/logo_opt.png">
    </div>
   
    <div id="company">
    <h2 class="name">Matriz</h2>
    <div>Av 8 de Julio #1671, Col Morelos </div>
    <div>Tel 36-19-36-63</div>
    <div><a href="">elhierro@live.com.mx</a></div>
</div>

  <div id="company">
      <h2 class="name">Sucursal</h2>
      <div>Camichines #30, Col Jardines 
    de <br> Sta María</div>
      <div>Tel 38-55-57-83</div>
      <div><a href="">arq.lagos2@gmail.com</a></div>
  </div>
 
  </div>
  <h2 style="text-align:justyfy; margin-top:-30px; margin-bottom:-20px;">COTIZACIÓN</h2>
  </header>
  <main>
    <div id="details" class="clearfix">
      <div id="CLIENTE:">';
      foreach($queryCliente as $query_cliente){
        $idCliente=$query_cliente["id"];
        $nombreFinal=$query_cliente["nombre"];
        if(empty($nombreFinal)){
          $nombreFinal=$nombreFinal.$query_cliente["nombre_agente"];
        }
      $plantilla.='
        <div class="to">CLIENTE:</div>
        <div class="address"  style="font-weight:bold;">'.$nombreFinal.'</div>
        <div class="address" style="text-align:justify">'.$query_cliente["domicilio"].'</div>
        <div class="address">Tel '.$query_cliente["telefono"].'</div>
        <div class="email"><a href="">'.$query_cliente["correo"].'</a></div>
      </div>';
      }
     $plantilla.=' <div id="invoice">
        <h1>ACEROS 8 DE JULIO</h1>
    <div class=""> <h3>'."Fecha ".$fecha.'</h3> </div>
    
      </div>
    </div>
    <table border="0" cellspacing="0" cellpadding="0">
      <thead>
        <tr>
          <th class="no">#</th>
          <th class="desc">DESCRIPCIÓN</th>
          <th class="unit">PRECIO UNITARIO</th>
          <th class="qty">CANTIDAD</th>
          <th class="total">TOTAL</th>
        </tr>
      </thead>
      <tbody>'
       ;
        $i=1;
        foreach ($query as $querys) { 
         
        $total+=$querys["total"];
        $subtotal+=$querys["subtotal"];
        $iva+=$querys["iva"];
        $plantilla.=
        '<tr> 
          <td class="no">'.$i.'</td>
          <td class="desc">'.$querys["descripcion"].'</td>
          <td class="unit">'.$querys["precio"].'</td>
          <td class="qty">'.$querys["cantidad"].'</td>
          <td class="total">'.$querys["total"].'</td>
          </tr>';
          $i++;
        }
    $plantilla.='
      </tbody>
      <tfoot>
        '.$datoDes.'
        <tr>
          <td colspan="2"></td>
          <td colspan="2">TOTAL</td>
          <td>'.number_format(floatval($total-$descuento), 2, '.', '').'</td>
        </tr>
      </tfoot>
    </table>
    <div id="thanks">Rapidez es nuestro compromiso</div>
    <div id="notices">
      <h2>NOTA!</h2>
      <div class="notice">La cotización solicitada requiere un 50% de anticipo, en caso de envío a domicilio estará sujeta a disponibilidad 
    del vehículo y turno.
    Los tiempos de entrega de placas o cortes serán calculados una vez se haya entregado el anticipo, agradecemos su preferencia.</div>
    </div>
</main>
 
</body>
<h3> Firma o sello de aceptación  </h3> 
' ;
require_once 'libreria_pdf/vendor/autoload.php' ;



  
  $mpdf = new Mpdf\Mpdf([]);

$css =file_get_contents('impresion/estilosImpresin.css');
$mpdf->SetHTMLHeader('FOLIO 00'.$numero);
$mpdf->writeHTML($css,\Mpdf\HTMLParserMode::HEADER_CSS);
$mpdf->setTitle('COTIZACIÓN');
$mpdf->writeHTML($plantilla,\Mpdf\HTMLParserMode::HTML_BODY);
$mpdf->setFooter('
<footer>

Precios sujetos a cambios sin previo aviso
</footer>');
$cadena='cotizaciones/';
$facturado='no';
$folio='00'.$numero;
$pendiente='pendiente';
$eliminado='no';
$nombreArchivo= $folio.$nombre.'.pdf';
$mpdf->Output($cadena.$nombreArchivo,'F');
$pst=$dbConexion->prepare("insert into historialventas values(null,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
foreach($query as $que){
$pst->bind_param('siissisddsissssi',$fecha,$idCliente,$que['id'],$folio,$pendiente,$numero,$eliminado,$que['cantidadDescontar'],floatval($total-$descuento),
$facturado,$idUser,$pago,$porcentajeDescuento,$credito,$serie,$que['id_cotizacion']);
$query= $pst->execute();
  
}
$delete =$dbConexion->query("update cotizaciontemporal set eliminado='si' where eliminado='no'");
  if(!$query||!$delete){
    $dbConexion->error;
    echo 'error';
  }else{
      echo 'dato insertado exitosamente';
      $pst->close();
      $dbConexion->close();
  }
 

$mpdf->Output($nombreArchivo,'I');



?>
