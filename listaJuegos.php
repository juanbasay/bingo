<?php
include("conexion.php");
include("config.php");
include("clases.php");
   
if(isset($_POST) && !empty($_POST["accion"])){
    switch($_POST["accion"]){
        case "nuevo":
                NuevoJuego();
            break;
      default:
        break;
    }
}

$lista = consultarJuegos();





?>


<html>
    <head>
    </heead>
    <body>
        <form method="post">
            <input type="hidden"  name="accion" value="nuevo" >
            <button submit>Nuevo Juego</button>
        </form>
        <hr/>
        <table border=1 >
            <thead>
                <tr>
                    <th>Lista de juegos</th>
                </tr>
            </thead>
            <tbody>
                <form method="post" id="formJuegos" action="index.php">
                    <input type="hidden" id="juego" name="juego">
                    <button type="submit" hidden></button>
                </form>
                <?php
                if(!empty($lista)){
                foreach($lista as $juego){?>
                <tr>
                    <td style="text-align: center;" onclick="submit(<?=$juego?>)"><?=$juego?></td>
                </tr>
                <?php }}?>
            </tbody>
        </table>
        <script>
            function submit(juego){
                document.getElementById("juego").value = juego;
                document.getElementById("formJuegos").submit();
            }
        </script>
    </body>
</html>
