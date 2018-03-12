/**
 * GESTIONE CASSA LATO CLIENT
 **/
var a_id_p = [];       //ARRAY ID PRODOTTI ORDINATI
var a_ing_p = [];    //ARRAY FLAG INGREDIENTI PRODOTTI ORDINATI
var a_desc_p = [];     //ARRAY DESCRIZIONI PRODOTTI ORDINATI
var a_prezzi_p = [];   //ARRAY PREZZI PRODOTTI ORDINATI
var a_comp = [];    //ARRAY PRODOTTI COMPATTO
var a_p_ing = []; //ARRAY OGGETTI PRODOTTI CON INGREDIENTI
var cont_p = 0; //CONTATORE PRODOTTI
var cont_p_o = 0;    //CONTATORE PRODOTTI CON INGREDIENTI
var resto = 0; //Variabile che contiene il resto
var tot = 0; //Variabile che contiene il totale dell'ordine
var contanti = 0;   //Variabile che conterra' i contanti per il resto
var input_varie = "";    //Variabile input varie
var i, j, z; //indice per array
var input_sub = ""; //variabile per statiera sub
var flagPagamento = false; //Flag fase di pagamento
/*Quasi tutti i metodi devono avere come prima riga
 if(flagPagameto == false){
 } else {
 alert("Prima cocludi l'ordine!!");
 }
 */

/*______________________________________________________________________________________________________________________
PARTE TASTIERE, PRODOTTI E SCONTRINO VIRTUALE
_______________________________________________________________________________________________________________________*/

/*
* In base al prodotto crea il popUp se ha ingredienti, altrimenti inserisce il prodotto negli array
 */
function popupProdotto(id_p) {
    $('#body_p').empty();
    var cod = "";
    $.ajax({
        type: "POST",
        url: "Dati/prodotto.php",
        data: "id_p=" + id_p,
        dataType: "html",
        success: function (msg) {
            var ogg = $.parseJSON(msg);
            //console.log(ogg);
            if (ogg.prodotto.flag_ing == 1) {
                cod += "<form id='form_prodotto'>" +
                    "<div class=\"form-group text-center\">" +
                    "<h3>" + ogg.prodotto.nome_p + "</h3>" +
                    "</div>" +
                    "<div class=\"form-group\">" +
                    "<div class='row'>";
                var trovato;
                for (var i = 0; i < ogg.arrayI.length; i++) {
                    trovato = 0;
                    for (var j = 0; j < ogg.IngS.length; j++) {
                        if (ogg.arrayI[i][0] == ogg.IngS[j][0]) {
                            trovato = 1;
                        }
                    }
                    if (trovato == 1) {
                        cod += "<div class='col-sm-6'>" +
                            "<div class='form-check' style='display: inline'>" +
                            "<label class='form-check-label'>" +
                            "<input checked type='checkbox' name='ingredienti[]' class='form-check-input' value='" + ogg.arrayI[i][0] + "'> " + ogg.arrayI[i][1] +
                            "</label>" +
                            "</div>" +
                            "</div>";
                    }
                }
                cod += "</div>" +
                    "</div>" +
                    "<div class=\"form-group text-center\">" +
                    "<button class='btn btn-primary btn-block' type='button' onclick='add_prodotto(\"" + ogg.prodotto.flag_ing + "\"," + ogg.prodotto.id_prodotto + ",\"" + ogg.prodotto.nome_p + "\",\"" + ogg.prodotto.prezzo + "\");'>Inserisci</button>" +
                    "</div>" +
                    "<div class=\"form-group\">" +
                    "</form>";
                $('#body_p').append(cod);
                $('#modal_prodotto').modal('show');
            } else {
                add_prodotto(ogg.prodotto.flag_ing, ogg.prodotto.id_prodotto, ogg.prodotto.nome_p, ogg.prodotto.prezzo);
            }

        },
        error: function () {
            alert("Chiamata fallita, si prega di riprovare...");
        }
    });
}

//Inserimento del prodotto negli array
function add_prodotto(flag, id, desc, prezzo) {
    //controlla se c'è un ordine in fase di pagamento
    if (flagPagamento == false) {
        //controlla se il prodotto ha ingredienti
        if (flag == 0) {
            //se non ha ingredienti inserisce i dati del prodotto negli array
            a_id_p[cont_p] = id;
            a_desc_p[cont_p] = desc;
            a_prezzi_p[cont_p] = prezzo;
            a_ing_p[cont_p] = 0;
            //incrementa il
            cont_p++;
        } else {
            var ing = [];
            var k = 0;
            //Recupero ingredienti selezionati
            var form = document.getElementById('form_prodotto').getElementsByTagName('input');
            for (var i = 0; i < form.length; i++) {
                if (form[i].type == 'checkbox') {
                    if (form[i].checked) {
                        ing[k] = form[i].value;
                        k++;
                    }
                }
            }
            var id_ing = [];
            var nome_ing = [];
            var presenza = [];
            var indice = 0;
            $.ajax({
                type: "POST",
                url: "Dati/prodotto.php",
                data: "id_p=" + id,
                dataType: "html",
                success: function (msg) {
                    var ogg = $.parseJSON(msg);
                    var ingP = false;
                    for (i = 0; i < ogg.IngS.length; i++) {
                        ingP = false;
                        //controllo se l'ingrediente è selezionato
                        for (j = 0; j < ing.length; j++) {
                            if (ogg.IngS[i][0] == ing[j]) {
                                ingP = true
                            }
                        }
                        //Creazione array per in gredienti in base alle scelte utente
                        if (ingP == true) {
                            id_ing[indice] = ogg.IngS[i][0];
                            nome_ing[indice] = ogg.IngS[i][1];
                            presenza[indice] = 1;
                            indice++;
                        } else {
                            id_ing[indice] = ogg.IngS[i][0];
                            nome_ing[indice] = ogg.IngS[i][1];
                            presenza[indice] = 0;
                            indice++;
                        }
                    }
                    //Caricamento array con oggetto prodotto comanda
                    a_p_ing[cont_p_o] = {
                        id: ogg.prodotto.id_prodotto,
                        nome: ogg.prodotto.nome_p,
                        id_ingredienti: id_ing,
                        nome_ingredineti: nome_ing,
                        flag_ingredienti: presenza
                    };
                    //incremento contatore prodotti comanda
                    cont_p_o++;

                },
                error: function () {
                    alert("Chiamata fallita, si prega di riprovare...");
                }
            });
            //Aggiunta del prodotto agli array dell'ordine
            a_id_p[cont_p] = id;
            a_desc_p[cont_p] = desc;
            a_prezzi_p[cont_p] = prezzo;
            a_ing_p[cont_p] = 1;
            cont_p++;
            $('#modal_prodotto').modal('hide');

        }
        //Avvio del metodo di creazione della Matrice Ordine per lo scontrino virtuale
        compattaArray();
    } else {
        alert("Prima cocludi l'ordine!!");
    }
}

function compattaArray() {
    var indice = 0;
    var cont;
    var nonContr;
    a_comp = [];
    for (i = 0; i < a_id_p.length; i++) {
        if (a_desc_p[i] != "Varie") {
            nonContr = false;
            for (z = 0; z < a_comp.length; z++) {
                if (a_id_p[i] == a_comp[z][0]) {
                    nonContr = true;
                }
            }
            if (nonContr == false) {
                cont = 0;
                for (j = 0; j < a_id_p.length; j++) {
                    if (a_id_p[i] == a_id_p[j]) {
                        cont++;
                    }
                }
                a_comp[indice] = [a_id_p[i], a_desc_p[i], cont, a_prezzi_p[i]];
                indice++;
            }
        } else {
            a_comp[indice] = [a_id_p[i], "Varie", 1, a_prezzi_p[i]];
            indice++;
        }
    }
    scontrino_v();
}

//Scontrino virtuale
function scontrino_v() {
    //$('#scontrino').removeClass('barra_y');
    $('#area_sub_tot').hide();
    $('#area_resto').hide();
    var tot = 0;
    $('#area_ordine').empty();
    for (i = 0; i < a_comp.length; i++) {
        var codice = "<div class=\"row\">"
            + "<div class=\"col-lg-4 col-md-5 col-sm-4 col-xs-4 text-left\">" + a_comp[i][1] + "</div>";
        var arr_num = a_comp[i][3].toString().split('.');
        //console.log(arr_num.length);
        if (a_comp[i][3].toString().indexOf(".") != (-1)) {
            if (arr_num[1] < 10) {
                codice += "<div class=\"col-lg-4 col-md-3 col-sm-4 col-xs-4 text-center\">" + a_comp[i][2] + "X" + a_comp[i][3] + "0 &euro;</div>";
            } else {
                codice += "<div class=\"col-lg-4 col-md-3 col-sm-4 col-xs-4 text-center\">" + a_comp[i][2] + "X" + a_comp[i][3] + " &euro;</div>";
            }
        } else {
            //console.log("va");
            codice += "<div class=\"col-lg-4 col-md-4 col-sm-4 col-xs-4 text-center\">" + a_comp[i][2] + "X" + a_comp[i][3] + ".00 &euro;</div>";
        }
        var prezzo = parseInt(a_comp[i][2]) * parseFloat(a_comp[i][3]);
        prezzo = arrotonda(prezzo, 2);
        codice += "<div class=\"col-lg-3 col-md-4 col-sm-3 col-xs-4 text-right\">" + prezzo + " &euro;</div>"
            + "<div class=\"col-lg-12\"><hr></div>"
            + "</div>";
        $('#area_ordine').append(codice);
        tot = tot + parseFloat(prezzo);
    }
    $('#tot').empty();
    var cod = "<h3><b>" + tot + " &euro;</b></h3>"
    $('#tot').append(cod);
}

//Scontrino virtuale vuoto
function scontrinoCanc() {
    //$('#scontrino').removeClass('barra_y');
    $('#area_sub_tot').hide();
    $('#area_resto').hide();
    $('#area_ordine').empty();
    $('#display_sub').empty();
    $('#display_varie').empty();
    $('#tot').empty();
}

//Arrotonda a 2 cifre
function arrotonda(valore, nCifre) {
    if (isNaN(parseFloat(valore)) || isNaN(parseInt(nCifre)))
        return false;
    else
        return Math.round(valore * Math.pow(10, nCifre)) / Math.pow(10, nCifre);
}