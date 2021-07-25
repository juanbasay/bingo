<?php 
Class mysqlClass{

    private $servidor='localhost'; 
    private $usuario='root';
    private $password='';
    private $base_datos='bingo';
    private $link;
    static $_instance;


    public function conectar(){
      $this->link=new mysqli($this->servidor, $this->usuario, $this->password,$this->base_datos,$this->link);
      $this->link->set_charset("utf8");
      return $this->link;
   }
}

function NuevoJuego(){
  $db     = new mysqlClass();
  $conn   = $db->conectar();
  
  $sql = "INSERT INTO juego VALUES();";
  if(!($result = $conn -> query($sql)))
    echo "error";
  $conn -> close();

  return $result;
}

function GuardarNumero($numero, $juego){
  $db     = new mysqlClass();
  $conn   = $db->conectar();
  
  $sql = "INSERT INTO `cantado` (`NumeroCantado`, `juego_NumeroJuego`) VALUES ($numero, $juego);";
  if(!($result = $conn -> query($sql)))
    echo "error";
  $conn -> close();

  return $result;
}

function DeshacerNumero($juego){
  $db     = new mysqlClass();
  $conn   = $db->conectar();
  
  $sql = "DELETE FROM `cantado` WHERE `juego_NumeroJuego`=".$juego." order by FechaHora desc limit 1;";

  if(!($result = $conn -> query($sql)))
    echo "error";

  $conn -> close();

  return $result;
}

function consultarCartonBingoPorNumero($numero){
  $carton_bingo    =   new carton_bingo();
  $db     = new mysqlClass();
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
  $carton_bingo = array();
  $db     = new mysqlClass();
  $conn   = $db->conectar();
  
  $sql = "SELECT * 
          FROM carton_bingo cg;";

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
      array_push($array,$carton);
    }
    return $array;
  }
  $conn -> close();

  return $carton_bingo;
}

function consultarJuegos(){
  $obj    = array();
  $db     = new mysqlClass();
  $conn   = $db->conectar();
  
  $sql = "select NumeroJuego from juego;";
  if ($result = $conn -> query($sql)) {      
      while ($row = $result->fetch_array()) {
          array_push($obj,$row[0]);
      } 
      $result -> free_result();
  }
  $conn -> close();
  return $obj;
}

function consultarCantado($juego){
  $obj = array();
  $db     = new mysqlClass();
  $conn   = $db->conectar();
  
  $sql = "select NumeroCantado from cantado where juego_NumeroJuego = $juego order by FechaHora asc";
  if ($result = $conn -> query($sql)) {
      while ($row = $result->fetch_array()) {
          array_push($obj,$row[0]);
      } 
      $result -> free_result();
  }

  $conn -> close();
  return $obj;
}
?>