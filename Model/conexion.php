<?php
use mysqlConection\mysql;
include("Class/mysql.class.php");

Class conexion{
    public function conectar(){
      $conexion = new mysqlConection\mysql();
      $conexion->servidor='localhost'; 
      $conexion->usuario='root';
      $conexion->password='';
      $conexion->base_datos='bingo';

      $conexion->link=new mysqli($conexion->servidor, $conexion->usuario, $conexion->password,$conexion->base_datos,$conexion->link);
      $conexion->link->set_charset("utf8");
      return $conexion->link;
   }
}
?>