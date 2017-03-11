$(document).ready(function(){

    $('.versItineraire').click(function(e){
        e.preventDefault();

        if(versAnnonce()==true){

            $('div.tab-pane').each(function(){
                $(this).removeClass('active');
            })

            $('li').each(function(){
                $(this).removeClass('active');
                $(this).removeClass('completed');
            })

            if(!$('a.versItineraire').parent().hasClass('active')){
                $('a.versItineraire').parent().addClass('active');
            }

            $('#itineraire').addClass('active');
            
            completed();
        }
    })

    $('.versAnnonce').click(function(e){
        e.preventDefault();

        if(versAnnonce()==true){

            $('div.tab-pane').each(function(){
                $(this).removeClass('active');
            })

            $('li').each(function(){
                $(this).removeClass('active');
                $(this).removeClass('completed');
            })

            if(!$('a.versAnnonce').parent().hasClass('active')){
                $('a.versAnnonce').parent().addClass('active');
            }

            $('#annonce').addClass('active');
            
            completed();
        }
    })

    $('.versPoster').click(function(e){
        e.preventDefault();

        if(versAnnonce()==true && versPoster()==true){

            $('div.tab-pane').each(function(){
                $(this).removeClass('active');
            })

            $('li').each(function(){
                $(this).removeClass('active');
                $(this).removeClass('completed');
            })

            if(!$('a.versPoster').parent().hasClass('active')){
                $('a.versPoster').parent().addClass('active');
            }
            
            $('#poster').addClass('active');

            completed();
        }
    })

})

function versAnnonce(){
    var okItineraire = true;
    var departureCity = $('[name*=departureCity]').val().length;
    var cityOfArrival = $('[name*=cityOfArrival]').val().length;
    var departureDate = $('[name*=departureDate]').val().length;
    var travelTime = $('[name*=travelTime]').val().length;

    $('.text-danger').remove();
    if(!departureCity){
        $('[name*=departureCity]').parent().append('<span class="text-danger"> Ce champ est obligatoire </span>');
        okItineraire=false;
    }

    if(!cityOfArrival){
        $('[name*=cityOfArrival]').parent().append('<span class="text-danger"> Ce champ est obligatoire </span>');
        okItineraire=false;
    }

    if(!departureDate){
        $('[name*=departureDate]').parent().append('<span class="text-danger"> Ce champ est obligatoire </span>');
        okItineraire=false;
    }

    if(!travelTime){
        $('[name*=travelTime]').parent().append('<span class="text-danger"> Ce champ est obligatoire </span>');
        okItineraire=false;
    }
    return okItineraire;
}

function versPoster(){
    var okAnnonce = true;
    var pricePerPersonne = $('[name*=pricePerPersonne]').val().length;
    var numberOfPlace = $('[name*=numberOfPlace]').val().length;
    var okAnnonce = true;

    $('.text-danger').remove();

    if(!pricePerPersonne){
        $('[name*=pricePerPersonne]').parent().parent().append('<span class="text-danger"> Ce champ est obligatoire </span>');
        okAnnonce=false;
    }

    if(!numberOfPlace){
        $('[name*=numberOfPlace]').parent().append('<span class="text-danger"> Ce champ est obligatoire </span>');
        okAnnonce=false;
    }
    return okAnnonce;
}

function completed(){
    $('li').each(function(index){
        if($(this).hasClass('active')){
            for (var i = index - 1; i >= 0; i--) {
                $("li:eq("+i+")").addClass('completed');
            }
        }
    })
}