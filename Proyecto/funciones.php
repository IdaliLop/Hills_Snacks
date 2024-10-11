<?php 

function conexion(){
    try{
        //CREANDO LA CONEXION 
        $conexion = new PDO('mysql:host=localhost;dbname=hills_snacks', 'root', '');
        //CONFIGURA EL MODO DE ERROR DE PDO PARA QUE LANCE EXCEPCIONES
        $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conexion;
    }catch(PDOException $e){
        //MANEJO DE ERROR EN CASO DE FALLAR LA CONEXION
        echo "Error: " . $e->getMessage();
        return false;//DEVUELVE FALSE SI HAY UN ERROR 
    }
}



?>