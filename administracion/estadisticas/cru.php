<?php
date_default_timezone_set('America/Mexico_City');

 $opcion=$_POST['opcion'];
 $accion=$_POST['accion'];   
 $rango=$_POST['rango'];
     
           
          switch($opcion){
          case 'clientes':
          switch($accion){
            case 'listar':      break;
            case 'crear':      break;
            case 'consultar':   break;
            case 'modificar':   break;
            case 'eliminar':     break;
            break; default: die('no existe opcion');  break;
           }
          
          break;
            case 'deudores':
            switch($accion){
              case 'listar': listarDeudores();   break;
              case 'crear':    break;
              case 'consultar':    break;
              case 'modificar':   break;
              case 'eliminar':    break;
              break; default: die('no existe opcion');  break;
             }
            
            break;
         
          case 'cotizaciones':
          switch($accion){
            case 'listar':   break;
            case 'listarFiltrado': break;
            case 'consultar':    break;
            break; default: die('no existe opcion');  break;
           }
          
          break;
          case 'ordenes':
          switch($accion){
            case 'listar':   break;           
            case 'consultar':   break;
            break; default: die('no existe opcion');  break;
           }
          
          break;
          case 'tickets':
          switch($accion){
            case 'listar':   break;
            case 'consultar':    break;
            break; default: die('no existe opcion');  break;
           }
          
          break;
          case 'historial':
          switch($accion){
            case 'listarCompras': listarHistorialCompras();  break;
           
            break; default: die('no existe opcion');  break;
           }
           break;
           case 'usuarios':
           include '../conecta.php';
           $password=$_POST['password'];
           $id=$_POST['id'];
           $nombre =$_POST['nombre'];
           $mail=$_POST['mail'];
           $sql="update usuarios set nombre= ?,correo=?, password=?
           where id=$id";
          $stmt=$dbConexion->prepare($sql);
          $stmt->bind_param("sss",$nombre,$mail,$password);
          $stmt->execute();
         
          if($stmt->affected_rows==0){
             echo 'no se pudo modificar'.$id.$nombre;
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
           default: die('no existe opcion');  break;


        }
  /*---------------------------------------------- AQUI EMPIEZAN LAS FUNCIONES DEL SWITCH CASE -----------------------------------*/
             //                                         funcion listar Filtrados de deudores

        
             function listarHistorialCompras(){
              include '../../conecta.php';
              $anio='2019';
              date('Y');
            $sql=$dbConexion->query("
            SELECT Mes,facturado,autorizado,pendiente
            FROM (SELECT MONTH(Fecha) AS Mes,
            count(if(estatus='autorizado',1,null)) as autorizado,
            count(if(estatus='pendiente',1,null)) as pendiente
            ,SUM(IF(YEAR(Fecha)=$anio&&estatus='autorizado',Total,0)) As 'facturado'
            FROM  (select * from historialcompras group by folio) as nu where YEAR(Fecha)=$anio group by mes) as ventas;
            ");
            
            if(!$sql){
            die( 'error');
            
            } 
            $jason= array();
            foreach($sql as $l){
            
            $jason[]= array(
            'autorizado'=>$l['autorizado'],
            'pendiente'=>$l['pendiente'],
            'mes'=>$l['Mes'],
            'facturado'=>$l['facturado']
            
            );
            
            }
            $respuesta=json_encode($jason);
            echo $respuesta;
            } 


            ///////////////////////////////////////////////// listar deudores//////////////////////////////////////////////////////////// 
       function listarDeudores(){
         include '../../conecta.php';
         $fecha=date('Y');
         $sql=$dbConexion->query("
         SELECT  nombre,folio,estatus,credito,facturado,total from historialventas join clientes where historialventas.id_cliente=clientes.id
          and (credito='si' and estatus='autorizado') group by folio;
         ");
         
         if(!$sql){
         die( 'error');
         
         } 
         $jason= array();
         foreach($sql as $l){
         
         $jason[]= array(
         'estatus'=>$l['estatus'],
         'credito'=>$l['credito'],
         'nombre'=>$l['nombre'],
         'facturado'=>$l['facturado'],
         'cantidad'=>$l['total'],
         'folio'=>$l['folio']
         
         );
         
         }
         $respuesta=json_encode($jason);
         echo $respuesta;
       }
?>


