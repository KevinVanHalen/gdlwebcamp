$(document).ready(function() {
    // Loguea administradores
    $('#login-admin').on('submit', function(e) {
        e.preventDefault();

        var datos = $(this).serializeArray();

        $.ajax({
            type: $(this).attr('method'),
            data: datos,
            url: $(this).attr('action'),
            dataType: 'json',
            success: function(data) {
                console.log(data);
                var resultado = data;
                if(resultado.respuesta == 'exitoso'){
                    swal(
                        'Login Correcto',
                        'Bienvenid@ ' + resultado.usuario +'!!',
                        'success'
                    )
                    setTimeout(function() {
                        window.location.href = 'admin-area.php';
                    }, 2000);
                }else{
                    swal(
                        'Error',
                        'Usuario o password incorrectos',
                        'error'
                    )
                }
            }
        })
    });
});