$(document).ready(function() {
    $('#buscar-cep').on('click', function(e) {
        e.preventDefault();

        $('#erro-cep').hide();
        $('#numero, #complemento').val('');

        var cep = $('#cep').inputmask('unmaskedvalue');

        buscarCEP(cep);
    });
});

function buscarCEP(cep) {

    $('#loading-image').show();

    $.ajax({
        type: "GET",
        url: APP_URL + '/endereco/cep',
        data: {
            cep: cep
        },
        success: function(msg) {
            var endereco = JSON.parse(msg);

            preencherCamposEndereco(endereco);
        },
        error: function(response, textStatus, errorThrown) {
            var error = response.responseText;

            /*console.log(response);
            console.log(textStatus);
            console.log(errorThrown);*/

            mensagemErro(error);
        },
        complete: function() {
            $('#loading-image').hide();
        }
    });

}

function preencherCamposEndereco(endereco) {

    $('#rua').val(endereco.logradouro);
    $('#bairro').val(endereco.bairro);

    $('#state option[selected]').each(function() {
        $(this).removeAttr('selected');
    });

    $('#state option[data-abbreviation=' + endereco.estado + ']').prop('selected', true);
    $('#state').trigger('change');

    var id = $('#city option').filter(function() {
        return $(this).html().toLowerCase() == endereco.cidade.toLowerCase();
    }).val();

    $('#city').val(id).trigger('chosen:updated');

}

function mensagemErro(mensagem) {
    $('#erro-cep').text(mensagem).show();
}