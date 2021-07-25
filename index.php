<?php
include("config.php");
include("Model/data.php");
include("Class/cantado.class.php");
include("Class/carton_bingo.class.php");

if(isset($_POST) && !empty($_POST["accion"])){
    switch($_POST["accion"]){
        case "guardar":
            if(!empty($_POST["numero"]))
                Data\GuardarNumero($_POST["numero"], $_POST["juego"]);
            break;
        case "deshacer":
            Data\DeshacerNumero($_POST["juego"]);
            break;
      default:
        break;
    }
}

$juego =$_POST["juego"];
if(!$juego)
    die(header("Location: ListaJuegos.php"));

function InListStyle($num, $arr){
    return in_array($num, $arr) ? "style='background-color:green;'" : "";
}

$ListaDiagIzq = [];
$ListaDiagDer = [];
$ListaHorizontalMedio = [];
$ListaEsquinas = [];
$ListaEquis = [];
$ListaCruz = [];
$ListaCompleto = [];

function IsHorizontalMedio($carton, $arr){
    if($carton && $arr){
        if( in_array($carton->b_3, $arr) &&
            in_array($carton->i_3, $arr) &&
            in_array($carton->g_3, $arr) &&
            in_array($carton->o_3, $arr)){
            return true;
        }
    }
    return false;
}

function IsEsquinas($carton, $arr){
    if($carton && $arr){
        if( in_array($carton->b_1, $arr) &&
            in_array($carton->o_1, $arr) &&
            in_array($carton->b_5, $arr) &&
            in_array($carton->o_5, $arr)){
            return true;
        }
        else 
            return false;
    }
    return false;
}

function IsEquis($carton, $arr){
    if($carton && $arr){
        if(IsDiagIzq($carton,$arr) && IsDiagDer($carton,$arr))
            return true;
        else 
            return false;

    }
    return false;
}

function IsCruz($carton, $arr){
    if($carton && $arr){
        
        if( in_array($carton->n_1, $arr) &&
            in_array($carton->n_2, $arr) &&
            in_array($carton->n_4, $arr) &&
            in_array($carton->n_5, $arr) &&
            in_array($carton->b_2, $arr) &&
            in_array($carton->i_2, $arr) &&
            in_array($carton->n_2, $arr) &&
            in_array($carton->g_2, $arr) &&
            in_array($carton->o_2, $arr)){
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




$cantados =  Data\consultarCantado($juego);

?>




<html>
    <head>
        <script src="https://code.jquery.com/jquery-3.6.0.slim.min.js" integrity="sha256-u7e5khyithlIdTpu22PHhENmPcRdFiHRjhAuHcs05RI=" crossorigin="anonymous"></script>
        <script>
            function consultarCarton(){
                $("[name=cartones]").each(function(){$(this).parent().prop("hidden",false);})   
                var numero1 = document.getElementById("carton_consulta_1").value;
                var numero2 = document.getElementById("carton_consulta_2").value;
                var numero3 = document.getElementById("carton_consulta_3").value;
                var numero4 = document.getElementById("carton_consulta_4").value;
                var numero5 = document.getElementById("carton_consulta_5").value;
                var numero6 = document.getElementById("carton_consulta_6").value;
                if(numero1 || numero2 || numero3 || numero4 || numero5 || numero6){
                    $("[name=cartones]").not("#carton_"+numero1)
                                        .not("#carton_"+numero2)
                                        .not("#carton_"+numero3)
                                        .not("#carton_"+numero4)
                                        .not("#carton_"+numero5)
                                        .not("#carton_"+numero6)
                        .each(function(){$(this).parent().prop("hidden",true);})
                }
            }
            function addLiCarton(ul, numero){
                if(ul && numero){
                    $("#"+ul).append("<li>"+numero+"</li>");
                }
            }

            function ModoDeJuego(modo){
                console.log("este es el modo:");
                console.log(modo);
                if(modo){
                    switch(modo){
                        case 1:
                            $('.ocultar').prop('hidden',true);$('#td_DiagIzq').prop('hidden',false);$('#titulo_DiagIzq').prop('hidden',false)
                            break;
                        case 2:
                            $('.ocultar').prop('hidden',true);$('#td_DiagDer').prop('hidden',false);$('#titulo_DiagDer').prop('hidden',false)
                            break;
                        case 3:
                            $('.ocultar').prop('hidden',true);$('#td_HorizontalMedio').prop('hidden',false);$('#titulo_HorizontalMedio').prop('hidden',false)
                            break;
                        case 4:
                            $('.ocultar').prop('hidden',true);$('#td_Esquinas').prop('hidden',false);$('#titulo_Esquinas').prop('hidden',false)
                            break;
                        case 5:
                            $('.ocultar').prop('hidden',true);$('#td_Equis').prop('hidden',false);$('#titulo_Equis').prop('hidden',false)
                            break;
                        case 6:
                            $('.ocultar').prop('hidden',true);$('#td_Cruz').prop('hidden',false);$('#titulo_Cruz').prop('hidden',false)
                            break;
                        case 7:
                            $('.ocultar').prop('hidden',true);$('#td_Completo').prop('hidden',false);$('#titulo_Completo').prop('hidden',false)
                            break;
                        default:
                            break;
                    }
                    $("#modoJuego").val(modo);
                }
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
            <input type="hidden" name="modoJuego" id="modoJuego" />
            <button type="submit">Enviar</button>
        </form>
        <hr />
        Modos de juego

        <button onclick="ModoDeJuego(1);">Binguito Diagonal Izquierda</button>  
        <button onclick="ModoDeJuego(2);">Binguito Diagonal Derecha</button>    
        <button onclick="ModoDeJuego(3);">Binguito Horizontal Medio</button>    
        <button onclick="ModoDeJuego(4);">Binguito Esquinas</button>    
        <button onclick="ModoDeJuego(5);">Binguito Equis</button>   
        <button onclick="ModoDeJuego(6);">Binguito Cruz</button>    
        <button onclick="ModoDeJuego(7);">Binguito Completo</button> 

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
                    <th hidden class="ocultar" id="titulo_DiagIzq">
                    Binguito Diagonal Izquierda
                    </th>
                    <th hidden class="ocultar" id="titulo_DiagDer">
                    Binguito Diagonal Derecha
                    </th>
                    <th hidden class="ocultar" id="titulo_HorizontalMedio">
                    Binguito Horizontal Medio
                    </th>
                    <th hidden class="ocultar" id="titulo_Esquinas">
                    Binguito Esquinas
                    </th>
                    <th hidden class="ocultar" id="titulo_Equis">
                    Binguito Equis
                    </th>
                    <th hidden class="ocultar" id="titulo_Cruz">
                    Binguito Cruz
                    </th>
                     <th hidden class="ocultar" id="titulo_Completo">
                    Binguito Completo
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="vertical-align: top;">
                        <table>
                            <tr>
                                

                            <?php
                            $x = 0;
                            $cantadosArr = [];
                            foreach($cantados as $obj) array_push($cantadosArr,$obj->NumeroCantado);
                            foreach( $cantados as $cantado ){
                                if($x==0){
                                    echo "<td style='vertical-align: top;'><ul>";
                                }
                                $x= $x+1;
                                
                            ?>
                                    <?php
                                        $letraCantado = "";
                                        if($cantado->NumeroCantado<=15)
                                            $letraCantado = "B";
                                        elseif($cantado->NumeroCantado<=30)
                                            $letraCantado = "I";
                                        elseif($cantado->NumeroCantado<=45)
                                            $letraCantado = "N";
                                        elseif($cantado->NumeroCantado<=60)
                                            $letraCantado = "G";
                                        elseif($cantado->NumeroCantado<=75)
                                            $letraCantado = "O";
                                    ?>
                                        <li><?=($letraCantado."".$cantado->NumeroCantado)?> </li>

                                        <?php
                                    if($x == $cantadosPorLinea){
                                        $x=0;
                                        echo "</ul></td>";
                                    }
                                ?>

                                        <?php }?>
                                        
                                
                                
                                    </ul>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <form method="post" id="formDeshacer">
                                        <input type="hidden" id="juego" name="juego" value="<?=$juego?>"?>
                                        <input type="hidden" name="accion" value="deshacer">
                                        <br/>
                                        <button onclick="if(confirm('¿Estás seguro de deshacer el último número marcado?')==true){document.getElementById('formDeshacer').submit() }">Deshacer</button>
                                    </form>
                                </td>
                            </tr>
                        </table>

                        <?php } ?>
                    </td>
                    <td hidden style="vertical-align: top;" class="ocultar" id="td_DiagIzq">
                        <ul id="DiagIzq" >
                        </ul>
                    </td>
                    <td hidden style="vertical-align: top;" class="ocultar" id="td_DiagDer">
                        <ul id="DiagDer" >
                        </ul>
                    </td>
                    <td hidden style="vertical-align: top;" class="ocultar" id="td_HorizontalMedio">
                        <ul id="HorizontalMedio" >
                        </ul>
                    </td>
                    <td hidden style="vertical-align: top;" class="ocultar" id="td_Esquinas">
                         <ul id="Esquinas" >
                         </ul>
                    </td>
                    <td hidden style="vertical-align: top;" class="ocultar" id="td_Equis">
                         <ul id="Equis" >
                         </ul>
                    </td>
                    <td hidden style="vertical-align: top;" class="ocultar" id="td_Cruz">
                         <ul id="Cruz" >
                         </ul>
                    </td>
                    <td hidden style="vertical-align: top;" class="ocultar" id="td_Completo">
                        <ul id="Completo" >
                        </ul>
                    </td>
                </tr>
            </tbody>
        </table>
        

        <hr /> 
                <label>Consultar Cartón</label>
                <input id="carton_consulta_1" name="carton_consulta" oninput="consultarCarton()" type="number" min=1 max=<?=$totalCartones?>>
                <input id="carton_consulta_2" name="carton_consulta" oninput="consultarCarton()" type="number" min=1 max=<?=$totalCartones?>>
                <input id="carton_consulta_3" name="carton_consulta" oninput="consultarCarton()" type="number" min=1 max=<?=$totalCartones?>>
                <input id="carton_consulta_4" name="carton_consulta" oninput="consultarCarton()" type="number" min=1 max=<?=$totalCartones?>>
                <input id="carton_consulta_5" name="carton_consulta" oninput="consultarCarton()" type="number" min=1 max=<?=$totalCartones?>>
                <input id="carton_consulta_6" name="carton_consulta" oninput="consultarCarton()" type="number" min=1 max=<?=$totalCartones?>>
                
                <button type="button" onclick="$('[name=carton_consulta]').val(''); consultarCarton();">Limpiar</button>
 
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
                foreach(Data\consultarCartonBingo() as $carton){
                    if(IsDiagIzq($carton,$cantadosArr))
                        array_push($ListaDiagIzq,$carton->NumeroCartonBingo);

                    if(IsDiagDer($carton,$cantadosArr))
                        array_push($ListaDiagDer,$carton->NumeroCartonBingo);

                    if(IsHorizontalMedio($carton,$cantadosArr))
                        array_push($ListaHorizontalMedio,$carton->NumeroCartonBingo);

                    if(IsEsquinas($carton,$cantadosArr))
                        array_push($ListaEsquinas,$carton->NumeroCartonBingo);

                     if(IsEquis($carton,$cantadosArr))
                        array_push($ListaEquis,$carton->NumeroCartonBingo);

                     if(IsCruz($carton,$cantadosArr))
                        array_push($ListaCruz,$carton->NumeroCartonBingo);


                    if(IsCompleto($carton,$cantadosArr))
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
                            <td <?=InListStyle($carton->b_1,$cantadosArr)?>><?=$carton->b_1?></td>
                            <td <?=InListStyle($carton->i_1,$cantadosArr)?>><?=$carton->i_1?></td>
                            <td <?=InListStyle($carton->n_1,$cantadosArr)?>><?=$carton->n_1?></td>
                            <td <?=InListStyle($carton->g_1,$cantadosArr)?>><?=$carton->g_1?></td>
                            <td <?=InListStyle($carton->o_1,$cantadosArr)?>><?=$carton->o_1?></td>
                        </tr>
                        <tr>
                            <td <?=InListStyle($carton->b_2,$cantadosArr)?>><?=$carton->b_2?></td>
                            <td <?=InListStyle($carton->i_2,$cantadosArr)?>><?=$carton->i_2?></td>
                            <td <?=InListStyle($carton->n_2,$cantadosArr)?>><?=$carton->n_2?></td>
                            <td <?=InListStyle($carton->g_2,$cantadosArr)?>><?=$carton->g_2?></td>
                            <td <?=InListStyle($carton->o_2,$cantadosArr)?>><?=$carton->o_2?></td>
                        </tr>
                        <tr>
                            <td <?=InListStyle($carton->b_3,$cantadosArr)?>><?=$carton->b_3?></td>
                            <td <?=InListStyle($carton->i_3,$cantadosArr)?>><?=$carton->i_3?></td>
                            <td></td>
                            <td <?=InListStyle($carton->g_3,$cantadosArr)?>><?=$carton->g_3?></td>
                            <td <?=InListStyle($carton->o_3,$cantadosArr)?>><?=$carton->o_3?></td>
                        </tr>
                        <tr>
                            <td <?=InListStyle($carton->b_4,$cantadosArr)?>><?=$carton->b_4?></td>
                            <td <?=InListStyle($carton->i_4,$cantadosArr)?>><?=$carton->i_4?></td>
                            <td <?=InListStyle($carton->n_4,$cantadosArr)?>><?=$carton->n_4?></td>
                            <td <?=InListStyle($carton->g_4,$cantadosArr)?>><?=$carton->g_4?></td>
                            <td <?=InListStyle($carton->o_4,$cantadosArr)?>><?=$carton->o_4?></td>
                        </tr>
                        <tr>
                            <td <?=InListStyle($carton->b_5,$cantadosArr)?>><?=$carton->b_5?></td>
                            <td <?=InListStyle($carton->i_5,$cantadosArr)?>><?=$carton->i_5?></td>
                            <td <?=InListStyle($carton->n_5,$cantadosArr)?>><?=$carton->n_5?></td>
                            <td <?=InListStyle($carton->g_5,$cantadosArr)?>><?=$carton->g_5?></td>
                            <td <?=InListStyle($carton->o_5,$cantadosArr)?>><?=$carton->o_5?></td>
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
                foreach($ListaDiagIzq as $num){?>
                    addLiCarton("DiagIzq",<?=$num?>);
                <?php }
                foreach($ListaDiagDer as $num){?>
                    addLiCarton("DiagDer",<?=$num?>);
                <?php }
                foreach($ListaHorizontalMedio as $num){?>
                    addLiCarton("HorizontalMedio",<?=$num?>);
                <?php }
                foreach($ListaEsquinas as $num){?>
                    addLiCarton("Esquinas",<?=$num?>);
                <?php }
                foreach($ListaEquis as $num){?>
                    addLiCarton("Equis",<?=$num?>);
                <?php }
                foreach($ListaCruz as $num){?>
                    addLiCarton("Cruz",<?=$num?>);
                <?php }
                foreach($ListaCompleto as $num){?>
                    addLiCarton("Completo",<?=$num?>);
                <?php }?>

                <?php 
            if(!empty($_POST["modoJuego"])){
                echo "ModoDeJuego(".$_POST["modoJuego"].");";
            }
            ?>
            </script>
            </tbody>
        </table>
        
    </body>
</html>
