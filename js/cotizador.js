(function() {
    "use strict";

    var regalo = document.getElementById('regalo');

    document.addEventListener('DOMContentLoaded', function() {

        //Campos Datos usuario
        var nombre = document.getElementById('nombre');
        var apellido = document.getElementById('apellido');
        var email = document.getElementById('email');

        //Campos pases
        var pase_dia = document.getElementById('pase_dia');
        var pase_dosdias = document.getElementById('pase_dosdias');
        var pase_completo = document.getElementById('pase_completo');

        //Botones y divs
        var calcular = document.getElementById('calcular');
        var errorDiv = document.getElementById('error');
        var botonRegistro = document.getElementById('btnRegistro');
        var lista_productos = document.getElementById('lista-productos');
        var suma = document.getElementById('suma-total');

        //Extras
        var etiquetas = document.getElementById('etiquetas');
        var camisas = document.getElementById('camisa_evento');

        botonRegistro.disabled = true;

        if(document.getElementById('calcular')) {

            calcular.addEventListener('click', calcularMontos);

            pase_dia.addEventListener('blur', mostrarDias);
            pase_dosdias.addEventListener('blur', mostrarDias);
            pase_completo.addEventListener('blur', mostrarDias);

            nombre.addEventListener('blur', validarCampos);
            apellido.addEventListener('blur', validarCampos);
            email.addEventListener('blur', validarCampos);
            email.addEventListener('blur', validarMail);

            function validarCampos() {
                if(this.value == ''){
                    errorDiv.style.display = 'block';
                    errorDiv.innerHTML = 'Este campo es obligatorio';
                    this.style.border = '1px solid red';
                    errorDiv.style.border = '1px solid red';
                }else {
                    errorDiv.style.display = 'none';
                    this.style.border = '1px solid #cccccc';
                }
            }

            function validarMail() {
                if(this.value.indexOf("@") > -1) {
                    errorDiv.style.display = 'none';
                    this.style.border = '1px solid #cccccc';
                }else {
                    errorDiv.style.display = 'block';
                    errorDiv.innerHTML = 'El email debe ser valido';
                    this.style.border = '1px solid red';
                    errorDiv.style.border = '1px solid red';
                }
            }

            function calcularMontos(event) {
                event.preventDefault();

                if(regalo.value === '') {
                    alert("Debes elegir un regalo");
                    regalo.focus();
                }else {
                    var boletosDia = parseInt(pase_dia.value, 10) || 0;
                    var boletos2Dias = parseInt(pase_dosdias.value, 10) || 0;
                    var boletoCompleto = parseInt(pase_completo.value, 10) || 0;
                    var cantCamisas = parseInt(camisas.value, 10) || 0;
                    var cantEtiquetas = parseInt(etiquetas.value, 10) || 0;

                    var totalPagar = (boletosDia * 30) + (boletos2Dias * 45) + (boletoCompleto * 50) + ((cantCamisas * 10) * .93) + (cantEtiquetas * 2);
                    
                    var listadoProductos = [];
                    
                    if(boletosDia >= 1) {
                        listadoProductos.push(boletosDia + ' Pases por día');
                    }
                    if(boletos2Dias >= 1){
                        listadoProductos.push(boletos2Dias + ' Pases por 2 día');
                    }
                    if(boletoCompleto >= 1){
                        listadoProductos.push(boletoCompleto + ' Pases completos');
                    }
                    if(cantCamisas >= 1){
                        listadoProductos.push(cantCamisas + ' Camisas');
                    }
                    if(cantEtiquetas >= 1) {
                        listadoProductos.push(cantEtiquetas + ' Etiquetas');
                    }

                    lista_productos.style.display = 'block';
                    lista_productos.innerHTML = '';

                    for(var i=0; i<listadoProductos.length; i++) {
                        lista_productos.innerHTML += listadoProductos[i] + '<br/>'
                    }

                    suma.innerHTML = '$ ' + totalPagar.toFixed(2);

                    botonRegistro.disabled = false;
                    document.getElementById('total_pedido').value = totalPagar;
                    //console.log(listadoProductos);
                    //console.log(totalPagar);
                }
            }

            // Revisar el funcionamiento de mostrar los dias
            function mostrarDias() {
                var boletosDia = parseInt(pase_dia.value, 10) || 0;
                var boletos2Dias = parseInt(pase_dosdias.value, 10) || 0;
                var boletoCompleto = parseInt(pase_completo.value, 10) || 0;
                    
                var diasElegidos = [];
                var flat = false;

                if(boletosDia > 0) {
                    diasElegidos.push('viernes');
                }else{
                    document.getElementById('viernes').style.display = 'none';
                }
                if(boletos2Dias > 0) {
                    diasElegidos.push('viernes', 'sabado');
                }else{
                    document.getElementById('viernes').style.display = 'none';
                    document.getElementById('sabado').style.display = 'none';
                }
                if(boletoCompleto > 0) {
                    diasElegidos.push('viernes', 'sabado', 'domingo');
                }else{
                    document.getElementById('viernes').style.display = 'none';
                    document.getElementById('sabado').style.display = 'none';
                    document.getElementById('domingo').style.display = 'none';
                }

                // if(boletoCompleto > 0) {
                //     diasElegidos.push('viernes', 'sabado', 'domingo');
                // }else if(boletos2Dias > 0) {
                //     diasElegidos.push('viernes', 'sabado');
                // }else if(boletosDia > 0) {
                //     diasElegidos.push('viernes');
                // }


                for(var i=0; i < diasElegidos.length; i++) {
                    document.getElementById(diasElegidos[i]).style.display = 'block';
                }
            }
        }

    }); //DOM CONTENT LOADED

})();