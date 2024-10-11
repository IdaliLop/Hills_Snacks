<?php
    include_once 'conexion.php';

    class Usuario{
        var $objetos;
        public $acceso;
        public function __construct(){
            $db = new Conexion();
            $this ->acceso = $db->pdo;
        }

        function loguearse ($user,$pass){
            //$sql = "SELECT*FROM usuario JOIN tipo_usuario ON id_tipo= tipo_usuario.id WHERE usuario=:user AND password=:pass";
            $sql = "SELECT*FROM usuario_Cliente WHERE usuario=:user AND password=:pass";
            $query = $this->acceso->prepare($sql);
            $query -> execute(array(':user'=>$user,':pass'=>$pass));
            $this->objetos =$query->fetchAll();
            return $this->objetos;
        }

        function registrarse ($user,$telefono, $pass, $nombres, $dni , $apellidos, $email){
            $sql = "INSERT INTO usuario_Cliente (Idusuario_UC,Nombre_UC, Apellido_UC, Pass_UC, Telefono_UC, Domicilio_UC, Correo_UC) VALUES (:user,:nombres,:apellidos,:telefono,:direc,:email,:pass)";
            $query = $this->acceso->prepare($sql);
            $query -> execute(array(":user"=>$user,":telefono"=>$telefono,":pass"=>$pass,":nombres"=>$nombres,":dni"=>$dni,":apellidos"=>$apellidos,":email"=>$email));
            $sql = "SELECT*FROM usuario WHERE usuario=:user AND password=:pass";
            $query = $this->acceso->prepare($sql);
            $query -> execute(array(':user'=>$user,':pass'=>$pass));
            $this->objetos =$query->fetchAll();
            return $this->objetos;
        }

        public function obtener_datos($idUsuario) {
            $sql = "SELECT * FROM usuario_Cliente WHERE id = :id";
            $query = $this->acceso->prepare($sql);
            $query ->execute(array(':id'=>$idUsuario));
            $this->objetos =$query->fetchAll();
            return $this->objetos;
        }
        
    }
?>