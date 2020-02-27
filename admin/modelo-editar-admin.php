<?php 

    include_once 'funciones/funciones.php';

    if(isset($_POST['registro']) == 'actualizar'){

        $usuario = $_POST['usuario'];
        $nombre = $_POST['nombre'];
        $password = $_POST['password'];
        $id_registro = $_POST['id_registro'];
        
        try {
            if(empty($_POST['password'])){
                $stmt = $conn->prepare("UPDATE admins SET usuario = ?, nombre = ?, editado = NOW() WHERE id_admin = ? ");
                $stmt->bind_param("ssi", $usuario, $nombre, $id_registro);
            }else{
                $opciones = array(
                    'cost' => 12
                );

                $hash_password = password_hash($password, PASSWORD_BCRYPT, $opciones);
                $stmt = $conn->prepare('UPDATE admins SET usuario = ?, nombre = ?, password = ?, editado = NOW() WHERE id_admin = ? ');
                $stmt->bind_param("sssi", $usuario, $nombre, $hash_password, $id_registro);
            }
            
            $stmt->execute();
            if($stmt->affected_rows){
                $respuesta = array(
                    'respuesta' => 'exito',
                    'id_actualizado' => $stmt->insert_id
                );
            }else{
                $respuesta = array(
                    'respuesta' => 'error'
                );
            }
            $stmt->close();
            $conn->close();
        } catch (Exception $e) {
            $respuesta = array(
                'respuesta' => $e->getMessage()
            );
        }

        die(json_encode($respuesta));
    }