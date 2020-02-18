

<?php
include 'conecta.php';
session_start();
$varsesion=$_SESSION['usuario'];

  $sqlQuery="select cantidad,descripcion,precio,subtotal,iva,total,id,cantidadDescontar,id_cotizacion,metros,tramos from  cotizaciontemporal where eliminado='no' and usuario='$varsesion'";
  $query = $dbConexion->query($sqlQuery);
 
  if(!$query){
    $dbConexion->error;
    echo 'errorsaso';
  }
  $jason=array();
 
  foreach($query as $l){

    
    
    $jason[]= array(
         'cantidad'=>$l['cantidad'],
          'descripcion'=>$l['descripcion'],
           'precioUnitario'=>$l['precio'],
        'subtotal'=>$l['subtotal'],
        'iva'=>$l['iva'],
        'total'=>$l['total'],
       
       
       
       
        'id'=>$l['id'],
        'cantidadDescontar'=>$l['cantidadDescontar'],
         'idCotizacion'=>$l['id_cotizacion'],
        'metros'=>$l['metros'],
        'tramos'=>$l['tramos']
    );
    
  }
          $respuesta=json_encode($jason);
echo $respuesta;



//precio();



?>