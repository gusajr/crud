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
    case "insertar":
        $columnas="";
        $sql = "SHOW COLUMNS FROM ".$_POST["tablaSeleccionada"];
        $result = $conn->query($sql);
        while($col = $result->fetch_array()) {
            $columnas = $columnas.$col[0].",";
        }
        $columnas = rtrim($columnas, ",");
        $sql = "INSERT INTO ".$_POST["tablaSeleccionada"]."(".$columnas.") VALUES (";
        forEach($_POST as $valor){
            if($valor!=$_POST["tablaSeleccionada"] && $valor!=$_POST["tablaOpcion"]){
                $sql = $sql."'".$valor."',";
            }
        }
        $sql = rtrim($sql, ",");
        $sql = $sql.");";
        //echo $sql;
        $result = $conn->query($sql);
        if(!$result){
            echo "Ha ocurrido un error al llenar la base de datos";
        }else{
            echo "La transacción ha sido exitosa";
        }
        break;
    case "actualizar":
        $columnas="";
        $sql = "SHOW COLUMNS FROM ".$_POST["tablaSeleccionada"];
        $result = $conn->query($sql);
        while($col = $result->fetch_array()) {
            $columnas = $columnas.$col[0].",";
        }
        $columnas = rtrim($columnas, ",");
        $columnas = explode(",",$columnas);
        $cont=0;
        $sql = "UPDATE ".$_POST["tablaSeleccionada"]." SET ";
        $where = "WHERE ";
        forEach($_POST as $valor){
            if($valor!=$_POST["tablaSeleccionada"] && $valor!=$_POST["tablaOpcion"]){
                if(!in_array($columnas[$cont],$ids)){
                    $sql = $sql.$columnas[$cont]."='".$valor."', ";
                }else{
                    $where = $where.$columnas[$cont]."='".$valor."'";
                }
                $cont++;
            }
        }
        $sql = rtrim($sql, ", ");
        $sql = $sql." ".$where;
        $result = $conn->query($sql);
        if($conn->affected_rows<1){
            echo "Ha ocurrido un error al actualizar la base de datos";
        }else{
            echo "La transacción ha sido exitosa";
        }
        break;
    case "borrar":
        $cont=0;
        $sql = "DELETE FROM ".$_POST["tablaSeleccionada"]. " WHERE ";
        forEach($_POST as $valor){
            if($valor!=$_POST["tablaSeleccionada"] && $valor!=$_POST["tablaOpcion"]){
                $sql = $sql.$ids[$cont]."='".$valor."' AND ";
                $cont++;
            }
        }
        $sql = rtrim($sql, "AND ");
        $sql = $sql.";";
        //echo $sql;
        $result = $conn->query($sql);
        if($conn->affected_rows<1){
            echo "Ha ocurrido un error al borrar el registro de la base de datos";
        }else{
            echo "La transacción ha sido exitosa";
        }
        break;

}
echo "<br><br><button type='button' class='btn btn-danger'><a href='inicio.php'>Regresar<a/></button>";
?>