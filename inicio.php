<?php
include("conexion.php");
$conn=conectar();
$sqlTablas = "SHOW TABLES";
$resultTablas = $conn->query($sqlTablas);
$cont=0;
$cadena="";

echo "
<!-- CSS only -->
<link href='https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css' rel='stylesheet' integrity='sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi' crossorigin='anonymous'>
<!-- JavaScript Bundle with Popper -->
<script src='https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js' integrity='sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3' crossorigin='anonymous'></script>
<div class='form-group'>
<form action='capturaDatos.php' method='post'>
<label for='tablaSeleccionada'>Selecciona la tabla de trabajo:</label>
<select id='tablaSeleccionada' name='tablaSeleccionada'>";
while($row = $resultTablas->fetch_array()) {
    echo "<option value=".$row[0].">".$row[0]."</option>";
}
echo "</select><br>";

echo "<label for='tablaOpcion'>¿Qué quieres hacer con la tabla?</label>
<select id='tablaOpcion' name='tablaOpcion'>
  <option value='insertar'>Insertar</option>
  <option value='leer'>Leer</option>
  <option value='actualizar'>Actualizar</option>
  <option value='borrar'>Borrar</option>
</select>
<br><br>
<input type='submit' class='btn btn-success' value='Enviar'> 
</form></div>";

?>