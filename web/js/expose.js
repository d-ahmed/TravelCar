$(document).ready(function() {
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