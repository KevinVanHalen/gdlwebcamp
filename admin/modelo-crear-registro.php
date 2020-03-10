<?php 

    include_once 'funciones/funciones.php';

    if(isset($_POST['registro']) == 'nuevo'){

        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $email = $_POST['email'];
        // Boletos
        $boletos_adquiridos = $_POST['boletos'];
        // Camisas y etiquetas
        $camisas = $_POST['pedido_extra']['camisas']['cantidad'];
        $etiquetas = $_POST['pedido_extra']['etiquetas']['cantidad'];
        // Pedido en formato json
        $pedido = productos_json($boletos_adquiridos, $camisas, $etiquetas);
        // Total a pagar
        $total = $_POST['total_pedido'];
        // Regalo
        $regalo = $_POST['regalo'];
        // Eventos
        $eventos = $_POST['registro_evento'];
        $registro_eventos = eventos_json($eventos);
        
        try {
            $stmt = $conn->prepare('INSERT INTO registrados (nombre_registrado, apellido_registrado, email_registrado, fecha_registro, pases_articulos, talleres_registrados, regalo, total_pagado, pagado) VALUES (?, ?, ?, NOW(), ?, ?, ?, ?, 1 ) ');
            $stmt->bind_param("sssssis", $nombre, $apellido, $email, $pedido, $registro_eventos, $regalo, $total);
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
