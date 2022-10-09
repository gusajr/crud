<?php 
include("conexion.php");
$conn=conectar();
$ids=[];
$sql = "SHOW KEYS FROM ".$_POST["tablaSeleccionada"];
$result = $conn->query($sql);
while($col = $result->fetch_array()) {
   array_push($ids,$col[4]);
}

echo "<link href='https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css' rel='stylesheet' integrity='sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi' crossorigin='anonymous'>
<!-- JavaScript Bundle with Popper -->
<script src='https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js' integrity='sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3' crossorigin='anonymous'></script>";
switch($_POST["tablaOpcion"]){
    case "leer":
        $sql = "SELECT * FROM ".$_POST["tablaSeleccionada"];
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            // output data of each row
            $all_property = array();  //declare an array for saving property
            //showing property
            echo '<table class="data-table">
                    <tr class="data-heading">';  //initialize table tag
            while ($property = mysqli_fetch_field($result)) {
                echo '<td>' . $property->name . '</td>';  //get field name for header
                $all_property[] = $property->name;  //save those to array
            }
            echo '</tr>'; //end tr tag
            //showing all data
            while ($row = mysqli_fetch_array($result)) {
                echo "<tr>";
                foreach ($all_property as $item) {
                    echo '<td>' . $row[$item] . '</td>'; //get items using property value
                }
                echo '</tr>';
            }
            echo "</table>";
        } else {
        echo "0 results";
        }
        break;
    case "insertar":
    case "actualizar":
        $sql = "SHOW COLUMNS FROM ".$_POST["tablaSeleccionada"];
        $result = $conn->query($sql);
        $columnas = "";
        echo "<form action='procesamiento.php' method='post'>";
        echo "<label for='tablaSeleccionada'>Tabla seleccionada: </label>";
        echo "<input type='text' id='tablaSeleccionada' name='tablaSeleccionada' value='".$_POST["tablaSeleccionada"]."' readonly> <br>";
        echo "<label for='tablaOpcion'>Tabla opción: </label>";
        echo "<input type='text' id='tablaOpcion' name='tablaOpcion' value='".$_POST["tablaOpcion"]."' readonly> <br>";

        while($col = $result->fetch_array()) {
            //echo "<option value=".$row[0].">".$row[0]."</option>";
            echo "<label for=".$col[0].">Atributo: ".$col[0]."</label><br><br>";
            echo "<input type='text' id=.'".$col[0]."' name='".$col[0]."' placeholder=".$col[0]."><br><br>";
            $columnas = $columnas." ".$col[0];
        }
        echo "<input type='submit' class='btn btn-success' value='Enviar'>
        </form>";
        break;
    case "borrar":
        echo "<form action='procesamiento.php' method='post'>";
        echo "<label for='tablaSeleccionada'>Tabla seleccionada: </label>";
        echo "<input type='text' id='tablaSeleccionada' name='tablaSeleccionada' value='".$_POST["tablaSeleccionada"]."' readonly> <br>";
        echo "<label for='tablaOpcion'>Tabla opción: </label>";
        echo "<input type='text' id='tablaOpcion' name='tablaOpcion' value='".$_POST["tablaOpcion"]."' readonly> <br>";

        forEach($ids as $valor) {
            echo "<label for=".$valor.">Atributo: ".$valor."</label><br><br>";
            echo "<input type='text' id=.'".$valor."' name='".$valor."' placeholder=".$valor."><br><br>";
        }
        echo "<input type='submit' class='btn btn-success' value='Enviar'>
        </form>";
        break;

}
echo "<button type='button'  class='btn btn-danger'><a href='inicio.php'>Regresar<a/></button>";
$conn->close();

?>