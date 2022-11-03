//Tayla Orsmond u21467456
//Path: js\location.js
//Language: Javascript, JQuery
//Description: This file contains the code for getting the user's location and displaying it on the map
//It makes use of the Google Maps API and the OpenStreetMap API, as well as the geoLocation API

$(() => {
    const display_location = () => {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(show_position);
        } else {
            console.log("Geolocation is not supported or allowed by this browser.");
        }
    }
    const show_position = position => {
        //document.getElementById("e_location").value = position.coords.latitude + ", " + position.coords.longitude;
        //get the name of the location to give to the location input
        fetch("https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=" + position.coords.latitude + "&lon=" + position.coords.longitude)
            .then(response => response.json())
            .then(data => {
                $("#e_location").val(data.address.road + ", " + data.address.city + ", " + data.address.country);
            });
        //display a map of the location in the map div
        $("#map").html("<iframe width='100%' height='100%' src='https://maps.google.com/maps?q=" + position.coords.latitude + "," + position.coords.longitude + "&hl=es;z=14&amp;output=embed' frameborder='0' scrolling='no' marginheight='0' marginwidth='0'></iframe>");
    }
    
    $("#e_location_btn").on('click', display_location);
});