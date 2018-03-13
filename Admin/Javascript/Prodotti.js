var keyColori = [
    "bg-red",
    "bg-orange",
    "bg-yellow",
    "bg-green",
    "bg-teal",
    "bg-aqua",
    "bg-primary",
    "bg-navy",
    "bg-purple",
    "bg-maroon",
    "bg-gray"
];
var Colori = [
    "Rosso",
    "Arancione",
    "Giallo",
    "Verde",
    "Verde Acqua",
    "Azzurro",
    "Blu",
    "Blu Scuro",
    "Viola",
    "Fucsia",
    "Grigio"
];

function crea_tabella() {
    $.ajax({
        type: "POST",
        url: "./Dati/tab_categorie.php",
        dataType: "html",
        success: function (risposta) {
            $('#body-mod-cat').empty();
            $('#body-mod-cat').append(risposta);
        },
        error: function () {
            alert("Chiamata fallita, si prega di riprovare...");
        }
    });
}
function modCat(id_cat) {
    var key_name = "#nome_" + id_cat;
    var key_colore = "#colore_" + id_cat;
    var key_bottone = "#button_" + id_cat;
    var nome = $(key_name).html();
    var colore = $(key_colore).html();
    var codeS = "<select class=\"form-control\" name=\"colore\" id=\"Mcolore_" + id_cat + "\">";
    for (var i = 0; i < Colori.length; i++) {
        if (Colori[i] == colore) {
            codeS += "<option selected value=\"" + keyColori[i] + "\">" + Colori[i] + "</option>";
        } else {
            codeS += "<option value=\"" + keyColori[i] + "\">" + Colori[i] + "</option>";
        }
    }
    codeS += "</select>";


    $(key_name).empty();
    $(key_name).append("<input class='form-control' id='Mnome_" + id_cat + "' value='" + nome + "'>");
    $(key_colore).empty();
    $(key_colore).append(codeS);
    $(key_bottone).empty();
    $(key_bottone).append("<button onclick=\"confModCat(" + id_cat + ")\" class='btn btn-success btn-block'><i class='fa fa-check'></i></button>");


}
function confModCat(id_cat) {
    var key_name = "#Mnome_" + id_cat;
    var key_colore = "#Mcolore_" + id_cat;
    var nome = $(key_name).val();
    var colore = $(key_colore).val();
    $.ajax({
        type: "POST",
        url: "./metodi/modCat.php",
        data: "id_cat=" + id_cat + "&nome=" + nome + "&colore=" + colore,
        dataType: "html",
        success: function (risposta) {
            if (risposta == 0) {
                $('#modOK').show();
            } else {
                $('#modERR').show();
            }
            setTimeout(function () {
                crea_tabella();
            }, 2000);
        },
        error: function () {
            alert("Chiamata fallita, si prega di riprovare...");
        }
    });

}
function bodyModProd(id_prod) {
    var cod = "";
    $.ajax({
        type: "POST",
        url: "./Dati/datiProdotto.php",
        data: "id_prod=" + id_prod,
        dataType: "html",
        success: function (risposta) {
            var ogg = $.parseJSON(risposta);

            cod += "<form method='post' action='metodi/modProd.php?id_prod="+ogg.prodotto.id_prodotto+"'>";
            cod += "<div class='form-group'>" +
                "<label for='nome'>Nome prodotto:</label>" +
                "<input type='text' class='form-control' maxlength='12' name='nome' id='nome' value='" + ogg.prodotto.nome_p + "' required>" +
                "</div>";

            cod += "<div class='form-group'>" +
                "<label for='prezzo'>Prezzo: (per la virgola usa il punto</label>" +
                "<input type='text' class='form-control' name='prezzo' id='prezzo' value='" + ogg.prodotto.prezzo + "' required>" +
                "</div>";

            cod += "<div class='form-group'>" +
                "<label for='caregorie'>Categoria prodotto:</label>" +
                "<select class='form-control' name='categoria' id='categoria'>";
            for (var i = 0; i < ogg.arrayC.length; i++) {
                if (ogg.prodotto.id_cat_prodotto == ogg.arrayC[i][0]) {
                    cod += "<option selected value='" + ogg.arrayC[i][0] + "'>" + ogg.arrayC[i][1] + "</option>";
                } else {
                    cod += "<option value='" + ogg.arrayC[i][0] + "'>" + ogg.arrayC[i][1] + "</option>";
                }
            }
            cod += "</select>" +
                "</div>";

            cod += "<div class='form-group'>" +
                "<label for='disp'>Disponibilit&agrave;:</label>" +
                "<select class='form-control' name='disp' id='disp'>";
            if (ogg.prodotto.disp == 1) {
                cod += "<option selected value='1'>SI</option>" +
                    "<option value='0'>NO</option>";
            } else {
                cod += "<option value='1'>SI</option>" +
                    "<option selected value='0'>NO</option>";
            }
            cod += "</select>" +
                "</div>";

            cod += "<div class='form-group'>" +
                "<label for='ingQM'>Ingredienti:</label>" +
                "<select class='form-control' name='ingQM' id='ingQM' onchange='controllaS(1)'>";
            if (ogg.prodotto.flag_ing == 1) {
                cod += "<option selected value='1'>SI</option>" +
                    "<option value='0'>NO</option>";
            } else {
                cod += "<option value='1'>SI</option>" +
                    "<option selected value='0'>NO</option>";
            }
            cod += "</select>" +
                "</div>";

            if (ogg.prodotto.flag_ing == 1) {
                cod += "<div id='ingM'>";
            } else {
                cod += "<div id='ingM' style='display: none'>";
            }

            cod +="<div class='box box-info'>" +
            "<div class='box-body'>" +
            "<div class='row'>";
            var trovato;
            for (var i=0;i<ogg.arrayI.length;i++) {
                trovato = 0;
                for(var j=0;j<ogg.IngS.length;j++){
                    if(ogg.arrayI[i][0]==ogg.IngS[j][0]){
                        trovato =1;
                    }
                }
                if(trovato == 1){
                    cod +="<div class='col-sm-4'>" +
                        "<div class='form-check' style='display: inline'>" +
                        "<label class='form-check-label'>" +
                        "<input checked type='checkbox' name='ingredienti[]' class='form-check-input' value='"+ogg.arrayI[i][0]+"'> "+ogg.arrayI[i][1]+
                        "</label>" +
                        "</div>" +
                        "</div>";
                } else {
                    cod +="<div class='col-sm-4'>" +
                        "<div class='form-check' style='display: inline'>" +
                        "<label class='form-check-label'>" +
                        "<input type='checkbox' name='ingredienti[]' class='form-check-input' value='"+ogg.arrayI[i][0]+"'> "+ogg.arrayI[i][1]+
                        "</label>" +
                        "</div>" +
                        "</div>";
                }

            }
            cod +="</div>" +
            "</div>" +
            "</div>" +
            "</div>" +
            "<div class='form-group'>" +
            "<button type='submit' class='btn btn-primary btn-block'>Inserisci</button>" +
            "</div>";
            cod += "</form>";
            $('#body-mod-prod').empty();
            $('#body-mod-prod').append(cod);
        },
        error: function () {
            alert("Chiamata fallita, si prega di riprovare...");
        }
    });
}