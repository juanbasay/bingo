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




function consultarCarton_letra_b($numero){
  $letra_b    =   new letra_b();
  $db     = new mysqlClass();
  $conn   = $db->conectar();
  
  $sql = "select * from letra_b where b_carton_NumeroCarton = $numero";
  if ($result = $conn -> query($sql)) {
      
      $letra_b = $result -> fetch_object(letra_b::class);
      $result -> free_result();
  }
  $conn -> close();

  return $letra_b;
}

function consultarCarton_letra_i($numero){
  $letra_b    =   new letra_i();
  $db     = new mysqlClass();
  $conn   = $db->conectar();
  
  $sql = "select * from letra_i where i_carton_NumeroCarton = $numero";
  if ($result = $conn -> query($sql)) {
      
      $letra_b = $result -> fetch_object(letra_b::class);
      $result -> free_result();
  }
  $conn -> close();

  return $letra_b;
}
function consultarCarton_letra_n($numero){
  $letra_n    =   new letra_n();
  $db     = new mysqlClass();
  $conn   = $db->conectar();
  
  $sql = "select * from letra_n where n_carton_NumeroCarton = $numero";
  if ($result = $conn -> query($sql)) {
      
      $letra_n = $result -> fetch_object(letra_n::class);
      $result -> free_result();
  }
  $conn -> close();

  return $letra_n;
}
function consultarCarton_letra_g($numero){
  $letra_g    =   new letra_g();
  $db     = new mysqlClass();
  $conn   = $db->conectar();
  
  $sql = "select * from letra_g where g_carton_NumeroCarton = $numero";
  if ($result = $conn -> query($sql)) {
      
      $letra_g = $result -> fetch_object(letra_g::class);
      $result -> free_result();
  }
  $conn -> close();

  return $letra_g;
}
function consultarCarton_letra_o($numero){
  $letra_o    =   new letra_o();
  $db     = new mysqlClass();
  $conn   = $db->conectar();
  
  $sql = "select * from letra_o where o_carton_NumeroCarton = $numero";
  if ($result = $conn -> query($sql)) {
      
      $letra_o = $result -> fetch_object(letra_o::class);
      $result -> free_result();
  }
  $conn -> close();

  return $letra_o;
}

function consultarCarton_todas_letras($numero){
  $letra_o    =   new letra_o();
  $db     = new mysqlClass();
  $conn   = $db->conectar();
  
  $sql = "SELECT * 
          FROM carton c
          JOIN letra_b b ON b.b_carton_NumeroCarton = c.NumeroCarton
          JOIN letra_i i on i.i_carton_NumeroCarton = b.b_carton_NumeroCarton
          JOIN letra_n n ON n.n_carton_NumeroCarton = i.i_carton_NumeroCarton
          JOIN letra_g g on g.g_carton_NumeroCarton = n.n_carton_NumeroCarton
          JOIN letra_o o on o.o_carton_NumeroCarton = g.g_carton_NumeroCarton
          
          WHERE c.NumeroCarton = $numero;";

  if ($result = $conn -> query($sql)) {
      
      $letra_o = $result -> fetch_object(letra_o::class);
      $result -> free_result();
  }
  $conn -> close();

  return $letra_o;
}

function consultar_vertical_todas($juego){
  $obj    = array();
  $db     = new mysqlClass();
  $conn   = $db->conectar();
  
  $sql = "SELECT c.NumeroCarton
  FROM carton c
  JOIN letra_b b ON b.b_carton_NumeroCarton = c.NumeroCarton
  JOIN letra_i i on i.i_carton_NumeroCarton = b.b_carton_NumeroCarton
  JOIN letra_n n ON n.n_carton_NumeroCarton = i.i_carton_NumeroCarton
  JOIN letra_g g on g.g_carton_NumeroCarton = n.n_carton_NumeroCarton
  JOIN letra_o o on o.o_carton_NumeroCarton = g.g_carton_NumeroCarton
  
  WHERE  ( 
        b.b_1 IN(SELECT NumeroCantado FROM cantado WHERE juego_NumeroJuego = $juego) and
        b.b_2 IN(SELECT NumeroCantado FROM cantado WHERE juego_NumeroJuego = $juego) and
        b.b_3 IN(SELECT NumeroCantado FROM cantado WHERE juego_NumeroJuego = $juego) and
        b.b_4 IN(SELECT NumeroCantado FROM cantado WHERE juego_NumeroJuego = $juego) and
        b.b_5 IN(SELECT NumeroCantado FROM cantado WHERE juego_NumeroJuego = $juego) 
       ) or
       
       (
         i.i_1 IN(SELECT NumeroCantado FROM cantado WHERE juego_NumeroJuego = $juego) and
        i.i_2 IN(SELECT NumeroCantado FROM cantado WHERE juego_NumeroJuego = $juego) and
        i.i_3 IN(SELECT NumeroCantado FROM cantado WHERE juego_NumeroJuego = $juego) and
        i.i_4 IN(SELECT NumeroCantado FROM cantado WHERE juego_NumeroJuego = $juego) and
        i.i_5 IN(SELECT NumeroCantado FROM cantado WHERE juego_NumeroJuego = $juego) 
       ) or
       (
         n.n_1 IN(SELECT NumeroCantado FROM cantado WHERE juego_NumeroJuego = $juego) and
        n.n_2 IN(SELECT NumeroCantado FROM cantado WHERE juego_NumeroJuego = $juego) and
        n.n_4 IN(SELECT NumeroCantado FROM cantado WHERE juego_NumeroJuego = $juego) and
        n.n_5 IN(SELECT NumeroCantado FROM cantado WHERE juego_NumeroJuego = $juego) 
       ) or
       (
         g.g_1 IN(SELECT NumeroCantado FROM cantado WHERE juego_NumeroJuego = $juego) and
        g.g_2 IN(SELECT NumeroCantado FROM cantado WHERE juego_NumeroJuego = $juego) and
        g.g_3 IN(SELECT NumeroCantado FROM cantado WHERE juego_NumeroJuego = $juego) and
        g.g_4 IN(SELECT NumeroCantado FROM cantado WHERE juego_NumeroJuego = $juego) and
        g.g_5 IN(SELECT NumeroCantado FROM cantado WHERE juego_NumeroJuego = $juego) 
       ) or
       (
         o.o_1 IN(SELECT NumeroCantado FROM cantado WHERE juego_NumeroJuego = $juego) and
        o.o_2 IN(SELECT NumeroCantado FROM cantado WHERE juego_NumeroJuego = $juego) and
        o.o_3 IN(SELECT NumeroCantado FROM cantado WHERE juego_NumeroJuego = $juego) and
        o.o_4 IN(SELECT NumeroCantado FROM cantado WHERE juego_NumeroJuego = $juego) and
        o.o_5 IN(SELECT NumeroCantado FROM cantado WHERE juego_NumeroJuego = $juego) 
       ) ";

  if ($result = $conn -> query($sql)) {      
    while ($row = $result->fetch_array()) {
        array_push($obj,$row[0]);
    } 
    $result -> free_result();
  }
  $conn -> close();
  return $obj;
}

function consultar_horizontal_todas($juego){
  $obj    = array();
  $db     = new mysqlClass();
  $conn   = $db->conectar();
  
  $sql = "SELECT c.NumeroCarton
  FROM carton c
  JOIN letra_b b ON b.b_carton_NumeroCarton = c.NumeroCarton
  JOIN letra_i i on i.i_carton_NumeroCarton = b.b_carton_NumeroCarton
  JOIN letra_n n ON n.n_carton_NumeroCarton = i.i_carton_NumeroCarton
  JOIN letra_g g on g.g_carton_NumeroCarton = n.n_carton_NumeroCarton
  JOIN letra_o o on o.o_carton_NumeroCarton = g.g_carton_NumeroCarton
  
  WHERE  ( 
        b.b_1 IN(SELECT NumeroCantado FROM cantado WHERE juego_NumeroJuego = $juego) and
        i.i_1 IN(SELECT NumeroCantado FROM cantado WHERE juego_NumeroJuego = $juego) and
        n.n_1 IN(SELECT NumeroCantado FROM cantado WHERE juego_NumeroJuego = $juego) and
        g.g_1 IN(SELECT NumeroCantado FROM cantado WHERE juego_NumeroJuego = $juego) and
        o.o_1 IN(SELECT NumeroCantado FROM cantado WHERE juego_NumeroJuego = $juego) 
       ) or
       
       ( 
        b.b_2 IN(SELECT NumeroCantado FROM cantado WHERE juego_NumeroJuego = $juego) and
        i.i_2 IN(SELECT NumeroCantado FROM cantado WHERE juego_NumeroJuego = $juego) and
        n.n_2 IN(SELECT NumeroCantado FROM cantado WHERE juego_NumeroJuego = $juego) and
        g.g_2 IN(SELECT NumeroCantado FROM cantado WHERE juego_NumeroJuego = $juego) and
        o.o_2 IN(SELECT NumeroCantado FROM cantado WHERE juego_NumeroJuego = $juego) 
       ) or
       
       ( 
        b.b_3 IN(SELECT NumeroCantado FROM cantado WHERE juego_NumeroJuego = $juego) and
        i.i_3 IN(SELECT NumeroCantado FROM cantado WHERE juego_NumeroJuego = $juego) and
        g.g_3 IN(SELECT NumeroCantado FROM cantado WHERE juego_NumeroJuego = $juego) and
        o.o_3 IN(SELECT NumeroCantado FROM cantado WHERE juego_NumeroJuego = $juego) 
       ) or
       
       ( 
        b.b_4 IN(SELECT NumeroCantado FROM cantado WHERE juego_NumeroJuego = $juego) and
        i.i_4 IN(SELECT NumeroCantado FROM cantado WHERE juego_NumeroJuego = $juego) and
        n.n_4 IN(SELECT NumeroCantado FROM cantado WHERE juego_NumeroJuego = $juego) and
        g.g_4 IN(SELECT NumeroCantado FROM cantado WHERE juego_NumeroJuego = $juego) and
        o.o_4 IN(SELECT NumeroCantado FROM cantado WHERE juego_NumeroJuego = $juego) 
       ) or
       
       ( 
        b.b_5 IN(SELECT NumeroCantado FROM cantado WHERE juego_NumeroJuego = $juego) and
        i.i_5 IN(SELECT NumeroCantado FROM cantado WHERE juego_NumeroJuego = $juego) and
        n.n_5 IN(SELECT NumeroCantado FROM cantado WHERE juego_NumeroJuego = $juego) and
        g.g_5 IN(SELECT NumeroCantado FROM cantado WHERE juego_NumeroJuego = $juego) and
        o.o_5 IN(SELECT NumeroCantado FROM cantado WHERE juego_NumeroJuego = $juego) 
       ) ";

  if ($result = $conn -> query($sql)) {      
    while ($row = $result->fetch_array()) {
        array_push($obj,$row[0]);
    } 
    $result -> free_result();
  }
  $conn -> close();
  return $obj;
}


function consultar_completo_todas($juego){
  $obj    = array();
  $db     = new mysqlClass();
  $conn   = $db->conectar();
  
  $sql = "SELECT c.NumeroCarton
  FROM carton c
  JOIN letra_b b ON b.b_carton_NumeroCarton = c.NumeroCarton
  JOIN letra_i i on i.i_carton_NumeroCarton = b.b_carton_NumeroCarton
  JOIN letra_n n ON n.n_carton_NumeroCarton = i.i_carton_NumeroCarton
  JOIN letra_g g on g.g_carton_NumeroCarton = n.n_carton_NumeroCarton
  JOIN letra_o o on o.o_carton_NumeroCarton = g.g_carton_NumeroCarton
  
  WHERE  ( 
        b.b_1 IN(SELECT NumeroCantado FROM cantado WHERE juego_NumeroJuego = $juego) and
        i.i_1 IN(SELECT NumeroCantado FROM cantado WHERE juego_NumeroJuego = $juego) and
        n.n_1 IN(SELECT NumeroCantado FROM cantado WHERE juego_NumeroJuego = $juego) and
        g.g_1 IN(SELECT NumeroCantado FROM cantado WHERE juego_NumeroJuego = $juego) and
        o.o_1 IN(SELECT NumeroCantado FROM cantado WHERE juego_NumeroJuego = $juego) 
       ) and
       
       ( 
        b.b_2 IN(SELECT NumeroCantado FROM cantado WHERE juego_NumeroJuego = $juego) and
        i.i_2 IN(SELECT NumeroCantado FROM cantado WHERE juego_NumeroJuego = $juego) and
        n.n_2 IN(SELECT NumeroCantado FROM cantado WHERE juego_NumeroJuego = $juego) and
        g.g_2 IN(SELECT NumeroCantado FROM cantado WHERE juego_NumeroJuego = $juego) and
        o.o_2 IN(SELECT NumeroCantado FROM cantado WHERE juego_NumeroJuego = $juego) 
       ) and
       
       ( 
        b.b_3 IN(SELECT NumeroCantado FROM cantado WHERE juego_NumeroJuego = $juego) and
        i.i_3 IN(SELECT NumeroCantado FROM cantado WHERE juego_NumeroJuego = $juego) and
        g.g_3 IN(SELECT NumeroCantado FROM cantado WHERE juego_NumeroJuego = $juego) and
        o.o_3 IN(SELECT NumeroCantado FROM cantado WHERE juego_NumeroJuego = $juego) 
       ) and
       
       ( 
        b.b_4 IN(SELECT NumeroCantado FROM cantado WHERE juego_NumeroJuego = $juego) and
        i.i_4 IN(SELECT NumeroCantado FROM cantado WHERE juego_NumeroJuego = $juego) and
        n.n_4 IN(SELECT NumeroCantado FROM cantado WHERE juego_NumeroJuego = $juego) and
        g.g_4 IN(SELECT NumeroCantado FROM cantado WHERE juego_NumeroJuego = $juego) and
        o.o_4 IN(SELECT NumeroCantado FROM cantado WHERE juego_NumeroJuego = $juego) 
       ) and
       
       ( 
        b.b_5 IN(SELECT NumeroCantado FROM cantado WHERE juego_NumeroJuego = $juego) and
        i.i_5 IN(SELECT NumeroCantado FROM cantado WHERE juego_NumeroJuego = $juego) and
        n.n_5 IN(SELECT NumeroCantado FROM cantado WHERE juego_NumeroJuego = $juego) and
        g.g_5 IN(SELECT NumeroCantado FROM cantado WHERE juego_NumeroJuego = $juego) and
        o.o_5 IN(SELECT NumeroCantado FROM cantado WHERE juego_NumeroJuego = $juego) 
       ) ";

  if ($result = $conn -> query($sql)) {      
    while ($row = $result->fetch_array()) {
        array_push($obj,$row[0]);
    } 
    $result -> free_result();
  }
  $conn -> close();
  return $obj;
}

function consultar_diagIzq_todas($juego){
  $obj    = array();
  $db     = new mysqlClass();
  $conn   = $db->conectar();
  
  $sql = "SELECT c.NumeroCarton
  FROM carton c
  JOIN letra_b b ON b.b_carton_NumeroCarton = c.NumeroCarton
  JOIN letra_i i on i.i_carton_NumeroCarton = b.b_carton_NumeroCarton
  JOIN letra_n n ON n.n_carton_NumeroCarton = i.i_carton_NumeroCarton
  JOIN letra_g g on g.g_carton_NumeroCarton = n.n_carton_NumeroCarton
  JOIN letra_o o on o.o_carton_NumeroCarton = g.g_carton_NumeroCarton
  
  WHERE  ( 
        b.b_1 IN(SELECT NumeroCantado FROM cantado WHERE juego_NumeroJuego = $juego) AND
        i.i_2 IN(SELECT NumeroCantado FROM cantado WHERE juego_NumeroJuego = $juego) AND
        g.g_4 IN(SELECT NumeroCantado FROM cantado WHERE juego_NumeroJuego = $juego) AND
        o.o_5 IN(SELECT NumeroCantado FROM cantado WHERE juego_NumeroJuego = $juego) 
        
      )";
 

  if ($result = $conn -> query($sql)) {      
    while ($row = $result->fetch_array()) {
        array_push($obj,$row[0]);
    } 
    $result -> free_result();
  }
  $conn -> close();
  return $obj;
}


function consultar_diagDer_todas($juego){
  $obj    = array();
  $db     = new mysqlClass();
  $conn   = $db->conectar();
  
  $sql = "SELECT c.NumeroCarton
  FROM carton c
  JOIN letra_b b ON b.b_carton_NumeroCarton = c.NumeroCarton
  JOIN letra_i i on i.i_carton_NumeroCarton = b.b_carton_NumeroCarton
  JOIN letra_n n ON n.n_carton_NumeroCarton = i.i_carton_NumeroCarton
  JOIN letra_g g on g.g_carton_NumeroCarton = n.n_carton_NumeroCarton
  JOIN letra_o o on o.o_carton_NumeroCarton = g.g_carton_NumeroCarton
  
  WHERE  ( 
        b.b_5 IN(SELECT NumeroCantado FROM cantado WHERE juego_NumeroJuego = $juego) AND
        i.i_4 IN(SELECT NumeroCantado FROM cantado WHERE juego_NumeroJuego = $juego) AND
        g.g_2 IN(SELECT NumeroCantado FROM cantado WHERE juego_NumeroJuego = $juego) AND
        o.o_1 IN(SELECT NumeroCantado FROM cantado WHERE juego_NumeroJuego = $juego) 
        
      )";

  if ($result = $conn -> query($sql)) {      
    while ($row = $result->fetch_array()) {
        array_push($obj,$row[0]);
    } 
    $result -> free_result();
  }
  $conn -> close();
  return $obj;
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



function consultarCarton($numero){
  $carton = new carton();
  $carton->numeroCarton = $numero;
  $carton->letra_b = consultarCarton_letra_b($numero);
  $carton->letra_i = consultarCarton_letra_i($numero);
  $carton->letra_n = consultarCarton_letra_n($numero);
  $carton->letra_g = consultarCarton_letra_g($numero);
  $carton->letra_o = consultarCarton_letra_o($numero);

  return $carton;
}

function consultarCarton2($numero){
  $carton = new carton();
  $carton->numeroCarton = $numero;

  $cartonCompleto = consultarCarton_todas_letras($numero);

  $letra_b = new letra_b();
  $letra_b->b_1 = $cartonCompleto->b_1;
  $letra_b->b_2 = $cartonCompleto->b_2;
  $letra_b->b_3 = $cartonCompleto->b_3;
  $letra_b->b_4 = $cartonCompleto->b_4;
  $letra_b->b_5 = $cartonCompleto->b_5;

  $letra_i = new letra_i();
  $letra_i->i_1 = $cartonCompleto->i_1;
  $letra_i->i_2 = $cartonCompleto->i_2;
  $letra_i->i_3 = $cartonCompleto->i_3;
  $letra_i->i_4 = $cartonCompleto->i_4;
  $letra_i->i_5 = $cartonCompleto->i_5;

  $letra_n = new letra_n();
  $letra_n->n_1 = $cartonCompleto->n_1;
  $letra_n->n_2 = $cartonCompleto->n_2;
  $letra_n->n_4 = $cartonCompleto->n_4;
  $letra_n->n_5 = $cartonCompleto->n_5;
  
  $letra_g = new letra_g();
  $letra_g->g_1 = $cartonCompleto->g_1;
  $letra_g->g_2 = $cartonCompleto->g_2;
  $letra_g->g_3 = $cartonCompleto->g_3;
  $letra_g->g_4 = $cartonCompleto->g_4;
  $letra_g->g_5 = $cartonCompleto->g_5;

  $letra_o = new letra_o();
  $letra_o->o_1 = $cartonCompleto->o_1;
  $letra_o->o_2 = $cartonCompleto->o_2;
  $letra_o->o_3 = $cartonCompleto->o_3;
  $letra_o->o_4 = $cartonCompleto->o_4;
  $letra_o->o_5 = $cartonCompleto->o_5;

  $carton->letra_b = $letra_b;
  $carton->letra_i = $letra_i;
  $carton->letra_n = $letra_n;
  $carton->letra_g = $letra_g;
  $carton->letra_o = $letra_o;

  return $carton;
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