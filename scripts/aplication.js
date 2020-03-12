function message(mensaje, imagen) {
    $("#titlemesagge").html("<strong>" + mensaje + "<strong/>");
    $("#iconmesagge").html(" <img src='" + imagen + "'/>");
    $("#barraf").slideDown(1000).delay(3000).fadeIn(400);
    $("#barraf").slideUp(1000).fadeOut(400);
}

function validar(e) {
    if (e.keyCode == 86 && e.ctrlKey)
        return true;
    tecla = (document.all) ? e.keyCode : e.which;
    if (tecla == 8)
        return true;
    if (tecla == 48)
        return true;
    if (tecla == 49)
        return true;
    if (tecla == 50)
        return true;
    if (tecla == 51)
        return true;
    if (tecla == 52)
        return true;
    if (tecla == 53)
        return true;
    if (tecla == 54)
        return true;
    if (tecla == 55)
        return true;
    if (tecla == 56)
        return true;
    if (tecla == 57)
        return true;
    // if (tecla==17) return true; 
    //if (tecla==86) return true;    
    patron = /1/; //ver nota
    te = String.fromCharCode(tecla);
    return patron.test(te);
}

function presence(value, label) {
    var values = {
        'valor': value,
        'label': label
    };
    var retorno = '';
    $.ajax({
        type: "POST",
        dataType: "json",
        url: "index.php?controlador=Validation&accion=validar_presencia",
        data: values,
        async: false,
        success: function(response) {
            respuesta = response.result;
            mensaje = response.mensaje;
            if (respuesta == 'true') {
                retorno = 'ok';
            } else {
                retorno = mensaje;
            }
        },
        error: function(error) {
            alert(error);
        }
    });
    return retorno;
}

function patt(value, type, label, minsize) {
    var values = {};
    var retorno = '';
    values['valor'] = value; //valor a verificar
    values['type'] = type; //val1                
    values['label'] = label;
    values['minis'] = minsize;
    $.ajax({
        type: "POST",
        dataType: "json",
        url: "index.php?controlador=Validation&accion=validar_pattern",
        data: values,
        async: false,
        success: function(response) {
            respuesta = response.result;
            mensaje = response.mensaje;
            if (respuesta === 'true') {
                retorno = 'ok';
            } else {
                retorno = 'mensaje';
            }
        },
        error: function(error) {
            alert(error);
        }
    });
    return retorno;
}

function unique(value, key, label, name, exception) {
    var values = {};
    var retorno = '';
    values['valor'] = value; //valor a verificar
    values['key'] = key; //val1                
    values['label'] = label;
    values['name'] = name;
    values['exception'] = exception;
    $.ajax({
        type: "POST",
        dataType: "json",
        url: "index.php?controlador=Validation&accion=validar_unica",
        data: values,
        async: false,
        success: function(response) {
            respuesta = response.result;
            mensaje = response.mensaje;
            if (respuesta == 'true') {
                retorno = 'ok';
            } else {
                retorno = mensaje;
            }
        },
        error: function(error) {
            alert(error);
        }
    });
    return retorno;
}

function validates(idform, messss) {
    if (!messss) { messss = "si"; }
    $('#' + idform + ' .error_input').remove();
    var $inputs = $('#' + idform + ' :input');
    var submitAct = true;
    $inputs.each(function() {
        if (!$(this).attr('disabled')) {
            if ($(this).attr('presence')) {
                var res = presence($(this).val(), $(this).attr('label'));
                if (res == 'ok') {
                    if ($(this).attr('patt')) {
                        var res2 = null;
                        if ($(this).attr('minsize')) {
                            res2 = patt($(this).val(), $(this).attr('patt'), $(this).attr('label'), $(this).attr('minsize'));
                        } else {
                            res2 = patt($(this).val(), $(this).attr('patt'), $(this).attr('label'), 0);
                        }
                        if (res2 == 'ok') {
                            if ($(this).attr('norepeat')) {
                                var res3 = unique($(this).val(), $(this).attr('norepeat'), $(this).attr('label'), $(this).attr('name'), $(this).attr('except') ? $(this).attr('except') : null);
                                if (res3 == 'ok') {

                                } else {
                                    submitAct = false;
                                    $(this).after('<div class="error_input" style="font-size: 12px; color: Red; font-weight: bold;">' + res3 + '</div>');
                                    $(this).css("background-color", "#F0CBBA");
                                }
                            }
                        } else {
                            submitAct = false;
                            $(this).after('<div class="error_input" style="font-size: 12px; color: Red; font-weight: bold;">' + res2 + '</div>');
                            $(this).css("background-color", "#F0CBBA");
                        }
                    } else {}
                } else {
                    submitAct = false;
                    $(this).after('<div class="error_input" style="margin-top:8px !important;font-size: 12px; color: Red; font-weight: bold;">' + res + '</div>');
                    $(this).css("background-color", "#F0CBBA");
                }
            } else {
                if ($(this).val() != '') {
                    if ($(this).attr('patt')) {
                        var res2 = null;
                        if ($(this).attr('minsize')) {
                            res2 = patt($(this).val(), $(this).attr('patt'), $(this).attr('label'), $(this).attr('minsize'));
                        } else {
                            res2 = patt($(this).val(), $(this).attr('patt'), $(this).attr('label'), 0);
                        }
                        if (res2 == 'ok') {
                            if ($(this).attr('norepeat')) {
                                var res3 = unique($(this).val(), $(this).attr('norepeat'), $(this).attr('label'), $(this).attr('name'), $(this).attr('except') ? $(this).attr('except') : null);
                                if (res3 == 'ok') {

                                } else {
                                    submitAct = false;
                                    $(this).after('<div class="error_input" style="font-size: 12px; color: Red; font-weight: bold;">' + res3 + '</div>');
                                    $(this).css("background-color", "#F0CBBA");
                                }
                            }
                        } else {
                            submitAct = false;
                            $(this).after('<div class="error_input" style="font-size: 12px; color: Red; font-weight: bold;">' + res2 + '</div>');
                            $(this).css("background-color", "#F0CBBA");
                        }
                    } else {
                        if ($(this).attr('norepeat')) {
                            var res3 = unique($(this).val(), $(this).attr('norepeat'), $(this).attr('label'), $(this).attr('name'), $(this).attr('except') ? $(this).attr('except') : null);
                            if (res3 == 'ok') {

                            } else {
                                submitAct = false;
                                $(this).after('<div class="error_input" style="font-size: 12px; color: Red; font-weight: bold;">' + res3 + '</div>');
                                $(this).css("background-color", "#F0CBBA");
                            }
                        }
                    }
                }
            }
        }
    });
    if (submitAct) {
        return true;
    } else {
        if (messss == "si") {
            message('Verifique los datos ingresados', 'images/iconos_alerta/error.png');
        }
        return false;
    }
}

$(function() {
    // var today = new Date();
    // $('input.onepic').simpleDatePicker({
    //     // chosendate:  $('input.onepic').attr("madate")? Number($('input.onepic').attr("madate")):today.getFullYear(),
    //     startdate: $('input.onepic').attr("midate") ? Number($('input.onepic').attr("midate")) : today.getFullYear() - 100,
    //     enddate: $('input.onepic').attr("madate") ? Number($('input.onepic').attr("madate")) : today.getFullYear(),
    //     x: 20,
    //     y: 20
    // });
    /*
     $('input.onepic').click(function(){
     $("[name='year']").val($(this).attr("madate")? Number($(this).attr("madate")):2013);   
     });   
     */

});