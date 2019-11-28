<?php
/*
	Plugin Name: saa interactive map
	Plugin URI: http://www.future-internet.com/plugins/popup.zip
	Description: SA Interactive Map, See Destinations on google map
	Version: 1.0
	Author: future Internet
	Author URI: http://www.future-internet.com
	License:  GPL2*/


//add shortcode
add_shortcode('saa-interactive-map', 'saa_interactivemap_shortcode');

//page function
function saa_interactivemap_shortcode($atts)
{
    extract(shortcode_atts(array(
        'languge' => 'en',
    ), $atts));

    $current_lang = get_bloginfo('language');
    //return map();
    return tablelist();
}

function saa_interactivemap_style()
{
    if ($current_lang == "ar") {
        wp_register_style('saa_interactive_map_css', plugins_url('/map_css_ar.css', __FILE__));
    } else {
        wp_register_style('saa_interactive_map_css', plugins_url('/map_css.css', __FILE__));
    }

    wp_enqueue_style('saa_interactive_map_css');
}

add_action('wp_enqueue_scripts', 'saa_interactivemap_style');

function tablelist()
{

    $mydb = new wpdb(DB_USER, DB_PASSWORD, 'saafidsdb', DB_HOST);
    $sql_query = "SELECT DISTINCT(`airport_master`.`AirportName`) AS airport_name,`airport_master`.`AirportName_AR` AS airport_name_ar FROM `flight_hdr`
				  LEFT JOIN `flightstatus_master` ON `flight_hdr`.`flight_status` = `flightstatus_master`.`StatusCode`
				  LEFT JOIN `airline_master`ON `flight_hdr`.`AIRL_CODE` = `airline_master`.`AirlineCode`
				  LEFT JOIN `flight_route` ON `flight_hdr`.`FLTKEY` = `flight_route`.`FLTKEY`
				  LEFT JOIN `airport_master` ON `flight_route`.`AirportCode` = `airport_master`.`AirportCode`
				  WHERE `flight_hdr`.`LOAD_TYPE` = '1' AND `flight_hdr`.`AORD_FLG` = 'D' ORDER BY airport_name ASC";

    $get_flights = $mydb->get_results($sql_query);


    $current_lang = qtrans_getLanguage();
    ob_start();
    $html .= '<div class="clear"></div><ul style="width:100%;">';
    foreach ($get_flights as $today) {
        $airport = ($current_lang == 'en') ? $today->airport_name : $today->airport_name_ar;
        $dir = ($current_lang == 'en') ? 'left' : 'right';
        if ($airport != '') {
            $html .= '<li style="width:25%; margin:0 10px; float:' . $dir . ';">' . $airport . '</li>';
        }
    }
    $html .= '</ul>';
    echo $html;
    return ob_get_clean();

}

//add js and css files
function map()
{
    ob_start();

    $current_lang = get_bloginfo('language');
    if ($current_lang != "ar") {
        $current_lang = "en";
    }
    ?>
    <style>
        html, body, #map-canvas {
            height: 100%;
            margin: 0px;
            padding: 0px
        }

        #map-canvas {
            width: 100%;
        }

        .map_wrapper {
            position: relative;
            width: auto;
            height: 600px;
            clear: both;
        }
    </style>

    <?php
    if ($current_lang == 'ar') {
        ?>
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAfiOWKHLx5YXuAITsfLqvvWTElyon6gqs&v=3.exp&sensor=true&libraries=places&language=ar"></script>
        <?php
    } else {
        ?>
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAfiOWKHLx5YXuAITsfLqvvWTElyon6gqs&v=3.exp&sensor=true&libraries=places&language=en"></script>
        <?php
    }
    ?>

    <script>
        var poly;
        var geodesicPoly;
        var marker1;
        var marker2;
        var map;
        var sharjah_airport = new google.maps.LatLng(25.3622222, 55.3911111);

        function initialize() {
            var mapOptions = {
                zoom: 3,
                minZoom: 2, maxZoom: 20,
                center: new google.maps.LatLng(20, 6),
            };

            map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
            map.controls[google.maps.ControlPosition.TOP_CENTER].push(document.getElementById('info'));

            $(window).resize(function () {
                google.maps.event.trigger(map, 'resize');
            });

            var polyOptions = {
                strokeColor: '#E41E26',
                strokeOpacity: 1.0,
                strokeWeight: 3,
                map: map,
            };
            poly = new google.maps.Polyline(polyOptions);

            var geodesicOptions = {
                strokeColor: '#E41E26',
                strokeOpacity: 1,
                strokeWeight: 1,
                geodesic: true,
                map: map
            };
            geodesicPoly = new google.maps.Polyline(geodesicOptions);

            //base marker
            addBaseMarker(25.3622222, 55.3911111);

            refreshIntervalId = setInterval(function () {
                add_marker_to_map()
            }, 1000);
        }

        function update(marker_position) {
            var path = [marker1.getPosition(), marker_position];
            //poly.setPath(path);
            geodesicPoly.setPath(path);
            var heading = google.maps.geometry.spherical.computeHeading(path[0],
                path[1]);
            document.getElementById('heading').value = heading;
            document.getElementById('origin').value = path[0].toString();
            document.getElementById('destination').value = path[1].toString();
        }

        google.maps.event.addDomListener(window, 'load', initialize);

        /*------------------------------------------------------------*/
        function addBaseMarker(currentCityLat, currentCityLang) {

            var iconBase = $("#watchtower_img").val();
            var base_airport_name = "Sharjah Airport";
            if ($('#map_lang').val() == "ar") {
                base_airport_name = "مطار الشارقة";
            }

            var myLatlng = new google.maps.LatLng(currentCityLat, currentCityLang);
            var infowindow_base = new google.maps.InfoWindow({
                content: base_airport_name
            });


            marker1 = new google.maps.Marker({
                position: myLatlng,
                map: map,
                title: base_airport_name,
                icon: iconBase,
                optimized: false
            });

            infowindow_base.open(map, marker1);

            google.maps.event.addListener(marker1, 'click', function () {
                if (infowindow_base) {
                    infowindow_base.close();
                }
                infowindow_base.open(map, marker1);
            });
        }


        var loop = 0;

        function add_marker_to_map() {
            cities_list = new Array();
            citiesLatLang_arr = new Array();

            cities_list_val = $('#cities').val();
            //cities_list_val.split(',',cities_list);
            cities_list = cities_list_val.split("^");

            /*---------get cities coords--------------*/
            if (loop < cities_list.length) {
                geocoder = new google.maps.Geocoder();
                var address = cities_list[loop];
                var add_name = address.split("(");
                //console.log(add_name[0]);
                geocoder.geocode({'address': add_name[0]}, function (results, status) {

                    if (status == google.maps.GeocoderStatus.OK) {
                        //console.log(address+'-'+status);
                        //console.log("Latitude: "+results[0].geometry.location.lat());
                        //console.log("Longitude: "+results[0].geometry.location.lng());
                        //alert("Latitude: "+results[0].geometry.location.lat());
                        //alert("Longitude: "+results[0].geometry.location.lng());
                        citiesLatLang_arr[loop] = results[0].geometry.location.lat();
                        citiesLatLang_arr[loop + 1] = results[0].geometry.location.lng();

                        //console.log(loop+":	"+citiesLatLang_arr[loop]+"  -   "+citiesLatLang_arr[loop+1]);

                        var currentCityLat = results[0].geometry.location.lat();
                        var currentCityLang = results[0].geometry.location.lng();
                        /*
                        var triangleCoords = [
                             new google.maps.LatLng(25.3622222, 55.3911111),
                             new google.maps.LatLng(currentCityLat/2, currentCityLang/2),
                             new google.maps.LatLng(currentCityLat, currentCityLang),
                         ];

                         // Construct the polygon.
                         bermudaTriangle = new google.maps.Polygon({
                           paths: triangleCoords,
                           strokeColor: '#FF0000',
                           strokeOpacity: 0.2,
                           strokeWeight: 1,
                           fillColor: '#FF0000',
                           fillOpacity: 0.2
                         });
                         bermudaTriangle.setMap(map);
                           setInterval(function(){},2000);
                           */

                        //show markers
                        addMarker(currentCityLat, currentCityLang, loop, address);

                    } else {
                        //console.log(address);
                        //console.log(address+": "+"Geocode was not successful for the following reason: " + status);
                    }
                });
            } else {
                //clearInterval(refreshIntervalId);
            }
            ++loop;
            if (loop >= cities_list.length) {
                clearInterval(refreshIntervalId);
                $(".map_loader").fadeOut('slow');
            }
        }


        var markers = Array();
        var infowindows = Array();

        function addMarker(currentCityLat, currentCityLang, cityNo, address) {

            var iconBase = $("#destination_img").val();
            var airlines_name = $("#airline_" + cityNo).val();
            var addr = address.split("-");

            var myLatlng = new google.maps.LatLng(currentCityLat, currentCityLang);
            var infowindow = new google.maps.InfoWindow({
                //content: ("<h1 class='airlines_head'>"+address+"</h1><p>Airline(s):&nbsp;"+airlines_name+"</p>")


                content: ("<h1 class='airlines_head'>" + addr[0] + "</h1>")
            });
            infowindows.push(infowindow);

            var marker = new google.maps.Marker({
                position: myLatlng,
                map: map,
                title: address,
                icon: iconBase,
                optimized: false,
                infoWindowIndex: cityNo
            });

            google.maps.event.addListener(marker, 'click', function (event) {
                for (var count = 0; count < infowindows.length; count++) {
                    infowindows[count].close();
                }

                infowindow.open(map, marker);
                var marker_position = event.latLng;

                //draw line
                update(marker_position);
                //load airport details
                load_airport_details(address);
            });
        }


        function load_airport_details(address) {

            var map_lang = $('#map_lang').val();
            var map_plugin_url = $('#map_plugin_url').val();
            $(".airport_details_screen").fadeTo("slow", 0.5);

            $.ajax({
                url: map_plugin_url + "sa_interactive_map_details.php",
                type: "POST",
                async: true,
                data: "address=" + address + "&language=" + map_lang,
                success: function (data, textStatus, jqXHR) {
                    $(".airport_details_screen").html("");
                    $(".airport_details_screen").html(data);

                    if ($(".airport_details_screen").width() < 5) {
                        $(".airport_details_screen").animate({width: '250px'}, 300);
                    }

                    $(".airport_details_screen").fadeTo("slow", 1);

                },
                error: function (data, textStatus, jqXHR) {
                    console.log('Smoething went wrong!');
                }
            });
        }
    </script>

    <?php
    //=================================================================
    //$filepath	= "http://www3.sharjahairport.ae/fids/w-e-e-k.xml";
    //$string = file_get_contents( $filepath );
    //=================================================================

    //$string = file_get_contents( ABSPATH.'notifications/arrival-departure-weekly-xml/on_week.xml');
    //ARRIVAL CURL
    /*$string_arrival 	=	'<flightSchedules xmlns="ShjFlightsAPI"><FromDate>'.date('d-m-Y',strtotime("-1 days")).'</FromDate><ToDate>'.date('d-m-Y',strtotime("+1 days")).'</ToDate><ArrivalOrDeparture></ArrivalOrDeparture></flightSchedules>';
    $ch_arrival 		=   curl_init('http://shjflights.sharjahairport.ae/shjFlightsAPI.svc/flightSchedules');

    curl_setopt($ch_arrival, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch_arrival, CURLOPT_HEADER, false);
    curl_setopt($ch_arrival, CURLOPT_POSTFIELDS, $string_arrival);
    curl_setopt($ch_arrival, CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch_arrival, CURLOPT_HTTPHEADER, array('Content-Type: application/xml','Content-Length: ' . strlen($string_arrival)));
    $result_arrival 	= curl_exec($ch_arrival);
    curl_close($ch_arrival);
    //#ARRIVAL CURL

    $response			=	simplexml_load_string($result_arrival);
    $xml				=	simplexml_load_string($response->flightSchedulesResult);



    foreach($xml AS $flight=>$flight_details){
        foreach($flight_details->Routing->AirportName AS $airport_name)
        {
            $citiesList[] = $airport_name;
        }
    }
    */

    include_once('../../../wp-config.php');
    global $wpdb;

    $citiesList = array();

    $sql = 'SELECT * FROM saa_flight_status_week';
    $flight_detail = $wpdb->get_results($sql, OBJECT);

    foreach ($flight_detail as $flight) {
        $citiesList[] = $flight->airport_name . '-' . $flight->flight_number;
    }

    $citiesList = array_unique($citiesList);
    $citiesList = implode("^", $citiesList);
    ?>

    <input type="hidden" id="map_lang" name="map_lang" value="<?php echo $current_lang; ?>"/>
    <input type="hidden" name="map_plugin_url" id="map_plugin_url" value="<?php echo plugin_dir_url(__FILE__); ?>">
    <input type="hidden" id="cities" name="cities" value="<?php echo $citiesList; ?>"/>
    <!--SAA google map-->

    <div class="map_loader"><?php echo ($current_lang == 'ar') ? 'جاري تحميل الخريطة' : 'Loading Map'; ?></div>
    <div class="map_wrapper">
        <div id="map-canvas"></div>
        <div class="airport_details_screen"></div>
    </div>
    <input type="hidden" id="destination_img" name="destination_img"
           value="<?php echo plugins_url('airport.png', __FILE__); ?>"/>
    <input type="hidden" id="watchtower_img" name="watchtower_img"
           value="<?php echo plugins_url('bullet.gif', __FILE__); ?>"/>

    <div id="panel" style="display: none;">
        Origin: <input type="text" readonly id="origin">
        Destination: <input type="text" readonly id="destination">
        Heading: <input type="text" readonly id="heading"> degrees
    </div>


    <div class="clear"></div>

    <?php
    /*
    foreach($cityDetails_arr AS $key=>$val)
    {
        ?>
        <input type="hidden" id="<?php echo 'airline_'.$key;?>" name="<?php echo 'airline_'.$key?>" value="<?php echo $val;?>" />
        <?php

    }
    */

    return ob_get_clean();
}

?>