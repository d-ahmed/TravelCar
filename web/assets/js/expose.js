$(document).ready(function() {
    console.log(Routing.generate('last_adverts_to_expose'));
    setInterval(function(){
        $.ajax({
            url: Routing.generate('last_adverts_to_expose'),
            dataType: 'JSON',
            type: 'GET',
            success: function (response) {
                $("#lastAdvert").children().remove();
                $.each(response, function (i) {
                    var departureDate = new Date(response[i].departureTime);
                    var departureCity = response[i].departureCity;
                    var cityOfArrival = response[i].cityOfArrival;
                    var places_availables = response[i].numberOfPlace - response[i].numberOfReservation;
                    var id = response[i].id;
                    $("#lastAdvert").append(
                        "<div class='col-md-4' >" +
                        "<div class='thumbnail'>" +
                        "<div class='caption'> " +
                        "<strong>"+departureDate.toLocaleDateString()+" à "+departureDate.toLocaleTimeString()+"</strong>"+
                        "<p><span class=\"glyphicon glyphicon-road text-primary\"></span> "+ departureCity + " → "+ cityOfArrival +
                        "<p><span class=\"glyphicon glyphicon-user text-primary\"></span> " + places_availables +  " places disponibles.</p>"+
                        "<a href=\"\" class=\"btn btn-info\" type=\"button\"> Réserver </a>"+
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

    $('.city').keyup(function () {
        $(this).preventDefault;
        var villes = [];
        $.ajax({
            url:"http://vicopo.selfbuild.fr/cherche/"+$(this).val(),
            dataType: 'JSON',
            type: 'GET',

            success: function (response) {

                $.each(response.cities,function(i) {
                    villes[i] = response.cities[i].city;
                });
                var monSet = new Set(villes);
                villes = Array.from(monSet);
                $('.city').autocomplete({
                    minLength:3,
                    source: villes,
                    maxShowItems: 5
                });

            },

            error: function (data, xhr, status, err) {
                //console.log("err "+err);
            },
        });
    })


});