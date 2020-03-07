<?php 

    include_once 'funciones/funciones.php';

    if(isset($_POST['registro']) == 'nuevo'){
        die(json_encode($_POST));

        $opciones = array(
            'cost' => 12
        );

        $password_hashed = password_hash($password, PASSWORD_BCRYPT, $opciones);
        
        try {
            $stmt = $conn->prepare("INSERT INTO admins (usuario, nombre, password) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $usuario, $nombre, $password_hashed);
            $stmt->execute();
            $id_registro = $stmt->insert_id;
            if($id_registro > 0){
                $respuesta = array(
                    'respuesta' => 'exito',
                    'id_admin' => $id_registro
                );
            } else {
                $respuesta = array(
                    'respuesta' => 'error'
                );
            }
            $stmt->close();
            $conn->close();
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }

        die(json_encode($respuesta));
    }
