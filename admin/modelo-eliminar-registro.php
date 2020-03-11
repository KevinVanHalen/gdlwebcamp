<?php 

    include_once 'funciones/funciones.php';
 
    if(isset($_POST['registro']) == 'eliminar'){

        $id_borrar = $_POST['id'];

        try {
            $stmt = $conn->prepare('DELETE FROM registrados WHERE id_registrado = ? ');
            $stmt->bind_param('i', $id_borrar);
            $stmt->execute();
            if($stmt->affected_rows){
                $respuesta = array(
                    'respuesta' => 'exito',
                    'id_eliminado' => $id_borrar
                );
            }else{
                $respuesta = array(
                    'respuesta' => 'error'
                );
            }
        } catch (Exception $e) {
            $respuesta = array(
                'respuesta' => $e->getMessage()
            );
        }

        die(json_encode($respuesta));
    }