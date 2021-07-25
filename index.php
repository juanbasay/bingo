<?php
include("conexion.php");
include("config.php");
include("clases.php");

if(isset($_POST) && !empty($_POST["accion"])){
    switch($_POST["accion"]){
        case "guardar":
            if(!empty($_POST["numero"]))
                GuardarNumero($_POST["numero"], $_POST["juego"]);
            break;
        case "deshacer":
            DeshacerNumero($_POST["juego"]);
            break;
      default:
        break;
    }
  }

function InListStyle($num, $arr){
    return in_array($num, $arr) ? "style='background-color:green;'" : "";
}

$ListaHorizontal = [];
$ListaVertical = [];
$ListaDiagIzq = [];
$ListaDiagDer = [];
$ListaCompleto = [];

function IsHorizontal($carton, $arr){
    if($carton && $arr){
        if( in_array($carton->b_1, $arr) &&
            in_array($carton->i_1, $arr) &&
            in_array($carton->n_1, $arr) &&
            in_array($carton->g_1, $arr) &&
            in_array($carton->o_1, $arr) ){
            return true;
        }
        if( in_array($carton->b_2, $arr) &&
            in_array($carton->i_2, $arr) &&
            in_array($carton->n_2, $arr) &&
            in_array($carton->g_2, $arr) &&
            in_array($carton->o_2, $arr)){
            return true;
        }
        if( in_array($carton->b_3, $arr) &&
            in_array($carton->i_3, $arr) &&
            in_array($carton->g_3, $arr) &&
            in_array($carton->o_3, $arr)){
            return true;
        }
        if( in_array($carton->b_4, $arr) &&
            in_array($carton->i_4, $arr) &&
            in_array($carton->n_4, $arr) &&
            in_array($carton->g_4, $arr) &&
            in_array($carton->o_4, $arr)){
            return true;
        }
        if( in_array($carton->b_5, $arr) &&
            in_array($carton->i_5, $arr) &&
            in_array($carton->n_5, $arr) &&
            in_array($carton->g_5, $arr) &&
            in_array($carton->o_5, $arr)){
            return true;
        }
    }
    return false;
}

function IsVertical($carton, $arr){
    if($carton && $arr){
        if( in_array($carton->b_1, $arr) &&
            in_array($carton->b_2, $arr) &&
            in_array($carton->b_3, $arr) &&
            in_array($carton->b_4, $arr) &&
            in_array($carton->b_5, $arr)){
            return true;
        }
        elseif( in_array($carton->i_1, $arr) &&
            in_array($carton->i_2, $arr) &&
            in_array($carton->i_3, $arr) &&
            in_array($carton->i_4, $arr) &&
            in_array($carton->i_5, $arr)){
            return true;
        }
        elseif( in_array($carton->n_1, $arr) &&
            in_array($carton->n_2, $arr) &&
            in_array($carton->n_4, $arr) &&
            in_array($carton->n_5, $arr)){
            return true;
        }
        elseif( in_array($carton->g_1, $arr) &&
            in_array($carton->g_2, $arr) &&
            in_array($carton->g_3, $arr) &&
            in_array($carton->g_4, $arr) &&
            in_array($carton->g_5, $arr)){
            return true;
        }
        elseif( in_array($carton->o_1, $arr) &&
            in_array($carton->o_2, $arr) &&
            in_array($carton->o_3, $arr) &&
            in_array($carton->o_4, $arr) &&
            in_array($carton->o_5, $arr)){
            return true;
        }
        else 
            return false;
    }
    return false;
}


function IsDiagIzq($carton, $arr){
    if($carton && $arr){
        if( in_array($carton->b_1, $arr) &&
            in_array($carton->i_2, $arr) &&
            in_array($carton->g_4, $arr) &&
            in_array($carton->o_5, $arr)){
            return true;
        }
        else 
            return false;
    }
    return false;
}

function IsDiagDer($carton, $arr){
    if($carton && $arr){
        if( in_array($carton->b_5, $arr) &&
                in_array($carton->i_4, $arr) &&
                in_array($carton->g_2, $arr) &&
                in_array($carton->o_1, $arr)){
            return true;
        }
        else 
            return false;
    }
    return false;
}

function IsCompleto($carton, $arr){
    if($carton && $arr){
        if( in_array($carton->b_1, $arr) &&
            in_array($carton->b_2, $arr) &&
            in_array($carton->b_3, $arr) &&
            in_array($carton->b_4, $arr) &&
            in_array($carton->b_5, $arr) &&

            in_array($carton->i_1, $arr) &&
            in_array($carton->i_2, $arr) &&
            in_array($carton->i_3, $arr) &&
            in_array($carton->i_4, $arr) &&
            in_array($carton->i_5, $arr) &&

            in_array($carton->n_1, $arr) &&
            in_array($carton->n_2, $arr) &&
            in_array($carton->n_4, $arr) &&
            in_array($carton->n_5, $arr) &&

            in_array($carton->g_1, $arr) &&
            in_array($carton->g_2, $arr) &&
            in_array($carton->g_3, $arr) &&
            in_array($carton->g_4, $arr) &&
            in_array($carton->g_5, $arr) &&

            in_array($carton->o_1, $arr) &&
            in_array($carton->o_2, $arr) &&
            in_array($carton->o_3, $arr) &&
            in_array($carton->o_4, $arr) &&
            in_array($carton->o_5, $arr)){
            return true;
        }
        else 
            return false;
    }
    return false;
}



$juego =$_POST["juego"];

$cantados =  consultarCantado($juego);

?>




<html>
    <head>
        <script src="https://code.jquery.com/jquery-3.6.0.slim.min.js" integrity="sha256-u7e5khyithlIdTpu22PHhENmPcRdFiHRjhAuHcs05RI=" crossorigin="anonymous"></script>
        <script>
            function consultarCarton(){
                var numero = document.getElementById("carton").value;
                if(numero){
                    $("[name=cartones]").not("#carton_"+numero).each(function(){$(this).parent().prop("hidden",true);})
                }
                else{
                 $("[name=cartones]").each(function(){$(this).parent().prop("hidden",false);})   
                }
            }
            function addLiCarton(ul, numero){
                console.log(numero);
                $("#"+ul).append("<li>"+numero+"</li>");
            }
        </script>
    </heead>
    <body>        
        <a href="listaJuegos.php">Volver</a>
        <br/>
        <hr />
        <form method="post">
            <label>Cantar Número</label>
            <input type="hidden" id="juego" name="juego" value="<?=$juego?>"?>
            <input type="hidden"  name="accion" value="guardar">
            <input type="number" min=1 max=75 id="numero" name="numero">
            <button type="submit">Enviar</button>
        </form>


        <?php
        if(!empty($cantados)){
        ?>
        <hr />

        <table border=1>
            <thead>
                <tr>
                    <th>
                    Números Cantados
                    </th>
                    <th>
                    Cartones horizontal
                    </th>
                    <th>
                    Cartones vertical
                    </th>
                    <th>
                    Cartones diagonal izquierda
                    </th>
                    <th>
                    Cartones diagonal derecha
                    </th>
                    <th>
                    Cartones completos
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="vertical-align: top;">
                        <ul>
                            <?php
                            foreach( $cantados as $cantado )
                            {?>
                                <li><?=($cantado)?> </li>
                            <?php }?>
                            <form method="post" id="formDeshacer">
                                <input type="hidden" id="juego" name="juego" value="<?=$juego?>"?>
                                <input type="hidden" name="accion" value="deshacer">
                                <br/>
                                <button onclick="if(confirm('¿Estás seguro de deshacer el último número marcado?')==true){document.getElementById('formDeshacer').submit() }">Deshacer</button>
                            </form>
                        </ul>
                        <?php } ?>
                    </td>
                    <td style="vertical-align: top;">
                        <ul id="Horizontal">
                        </ul>
                    </td>
                    <td style="vertical-align: top;">
                         <ul id="Vertical">
                         </ul>
                    </td>
                    <td style="vertical-align: top;">
                        <ul id="DiagIzq">
                        </ul>
                    </td>
                    <td style="vertical-align: top;">
                        <ul id="DiagDer">
                        </ul>
                    </td>
                    <td style="vertical-align: top;">
                        <ul id="Completo">
                        </ul>
                    </td>
                </tr>
            </tbody>
        </table>
        

        <hr /> 
                <label>Consultar Cartón</label>
                <input id="carton" name="carton" type="number" min=1 max=<?=$totalCartones?>>
                <button type="button" onclick="consultarCarton()">Consultar </button>
 
        <hr />
        <table border=1>
            <thead>
                <th colspan="<?=$cartonPorLinea?>">Cartones</th>
            </thead>
            <tbody>
                <?php 
                $contador = 0;
                echo "<tr>";
                $i=0;
                foreach(consultarCartonBingo() as $carton){

                    if(IsHorizontal($carton,$cantados))
                        array_push($ListaHorizontal,$carton->NumeroCartonBingo);
                    if(IsVertical($carton,$cantados))
                        array_push($ListaVertical,$carton->NumeroCartonBingo);
                    if(IsDiagIzq($carton,$cantados))
                        array_push($ListaDiagIzq,$carton->NumeroCartonBingo);
                    if(IsDiagDer($carton,$cantados))
                        array_push($ListaDiagDer,$carton->NumeroCartonBingo);
                    if(IsCompleto($carton,$cantados))
                        array_push($ListaCompleto,$carton->NumeroCartonBingo);
                    

                    $i++;
                    $contador++;
                    if($contador == $cartonPorLinea+1){
                        $contador = 1;
                        echo "</tr>";
                        echo "<tr>";
                    }
 
                    if(empty($carton->b_1) ||
                       empty($carton->b_2) ||
                       empty($carton->b_3) ||
                       empty($carton->b_4) ||
                       empty($carton->b_5) ||
                       empty($carton->i_1) ||
                       empty($carton->i_2) ||
                       empty($carton->i_3) ||
                       empty($carton->i_4) ||
                       empty($carton->i_5) ||
                       empty($carton->n_1) ||
                       empty($carton->n_2) ||
                       empty($carton->n_4) ||
                       empty($carton->n_5) ||
                       empty($carton->g_1) ||
                       empty($carton->g_2) ||
                       empty($carton->g_3) ||
                       empty($carton->g_4) ||
                       empty($carton->g_5) ||
                       empty($carton->o_1) ||
                       empty($carton->o_2) ||
                       empty($carton->o_3) ||
                       empty($carton->o_4) ||
                       empty($carton->o_5) ){
                        echo "<td>Falta Cartón #".$i."</td>";
                    }
                    else{

                    echo "<td>";
                    ?>


                <table border=1 name="cartones" id="carton_<?=$i?>">
                    <thead>
                        <tr>
                            <th colspan=5><?="BINGO #".$i?></th>
                        </tr>
                        <tr>
                            <th>B</th>
                            <th>I</th>
                            <th>N</th>
                            <th>G</th>
                            <th>O</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td <?=InListStyle($carton->b_1,$cantados)?>><?=$carton->b_1?></td>
                            <td <?=InListStyle($carton->i_1,$cantados)?>><?=$carton->i_1?></td>
                            <td <?=InListStyle($carton->n_1,$cantados)?>><?=$carton->n_1?></td>
                            <td <?=InListStyle($carton->g_1,$cantados)?>><?=$carton->g_1?></td>
                            <td <?=InListStyle($carton->o_1,$cantados)?>><?=$carton->o_1?></td>
                        </tr>
                        <tr>
                            <td <?=InListStyle($carton->b_2,$cantados)?>><?=$carton->b_2?></td>
                            <td <?=InListStyle($carton->i_2,$cantados)?>><?=$carton->i_2?></td>
                            <td <?=InListStyle($carton->n_2,$cantados)?>><?=$carton->n_2?></td>
                            <td <?=InListStyle($carton->g_2,$cantados)?>><?=$carton->g_2?></td>
                            <td <?=InListStyle($carton->o_2,$cantados)?>><?=$carton->o_2?></td>
                        </tr>
                        <tr>
                            <td <?=InListStyle($carton->b_3,$cantados)?>><?=$carton->b_3?></td>
                            <td <?=InListStyle($carton->i_3,$cantados)?>><?=$carton->i_3?></td>
                            <td></td>
                            <td <?=InListStyle($carton->g_3,$cantados)?>><?=$carton->g_3?></td>
                            <td <?=InListStyle($carton->o_3,$cantados)?>><?=$carton->o_3?></td>
                        </tr>
                        <tr>
                            <td <?=InListStyle($carton->b_4,$cantados)?>><?=$carton->b_4?></td>
                            <td <?=InListStyle($carton->i_4,$cantados)?>><?=$carton->i_4?></td>
                            <td <?=InListStyle($carton->n_4,$cantados)?>><?=$carton->n_4?></td>
                            <td <?=InListStyle($carton->g_4,$cantados)?>><?=$carton->g_4?></td>
                            <td <?=InListStyle($carton->o_4,$cantados)?>><?=$carton->o_4?></td>
                        </tr>
                        <tr>
                            <td <?=InListStyle($carton->b_5,$cantados)?>><?=$carton->b_5?></td>
                            <td <?=InListStyle($carton->i_5,$cantados)?>><?=$carton->i_5?></td>
                            <td <?=InListStyle($carton->n_5,$cantados)?>><?=$carton->n_5?></td>
                            <td <?=InListStyle($carton->g_5,$cantados)?>><?=$carton->g_5?></td>
                            <td <?=InListStyle($carton->o_5,$cantados)?>><?=$carton->o_5?></td>
                        </tr> 
                    </tbody>
                </table>

                <?php
                    echo "</td>";
                    
                }
            }
                ?>
            <script>
                <?php
                foreach($ListaHorizontal as $num){?>
                    addLiCarton("Horizontal",<?=$num?>)
                <?php }
                foreach($ListaVertical as $num){?>
                    addLiCarton("Vertical",<?=$num?>)
                <?php }
                foreach($ListaDiagIzq as $num){?>
                    addLiCarton("DiagIzq",<?=$num?>)
                <?php }
                foreach($ListaDiagDer as $num){?>
                    addLiCarton("DiagDer",<?=$num?>)
                <?php }
                foreach($ListaCompleto as $num){?>
                    addLiCarton("Completo",<?=$num?>)
                <?php }?>

            </script>
            </tbody>
        </table>
        
    </body>
</html>
