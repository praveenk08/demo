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
                <input type="hidden" name="longitude" id="longitude" value="77.3910">
                <input type="hidden" name="latitude" id="latitude" value="28.5355">
            	</form>
                
			</div>
			<?php
			 $this->load->view('website/includes/footer');
            ?>
              
            <script>
 
            function initMap() 
            {
                let latitude=parseFloat(document.getElementById('latitude').value);
                let longitude=parseFloat(document.getElementById('longitude').value);
                let input = document.getElementById('your_address');
                                              
                map = new google.maps.Map(document.getElementById('map'), {
                    center: {lat:latitude,lng:longitude},
                    zoom: 10
                });
               
                var marker = new google.maps.Marker({
                    position: {lat:latitude,lng:longitude},
                    map: map,
                    title: input.value.length?input.value:''
                });
                
                // autocomplete starts
                let options = {
                    types: ['(regions)'],
                    componentRestrictions: {country:"IN"}
                };
                
                let autocomplete = new google.maps.places.Autocomplete(input,options);
                
                google.maps.event.addDomListener(input, 'keydown', function(event) { 
                    if (event.keyCode == 13) { 
                        event.preventDefault(); 
                        return false;
                    }
                }); 

                google.maps.event.addListener(autocomplete, 'place_changed', function () {
                    var place = autocomplete.getPlace();
                    if(place)
                    {
                        
                        var lat = place.geometry.location.lat();
                        var long = place.geometry.location.lng();
                        document.getElementById('longitude').value=long;
                        document.getElementById('latitude').value=lat;
                        initMap();
                    }
                    
                });

               
                // autocomplete ends
            }

            function getLocation() 
            {
                

                function success(position) {
                    let latitude  = position.coords.latitude;
                    let longitude = position.coords.longitude;
                    let geolocation=latitude+','+longitude;
                    $.getJSON("https://maps.googleapis.com/maps/api/geocode/json?key=AIzaSyBPOxoqGdov5Z9xJw1SMVa_behLLSPacVM&latlng="+geolocation+"&sensor=false", function(result){
                        $("#your_address").val(result.results[0].formatted_address);
                    });
                    //alert(latitude+" "+longitude);
                    //console.log(position);
                    document.getElementById('longitude').value=longitude;
                    document.getElementById('latitude').value=latitude;
                    initMap();
                };

                function error() {
                    initMap();
                    alert("Unable to retrieve your location");
                };
                navigator.geolocation.getCurrentPosition(success, error);
            }
            getLocation();

                
    $(function(){
        
        $('#register_now').click(function(){
            $('#change_address').val($('#your_address').val());
            $('#registration_page').submit();
        })
    })
    </script>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBPOxoqGdov5Z9xJw1SMVa_behLLSPacVM&callback=initMap&libraries=places">
    </script>
 