<html>
    <head>
        <link rel="stylesheet" href="http://unpkg.com/leaflet@1.4.0/dist/leaflet.css" />
        <script src="http://unpkg.com/leaflet@1.4.0/dist/leaflet.js"></script>
        <script src="<?php echo base_url() ?>assets/js/kml.js"></script>
    </head>
    <body>
        <!-- <?php print_r($kml[0]['upload_kml']); ?> -->
        <div style="width: 95vw; height: 90vh" id="map"></div>
        <script type="text/javascript">
            // Make basemap
            const map = new L.Map('map', { center: new L.LatLng(58.4, 43.0), zoom: 11 });
            const osm = new L.TileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png');

            map.addLayer(osm);

            // Load kml file
            fetch( '<?php echo base_url('uploads/'.$kml[0]['upload_kml']) ?>')
                .then(res => res.text())
                .then(kmltext => {
                    // Create new kml overlay
                    const parser = new DOMParser();
                    const kml = parser.parseFromString(kmltext, 'text/xml');
                    const track = new L.KML(kml);
                    map.addLayer(track);

                    // Adjust map to show the kml
                    const bounds = track.getBounds();
                    map.fitBounds(bounds);
                });
        </script>
    </body>
</html>