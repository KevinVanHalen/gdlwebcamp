<?php 

    include_once 'funciones/funciones.php';

    if(isset($_POST['registro']) == 'nuevo'){
        
        /*
        $respuesta = array(
            'post' => $_POST,
            'file' => $_FILES
        );

        die(json_encode($respuesta));
        */

        $nombre = $_POST['nombre_invitado'];
        $apellido = $_POST['apellido_invitado'];
        $biografia = $_POST['biografia_invitado'];

        $directorio = "../img/invitados/";

        if(!is_dir($directorio)){
            mkdir($directorio, 0755, true);
        }

        if(move_uploaded_file($_FILES['archivo_imagen']['tmp_name'], $directorio . $_FILES['archivo_imagen']['name'])){
            $imagen_url = $_FILES['archivo_imagen']['name'];
            $imagen_resultado = "Se subió correctamente";
        }else{
            $respuesta = array(
                'respuesta' => error_get_last()
            );
        }

        try {
            $stmt = $conn->prepare('INSERT INTO invitados (nombre_invitado, apellido_invitado, descripcion, url_imagen) VALUES (?, ?, ?, ?) ');
            $stmt->bind_param("ssss", $nombre, $apellido, $biografia, $imagen_url);
            $stmt->execute();
            $id_insertado = $stmt->insert_id;
            if($stmt->affected_rows){
                $respuesta = array(
                    'respuesta' => 'exito',
                    'id_insertado' => $id_insertado,
                    'resultado_imagen' => $imagen_resultado
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
