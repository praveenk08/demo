<?php
$this->load->view('website/includes/header');
?>	
<?php
			if(is_file('attachments/pages/main/'.$page['banner_image'])){
				$image=base_url('attachments/pages/main/'.$page['banner_image']);
			}else{
				$image=base_url('assets/frontend/images/hsbanner.jpg');
            }
            ?>	

  <!-- Top Banner scetion -->
  <div class="topBanner" style="background-image: url('<?php echo $image;?>');">
					<div class="container-fluid">
						<div class="topBContent">
							<h1><?php echo $page['name'];?></h1>
							<p><?php echo $page['banner_title'];?></p>
						</div>
					</div>
				</div>
            


			<!-- Main body wrapper -->
			<div class="mainBody position-relative">
                <div class="changeLoc" style="position: absolute; top: 10px; right: 55px; max-width:400px; z-index:1;">
                    <div class="card shadow">
                        <div class="card-body text-center">

                            <div class="form-group"><input type="text" id="your_address" class="form-control w-100" placeholder="Your location" style="min-width:300px;"></div>
                            <button class="btn signupBtn bg-warning text-dark" name="register_now" id="register_now" >Continue</button>
                        </div>
                    </div>
					
				</div>

				<div class="msMap">
                <div id="map" style="height: 400px; width:100%;"></div>
					<!--<iframe src="https://www.google.com/maps/embed" width="100%" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>-->
                </div>
                <form method="POST" id="registration_page" action="<?php echo base_url('registration-step-three');?>">
                <input type="hidden" name="role_id" id="role_id" value="<?php echo $role;?>">
                <input type="hidden" name="change_address" id="change_address" value="">
                <input type="hidden" name="longitude" id="longitude" value="">
                <input type="hidden" name="latitude" id="latitude" value="">
            	</form>
                
			</div>
			<?php
			 $this->load->view('website/includes/footer');
            ?>
              
            <script>

        function initMap() {


            var map = new google.maps.Map(document.getElementById('map'), {zoom: 10,'region':'IN'});
             var marker = new google.maps.Marker({map: map});
             var input = document.getElementById('your_address');
	
	
//              var options = {
// 	types: ['(regions)'],
// 	componentRestrictions: {country:'in'}
// };

// var autocomplete = new google.maps.places.Autocomplete(input,options);
// 	google.maps.event.addListener(autocomplete, 'place_changed', function () {
   
// 	var place = autocomplete.getPlace();
// 	if(place)
// 	{
// 	  var lat = place.geometry.location.lat();
// 	  var long = place.geometry.location.lng();
// 	  $("#longitude").val(long);
// 	  $("#latitude").val(lat);
//  	}
// 	// google.maps.event.trigger(map, 'resize');
//     });
    


            
        }
        function processGeolocationResult(position) {
            html5Lat = position.coords.latitude; //Get latitude
            html5Lon = position.coords.longitude; //Get longitude
            html5TimeStamp = position.timestamp; //Get timestamp
            html5Accuracy = position.coords.accuracy; //Get accuracy in meters

            var uluru = {lat: html5Lat, lng: html5Lon};
            var map = new google.maps.Map(
            document.getElementById('map'), {zoom: 10, center: uluru});
            var marker = new google.maps.Marker({position: uluru, map: map});
            return (html5Lat).toFixed(8) + ", " + (html5Lon).toFixed(8);
            
         }

        function initializeCurrent(latcurr, longcurr) {
            currgeocoder = new google.maps.Geocoder();
            console.log(latcurr + "-- ######## --" + longcurr);
            if (latcurr != '' && longcurr != '') {
                var myLatlng = new google.maps.LatLng(latcurr, longcurr);
                return getCurrentAddress(myLatlng);
            }
        }
        function getCurrentAddress(location) {
            currgeocoder.geocode({
             'location': location
            }, function(results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                 $("#your_address").val(results[0].formatted_address);
            } else {
                alert('Geocode was not successful for the following reason: ' + status);
            }
        });
     }
 
               // var x = document.getElementById("demo");
    function getLocation() 
    {
        

        function success(position) {
            navigator.geolocation.getCurrentPosition(function(position, html5Error) {
            geo_loc = processGeolocationResult(position);
            currLatLong = geo_loc.split(",");
            initializeCurrent(currLatLong[0], currLatLong[1]);
            });
        };

        function error() {
            initMap();
           alert("Unable to retrieve your location");
        };
        navigator.geolocation.getCurrentPosition(success, error);
    }
            
                
    $(function(){
        //getLocation();
        $('#register_now').click(function(){
            $('#change_address').val($('#your_address').val());
            $('#registration_page').submit();
        })
    })
    </script>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBPOxoqGdov5Z9xJw1SMVa_behLLSPacVM&callback=initMap">
    </script>
 