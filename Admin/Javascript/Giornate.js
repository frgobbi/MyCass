function addGiornata() {
    $.ajax({
        type: "POST",
        url: "./metodi/addGiorno.php",
        dataType: "html",
        success: function(msg)
        {
            var ogg = $.parseJSON(msg);
            console.log(ogg);
            if(ogg.esito == 0){
                $('#ErrorA').hide();
                $('#WarnigA').hide();
                var L = document.getElementById("bodyTG").rows.length;
                var T = document.getElementById("bodyTG").insertRow(L);
                var C1 = T.insertCell(0);
                var C2 = T.insertCell(1);
                var C3 = T.insertCell(2);
                C1.innerHTML = "<td>"+ogg.new_g.data_giorno+"</td>";
                C2.innerHTML = "<td>"+ogg.new_g.incasso+" &euro;</td>";
                C3.innerHTML = "<td><button class='btn btn-danger btn-block'><i class=\"fas fa-window-close\"></i></button></td>";
            } else {
                if(ogg.esito == 1){
                    $('#ErrorA').show();
                    $('#WarnigA').hide();
                } else {
                    if (ogg.esito == 2){
                        $('#ErrorA').hide();
                        $('#WarnigA').show();
                    }
                }
            }


        },
        error: function()
        {
            alert("Chiamata fallita, si prega di riprovare...");
        }
    });
}
function chiudi_giorno() {

}