<?php 

    include_once 'funciones/funciones.php';

    if(isset($_POST['registro']) == 'actualizar'){

        $titulo = $_POST['titulo_evento'];
        $categoria_id = $_POST['categoria_evento'];
        $invitado_id = $_POST['invitado'];
        // Obtener la fecha
        $fecha = $_POST['fecha_evento'];
        $fecha_formateada = date('Y-m-d', strtotime($fecha));
        // Hora
        $hora = $_POST['hora_evento'];
        $id_registro = $_POST['id_registro'];
        
        $hora_formateada = date('H:i', strtotime($hora));

        try {
            $stmt = $conn->prepare('UPDATE eventos SET nombre_evento = ?, fecha_evento = ?, hora_evento = ?, id_cat_evento = ?, id_inv = ?, editado = NOW() WHERE evento_id = ? ');
            $stmt->bind_param('sssiii', $titulo, $fecha_formateada, $hora_formateada, $categoria_id, $invitado_id, $id_registro);
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