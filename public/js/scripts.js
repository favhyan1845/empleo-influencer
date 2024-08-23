/*!
 * Xharla
 * script to different actions from the frontend side
 */

//Declarate url base to the system
var baseUrl = $('#baseUrl').val();
//actions buttons

(function($) {
    $('.form-check-input').click(function(evt) {
        if ($(this).is(':checked')) {
            $(this).prop('checked', true).attr('checked', 'checked');

            var value = $(this).attr("value");
            $.ajax({
                    url: baseUrl+"/subcategorias",
                    type: "POST",
                    headers: { 'X-Requested-With': 'XMLHttpRequest' },
                    data: { "id": value }
                }).done(function(response) {
                    $("#subcategoria").html(response);
                })
                .fail(function() {
                    console.log("error");
                })
        } else {
            $(this).prop('checked', false).removeAttr('checked');
        }

    });
    var myModal = document.getElementById('myModal');
    var myInput = document.getElementById('myInput');

    if (myModal !== null || myInput !== null) {
        myModal.addEventListener('shown.bs.modal', function() {
            myInput.focus()
        });
    }

    $("#search-addon").click(function() {
        var word = document.getElementById("sbar").value;
        $.ajax({
                url: baseUrl+"/buscar-campañas",
                headers: { 'X-Requested-With': 'XMLHttpRequest' },
                type: 'GET', // The HTTP Method, can be GET POST PUT DELETE etc
                data: { 'q': word }, // Additional parameters here
            }).done(function(response) {
                $('.lista-campanas').html(response);
            })
            .fail(function() {
                console.log("error");
            });
    });

    $('#search-addon_a').click(function(evt) {
        $.ajax({
                url: baseUrl+"/campañas",
                type: "GET",
                headers: { 'X-Requested-With': 'XMLHttpRequest' },
            }).done(function(response) {
                $(".selected-campaing").html(response);
            })
            .fail(function() {
                console.log("error");
            })
    });

})($)
//actions functions
function campaign(id) {

    dedString = base64Decode(id);
    var decodedString = base64Decode(id);

    $.ajax({
            url: baseUrl+"/campañas?id="+decodedString,
            type: "GET",
            headers: { 'X-Requested-With': 'XMLHttpRequest' },
        }).done(function(response) {
            $(".selected-campaing").html(response);
        })
        .fail(function() {
            console.log("error");
        });
}
function applyCampaign(id){
    dedString = base64Decode(id);
    var decodedString = base64Decode(id);

    $.ajax({
            url: baseUrl+"/aplicar-campaña?id="+decodedString,
            type: "GET",
            headers: { 'X-Requested-With': 'XMLHttpRequest' },
        }).done(function(response) {
            $(".selected-campaing").html(response);
            setTimeout(function() {
                $('.card_'+decodedString).remove();
            }, 1000);
        })
        .fail(function() {
            console.log("error");
        })
}
function handleDataId(element) {
    // Obtiene el valor de data-id
    var dataId = element.getAttribute('data-id');

    // Usa el valor de data-id como desees
    var newHref = baseUrl+"/eliminar-experiencia/" + dataId;
    $('#confirm').attr('href', newHref);
    $('#dataId').html(dataId);
}

function closeModal() {
    // Cierra el modal usando jQuery
    $('#modalEliminar').modal('hide');
}

function base64Decode(encodedStr) {
    // Using atob() function to decode the Base64 encoded string
    return atob(encodedStr);
}