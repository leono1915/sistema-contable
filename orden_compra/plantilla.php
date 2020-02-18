<?php

include '../conecta.php';
session_start();
$varsession=$_SESSION['usuario'];
$time = time();

$fecha= date("y-m-d", $time);
$queryUsuario=$dbConexion->query("select * from usuarios where usuario='$varsession'");

 foreach($queryUsuario  as $user){
         $idUser=$user['id'];
         $nombreU=$user['nombre'];
 }
$nombre=trim($_GET['nombreCliente']);
if($nombre=='Nombre Proveedor'){
  die('<h1>se necesita elegir un proveedor para generar la cotizacion</h1>');
}
$sqlQuery="select * from  ordencompra where usuario='$varsession'";
  $query = $dbConexion->query($sqlQuery);
  if($query->num_rows==0){
    die('<h1>no hay datos para generar orden de compra asegurese de generar la tabla de productos</h1>');
  }
  $queryCliente=$dbConexion->query("select *from proveedores where nombre='$nombre' ");
  
  $result2=$dbConexion->query('select * from  historialcompras order by numero desc limit 1');
  foreach($result2 as $r){
    $numero= $r['numero']+1;
  }
  if(empty($numero)){
    $numero=1;
  }
$plantilla='
<body>
  <header class="clearfix"><meta http-equiv="Content-Type" content="text/html; charset=gb18030">
  <div class="division">
    <div id="company">
      <img src="../impresion/img/logo_opt.png">
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
  <h2 style="text-align:justyfy; margin-top:-30px; margin-bottom:-20px;">ORDEN DE COMPRA</h2>
  </header>
  <main>
    <div id="details" class="clearfix">
      <div id="Proveedor">';
      foreach($queryCliente as $query_cliente){
        $idCliente=$query_cliente["id"];
        $domicilioP=$query_cliente["direccion"];
      $plantilla.='
        <div class="to">Proveedor:</div>
        <h2 class="name"  style="font-weight:bold;">'.$query_cliente["nombre"].'</h2>
        <div class="address">'.$query_cliente["direccion"].'</div>
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
          <td class="total">'.$querys["subtotal"].'</td>
          </tr>';
          $i++;
        }
    $plantilla.='
      </tbody>
      <tfoot>
        <tr>
          <td colspan="2"></td>
          <td colspan="2">SUBTOTAL</td>
          <td>'.number_format(floatval($subtotal), 2, '.', '').'</td>
        </tr>
        <tr>
          <td colspan="2"></td>
          <td colspan="2">IVA 16%</td>
          <td>'.number_format(floatval($iva), 2, '.', '').'</td>
        </tr>
        <tr>
          <td colspan="2"></td>
          <td colspan="2">TOTAL</td>
          <td>'.number_format(floatval($total), 2, '.', '').'</td>
        </tr>
      </tfoot>
    </table>
    <div id="thanks">Rapidez es nuestro compromiso</div>
    <div id="notices">
      <h2>NOTA!</h2>
      <div class="notice">Sirva la presente orden de compra autorizada por '.$nombreU.' a '.$nombre.', domiciliado en '.$domicilioP.'.
      Quedando en espera de la entrega de los productos solicitados en el tiempo y forma pactado
      .</div>
    </div>
</main>
 
</body>
<h3> Firma o sello de aceptación  </h3>
';
require_once '../libreria_pdf/vendor/autoload.php' ;



  
  $mpdf = new Mpdf\Mpdf([]);

$css =file_get_contents('../impresion/estilosImpresin.css');
$mpdf->SetHTMLHeader('FOLIO C0'.$numero);
$mpdf->writeHTML($css,\Mpdf\HTMLParserMode::HEADER_CSS);
$mpdf->setTitle('ORDEN DE COMPRA ');
$mpdf->writeHTML($plantilla,\Mpdf\HTMLParserMode::HTML_BODY);
$mpdf->setFooter('
<footer>


</footer>');
$cadena='ordenes_compra/';
 
$folio='C0'.$numero;
$pendiente='pendiente';
$eliminado='no';
$serie='';
$nombreArchivo= $folio.$nombre.'.pdf';
$mpdf->Output($cadena.$nombreArchivo,'F');
$pst=$dbConexion->prepare("insert into historialcompras values(null,?,?,?,?,?,?,?,?,?,?,?)");
foreach($query as $que){
   
$pst->bind_param('siissisddis',$fecha,$idCliente,$que['id'],$folio,$pendiente,$numero,$eliminado,$que['cantidadDescontar'],$total,$idUser,$serie);
$query= $pst->execute();
  
}
$delete =$dbConexion->query("delete from ordencompra");
  if(!$query||!$delete){
    $dbConexion->error;
    echo 'error';
    //$que.$fecha.$idCliente.$que['id'].$folio.$pendiente.$numero.$eliminado.$que['cantidadDescontar'].$total.$idUser.$serie
    // die( $query);
  }else{
      
      echo 'dato insertado exitosamente';
      $pst->close();
      $dbConexion->close();
  }
 

$mpdf->Output($cadena.$nombreArchivo,'I');



?>
