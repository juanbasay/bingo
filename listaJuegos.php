<?php
include("config.php");
include("Model/data.php");
include("Class/cantado.class.php");
   
if(isset($_POST) && !empty($_POST["accion"])){
    switch($_POST["accion"]){
        case "nuevo":
            Data\NuevoJuego();
            break;
      default:
        break;
    }
}
$lista = Data\consultarJuegos();
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
                    <th>Fecha Juego</th>
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
                <tr onclick="submit(<?=$juego["NumeroJuego"]?>)">
                    <td style="text-align: center;" ><?=$juego["NumeroJuego"]?></td>
                    <td style="text-align: center;" ><?=$juego["FechaJuego"]?></td>
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
