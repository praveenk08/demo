<?php
 $this->load->view('vendor/includes/header');?>

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Dashboard
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Weather Forcasting</li>
      </ol>
    </section>
<?php

 //echo '<pre>';
 //print_r($response);
 // print_r($response->request->type);
  ?>
 
    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="box box-primary">
        <div class="box-body">
          <section class="hero">
            <div class="weather_animated">
              <input type="hidden" name="client_ip" value="223.233.104.95">

              <div class="location">
                <span data-api="location"><?php  echo $response->location->name. ' '.$response->location->region. ' '.$response->location->country;?></span>
              </div>

              <div class="main_left">
                <i data-api="current_icon" class="full_clouds" style="background-image:url(<?php echo $response->current->weather_icons[0]?>)"></i>
                <span data-api="current_main_descr"><?php  echo $response->current->weather_descriptions['0'];?></span>
              </div>

              <div class="main_right">
                <span data-api="current_wind_speed" class="wind">Wind: <?php  echo $response->current->wind_speed;?> kmph</span>
                <span data-api="current_precip" class="precip">Precip: <?php  echo $response->current->precip;?> mm</span>
                <span data-api="current_pressure" class="pressure">Pressure: <?php  echo $response->current->pressure;?> mb</span>
                <span data-api="current_temperature" class="temperature"><?php  echo $response->current->temperature;?>°c</span>
              </div>

              <div data-api="forecast_week" class="week">
                <!--<div class="day"><span class="name">THU</span><i class="partly_cloudy"></i><span class="temperature">30 °c</span>
                </div>
                <div class="day"><span class="name">FRI</span><i class="partly_cloudy"></i><span class="temperature">27 °c</span>
                </div>
                <div class="day"><span class="name">SAT</span><i class="partly_cloudy"></i><span class="temperature">26 °c</span>
                </div>
                <div class="day"><span class="name">SUN</span><i class="partly_cloudy"></i><span class="temperature">29 °c</span>
                </div>
                <div class="day"><span class="name">MON</span><i class="partly_cloudy"></i><span class="temperature">31 °c</span>
                </div>-->
              </div>
            
            </div>
          </section>
        </div>
      </div>
    </section>
      
  <?php
 
  $this->load->view('vendor/includes/footer');?>

  <style>
			.weather_animated{
				color: #111;
  max-width: 500px;
    margin:auto;
	position: relative;
	border-radius: 10px;
	border: 4px solid #3c8dbc;
	background: #f5f5f5;
}
 .weather_animated i {
	background: url(https://weatherstack.com/site_images/weather_icon_partly_cloudy.svg);
	background-size: cover;
	background-repeat: no-repeat;
	width: 80px;
	height: 70px;
	position: absolute;
}
/*.weather_animated i.partly_cloudy {
	background: url(https://weatherstack.com/site_images/weather_icon_partly_cloudy.svg);
	background-size: cover;
	background-repeat: no-repeat;
	top: 19px !important;
}
.weather_animated i.full_clouds {
	background: url(https://weatherstack.com/site_images/weather_icon_full_clouds.svg);
	background-size: cover;
	background-repeat: no-repeat;
	top: 19px !important;
}
.weather_animated i.night {
	background: url(https://weatherstack.com/site_images/weather_icon_night.svg);
	background-size: cover;
	background-repeat: no-repeat;
	top: 16px !important;
}
.weather_animated i.sun_rain_clouds {
	background: url(https://weatherstack.com/site_images/weather_icon_sun_rain_clouds.svg);
	background-size: cover;
	background-repeat: no-repeat;
	top: 15px !important;
}
.weather_animated i.full_sun {
	background: url(https://weatherstack.com/site_images/weather_icon_full_sun.svg);
	background-size: cover;
	background-repeat: no-repeat;
	top: 17px !important;
}
.weather_animated i.rainy {
	background: url(https://weatherstack.com/site_images/weather_icon_rainy.svg);
	background-size: cover;
	background-repeat: no-repeat;
	top: 13px !important;
}
.weather_animated i.cloud_slight_rain {
	background: url(https://weatherstack.com/site_images/weather_icon_cloud_slight_rain.svg);
	background-size: cover;
	background-repeat: no-repeat;
	top: 13px !important;
}
.weather_animated i.thunder {
	background: url(https://weatherstack.com/site_images/weather_icon_thunder.svg);
	background-size: cover;
	background-repeat: no-repeat;
	top: 0px;
} */
.weather_animated .location {display: block;height: 40px;text-align: center;padding-top: 15px;}
.weather_animated .location span {font-weight: bold;}
.weather_animated .main_left {float: left;width: 275px;height: 180px;}
.weather_animated .main_left i {
    background-size: cover;
    width: 140px;
    height: 137px;
    left: 22px;
    top: 40px !important;
}
.weather_animated .main_left span {position: absolute;top: 180px;left: 22px;font-weight: bold;width: 150px;text-align: center;}
.weather_animated .main_right {float: right;/* width: 215px; */height: 137px;padding-top: 26px;position: absolute;left: 67px;right: 37px;left: unset;}
.weather_animated .main_right span {
	display: block;
	margin-bottom: 2px;
	font-size: 13px;
}
.weather_animated .main_right .wind {

}
.weather_animated .main_right .precip {

}
.weather_animated .main_right .pressure {

}
.weather_animated .main_right .temperature {position: absolute;left: -135px;top: 33px;font-size: 32px;}
.weather_animated .week {clear: both;display: block;width: 100%;text-align: center;}
.weather_animated .week .day {display: inline-block;width: 95px;height: 107px;position: relative;}
.weather_animated .week .day .name {font-weight: 600;font-size: 12px;display: block;}
.weather_animated .week .day i {
    top: 14px;
    left: 16px;
    background-size: 60px;
}
.weather_animated .week .day .temperature {
    position: absolute;
    bottom: 11px;
    width: 100%;
    left: 2px;
    font-size: 14px;
    font-weight: 600;
}
.weather_animated.loading * {
	display: none;
}
.weather_animated.loading {
	background: #16394c url(https://weatherstack.com/site_images/sun_loading.svg);
	background-size: 100px;
	background-repeat: no-repeat;
	background-position: center;
	background-position-y: 75px;
}
.weather_animated.loading:after {
	content: 'Fetching data ...';
	color: #657f92;
	font-family: Promo,Helvetica,Arial,sans-serif;
	font-size: 17px;
	display: block;
	margin: 0 auto;
	text-align: center;
	position: relative;
	top: 160px;
}
		</style>
    