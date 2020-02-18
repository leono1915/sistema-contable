

<?php
include 'conecta.php';
session_start();
$varsesion=$_SESSION['usuario'];
$folio=trim($_POST['folio']);
  $sqlQuery="select cotizaciontemporal.* from  cotizaciontemporal join usuarios where usuarios.usuario=
  cotizaciontemporal.usuario and eliminado='si'  and cotizaciontemporal.id_cotizacion in(select idcotizacion from
  historialventas where folio='$folio')";
  $query = $dbConexion->query($sqlQuery);

  if(!$query){
    $dbConexion->error;
    echo 'error';
  }
  $jason=array();
  foreach($query as $l){

    
    
    $jason[]= array(
        'idCotizacion'=>$l['id_cotizacion'],
        'cantidad'=>$l['cantidad'],
        'descripcion'=>$l['descripcion'],
        'precioUnitario'=>$l['precio'],
        'subtotal'=>$l['subtotal'],
        'iva'=>$l['iva'],
        'total'=>$l['total'],
        'accion'=>$l['accion'],
        'id'=>$l['id'],
        'cantidadDescontar'=>$l['cantidadDescontar'],
        'metros'=>$l['metros'],
        'tramos'=>$l['tramos']
    );
    
  }
          $respuesta=json_encode($jason);
echo $respuesta;



//precio();



?>