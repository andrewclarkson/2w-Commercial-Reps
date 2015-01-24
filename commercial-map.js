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

    var active = null;
    var url = $("#commercial-representatives-map").data('states');
    $.ajax({
        url: url,
        mimeType: 'application/json',
        dataType: 'json',
        success: function(data) {
            L.geoJson(data, {
                onEachFeature: function(feature, layer) {
                    layer.on({
                        click: function(event) {
                            var state = document.getElementById(feature.properties.name);
                            console.log(state);
                            if(active && active != feature.properties.name) {
                                var old = document.getElementById(active);
                                $(old).removeClass('active');
                            }
                            
                            if(!state) {
                                $('#none').addClass('active');
                                active = 'none';
                                return;
                            } else {
                                active = feature.properties.name;
                                $(state).addClass('active');
                            }
                        }
                    });
                }
            }).addTo(map);
        }
    });    
});
