<?php
namespace Data{

    use bingo\cantado;
    use bingo\carton_bingo;
    use conexion;

include("conexion.php");

  function NuevoJuego(){
    $db     = new conexion();
    $conn   = $db->conectar();
    
    $sql = "INSERT INTO juego VALUES();";
    if(!($result = $conn -> query($sql)))
      echo "error";
    $conn -> close();

    return $result;
  }

  function GuardarNumero($numero, $juego){
    $db     = new conexion();
    $conn   = $db->conectar();
    
    $sql = "INSERT INTO `cantado` (`NumeroCantado`, `juego_NumeroJuego`) VALUES ($numero, $juego);";
    if(!($result = $conn -> query($sql)))
      echo "error";
    $conn -> close();

    return $result;
  }

  function DeshacerNumero($juego){
    $db     = new conexion();
    $conn   = $db->conectar();
    
    $sql = "DELETE FROM `cantado` WHERE `juego_NumeroJuego`=".$juego." order by FechaHora desc limit 1;";

    if(!($result = $conn -> query($sql)))
      echo "error";

    $conn -> close();

    return $result;
  }

  function consultarCartonBingoPorNumero($numero){
    $carton_bingo    =   new carton_bingo();
    $db     = new conexion();
    $conn   = $db->conectar();
    
    $sql = "SELECT * 
            FROM carton_bingo cg
            WHERE cg.NumeroCartonBingo = $numero;";

    if ($result = $conn -> query($sql)) {
        
        $carton_bingo = $result -> fetch_object(carton_bingo::class);
        $result -> free_result();
    }
    $conn -> close();

    return $carton_bingo;
  }

  function consultarCartonBingo(){
    include("config.php");
    $carton_bingo = array();
    $db     = new conexion();
    $conn   = $db->conectar();
    
    $sql = "SELECT * 
            FROM carton_bingo cg";

    $sql.= ($usa_NumeroCartonManual)?" order by NumeroManual asc ": " order by NumeroCartonBingo asc";

    if ($result = $conn -> query($sql)) {
      $array = [];
      while ($row = $result->fetch_assoc()){
        $carton = new carton_bingo(); 
        $carton->NumeroCartonBingo = $row["NumeroCartonBingo"];

        $carton->b_1 = $row["b_1"];
        $carton->b_2 = $row["b_2"];
        $carton->b_3 = $row["b_3"];
        $carton->b_4 = $row["b_4"];
        $carton->b_5 = $row["b_5"];

        $carton->i_1 = $row["i_1"];
        $carton->i_2 = $row["i_2"];
        $carton->i_3 = $row["i_3"];
        $carton->i_4 = $row["i_4"];
        $carton->i_5 = $row["i_5"];

        $carton->n_1 = $row["n_1"];
        $carton->n_2 = $row["n_2"];
        $carton->n_4 = $row["n_4"];
        $carton->n_5 = $row["n_5"];
        
        $carton->g_1 = $row["g_1"];
        $carton->g_2 = $row["g_2"];
        $carton->g_3 = $row["g_3"];
        $carton->g_4 = $row["g_4"];
        $carton->g_5 = $row["g_5"];

        $carton->o_1 = $row["o_1"];
        $carton->o_2 = $row["o_2"];
        $carton->o_3 = $row["o_3"];
        $carton->o_4 = $row["o_4"];
        $carton->o_5 = $row["o_5"];
        
        $carton->NombreComprador = $row["NombreComprador"];
        $carton->NumeroManual = ($usa_NumeroCartonManual)?$row["NumeroManual"]:$row["NumeroCartonBingo"];
        array_push($array,$carton);
      }
      return $array;
    }
    $conn -> close();

    return $carton_bingo;
  }

  function consultarJuegos(){
    $obj    = array();
    $db     = new conexion();
    $conn   = $db->conectar();
    
    $sql = "select * from juego;";
    if ($result = $conn -> query($sql)) {      
        while ($row = $result->fetch_array()) {
            array_push($obj,$row);
        } 
        $result -> free_result();
    }
    $conn -> close();
    return $obj;
  }

  function consultarCantado($juego){
    $obj = array();
    $db     = new conexion();
    $conn   = $db->conectar();
    
    $sql = "select * from cantado where juego_NumeroJuego = $juego order by FechaHora asc";
    if ($result = $conn -> query($sql)) {
        while ($row = $result->fetch_array()) {
            $cantado = new cantado();
            $cantado->FechaHora = $row["FechaHora"];
            $cantado->juego_NumeroJuego = $row["juego_NumeroJuego"];
            $cantado->NumeroCantado = $row["NumeroCantado"];
            array_push($obj,$cantado);
        } 
        $result -> free_result();
    }

    $conn -> close();
    return $obj;
  }
}
?>