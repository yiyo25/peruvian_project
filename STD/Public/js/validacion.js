$( function() {
	$(".number").keydown(function (e) {
           // Permite: backspace, delete, tab, escape, enter and .
           if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
               // Permite: Ctrl+A
               (e.keyCode == 65 && e.ctrlKey === true) ||
               // Permite: home, end, left, right
               (e.keyCode >= 35 && e.keyCode <= 39)) {
               // solo permitir lo que no este dentro de estas condiciones es un return false
               return;
           }
           // Aseguramos que son numeros
           if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
               e.preventDefault();
           }
       });
} );
