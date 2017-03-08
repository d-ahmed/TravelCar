$(document).ready(function() {
    var adverts = [];
    setInterval(function(){
        $.ajax({
            url: Routing.generate('last_adverts_to_expose'),
            dataType: 'JSON',
            type: 'GET',
            success: function (response) {
                $("#lastAdvert").children().remove();
                $.each(response, function (i) {
                    var departureDate = new Date(response[i].departureTime);
                    $("#lastAdvert").append(
                        "<div class='col-md-3' >" +
                        "<div class='thumbnail'>" +
                        "<div class='caption'> " +
                        "<strong>"+departureDate.toLocaleDateString()+" à "+departureDate.toLocaleTimeString()+"</strong>"+
                        "</div> " +
                        "</div>" +
                        " </div>"
                    )
                })
            },

            error: function (data, xhr, status, err) {
                //console.log("err "+err);
            },
        });
    }, 4000);

    $.ajax({
        url:"/ville",
        dataType: 'JSON',
        type: 'GET',

        success: function (response) {
            $.each(response,function(i) {
                villes[i] = response[i].ville;
            });

            $('#ville').autocomplete({
                minLength:3,
                source:cleanArray(villes)
            });
        },

        error: function (data, xhr, status, err) {
            //console.log("err "+err);
        },
    });

});