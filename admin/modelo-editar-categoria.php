<?php 

    include_once 'funciones/funciones.php';

    if(isset($_POST['registro']) == 'actualizar'){

        $nombre_categoria = $_POST['nombre_categoria'];
        $icono = $_POST['icono'];
        $id_registro = $_POST['id_registro'];

        try {
            $stmt = $conn->prepare('UPDATE categoria_evento SET cat_evento = ?, icono = ?, editado = NOW() WHERE id_categoria = ? ');
            $stmt->bind_param('ssi', $nombre_categoria, $icono, $id_registro);
            $stmt->execute();
            if($stmt->affected_rows){
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