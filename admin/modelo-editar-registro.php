<?php 

    include_once 'funciones/funciones.php';

    if(isset($_POST['registro']) == 'actualizar'){

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

        $fecha_registro = $_POST['fecha_registro'];
        $id_registro = $_POST['id_registro'];

        try {
            $stmt = $conn->prepare('UPDATE registrados SET nombre_registrado = ?, apellido_registrado = ?, email_registrado = ?, fecha_registro = ?, pases_articulos = ?, talleres_registrados = ?, regalo = ?, total_pagado = ?, pagado = 1 WHERE id_registrado = ? ');
            $stmt->bind_param('ssssssisi', $nombre, $apellido, $email, $fecha_registro, $pedido, $registro_eventos, $regalo, $total, $id_registro);
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