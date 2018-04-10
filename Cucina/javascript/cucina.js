var timeLeft = 30;
var timerId = setInterval(countdown, 1000);

function countdown() {
    if (timeLeft == -1) {
        clearTimeout(timerId);
        aggiornaOrdini()
    } else {
        //console.log(30 - timeLeft);
        var width = ((30 - timeLeft)*100)/30;
        $('#barra').width(width + '%');
        timeLeft--;
    }
}
function aggiornaOrdini(){
    var codiceO = "";
    var codiceP = "";
    $.ajax({
        type: "POST",
        url: "Dati/ordini.php",
        dataType: "html",
        success: function(msg)
        {
            var ogg = $.parseJSON(msg);
            codiceO += "<table class=\"table table-hover table-bordered\">" +
                "<thead>" +
                "<tr>" +
                "<th>Sel</th>" +
                "<th>Codice</th>" +
                "<th>Ora conferma</th>" +
                "</tr>" +
                "</thead>" +
                "<tbody>";
                for(var i =0;i<ogg.ordini.length;i++){
                    if (ogg.ordini[i].colore =="R") {
                        codiceO += "<tr id='TR_"+ogg.ordini[i].codice+"' style='background-color:red'>";
                    } else {
                        if (ogg.ordini[i].colore =="G") {
                            codiceO +=  "<tr id='TR_"+ogg.ordini[i].codice+"' style='background-color:yellow'>";
                        } else {
                            codiceO += "<tr id='TR_"+ogg.ordini[i].codice+"'>";
                        }
                    }
                    codiceO += "<td>";
                    codiceO += "<div class=\"btn-group\" data-toggle=\"buttons\">" +
                    "<label class=\"btn btn-primary\">" +
                    "<input type=\"checkbox\" name='ordini' value='"+ogg.ordini[i].codice+"' autocomplete=\"off\">" +
                    "<span class=\"glyphicon glyphicon-ok\"></span>" +
                    "</label>" +
                    "</div>";
                    codiceO += "</td>";
                    codiceO += "<td>"+ogg.ordini[i].codice+"</td>";
                    codiceO += "<td>"+ogg.ordini[i].ora+"</td>";
                    codiceO += "</tr>";
                }
            codiceO += "</tbody></table>";


            codiceP += "<table class=\"table table-striped table-bordered\">" +
                "<thead>" +
                "<tr>" +
                "<th></th>" +
                "<th>Nome Prodotto</th>" +
                "<th>Quantit&agrave;</th>" +
                "</tr>" +
                "</thead>" +
                "<tbody>" +
                "<tr>";
                for (var i=0; i<ogg.prodotti.length;i++){
                codiceP += "<td></td>";
                codiceP += "<td>"+ogg.prodotti[i].prodotto+"</td>";
                codiceP += "<td>"+ogg.prodotti[i].numero+"</td>";
                codiceP += "</tr>";
            }
            codiceP += "</tbody></table>";


                $('#ordini').empty();
                $('#prodotti').empty();
                $('#ordini').append(codiceO);
                $('#prodotti').append(codiceP);
        },
        error: function()
        {
            alert("Chiamata fallita, si prega di riprovare...");
        }
    });
    timeLeft = 30;
    timerId = setInterval(countdown, 1000);
}
function evadi() {
    var tipo = 0;
    var stringa = $('#code').val();
    //console.log("__"+stringa);
    var contaC = 0;
    var check = [];
    $("input[name=ordini]").each(function () {
        var ischecked = $(this).is(":checked");
        if (ischecked) {
            check[contaC]=$(this).val();
            tipo = 1;
            contaC ++;
        }
    });
    var parametriCheck = "numeroC="+(parseInt(contaC));
    for(var i = 0;i<check.length;i++){
        parametriCheck += "&CK"+i+"="+check[i];
    }
    $.ajax({
        type: "POST",
        url: "metodi/evadi.php",
        data: parametriCheck+"&tipo="+tipo+"&str="+stringa,
        dataType: "html",
        success: function(msg)
        {
            if(msg == 0){
                aggiornaOrdini()
            } else {
                alert("Qualcosa e' andato storto riprova");
            }
        },
        error: function()
        {
            alert("Chiamata fallita, si prega di riprovare...");
        }
    });

    $('#code').val("");
}