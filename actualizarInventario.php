<?php

include 'conecta.php';
$time = time();

$fecha= date("y-m-d", $time);
$serie=trim($_POST['serie']);
$id=$_POST['idCotizacion'];
$idProducto=$_POST['idProducto'];
$cantidad=$_POST['cantidad'];
$cantidadD=$_POST['cantidadT'];
$metros=$_POST['metrosT'];
$facturado=$_POST['facturado'];
$folio=trim($_POST['folio']);
$respuesta=$_POST['respuesta'];
$pago=$_POST['pago'];
$credito=$_POST['credito'];
$update="update  ";
$subtotal=$_POST['subtotal'];
$iva=$_POST['impuesto'];
$total=$_POST['total_n'];
$archivo=$_POST['archivo'];
switch($respuesta){
    case '':case'no':case 'NO':

    $sql=$dbConexion->query("delete from cotizaciontemporal where id_cotizacion='$id'");
    if($sql){
        $dbConexion->close();
        echo'Eliminado sin actualizar';
    }

   
    break;
    case 'SI':case 'si':
    $sql=$dbConexion->query("update productos set cantidad=cantidad-'$cantidad' where id='$idProducto'");
    $sql2=$dbConexion->query("delete from cotizaciontemporal where id_cotizacion='$id'");
    if($sql&&$sql2){
        $dbConexion->close();
        echo 'Producto actualizado exitosamente';
    }
   
    break;
    case 'indefinido': case 'no':
    $sql=$dbConexion->query("delete from ordencompra where id_orden='$id'");
    if($sql){
        $dbConexion->close();
        echo 'Producto eliminado exitosamente';
    }
    break;
    case 'calcularNuevoTotal':
    $sql=$dbConexion->query("update cotizaciontemporal set cantidad='$cantidad', subtotal='$subtotal', iva='$iva',
     total='$total', cantidadDescontar='$cantidadD' where id_cotizacion='$id'");
    if($sql){
        $dbConexion->close();
        echo'Eliminado sin actualizar';
    }else{
        echo 'no quedo';
    }
    break;
    case 'calcularNuevoTotalCompras':
    $sql=$dbConexion->query("update ordencompra set cantidad='$cantidad', subtotal='$subtotal', iva='$iva',
     total='$total', cantidadDescontar='$cantidadD' where id_orden='$id'");
    if($sql){
        $dbConexion->close();
        echo'Eliminado sin actualizar';
    }else{
        echo 'no quedo';
    }
    break;
    case 'actualizarInventarioSuma':
    switch($serie){
    case 'serie a':
    $pend='autorizado';
    $sql=" update productos join historialcompras set cantidad=cantidad+historialcompras.cantidadDescontar, estatus=?,fecha='$fecha',
    serie=?
    where productos.id=historialcompras.id_producto and historialcompras.folio=? and estatus='pendiente'";
    $stmt=$dbConexion->prepare($sql);
     $stmt->bind_param("sss",$pend,$serie,$folio);
     $stmt->execute();
     
     if($stmt->affected_rows==0){
        echo 'esa orden de compra ya fue autorizada';
        
        die();
     }
    if($stmt){
        $stmt->close();
        $dbConexion->close();
        echo'actualizacion exitosa';

    }else{
        echo 'no quedo';
        $sql->error;
    }
    break;
    case 'serie b':
    $pend='autorizado';
    $sql=" update productosb join historialcompras set cantidad=cantidad+historialcompras.cantidadDescontar, estatus=?,fecha='$fecha',
    serie=?
    where productosb.id=historialcompras.id_producto and historialcompras.folio=? and estatus='pendiente'";
    $stmt=$dbConexion->prepare($sql);
     $stmt->bind_param("sss",$pend,$serie,$folio);
     $stmt->execute();
     
     if($stmt->affected_rows==0){
        echo 'esa orden de compra ya fue autorizada';
        
        die();
     }
    if($stmt){
        $stmt->close();
        $dbConexion->close();
        echo'actualizacion exitosa';

    }else{
        echo 'no quedo';
        $sql->error;
    }
    break;
    default: echo "error de switch"; ;
    
    }
   
    break;
    case 'actualizarInventarioResta':
    switch($serie){
    case 'serie a':
    $sql=" update productos join historialventas set cantidad=cantidad-historialventas.cantidadDescontar, estatus='autorizado', 
    facturado=?, pago=?,credito=?, serie=?,fecha='$fecha' where productos.id=historialventas.id_producto and historialventas.folio=? and estatus='pendiente'";
    $stmt=$dbConexion->prepare($sql);
    $stmt->bind_param("sssss", $facturado,$pago,$credito,$serie,$folio);
    $stmt->execute();
    
    if($stmt->affected_rows==0){
       echo 'esa cotizacion ya fue autorizada';
      // echo $stmt->affected_rows;
       die();
    }
   if($sql){
       $stmt->close();
       $dbConexion->close();
       echo'actualizacion exitosa';

   }else{
       echo 'no quedo';
       $sql->error;
   }
    break;
    case 'serie b':
    $sql=" update productosb join historialventas set cantidad=cantidad-historialventas.cantidadDescontar, estatus='autorizado', 
    facturado=?, pago=?,credito=?,serie=?,fecha='$fecha' where productosb.id=historialventas.id_producto and historialventas.folio=? and estatus='pendiente'";
    $stmt=$dbConexion->prepare($sql);
    $stmt->bind_param("sssss", $facturado,$pago,$credito,$serie,$folio);
    $stmt->execute();
    
    if($stmt->affected_rows==0){
       echo 'esa cotizacion ya fue autorizada';
      // echo $stmt->affected_rows;
       die();
    }
   if($sql){
       $stmt->close();
       $dbConexion->close();
       echo'actualizacion exitosa';

   }else{
       echo 'no quedo';
       $sql->error;
   }
    break;
    default: ;
    }
   
    break;
    case 'actualizarInventarioSumaTicket':
    switch($serie){
    case 'serie a': 
    $pend='pendiente';
    $sql=" update productos join historialventas set cantidad=cantidad+historialventas.cantidadDescontar, estatus=?, pago=' ',fecha='$fecha',
    credito=' '
    where productos.id=historialventas.id_producto and historialventas.folio=? and estatus='autorizado' and facturado='no'";
    $stmt=$dbConexion->prepare($sql);
     $stmt->bind_param("ss",$pend,$folio);
     $stmt->execute();
     
     if($stmt->affected_rows==0){
        echo 'esta cotizacionn ya fue cancelado o facturado';
        
        die();
     }
    if($stmt){
        $stmt->close();
        $dbConexion->close();
        echo'actualizacion exitosa';

    }else{
        echo 'no quedo';
        $sql->error;
    }
    break;
    case 'serie b':
    $pend='pendiente';
    $sql=" update productosb join historialventas set cantidad=cantidad+historialventas.cantidadDescontar, estatus=?, pago=' ',fecha='$fecha',
    credito=' '
    where productosb.id=historialventas.id_producto and historialventas.folio=? and estatus='autorizado' and facturado='no'";
    $stmt=$dbConexion->prepare($sql);
     $stmt->bind_param("ss",$pend,$folio);
     $stmt->execute();
     
     if($stmt->affected_rows==0){
        echo 'esta cotizaci¨®n ya fue cancelado o facturado';
        
        die();
     }
    if($stmt){
        $stmt->close();
        $dbConexion->close();
        echo'actualizacion exitosa';

    }else{
        echo 'no quedo';
        $sql->error;
    }
    break;
    default: echo 'error';
    }
    break;
    case 'actualizarEstatusTicket':
    $pend='si';
    $sql=" update  tickets set facturado=?
    where folio=? and facturado='no' and estatus!='cancelado'";
    $stmt=$dbConexion->prepare($sql);
     $stmt->bind_param("ss",$pend,$folio);
     $stmt->execute();
     
     if($stmt->affected_rows==0){
        echo 'este ticket ya fue facturado o cancelado';
        
        die();
     }
    if($stmt){
        $stmt->close();
        $dbConexion->close();
        echo'actualizacion exitosa';

    }else{
        echo 'no quedo';
        $sql->error;
    }
    break;
    case 'eliminarDefinitivo':
    
    $sql=" delete from cotizaciontemporal  where id_cotizacion=?";
    $stmt=$dbConexion->prepare($sql);
     $stmt->bind_param("i",$id);
     $stmt->execute();
     
     if($stmt->affected_rows==0){
        echo 'este ticket ya fue facturado o cancelado'.$id;
        
        die();
     }
    if($stmt){
        $stmt->close();
        $dbConexion->close();
        echo'actualizacion exitosa';

    }else{
        echo 'no quedo';
        $sql->error;
    }
    break;
    case 'consultarEstado':
    
    $sql=" select estatus, credito from historialventas where folio='$folio' group by folio";
    $stmt=$dbConexion->query($sql);
   $arrayName= array();
    foreach($stmt as $query){
        $arrayName[] = array('pendiente' => $query['estatus'],
                              'credito'=> $query['credito']);
    }
    echo  json_encode($arrayName);
    break;
    case 'eliminarTicket':
    
        $sql=" delete from historialventas where folio=? ";
        $stmt=$dbConexion->prepare($sql);
        $stmt->bind_param("s",$folio);
        $stmt->execute();
        
        if($stmt->affected_rows==0){
           echo 'esta cotizacion ya fue facturada o cancelada'.$folio;
           
           die();
        }
       if($stmt){
           $stmt->close();
           $dbConexion->close();
           echo'actualizacion exitosa';
           unlink($archivo);
   
       }else{
           echo 'no quedo';
           $sql->error;
       }
        
        break;
    default: die("no existe esa opcion"); break;
}







?>