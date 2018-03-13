/**
 * GESTIONE CASSA LATO CLIENT
 **/
var a_id_p = [];       //ARRAY ID PRODOTTI ORDINATI
var a_ing_p = [];    //ARRAY FLAG INGREDIENTI PRODOTTI ORDINATI
var a_desc_p = [];     //ARRAY DESCRIZIONI PRODOTTI ORDINATI
var a_prezzi_p = [];   //ARRAY PREZZI PRODOTTI ORDINATI
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
var flagStampante = true;   //Flag per attivare stampante
/*Quasi tutti i metodi devono avere come prima riga
 if(flagPagamento== false){
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
                    if (flagPagamento == false) {
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
                        alert("Prima cocludi l'ordine!!");
                    }
                } else {
                    add_prodotto(ogg.prodotto.flag_ing, ogg.prodotto.id_prodotto, ogg.prodotto.nome_p, ogg.prodotto.prezzo);
                }

            },
            error: function () {
                alert("Chiamata fallita, si prega di riprovare...");
            }
        }
    )
    ;
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
                            nome_ing[indice] = ogg.arrayI[i][1];
                            presenza[indice] = 1;
                            indice++;
                        } else {
                            id_ing[indice] = ogg.IngS[i][0];
                            nome_ing[indice] = ogg.arrayI[i][1];
                            presenza[indice] = 0;
                            indice++;
                        }
                    }
                    //Caricamento array con oggetto prodotto comanda
                    a_p_ing[cont_p_o] = {
                        id: ogg.prodotto.id_prodotto,
                        nome: ogg.prodotto.nome_p,
                        idIngredienti: id_ing,
                        nomeIngredineti: nome_ing,
                        flagIngredienti: presenza
                    };
                    //console.log(a_p_ing[cont_p_o]);
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
        scontrino_v();
    } else {
        alert("Prima cocludi l'ordine!!");
    }
}
//Apri popUp Varie
function popupVarie() {
    input_varie = "";
    $('#display_varie').empty();
    $('#modal_varie').modal('show');
}
//tastiere
function tastiera(tipo, num) {
    if (tipo.localeCompare("varie") == 0) {
        $('#display_varie').empty();
        input_varie = input_varie + num;
        var str = input_varie + " &euro;";
        $('#display_varie').append(str);
    } else {
        if (tipo.localeCompare("sub") == 0) {
            $('#display_sub').empty();
            input_sub = input_sub + num;
            var str = input_sub + " &euro;";
            $('#display_sub').append(str);
        }
    }
}
//Inserimento prodotto Varie
function prodotto_varie() {
    var prezzo = parseFloat(input_varie);
    a_id_p[cont_p] = "";
    a_prezzi_p[cont_p] = prezzo;
    a_desc_p[cont_p] = "Varie";
    a_ing_p[cont_p] = 0;
    cont_p++;
    scontrino_v();
    input_varie = "";
    $('#modal_varie').modal('hide');
    $('#display_varie').empty();
}
//annulla varie
function annullaVarie() {
    input_varie = "";
    $('#modal_varie').modal('hide');
    $('#display_varie').empty();
}
//cancellare ultimo articolo
function cancella() {
    if (flagPagamento == false) {
        cont_p--;
        a_id_p[cont_p] = null;
        a_prezzi_p[cont_p] = null;
        a_desc_p[cont_p] = null;
        if(a_ing_p[cont_p] == 1){
            cont_p_o--;
            a_p_ing[cont_p_o]=null;
        } else {
            a_ing_p[cont_p] = null;
        }

        scontrino_v();
    } else {
        alert("Prima cocludi l'ordine!!");
    }
}
//annullamento dell'ordine
function annulla() {
    a_p_ing = [];
    a_id_p = [];
    a_prezzi_p = [];
    a_desc_p = [];
    cont_p = 0;
    cont_p_o = 0;
    resto = 0;
    tot = 0;
    contanti = 0;
    input_varie = "";
    flagPagamento = false;
    input_sub = "";
    scontrinoCanc();
}
/*______________________________________________________________________________________________________________________
* Totali Ordine
*_____________________________________________________________________________________________________________________*/
//subtotale
function subtotale() {
    if (cont_p > 0) {
        $('#display_sub').empty();
        flagPagamento = true;
        $('#modal_subtot').modal('show');
    } else {
        alert("Prima ordina qualcosa!!!")
    }
}

//annullamento del resto
function annullaResto() {
    flagPagamento = false;
    $('#modal_subtot').modal('hide');
    totale_ord();
}

//totale Ordine
function totale_ord(tipo) {
    if (cont_p > 0) {
        var a_comp = compattaArray();
        var totale = 0;
        for (i = 0; i < a_comp.length; i++) {
            var prezzo = parseInt(a_comp[i][2]) * parseFloat(a_comp[i][3]);
            totale = totale + parseFloat(prezzo);
        }
        tot = totale;
        tot = arrotonda(tot, 2);
        var strId = "";
        var strPrezzi = "";
        var strQuantita = "";
        var strDesc = "";
        var strING = "";

        for (i = 0; i < a_comp.length; i++) {
            if (i == 0) {
                strId += "id" + i + "=" + a_comp[i][0];
                strPrezzi += "prezzi" + i + "=" + a_comp[i][3];
                strQuantita += "quant" + i + "=" + a_comp[i][2];
                strDesc += "desc" + i + "=" + a_comp[i][1];
                strING += "prod_i"+ i + "=" + a_comp[i][4]
            } else {
                strId += "&id" + i + "=" + a_comp[i][0];
                strPrezzi += "&prezzi" + i + "=" + a_comp[i][3];
                strQuantita += "&quant" + i + "=" + a_comp[i][2];
                strDesc += "&desc" + i + "=" + a_comp[i][1];
                strING += "&prod_i"+ i + "=" + a_comp[i][4]
            }
        }
        var parametri = strId + "&" + strPrezzi + "&" + strQuantita + "&" + strDesc + "&" + strING + "&num_P=" + cont_p+"&tipo="+tipo;

        $.ajax({
            type: "POST",
            url: "metodi/acquisto.php",
            data: parametri,
            dataType: "html",
            success: function (risposta) {
                var ogg = $.parseJSON(risposta);
                if (ogg.esito==0) {
                    var str = "";
                    if(tipo==0) {
                        if (flagPagamento == false) {
                            str = strStampa("SC");
                        } else {
                            contanti = input_sub;
                            resto = parseFloat(contanti) - parseFloat(totale);
                            resto = arrotonda(parseFloat(resto), 2);
                            str = strStampa("SC");

                            var strC = "<h4><b>" + contanti + " &euro;</b></h4>";
                            $('#contante').empty();
                            $('#contante').append(strC);

                            var strR = "<h4><b>" + resto + " &euro;</b></h4></div>";
                            $('#resto').empty();
                            $('#resto').append(strR);

                            $('#area_sub_tot').show();
                            $('#area_resto').show();

                            //$('#scontrino').addClass('barra_y');
                            $('#modal_subtot').modal('hide');
                            $('#scontrino').animate({scrollTop: $('#scontrino').height()}, 100);
                        }
                    } else {
                        //Buono sconto
                    }
                    if(ogg.ingredienti == 1){
                        str += ogg.foto;
                    }
                    if (flagStampante == true) {
                        stampa(str);
                    }
                    a_p_ing = [];
                    a_id_p = [];
                    a_prezzi_p = [];
                    a_desc_p = [];
                    cont_p = 0;
                    cont_p_o = 0;
                    resto = 0;
                    tot = 0;
                    contanti = 0;
                    input_varie = "";
                    flagPagamento = false;
                    input_sub = "";
                }
            },
            error: function () {
                alert("Ordine non inserito!!");
            }
        });
    } else {
        alert("Prima ordina qualcosa!!!")
    }
}

//annullamento del resto
function annullaResto() {
    flagPagamento = false;
    $('#modal_subtot').modal('hide');
    totale_ord();

}

/*______________________________________________________________________________________________________________________
* Funzioni Stampa scontrino Virtuale
*_____________________________________________________________________________________________________________________*/

//Scontrino virtuale
function scontrino_v() {
    $('#area_sub_tot').hide();
    $('#area_resto').hide();
    var a_comp = compattaArray();
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
        tot = arrotonda(tot,2);
    }
    $('#tot').empty();
    var cod = "<h3><b>" + tot + " &euro;</b></h3>"
    $('#tot').append(cod);
}

//Scontrino virtuale vuoto
function scontrinoCanc() {
    //$('#scontrino').removeClass('barra_y');
    input_varie="";
    input_sub="";
    $('#area_sub_tot').hide();
    $('#area_resto').hide();
    $('#area_ordine').empty();
    $('#display_sub').empty();
    $('#display_varie').empty();
    $('#tot').empty();
}

/*______________________________________________________________________________________________________________________
* Funzioni per la gestione dei dati
______________________________________________________________________________________________________________________*/

//Campatta Array dei prodotti in un'unica matrice
function compattaArray() {
    var indice = 0;
    var cont;
    var nonContr;
    var a_comp = [];
    var contrING = 0;
    for (i = 0; i < cont_p; i++) {
        contrING = 0;
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
                if(a_ing_p[i]==1){
                    contrING = 1;
                }
                a_comp[indice] = [a_id_p[i], a_desc_p[i], cont, a_prezzi_p[i],contrING];
                indice++;
            }
        } else {
            a_comp[indice] = [a_id_p[i], "Varie", 1, a_prezzi_p[i],0];
            indice++;
        }
    }
    return a_comp;
}

//Arrotonda a 2 cifre
function arrotonda(valore, nCifre) {
    if (isNaN(parseFloat(valore)) || isNaN(parseInt(nCifre)))
        return false;
    else
        return Math.round(valore * Math.pow(10, nCifre)) / Math.pow(10, nCifre);
}

/*______________________________________________________________________________________________________________________
* PARTE DI STAMPA
 */

//toString Inter0 (massimo 3 cifre)
function toStringIntero(numero) {
    var str = "";
    if (numero < 10) {
        str += "  " + numero;
    } else {
        if (numero < 100) {
            str += " " + numero;
        } else {
            str += numero;
        }
    }
    return str;
}

//toString Decimale (3 cifre parte intera, 2 cifre parte decimale
function toStringDecimale(numero) {
    var arr_num = numero.toString().split('.');
    var str = "";
    if (arr_num[0] < 10) {
        str += "  " + arr_num[0];
    } else {
        if (arr_num[0] < 100) {
            str += " " + arr_num[0];
        } else {
            str += arr_num[0];
        }
    }
    str += ".";
    if (numero.toString().indexOf(".") != (-1)) {
        if (arr_num[1] < 10) {
            str += arr_num[1] + "0";
        } else {
            str += arr_num[1];
        }
    } else {
        str += "00";
    }
    return str;
}

//Stringa per stampante
function strStampa(tipo) {
    var a_comp = compattaArray();
    var str = "";
    if (tipo.localeCompare("SC") == 0) {
        str += "2_1                                   EURO_1";
        for (i = 0; i < a_comp.length; i++) {
            var sp1 = "";//spazio1
            var numTx = a_comp[i][1].length;//parte testo
            var mancanti = 12 - parseInt(numTx);
            var app = "";
            for (j = 0; j < mancanti; j++) {
                app += " ";
            }
            var Tx = a_comp[i][1] + app;//parte testo
            var sp2 = "     ";//spazio2
            var qua = toStringIntero(a_comp[i][2]);//parte numeri
            var deci = toStringDecimale(a_comp[i][3]);
            var molt = qua + "X" + deci; //qua e prezzo
            var sp3 = "      ";//spazio3
            var prezzo = parseInt(a_comp[i][2]) * parseFloat(a_comp[i][3]);
            var prezzo_str = toStringDecimale(prezzo); //tot prezzo
            var sp4 = " ";//spazio4
            str += sp1 + Tx + sp2 + molt + sp3 + prezzo_str + sp4 + ":";
        }

        //TOTALE SCONTRINO
        str += "_2_1";
        str += "TOTALE                           ";
        var cifra = toStringDecimale(tot); //tot prezzo
        str += cifra + ":";
        //CONTANTI E RESTO
        if (flagPagamento == true) {
            str += "CONTANTE                         ";
            cifra = toStringDecimale(contanti);
            str += cifra + ":";
            str += "RESTO                            ";
            cifra = toStringDecimale(resto);
            str += cifra + ":";
        }
        str += "_4_5";
        if(cont_p_o>0){
            str += stringaIngredienti();
        }
    } else {
        if (tipo.localeCompare("SC-CARD") == 0) {
            str += "2_1                                   EURO_1";
            for (i = 0; i < a_comp.length; i++) {
                var sp1 = "";//spazio1
                var numTx = a_comp[i][1].length;//parte testo
                var mancanti = 12 - parseInt(numTx);
                var app = "";
                for (j = 0; j < mancanti; j++) {
                    app += " ";
                }
                var Tx = a_comp[i][1] + app;//parte testo
                var sp2 = "     ";//spazio2
                var qua = toStringIntero(a_comp[i][2]);//parte numeri
                var deci = toStringDecimale(a_comp[i][3]);
                var molt = qua + "X" + deci; //qua e prezzo
                var sp3 = "      ";//spazio3
                var prezzo = parseInt(a_comp[i][2]) * parseFloat(a_comp[i][3]);
                var prezzo_str = toStringDecimale(prezzo); //tot prezzo
                var sp4 = " ";//spazio4
                str += sp1 + Tx + sp2 + molt + sp3 + prezzo_str + sp4 + ":";
            }
            //TOTALE SCONTRINO
            str += "_2_1";
            str += "TOTALE                           ";
            var cifra = toStringDecimale(tot); //tot prezzo
            str += cifra + ":_2_";
            str += "1          PAGAMENTO CON BANCOMAT          ";
            str += "_4_5";
            if(cont_p_o>0){
                str += stringaIngredienti();
            }
        }
    }
    //console.log(str);
    return str;
}
//STRINGA INGREDIENTI
function stringaIngredienti() {
    var str = "";
        str += "_6";
        for (i=0;i<cont_p_o;i++){
            //console.log(a_p_ing[i]);
            str += a_p_ing[i].id+":";
            str += a_p_ing[i].nome+":";
            for(z=0;z<a_p_ing[i].idIngredienti.length;z++){
                str += a_p_ing[i].idIngredienti[z]+"-";
            }
            str += ":";
            for(z=0;z<a_p_ing[i].nomeIngredineti.length;z++){
                str += a_p_ing[i].nomeIngredineti[z]+"-";
            }
            str += ":";
            for(z=0;z<a_p_ing[i].flagIngredienti.length;z++){
                str += a_p_ing[i].flagIngredienti[z]+"-";
            }
            str += ";";
        }
    return str;
}
//Stampa Scontrino
function stampa(str) {
    if (flagStampante == true) {
        $.ajax({
            type: "POST",
            url: "../Librerie/Stampante/Stampa.php",
            data: "comando=" + str,
            dataType: "html",
            success: function () {
            },
            error: function () {
                alert("Scontrino non stampato");
            }
        });
    }
}