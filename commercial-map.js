jQuery(document).ready(function($) {
    var map = L.map('commercial-representatives-map').setView([37.8, -96], 4);
    
    var tiles = L.tileLayer('http://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token={access_token}', {
        id: 'mapbox.light',
        attribution: 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, ' +
                     '<a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
                     'Imagery © <a href="http://mapbox.com">Mapbox</a>',
        access_token: 'pk.eyJ1IjoiYml0Ym9ybiIsImEiOiJZUkExSDFNIn0.FSCoCo3RnLywvlAWYfWb-g'
    })
    
    tiles.addTo(map);

    

});
