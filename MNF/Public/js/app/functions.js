/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function editRuta(from){
    $("#edit_new_ruta").click(function(e){
        e.preventDefault();
        $("#txt_ruta").hide();
        $("#new_ruta").show();
        /*if(from == "tri"){
            if($("#edit_ruta").hasClass('col-sm-3')){
                $("#edit_ruta").removeClass('col-sm-3');
                $("#edit_ruta").addClass('col-sm-6');
            }
        }*/
    });
        
}
function modalError(msg_error){
    const wrapper = document.createElement('div');
    wrapper.innerHTML = msg_error;
    swal({ 
        icon: 'error',
        title: 'Ocurrio un problema!!',
        
        content: wrapper,
        dangerMode: true,
        timer: 10000
    });
}

function soloNumeros(e) {
    var key = window.event ? e.which : e.keyCode;
    if (key < 48 || key > 57) {
        e.preventDefault();
    }
}


function soloNumerosandDecimal(evt)
{
        if(window.event){ keynum = evt.keyCode; }
        else{ keynum = evt.which; }

        if( (keynum>45 && keynum<58) && (keynum!=47) ){return true;}
        else{return false;}
}
function validarSiNumero(txt)
{
    if (!/^([0-9])*[.]?[0-9]*$/.test(txt.value))
    {
        modalError("El valor " + txt.value + " no es un número");
        txt.focus();
        $("#" + txt.id + "").addClass('error-input');
    }
}
