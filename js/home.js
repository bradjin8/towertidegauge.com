let map;
let locations = [];

document.addEventListener('DOMContentLoaded', function () {
    getTideGauges();
});

function initMap() {
    let dropdown = "";
    let mapElement = document.getElementById('map'), map, mid, mapOptions;

    if (mapElement) {
        mid = new google.maps.LatLng(30, 14);
        mapOptions = {
            zoom: 3,
            center: mid,
            disableDefaultUI: true,
        }
        map = new google.maps.Map(mapElement, mapOptions);
        google.maps.importLibrary("maps");
        google.maps.importLibrary("marker");
    }
    for (let i = 0; i < locations.length; i++) {
        const data = locations[i];
        let siteLink = `<a href="${base_url}/widget/${data._serial}">${data._loc}: ${data._serial}</a>`;
        dropdown = dropdown.concat(siteLink)
        document.getElementById("dropdown").innerHTML = dropdown;

        const link = '<div id="siteLink" onclick=window.location.href="widget/' + data._serial + '">' + data._loc.toUpperCase() + '</div>'
        const contentString =
            '<head><link rel="stylesheet" href="index.css"/>' +
            '<body>' +
            '<div id="siteContent">' +
            link +
            '<div>' + data._country + '</div>' +
            '</div>' +
            '</body></head>';

        if (mapElement) {
            const infowindow = new google.maps.InfoWindow({
                content: contentString,
                maxwidth: 200,
            });

            const marker = new google.maps.Marker({
                position: { lat: parseFloat(data._lat), lng: parseFloat(data._lon) },
                map: map,
                animation: google.maps.Animation.DROP,
                title: data._loc,

            });

            marker.addListener("click", () => {
                infowindow.open({
                    anchor: marker,
                    map,
                    shouldFocus: false,
                });
            });
        }
    }

}

function getTideGauges() {
    $.get(`${base_url}/api/tidegauge`, function (data) {
        if (data) {
            let serial = -1;
            let sites = [];

            //console.log(data);
            for (let a = 0; a < data.length; a++) {
                if (serial != data[a]._serial) {
                    sites.push(data[a]);
                    serial = data[a]._serial;
                }
            }
            locations = sites;
            initMap();
        }
    });
}
