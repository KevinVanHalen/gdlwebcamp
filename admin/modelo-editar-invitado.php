<?php 

    include_once 'funciones/funciones.php';

    if(isset($_POST['registro']) == 'actualizar'){

        $nombre = $_POST['nombre_invitado'];
        $apellido = $_POST['apellido_invitado'];
        $biografia = $_POST['biografia_invitado'];
        $id_registro = $_POST['id_registro'];

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
            if($_FILES['archivo_imagen']['size'] > 0 ){
                // Con imagen
                $stmt = $conn->prepare('UPDATE invitados SET nombre_invitado = ?, apellido_invitado = ?, descripcion = ?, url_imagen = ?, editado = NOW() WHERE invitado_id = ? ');
                $stmt->bind_param("ssssi", $nombre, $apellido, $biografia, $imagen_url, $id_registro);
            }else{
                // Sin imagen
                $stmt = $conn->prepare('UPDATE invitados SET nombre_invitado = ?, apellido_invitado = ?, descripcion = ?, editado = NOW() WHERE invitado_id = ? ');
                $stmt->bind_param("sssi", $nombre, $apellido, $biografia, $id_registro);
            }
            
            $estado = $stmt->execute();

            if($estado > 0){
                $respuesta = array(
                    'respuesta' => 'exito',
                    'id_actualizado' => $id_registro
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