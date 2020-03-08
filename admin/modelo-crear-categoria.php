<?php 

    include_once 'funciones/funciones.php';

    if(isset($_POST['registro']) == 'nuevo'){
        
        $nombre_categoria = $_POST['nombre_categoria'];
        $icono = $_POST['icono'];

        try {
            $stmt = $conn->prepare('INSERT INTO categoria_evento (cat_evento, icono) VALUES (?, ?) ');
            $stmt->bind_param("ss", $nombre_categoria, $icono);
            $stmt->execute();
            $id_insertado = $stmt->insert_id;
            if($stmt->affected_rows){
                $respuesta = array(
                    'respuesta' => 'exito',
                    'id_insertado' => $id_insertado
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
