function creaUtente() {
    document.getElementById("formU").reset();
    var user = $('#userU').val();
    var nome = $('#nomeU').val();
    var cognome = $('#cognomeU').val();
    var cat = $('#id_catU').val();
    var pwd1 = $('#pwd1').val();
    var pwd2 = $('#pwd2').val();


    if(pwd1==pwd2){
        $.ajax({
            type: "POST",
            url: "metodi/addUtente.php",
            data: "user="+user+"&nome=" + nome + "&cognome=" + cognome+"&cat="+cat+"&pwd="+pwd1,
            dataType: "html",
            success: function(msg)
            {
                //console.log(msg);
                var ogg = $.parseJSON(msg);
                if(ogg.esito == 0){
                    $('#EAUtente').hide();
                    var L = document.getElementById("bodyTUtente").rows.length;
                    var T = document.getElementById("bodyTUtente").insertRow(L);
                    var C1 = T.insertCell(0);
                    var C2 = T.insertCell(1);
                    var C3 = T.insertCell(2);
                    var C4 = T.insertCell(3);
                    var C5 = T.insertCell(4);
                    C1.innerHTML = "<td>"+user+"</td>";
                    C2.innerHTML = "<td>"+ogg.ogg.nome.charAt(0).toUpperCase() + ogg.ogg.nome.slice(1)+"</td>";
                    C3.innerHTML = "<td>"+ogg.ogg.cognome.charAt(0).toUpperCase() + ogg.ogg.cognome.slice(1)+"</td>";
                    C4.innerHTML = "<td>"+ogg.ogg.nome_cat+"</td>";
                    C5.innerHTML = "<td><button onclick='popUtente(\""+user+"\")' class='btn btn-primary btn-block'><i class='fas fa-pencil-alt'></i></button></td>";
                    $('#modal-new_utente').modal('hide');
                    //window.location.reload();
                } else {
                    $('#EAUtente').show();
                }
            },
            error: function()
            {
                alert("Chiamata fallita, si prega di riprovare...");
            }
        });
        $('#WAUtente').hide();
    } else {
        $('#WAUtente').show();
    }
}
function popModUtente(id_u){
    var cod;
    $.ajax({
        type: "POST",
        url: "Dati/Utente.php",
        data: "id_u=" + id_u,
        dataType: "html",
        success: function(msg)
        {
            var ogg = $.parseJSON(msg);
            console.log(ogg);
            cod = "<form id=\"formU\">"+
                "<div class=\"form-group\">" +
                    "<label for=\"userU\">Username Utente:</label>" +
                    "<input disabled type=\"text\" class=\"form-control\" name=\"userUM\" id=\"userUM\" value='"+ogg.utente.username+"' required>" +
                "</div>" +

                "<div class=\"form-group\">" +
                    "<label for=\"nomeU\">Nome Utente:</label>" +
                    "<input type=\"text\" class=\"form-control\" name=\"nomeUM\" id=\"nomeUM\" value='"+ogg.utente.nome+"' required>" +
                "</div>" +

                "<div class=\"form-group\">" +
                    "<label for=\"cognomeU\">Cognome Utente:</label>" +
                    "<input type=\"text\" class=\"form-control\" name=\"cognomeUM\" id=\"cognomeUM\" value='"+ogg.utente.cognome+"' required>" +
                "</div>";

                cod += "<div class=\"form-group\">" +
                    "<label for=\"id_catU\">Categoria utente:</label>" +
                    "<select class=\"form-control\" name=\"id_catUM\" id=\"id_catUM\">";
                    for (var i = 0; i < ogg.cat.length; i++) {
                        if (ogg.utente.id_cat == ogg.cat[i][0]) {
                            cod += "<option selected value='" + ogg.cat[i][0] + "'>" + ogg.cat[i][1] + "</option>";
                        } else {
                            cod += "<option value='" + ogg.cat[i][0] + "'>" + ogg.cat[i][1] + "</option>";
                        }
                    }
                    cod +="</select>" +
                "</div>" +

                "<div class=\"form-group\">" +
                    "<label for=\"pw1\">Password:</label>" +
                    "<input type=\"password\" class=\"form-control\" name=\"pwdM\" id=\"pwdM\" required>" +
                "</div>" +

                "<div class=\"form-group\">" +
                    "<button type=\"button\" onclick=\"modUtente('"+ogg.utente.username+"')\" class=\"btn btn-primary btn-block\">Inserisci" +
                    "</button>" +
                "</div>" +

                "<div class=\"form-group\">" +
                    "<button type=\"button\" onclick=\"eliminaUtente('"+ogg.utente.username+"')\" class=\"btn btn-danger btn-block\">Elimina Utente" +
                    "</button>" +
                "</div>" +

                "<div id=\"EAU\" style=\"display: none;\" class=\"callout callout-danger\">" +
                        "<h4>Errore</h4>\n" +
                        "<p>Qualcosa è andato storto, riprova pi&ugrave; tardi</p>\n" +
                "</div>" +
            "</form>";

            $('#bodyModUtente').empty();
            $('#bodyModUtente').append(cod);
        },
        error: function()
        {
            alert("Chiamata fallita, si prega di riprovare...");
        }
    });
}
function modUtente(id_u) {
    var nome = $('#nomeUM').val();
    var cognome = $('#cognomeUM').val();
    var cat = $('#id_catUM').val();
    var pwd = $('#pwdM').val();

    $.ajax({
        type: "POST",
        url: "metodi/modUtente.php",
        data: "id_u=" + id_u+"&nome="+nome+"&cognome="+cognome+"&cat="+cat+"&pwd="+pwd,
        dataType: "html",
        success: function(msg)
        {
            if(msg == 0){
                $('#EAU').hide();
                window.location.reload();
            } else {
                $('#EAU').show();
            }
        },
        error: function()
        {
            alert("Chiamata fallita, si prega di riprovare...");
        }
    });
}
function eliminaUtente(id_u) {
    var nome = $('#nomeUM').val();
    var cognome = $('#cognomeUM').val();
    var cat = $('#id_catUM').val();
    var pwd = $('#pwdM').val();

    $.ajax({
        type: "POST",
        url: "metodi/eliminaUtente.php",
        data: "id_u=" + id_u,
        dataType: "html",
        success: function(msg)
        {
            if(msg == 0){
                $('#EAU').hide();
                window.location.reload();
            } else {
                $('#EAU').show();
            }
        },
        error: function()
        {
            alert("Chiamata fallita, si prega di riprovare...");
        }
    });
}