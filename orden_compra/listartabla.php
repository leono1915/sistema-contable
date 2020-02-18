<?php
include '../conecta.php';
session_start();
$varsesion=$_SESSION['usuario'];
  $sqlQuery="select  cantidad,descripcion,precio,subtotal,iva,total,id,cantidadDescontar,id_orden,metros,tramos from ordencompra where usuario='$varsesion'";
  $query = $dbConexion->query($sqlQuery);

  if(!$query){
    $dbConexion->error;
    echo 'error';
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
         'idCotizacion'=>$l['id_orden'],
        'metros'=>$l['metros'],
        'tramos'=>$l['tramos']
    );
    
  }
          $respuesta=json_encode($jason);
echo $respuesta;







?>