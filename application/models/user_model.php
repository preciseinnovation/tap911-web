<?php
$this->load->view('Header');
?>
<style>
 #overlay {
    position: fixed;
    display: none;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: rgba(0,0,0,0.5);
    z-index: 2;
    cursor: pointer;
}
</style>
<input type="hidden" id="from_lat" >
<input type="hidden" id="from_lng" >
<input type="hidden" id="to_lng"  >
<input type="hidden" id="to_lat" >
<input type="hidden" id="fist_add" >
<!-- TOP MENU-->
<div class="section top-header-menu">
  <div id="overlay" ></div>
  <div class="wrap-thm">
    <div class="container">
      <div class="row row-thm">
        <div class="col s12">
          <form>
            <table width="100%" border="0">
              <tbody>
                <tr class="tdpadding0">
                  <td rowspan="2" width="35"><img src="<?php echo base_url(); ?>img/from-to-icon.png" alt="IMG SRC" class="responsive-img"/></td>
                  <td><input id="from_address" type="text" placeholder="Your Starting Location" class="validate browser-default browser-default-text autocomplete"></td>
                </tr>
                <tr class="tdpadding0">
                  <td><input id="to_address" type="text" placeholder="Your Destination" class="validate browser-default browser-default-text autocomplete" onclick="disblediv()"></td>
                </tr>
              </tbody>
            </table>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- END TOP MENU-->
<div class="section top-header-menu top-header-menu-light">
  <div class="wrap-thm">
    <div class="container">
      <div class="row row-thm">
        <table width="100%" border="0" class="table">
          <tr>
            <td width="40"><img src="<?php echo base_url(); ?>img/depature-ico.png" alt=""/></td>
            <td align="left" valign="middle"><span class="white-color">Depart at: <input type="text" id="time_value"  class="timepicker browser-default browser-default-text TimeElement">  </span> </td>
            <td align="right"><a href="#" id="train_mode" class="btn btn-tiny mode_button"><i class="fa fa-train"></i> <small>Train</small></a> <a href="#" id="taxi_mode" class="btn btn-tiny mode_button"><i class="fa fa-taxi"></i> <small>Taxi</small></a> <a href="#" id="bus_mode" class="btn btn-tiny mode_button"><i class="fa fa-bus"></i> <small>Bus</small></a></td>
          </tr>
        </table>
      </div>
    </div>
  </div>
</div>
<div id="page-content" style="display: none;">
  <div class="section news">
    <div class="container">
      <div class="row">
        <div class="col s12" id="list_route">
        </div>
      </div>
    </div>
  </div>
  </div>
<div id='map'></div>
<div class="row">
  <div class="col s6"> <a href="#" ><img src="<?php echo base_url(); ?>img/getRouteNav.png" alt="" style="padding-top:12px;"/></a> </div>
  <div class="col s6">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><a href="#"><img src="<?php echo base_url(); ?>img/walking.png" alt=""/></a></td>
        <td><a href="#"><img src="<?php echo base_url(); ?>img/bus.png" alt=""/></a></td>
        <td><a href="#"><img src="<?php echo base_url(); ?>img/Train_icon.png" alt=""/></a></td>
        <td><a href="#"><img src="<?php echo base_url(); ?>img/bybus.png" alt=""/></a></td>
      </tr>
    </table>
  </div>
</div>
<?php
$this->load->view('footer');
?>
<script src='https://api.tiles.mapbox.com/mapbox-gl-js/v0.44.2/mapbox-gl.js'></script> 
<script>
  mapboxgl.accessToken = 'pk.eyJ1Ijoic2FzaGlrYW50YSIsImEiOiJjamZ3b291dmwxNWo2MnFteWl1eW5uMHR6In0.gFz5IkWSCPG8zVIv1oLt7w';
  var map = new mapboxgl.Map({
    container: 'map', // container id
    style: 'mapbox://styles/mapbox/streets-v9', // stylesheet location
    center: [-74.50, 40], // starting position [lng, lat]
    zoom: 9 // starting zoom
  });
</script>
<script>
$('.timepicker').pickatime({
    default: 'now', // Set default time: 'now', '1:30AM', '16:30'
    fromnow: 0,       // set default time to * milliseconds from now (using with default = 'now')
    twelvehour: true, // Use AM/PM or 24-hour format
    donetext: 'OK', // text for done-button
    cleartext: 'Clear', // text for clear-button
    canceltext: 'Cancel', // Text for cancel-button
    autoclose: false, // automatic close timepicker
    ampmclickable: true, // make AM PM clickable
    aftershow: function(){} //Function for after opening timepicker
  });
</script>
<script>
    var swiper = new Swiper('.swiper-container', {
    slidesPerView: 3,
    spaceBetween: 5,
      scrollbar: {
        el: '.swiper-scrollbar',
        hide: true,
      },
    });
</script>
<script>
    $(function () {
      $('.showSingle').click(function(){
          $('.targetDiv').hide();
          $('#div'+$(this).attr('target')).show();
      });
  });
</script>

<script src="<?php echo base_url(); ?>js/swiper.min.js"></script> 
<script>
      $("document").ready(function(){
        $(".mode_button").click(function(){
            if($(this).hasClass("btn-disabled")){
                $(this).addClass("btn-tiny").removeClass("btn-disabled");
            }else{
               $(this).addClass("btn-tiny").removeClass("btn-primary");
            }
            Check_route();
        });
      });

      var map=null;
      var markers = [];
      var all_data=null;
      var cheapest_cost=null;
      var fastest_rotute=null;
      var bounds =null;
    function initMap() {
         map = new google.maps.Map(document.getElementById('map'), {
          center: {lat:  2.3185, lng:  28.047 },
          zoom: 04
        });
            var input = document.getElementById('from_address');
            var autocomplete = new google.maps.places.Autocomplete(input);
            autocomplete.bindTo('bounds', map);
            
            autocomplete.addListener('place_changed', function() {
              map.setZoom(18);
              var marker = new google.maps.Marker({
                map: map,
                anchorPoint: new google.maps.Point(0, -29)
              });
              marker.setVisible(false);
              var place = autocomplete.getPlace(); 
              if (place.geometry.viewport) {
                map.fitBounds(place.geometry.viewport);
              } else {
                map.setCenter(place.geometry.location);
                map.setZoom(17);  // Why 17? Because it looks good.
              }
              var lat = place.geometry.location.lat();
              var lng = place.geometry.location.lng();
              $('#from_lat').val(lat);
              $('#from_lng').val(lng);


              marker.setPosition(place.geometry.location);
              marker.setVisible(true); 
              Check_route();
            }); 
            var input2 = document.getElementById('to_address');
            var autocomplete2 = new google.maps.places.Autocomplete(input2);
            autocomplete2.bindTo('bounds', map);
            
            autocomplete2.addListener('place_changed', function() {
              var marker = new google.maps.Marker({
              map: map,
              anchorPoint: new google.maps.Point(0, -29)
            });
             markers.push(marker);
              marker.setVisible(false);
              var place = autocomplete2.getPlace(); 
              if (place.geometry.viewport) {
                map.fitBounds(place.geometry.viewport);
              } else {
                map.setCenter(place.geometry.location);
                map.setZoom(17);  // Why 17? Because it looks good.
              }
              var lat = place.geometry.location.lat();
              var lng = place.geometry.location.lng();
               $('#to_lat').val(lat);
              $('#to_lng').val(lng);
              marker.setPosition(place.geometry.location);
              marker.setVisible(true);
              console.log("place_changed");
              Check_route();
            /*  var address = '';
              if (place.address_components) {
                address = [
                  (place.address_components[0] && place.address_components[0].short_name || ''),
                  (place.address_components[1] && place.address_components[1].short_name || ''),
                  (place.address_components[2] && place.address_components[2].short_name || '')
                ].join(' ');
              }*/
            }); 
        
      }
function Check_route(){
        
        var from_lng=$('#from_lng').val();
        var from_lat=$('#from_lat').val();
        var to_lats = $('#to_lat').val();
        var to_lngs = $('#to_lng').val();
        var time_value = $('#time_value').val();
        var modes=[];
        var train_mode= ($('#train_mode').hasClass('btn-primary'))? '1': '0';
        var taxi_mode= ($('#taxi_mode').hasClass('btn-primary'))? '1': '0';
        var bus_mode= ($('#bus_mode').hasClass('btn-primary'))? '1': '0';
        modes.push(train_mode);
        modes.push(taxi_mode);
        modes.push(bus_mode);
        modes= JSON.stringify(modes);
        if(from_lng !="" && from_lat!="" && to_lats!="" && to_lngs!=""){
          $('#overlay').show();
         $.ajax({
                type: "POST",
                url: '<?php echo site_url(); ?>' + "/planner/Get_routes",
                data:{
                  to_lat:to_lats,
                  to_lng:to_lngs,
                  from_lat:from_lat,
                  from_lng:from_lng,
                  modes:modes,
                  time_value:time_value
                },
                dataType: 'json',
                success: function (results)
                {
                  console.log(results);

                      if(results.result == "false"){
                        //give error
                        alert("No results found");
                         $('#list_route').html('');
                        // $("#info_div").html('');
                        clear_map();
                      }else{
                        //alert("hello222");
                        
                        all_data=results.travel_path;
                        var main_json = results.travel_path;
                         cheapest_cost= results.chipest_cost;
                        fastest_rotute= results.min_duration;
                         var w_html="";
                           $.each(main_json, function(i, item) {
                             w_html+=create_route_html(i,item);
                           });
                          $('#list_route').html(w_html);
                      }
                      $('#overlay').hide();
                }
          });
        }
      }


      function create_route_html(i,routes){
            var html="";
            html+='<a id="list_'+i+'" onclick="create_route_map('+i+')" class="list-group-item flex-column align-items-start" >';
              html+='<div class="news-content  wallet">';
              html+='<div class="news-detail">';
              html+='<div class="swiper-container">';
              html+='<div class="swiper-wrapper">';
              html+='<div class="swiper-slide">';
              $.each(routes.route, function(i, route) {

                
                    if(route.type=="Walking"){
                      html+= '<img src="/img/walking.png" style="opacity:0.6">';
                    }else if(route.type=="Rail"){
                      html+= '<h5 class="news-title"><i class="fa fa-male"></i><small>M</small>&gt;</h5>';
                    }else if(route.type=="Bus"){
                      html+='<h5 class="news-title"><i class="fa fa-bus"></i><small>M</small>&gt;</h5>';
                    }else{
                      html+='<h5 class="news-title"><i class="fa  fa-taxi"></i><small>M</small>&gt;</h5>';
                    }
                    html+= route.distance+'<strong> ></strong>'; 

              });
              html+='</div></div>';
              html+='<div class="swiper-scrollbar"></div>';
             
             if(routes.final_distance > 1000){
              var d=(routes.final_distance/1000);
              var km= d.toFixed(1)+ 'km';
             }else{
              var km=routes.final_distance.toFixed(1)+' m'; 
             }
              html+='<div class="col s5 tdpadding5">';
              html+='<div class="display-btn marginTop10"> '+km+' </div>';
              html+='</div>';
              html+='div class="col s3 tdpadding5">';
                html+='<div class="display-btn marginTop10"> R'+routes.final_cost+' </div>';
               html+='</div>';
            if(cheapest_cost==routes.final_cost ){

           html+='<div class="col s2"> <img src="<?php echo base_url(); ?>img/cheapest.png" alt="cheapest"/> </div>';
              html+='<div class="col s3"><a href="#" class="showSingle" target="1"><img src="<?php echo base_url(); ?>img/i-icon.png" alt="" class="grid-img"/> </a></div>';
               html+='<div class="col s3"><a href="direction.html"><img src="<?php echo base_url(); ?>img/right-sign-icon.png" alt="" class="grid-img"/></a> </div>';

          }else if(routes.final_distance==fastest_rotute){
             html+='<div class="col s2"> <img src="<?php echo base_url(); ?>img/fastest.png" alt="cheapest"/> </div>';
              html+='<div class="col s3"><a href="#" class="showSingle" target="1"><img src="<?php echo base_url(); ?>img/i-icon.png" alt="" class="grid-img"/> </a></div>';
               html+='<div class="col s3"><a href="direction.html"><img src="<?php echo base_url(); ?>img/right-sign-icon.png" alt="" class="grid-img"/></a> </div>';
          }
            html+='</div>';
            html+='<div class="row">';
            html+='<table width="100%" class="table margin-bottom-none">';
            html+='<tr>';
            html+='<td align="left"><a  onclick="show_info('+i+')" ><img src="<?php echo base_url(); ?>img/i-icon.png" alt=""/></a></td>';
            html+='<td align="center"><a  onclick="create_info('+i+')" ><img src="<?php echo base_url(); ?>img/right-sign-icon.png" alt=""/></a></td>';
              var hhmm=SecondsTohhmmss(routes.final_duration);
             html+='<div class="col s6 txtMinutes"> <span class="txtMinutes">'+hhmm+'</span></div>';
             html+='</div>';
            html+='<div class="clearfix"></div>';
             html+='</div>';
             html+='<div class="news-content slideBox targetDiv" id="div1">';
             html+='<div class="news-detail">';
             html+='<div class="col s12">';
                 html+='<table width="100%" border="0" class="table striped">';
                   html+='<tbody>';
                     html+='<tr class="tdpadding0">';
                     $.each(routes.info_data, function(i, infos) {
                $.each(infos, function(i,info){
                      if(info.type=="walk"){
                        html+='<td width="40%" class="blue-text">Walking</td>';
                      }else{
                      html+='<td>'+info.train+'</td>';
                   } 
                   html+='</tr>';
                   html+='</tbody>';
                     });
                   });
                 html+='</table>';
               html+='</div>';
             html+='<div class="clearfix"></div>';
             html+='</div>';
            html+='</div>';
            html+='<div class="clearfix"></div>';
            html+='</a>';
            return html;
      }
         function SecondsTohhmmss(totalSeconds) {
    var hours   = Math.floor(totalSeconds / 3600);
    var minutes = Math.floor((totalSeconds - (hours * 3600)) / 60);
    var seconds = totalSeconds - (hours * 3600) - (minutes * 60);

    // round seconds
    seconds = Math.round(seconds * 100) / 100

    var result = (hours < 10 ? "0" + hours : hours);
        result += " hour(s)" + (minutes < 10 ? "0" + minutes : minutes) + ' minute(s)'; 
    return result;
  }
</script>
<script>
    var routes_map_array=[];
      function create_route_map(results){

        bounds = new google.maps.LatLngBounds();
        console.log(all_data[results]);
          for (var i = 0; i < markers.length; i++) {
            markers[i].setMap(null);
          }
          for (var i = 0; i < routes_map_array.length; i++) {
            routes_map_array[i].setMap(null);
          }
          var from_lng=$('#from_lng').val();
          var from_lat=$('#from_lat').val();
          var to_lats = $('#to_lat').val();
          var to_lngs = $('#to_lng').val();
            var first_lat = {lat: parseFloat(from_lat), lng: parseFloat(from_lng)};
            var marker = new google.maps.Marker({
                      position: first_lat,
                      map: map, 
            });
            bounds.extend( marker.getPosition() );
            markers.push(marker);
            var last_lat = {lat: parseFloat(to_lats), lng: parseFloat(to_lngs)};
            var marker = new google.maps.Marker({
                      position: last_lat,
                      map: map, 
            });
            markers.push(marker);
            bounds.extend( marker.getPosition() );
               map.fitBounds(bounds);


          $.each(all_data[results].map_data, function(i, map_array) {
            var type= all_data[results].route[i]['type'];
            if(type=="Walking"){
              var color="#f48100";
            }else if(type=='Rail'){
              var color="#16519e";
            }else if(type=='Bus'){
              var color="#a9e5f9";
            }else{
              var color="#f21461";
            }
            console.log(type);
            var dataArray = [];
              $.each(map_array, function(i, map_lng) {
                var stuff={};
                stuff['lat']=map_lng[1];
                stuff['lng']=map_lng[0];
                dataArray.push(stuff);
                 
              });

              // Define a symbol using SVG path notation, with an opacity of 1.
              var lineSymbol = {
                path: 'M 0,-1 0,1',
                strokeOpacity: 1,
                scale: 4
              };
              if(type=="Walking"){
                  var flightPath = new google.maps.Polyline({
                    path: dataArray,
                    geodesic: true,
                    strokeColor:color,
                    strokeOpacity: 0,
                    strokeWeight: 2,
                     icons: [{
                      icon: lineSymbol,
                      offset: '0',
                      repeat: '20px'
                    }],
                  }); 
                  invisiblePolyline = new google.maps.Polyline({
            path: dataArray,
            strokeColor: "#0000FF",
            strokeOpacity: 0.0,
            strokeWeight: 20
          });

              }else{
                  var flightPath = new google.maps.Polyline({
                    path: dataArray,
                    geodesic: true,
                    strokeColor:color,
                    strokeOpacity: 1.0,
                    strokeWeight: 2,
                     
                  }); 
                  invisiblePolyline = new google.maps.Polyline({
            path: dataArray,
            strokeColor: "#0000FF",
            strokeOpacity: 0.0,
            strokeWeight: 20
          });
              }
               
              routes_map_array.push(flightPath);
              flightPath.setMap(map);
              invisiblePolyline.setMap(map);
               google.maps.event.addListener(invisiblePolyline, 'mouseover', function (event) {
          flightPath.setOptions({
            strokeWeight: 5,
          });
        });

        google.maps.event.addListener(invisiblePolyline, 'mouseout', function (event) {
          flightPath.setOptions({
            strokeWeight: 2,
          });
        });
        google.maps.event.addListener(invisiblePolyline, "click", function(){
                create_info(results);
               });
          });
          $('html, body').animate({
            scrollTop: $("#map").offset().top-100
        }, 1000);
      
      }

      function newLocation(newLat,newLng)
{
  map.setCenter({
    lat : newLat,
    lng : newLng
  });
}
function clear_map()
{
 for (var i = 0; i < markers.length; i++) {
            markers[i].setMap(null);
          }
          for (var i = 0; i < routes_map_array.length; i++) {
            routes_map_array[i].setMap(null);
          } 
}
</script>
<script type="text/javascript">
  function disblediv(){
    document.getElementById('page-content').style.display='block';
  }
</script>
 <script  src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDEKSZpSji-0332YHJoMpRAJNPKzaQv36A&libraries=places&callback=initMap&region=ZA"
        async defer></script>
<script src="<?php echo base_url();?>js/swiper.min.js"></script> 
  <script>
  
  $('.timepicker').pickatime({
    default: 'now', // Set default time: 'now', '1:30AM', '16:30'
    fromnow: 0,       // set default time to * milliseconds from now (using with default = 'now')
    twelvehour: true, // Use AM/PM or 24-hour format
    donetext: 'OK', // text for done-button
    cleartext: 'Clear', // text for clear-button
    canceltext: 'Cancel', // Text for cancel-button
    autoclose: false, // automatic close timepicker
    ampmclickable: true, // make AM PM clickable
    aftershow: function(){} //Function for after opening timepicker
  });
  </script>
  
<script>
    var swiper = new Swiper('.swiper-container', {
    slidesPerView: 3,
    spaceBetween: 5,
      scrollbar: {
        el: '.swiper-scrollbar',
        hide: true,
      },
    });
</script>
<script>
    $(function () {
      $('.showSingle').click(function(){
          $('.targetDiv').hide();
          $('#div'+$(this).attr('target')).show();
      });
  });
</script> 