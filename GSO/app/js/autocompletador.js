$(document).ready(function(){
    $("#persona").autocomplete({
        dataType: 'JSON',
        source: function(request, response) {
            jQuery.ajax({
                url: 'request.php',
                type: "post",
                dataType: "json",
                data: {
                    action: 'BuscarUsuario',
                    usuario: request.term
                },
                success: function(data) {
                    response($.map(data, function(item) {
                        return {
                            id: item.id,
                            value: item.nombre
                        }
                    }))
                }
            })
        },
        select: function(e,ui){
            $("#resultado").text('Se encontro a la siguiente persona ' + ui.item.value + ' identificada con el ID ' + ui.item.id);
        }
    })
})