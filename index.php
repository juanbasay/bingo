<?php
include("conexion.php");
include("config.php");
include("clases.php");

function InListStyle($num, $arr){
    return in_array($num, $arr) ? "style='background-color:green;'" : "";
}

function InList_B($num, $arr){
    return in_array($num, $arr);
}

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


$juego =$_POST["juego"];

$totalCartones = 420;

$inicio = (!empty($_POST["carton"]))?$_POST["carton"]:1;
$fin = (!empty($_POST["carton"]))?$_POST["carton"]: $totalCartones;

$cantados =  consultarCantado($juego);


$lista_vertical = [];
foreach(consultar_vertical_todas($juego) as $numero){
    array_push($lista_vertical,$numero);
}

$lista_horizontal = [];
foreach(consultar_horizontal_todas($juego) as $numero){
    array_push($lista_horizontal,$numero);
}

$lista_diagIzq = [];
foreach(consultar_diagIzq_todas($juego) as $numero){
    array_push($lista_diagIzq,$numero);
}

$lista_diagDer = [];
foreach(consultar_diagDer_todas($juego) as $numero){
    array_push($lista_diagDer,$numero);
}

$lista_completo = [];
foreach(consultar_completo_todas($juego) as $numero){
    array_push($lista_completo,$numero);
}

?>




<html>
    <head>
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
                            <?php 
                                foreach($lista_horizontal as $item){?>
                            <li><?=$item?></li>
                                <?php }?>
                        </ul>
                    </td>
                    <td style="vertical-align: top;">
                         <ul id="Vertical">
                             <?php 
                                foreach($lista_vertical as $item){?>
                            <li><?=$item?></li>
                                <?php }?>
                         </ul>
                    </td>
                    <td style="vertical-align: top;">
                        <ul id="DiagIzq">
                            <?php 
                                foreach($lista_diagIzq as $item){?>
                            <li><?=$item?></li>
                                <?php }?>
                        </ul>
                    </td>
                    <td style="vertical-align: top;">
                        <ul id="DiagDer">
                            <?php 
                                foreach($lista_diagDer as $item){?>
                            <li><?=$item?></li>
                                <?php }?>
                        </ul>
                    </td>
                    <td style="vertical-align: top;">
                        <ul id="Completo">
                            <?php 
                                foreach($lista_completo as $item){?>
                            <li><?=$item?></li>
                                <?php }?>
                        </ul>
                            
                    </td>
                </tr>
            </tbody>
        </table>
        

        <hr />
        <form method="post">
                <label>Consultar Cartón</label>
                <input type="hidden" id="juego" name="juego" value="<?=$juego?>"?>
                <input id="carton" name="carton" type="number" min=1 max=<?=$totalCartones?>>
                <button type="submit">Consultar </button>

        </form>
        <hr />
        <table border=1>
            <thead>
                <th colspan="<?=$cartonPorLinea?>">Cartones</th>
            </thead>
            <tbody>
                <?php $contador = 0;?>
                <?php 
                echo "<tr>";

                for($i=$inicio;$i<=$fin;$i++){
                    $contador++;
                    if($contador == $cartonPorLinea+1){
                        $contador = 1;
                        echo "</tr>";
                        echo "<tr>";
                    }

                    $carton = consultarCarton2($i);
                    
                    if(!(!empty($carton->letra_b) && !empty($carton->letra_i) && !empty($carton->letra_n) && !empty($carton->letra_g) && !empty($carton->letra_o))){
                        echo "<td>Falta Cartón #".$i."</td>";
                    }
                    else{
                    
                    echo "<td>";
                    ?>


                <table border=1>
                    <thead>
                        <tr>
                            <th  colspan=5><?="BINGO #".$i?></th>
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
                            <td <?=InListStyle($carton->letra_b->b_1,$cantados)?>><?=$carton->letra_b->b_1?></td>
                            <td <?=InListStyle($carton->letra_i->i_1,$cantados)?>><?=$carton->letra_i->i_1?></td>
                            <td <?=InListStyle($carton->letra_n->n_1,$cantados)?>><?=$carton->letra_n->n_1?></td>
                            <td <?=InListStyle($carton->letra_g->g_1,$cantados)?>><?=$carton->letra_g->g_1?></td>
                            <td <?=InListStyle($carton->letra_o->o_1,$cantados)?>><?=$carton->letra_o->o_1?></td>
                        </tr>
                        <tr>
                            <td <?=InListStyle($carton->letra_b->b_2,$cantados)?>><?=$carton->letra_b->b_2?></td>
                            <td <?=InListStyle($carton->letra_i->i_2,$cantados)?>><?=$carton->letra_i->i_2?></td>
                            <td <?=InListStyle($carton->letra_n->n_2,$cantados)?>><?=$carton->letra_n->n_2?></td>
                            <td <?=InListStyle($carton->letra_g->g_2,$cantados)?>><?=$carton->letra_g->g_2?></td>
                            <td <?=InListStyle($carton->letra_o->o_2,$cantados)?>><?=$carton->letra_o->o_2?></td>
                        </tr>
                        <tr>
                            <td <?=InListStyle($carton->letra_b->b_3,$cantados)?>><?=$carton->letra_b->b_3?></td>
                            <td <?=InListStyle($carton->letra_i->i_3,$cantados)?>><?=$carton->letra_i->i_3?></td>
                            <td></td>
                            <td <?=InListStyle($carton->letra_g->g_3,$cantados)?>><?=$carton->letra_g->g_3?></td>
                            <td <?=InListStyle($carton->letra_o->o_3,$cantados)?>><?=$carton->letra_o->o_3?></td>
                        </tr>
                        <tr>
                            <td <?=InListStyle($carton->letra_b->b_4,$cantados)?>><?=$carton->letra_b->b_4?></td>
                            <td <?=InListStyle($carton->letra_i->i_4,$cantados)?>><?=$carton->letra_i->i_4?></td>
                            <td <?=InListStyle($carton->letra_n->n_4,$cantados)?>><?=$carton->letra_n->n_4?></td>
                            <td <?=InListStyle($carton->letra_g->g_4,$cantados)?>><?=$carton->letra_g->g_4?></td>
                            <td <?=InListStyle($carton->letra_o->o_4,$cantados)?>><?=$carton->letra_o->o_4?></td>
                        </tr>
                        <tr>
                            <td <?=InListStyle($carton->letra_b->b_5,$cantados)?>><?=$carton->letra_b->b_5?></td>
                            <td <?=InListStyle($carton->letra_i->i_5,$cantados)?>><?=$carton->letra_i->i_5?></td>
                            <td <?=InListStyle($carton->letra_n->n_5,$cantados)?>><?=$carton->letra_n->n_5?></td>
                            <td <?=InListStyle($carton->letra_g->g_5,$cantados)?>><?=$carton->letra_g->g_5?></td>
                            <td <?=InListStyle($carton->letra_o->o_5,$cantados)?>><?=$carton->letra_o->o_5?></td>
                        </tr> 
                    </tbody>
                </table>

                <?php
                    echo "</td>";
                    
                }
            }
                ?>


            </tbody>
        </table>
        
    </body>
</html>
