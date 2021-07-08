
	function makeTrim(x) {
		if (x) {
			return x.replace(/^\s+|\s+$/gm, '');
		} else {
			return x;
		}
	}

	function validEmail(email) {
		var re = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
		return re.test(email);
	}
	function addRemoveWishList(id){
		$.ajax({
				type: 'POST',
 				url: urls.addRemoveWishlist,
				data:{
					'product_id':id,
				},
				success: function (ajaxresponse) {
					response=JSON.parse(ajaxresponse);
					if(response['status']){
						$('#'+id).html('<i class="fas fa-heart"></i>');
					}else{
						$('#'+id).html('<i class="far fa-heart"></i>');
					}
					$('#wish_counter').html(response['total_wishlist']);
					$('#success_message').html('<div class="alert alert-success">'+response['message']+'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
					closePopup('success_message');
				}
			});
		}
		function addProductToCart(product_id,quantity=1){
			$.ajax({
				type: 'POST',
				url: urls.addProductToCart,
				data:{
					'quantity':quantity,
					'product_id':product_id,
				 },
				success: function (ajaxresponse) {
					response=JSON.parse(ajaxresponse);
					if(response['status']){
						$('#success_message').html('<div class="alert alert-success">'+response['message']+'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
						$('#added'+product_id).html('Added');
					}else{
						$('#success_message').html('<div class="alert alert-danger">'+response['message']+'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
 					}
					closePopup('success_message');
					$('#cart_counter').html(response['total_cart']);
				}
			});	
		}
    function closePopup(id){
		//$("html, body").animate({ scrollTop: 0 }, "slow");
		$("#"+id).fadeTo(5000, 500).slideUp(500, function(){
			$("#"+id).slideUp(5000);
			 });
	}
	function ChangeUrl(page, url) {
		if (typeof (history.pushState) != "undefined") {
				var obj = { Page: page, Url: url };
				history.pushState(obj, obj.Page, obj.Url);
		}
	}

	
	function loginForgot(id){
		$('#login_btn').removeAttr("disabled");
		$('#forgot_btn').removeAttr("disabled");
		$('#forgot_password_form input').css('border', '1px solid #ccc');
		$('#login_form input').css('border', '1px solid #ccc');
		$('#login_form').trigger("reset");
		$('#registration_form').trigger("reset");
		$('.success').html('');
		$('.error').html('');
		if(!id){
			$('#login_part').hide();
			$('#forgot_password_part').show();
		}else{
			$('#login_part').show();
			$('#forgot_password_part').hide();
		}
	}
	
	function changeLanguage(value){
		$.ajax({
			type: "POST",
			url: urls.changeLanguage,
			data: {'id':value},
			success: function(ajaxresponse){
 			location.reload();	 
			}
		});
	}

	function showHideData(id){
		var show_hide_status= $('#show_hide_status'+id).val();
		if(show_hide_status==0){
			$('#discription'+id).show();
 			$('#show_hide_btn'+id).html('<img src="'+urls.base_url+'/assets/frontend/images/details_close.png">');
			$('#show_hide_status'+id).val(1);
		}else{
			$('#show_hide_status'+id).val(0);
			$('#show_hide_btn'+id).html('<img src="'+urls.base_url+'/assets/frontend/images/details_open.png">');
			$('#discription'+id).hide();

		  }
	 }
function deleteProfilePhoto(url){
	$('#removeProfilePhotoPouup').modal('hide');
	$.ajax({
		type: "POST",
		data:{'id':1},
		url: url,
 		success: function(ajaxresponse){
			  response=JSON.parse(ajaxresponse);
			if(!response['status']){
				$('#success_message').html('<div class="alert alert-danger">'+response['message']+'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
			}else{ 
				$('#image_preview').html('');
				$('#success_message').html('<div class="alert alert-success">'+response['message']+'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
				setTimeout(function(){
					location.reload();	 
				}, 3000);
			}  
		}
	});
}
function DeleteRecord(id){
	$('#deleteRecordPouup').modal('show');
	$('#action_id').val(id);
	$('#delete_record_confirmation_message').html('Are you sure want to delete this record?');
}
function deleteActionPerform(url){
	$('#deleteRecordPouup').modal('hide');
	$.ajax({
		type: "POST",
		url: url,
		data: {'action_id':$('#action_id').val()},
		success: function(ajaxresponse){
			  response=JSON.parse(ajaxresponse);
			if(!response['status']){
				$('#success_message').html('<div class="alert alert-danger">'+response['message']+'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
			}else{
				$('#success_message').html('<div class="alert alert-success">'+response['message']+'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
				setTimeout(function(){
					location.reload();
					},1000);
				   
			}  
		}
	});

}


$(function(){

	

	$(".allownumericwithoutdecimal").on("keypress keyup blur",function (event) {    
		$(this).val($(this).val().replace(/[^\d].+/, ""));
		if ((event.which < 48 || event.which > 57)) {
				event.preventDefault();
		}
});


$('#change_country').change(function(){
 	$('#change_state').html('');
	var change_state_html="<option value=''>Select State</option>";
	var change_city_html="<option value=''>Select City</option>";
	var country_id=this.value;
	if(country_id!=''){
		$.ajax({
			type: "POST",
			url: urls.changeCountryGetState,
			data: {'country_id':country_id},
			 success: function (ajaxresponse) {
				response = JSON.parse(ajaxresponse);
				if(response.length){
					for(i=0;i<response.length;i++){
						change_state_html +='<option value="'+response[i]['id']+'">'+response[i]['name']+'</option>';
					}
				}
				$('#change_state').html(change_state_html);
				$('#change_city').html(change_city_html);
			}
		});
	}else{
		$('#change_state').html(change_state_html);
		$('#change_city').html(change_city_html);
	}
});

$('#change_state').change(function(){
	$('#change_city').html('');
	 var change_city_html="<option value=''>Select City</option>";
	var state_id=this.value;
	if(state_id!=''){
		$.ajax({
			type: "POST",
			url: urls.changeStateGetCity,
			data: {'state_id':state_id},
			 success: function (ajaxresponse) {
				response = JSON.parse(ajaxresponse);
				if(response.length){
					for(i=0;i<response.length;i++){
						change_city_html +='<option value="'+response[i]['id']+'">'+response[i]['name']+'</option>';
					}
				}
				 $('#change_city').html(change_city_html);
			}
		});
	}else{
		 $('#change_city').html(change_city_html);
	}
});
	var current_url=window.location.href;
	if(current_url!=urls.base_url){
 		$('.header').removeClass();
	}

	$('#delete_photo').click(function(){
		$('#removeProfilePhotoPouup').modal('show');
 		$('#delete_profile_image_confirmation_message').html('Are you sure want to delete your photo?');
	})
	
	
	$('#add_btn').click(function(){
		$('#add_btn').attr("disabled", true);
		$('#registration_form input,select').css('border', '1px solid #ccc');
		$('#success_message').html('');
		$('.error').html('');
		$.ajax({
			type: "POST",
			url: urls.addUser,
			data: $('#registration_form').serialize(),
			success: function(ajaxresponse){
				  response=JSON.parse(ajaxresponse);
				if(!response['status']){
					$.each(response['response'], function(key, value) {
						$('#' + key).css('border', '1px solid #cc0000');
						$('#'+key+'_error').html(value);
					});
					$('#success_message').html('<div class="alert alert-danger">'+response['message']+'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
					$('#add_btn').removeAttr("disabled");
				}else{
					$('#success_message').html('<div class="alert alert-success">'+response['message']+'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
					$('#registration_form').trigger("reset");
					$('#add_btn').removeAttr("disabled");
					setTimeout(function(){
						$('#success_message').html('');
						window.location.href = urls.base_url; 
						}, 5000);
					   
				}  
			}
		});
	});

	$('#login_btn').click(function(){
 		$('#login_btn').attr("disabled", true);
		$('#login_form input').css('border', '1px solid #ccc');
		$('#success_message').html('');
		$('.error').html('');
		$.ajax({
			type: "POST",
			url: urls.login,
			data: $('#login_form').serialize(),
			success: function(ajaxresponse){
				response=JSON.parse(ajaxresponse);
				if(!response['status']){
					$.each(response['response'], function(key, value) {
 						$('#' + key).css('border', '1px solid #cc0000');
						$('#'+key+'_error').html(value);
 					});
					$('#success_message').html('<div class="alert alert-danger">'+response['message']+'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
					$('#login_btn').removeAttr("disabled");
				}else{
 					$('#success_message').html('<div class="alert alert-success">'+response['message']+'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
					$('#forgot_password_form').trigger("reset");
					$('#login_btn').removeAttr("disabled");
					setTimeout(function(){
						$('#success_message').html('');
						if(response['ch_url']!=''){
							window.location.href = response['ch_url']; 
						}else{
							window.location.href = response['url']; 
						}
					}, 1000);
					   
				}  
			}
		});
	});

	   $('#change_password_btn').click(function(){
 	   $('#change_password_btn').attr("disabled", true);
	   $('#change_password_form input').css('border', '1px solid #ccc');
	   $('#success_message').html('');
	   $('.error').html('');
	   $.ajax({
		   type: "POST",
		   url: urls.changePassword,
		   data: $('#change_password_form').serialize(),
		   success: function(ajaxresponse){
			   response=JSON.parse(ajaxresponse);
			   if(!response['status']){
				   $.each(response['response'], function(key, value) {
						$('#' + key).css('border', '1px solid #cc0000');
					   $('#'+key+'_error').html(value);
					});
				   $('#success_message').html('<div class="alert alert-danger">'+response['message']+'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
				   $('#change_password_btn').removeAttr("disabled");
			   }else{
				   $('#success_message').html('<div class="alert alert-success">'+response['message']+'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
				   $('#change_password_form').trigger("reset");
				   $('#change_password_btn').removeAttr("disabled");
				   setTimeout(function(){
				   $('#success_message').html('');
					window.location.href = urls.loginForm; 
					}, 5000);
			   }  
		   }
	   });
   });
	

	$('#forgot_btn').click(function(){
		$('#forgot_btn').attr("disabled", true);
		$('#forgot_password_form input').css('border', '1px solid #ccc');
		$('#forgot_success_message').html('');
		$('.error').html('');
		$.ajax({
			type: "POST",
			url: urls.forgotPassword,
			data: $('#forgot_password_form').serialize(),
			success: function(ajaxresponse){
				  response=JSON.parse(ajaxresponse);
				if(!response['status']){
					$.each(response['response'], function(key, value) {
 						$('#' + key).css('border', '1px solid #cc0000');
						$('#'+key+'_error').html(value);
 					});
					$('#forgot_success_message').html('<div class="alert alert-danger">'+response['message']+'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
					$('#forgot_btn').removeAttr("disabled");
				}else{
 					$('#forgot_success_message').html('<div class="alert alert-success">'+response['message']+'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
					$('#forgot_password_form').trigger("reset");
					$('#forgot_btn').removeAttr("disabled");
					setTimeout(function(){
						$('#forgot_success_message').html('');
						}, 3000);
					   
				}  
			}
		});
	});
	


	$('#contact_now').click(function(){
		$('#contact_now').attr("disabled", true);
		$('#contact_now_form_form input,textarea').css('border', '1px solid #ccc');
		$('#success_message').html('');
		$('.error').html('');
		$.ajax({
			type: "POST",
			url: urls.contactUsNow,
			data: $('#contact_now_form_form').serialize(),
			success: function(ajaxresponse){
				  response=JSON.parse(ajaxresponse);
				if(!response['status']){
					$.each(response['response'], function(key, value) {
						$('#' + key).css('border', '1px solid #cc0000');
						$('#'+key+'_error').html(value);
					});
					$('#success_message').html('<div class="alert alert-danger">'+response['message']+'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
					$('#contact_now').removeAttr("disabled");
				}else{
					$('#success_message').html('<div class="alert alert-success">'+response['message']+'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
					$('#contact_now_form_form').trigger("reset");
					$('#contact_now').removeAttr("disabled");
					setTimeout(function(){
						$('#success_message').html('');
						}, 3000);
					   
				}  
			}
		});
	})

	

	$('#subscribe_btn').click(function(){
		var status=true;
		$('#subscribe_email_error').html('');
		$('#subscribe_success').html('');
		 var email=makeTrim($('#subscribe_email').val());
		var valid_email=validEmail(email);
		var message='';
		$('#subscribe_email').css('border', '1px solid #ccc');
		if(email==''){
			$('#subscribe_email').css('border', '1px solid #cc0000');
			status=false;
			message='<p class="error">Please enter email!</p>';
		}else if(valid_email==false){
			$('#subscribe_email').css('border', '1px solid #cc0000');
			status=false;
			message='<p class="error">Please enter valid email!</p>';
		}
		if(status==false){
			$('#subscribe_email_error').html(message);
			return false;
		}else{
			$.ajax({
			url: urls.subscribe,
			type: "POST",
			data: {"email":email},
			success: function (ajaxresponse) { 
			response=JSON.parse(ajaxresponse);
			var response_status=response['status'];
			if(!response_status){
				message='<p class="error">You have alredy subscribed!</p>';
				$('#subscribe_email_error').html(message);
			 }else{
				 message='<p class="success">You have successfully subscribed!</p>';
				 $('#subscribe_success').html(message);
				 $('#subscribe_email').val('');
			 }
			return false;
			 }
		}) 
		}
	});

	$('#update_customer_profile').click(function(){
		$('#update_customer_profile').attr("disabled", true);
		$('#update_customer_profile_form input').css('border', '1px solid #ccc');
		$('#success_message').html('');
		$('.error').html('');
   		$.ajax({
			url: urls.customerSaveUpdateProfile,
			type: "POST",
			data: new FormData($("#update_customer_profile_form")[0]),
			async: false,
			cache: false,
			contentType: false,
			processData: false,
			success: function (ajaxresponse) { 
				response=JSON.parse(ajaxresponse);
				if(!response['status']){
					$.each(response['response'], function(key, value) {
						$('#' + key).css('border', '1px solid #cc0000');
						$('#'+key+'_error').html(value);
					});
					$('#success_message').html('<div class="alert alert-danger">'+response['message']+'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
					$('#update_customer_profile').removeAttr("disabled");
				}else{
					$('#success_message').html('<div class="alert alert-success">'+response['message']+'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
 					setTimeout(function(){
						location.reload();
					}, 500);
					   
				} 
 			 }
		}) 
	});


	$('#update_delivery_boy_profile').click(function(){
  		$('#update_delivery_boy_profile').attr("disabled", true);
		$('#update_delivery_boy_profile_form input').css('border', '1px solid #ccc');
		$('#success_message').html('');
		$('.error').html('');
   		$.ajax({
			url: urls.deliveryBoySaveUpdateProfile,
			type: "POST",
			data: new FormData($("#update_delivery_boy_profile_form")[0]),
			async: false,
			cache: false,
			contentType: false,
			processData: false,
			success: function (ajaxresponse) { 
				response=JSON.parse(ajaxresponse);
				if(!response['status']){
					$.each(response['response'], function(key, value) {
						$('#' + key).css('border', '1px solid #cc0000');
						$('#'+key+'_error').html(value);
 					});
					$('#success_message').html('<div class="alert alert-danger">'+response['message']+'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
					$('#update_delivery_boy_profile').removeAttr("disabled");
				}else{
					$('#success_message').html('<div class="alert alert-success">'+response['message']+'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
 					setTimeout(function(){
						location.reload();
					}, 500);
					   
				} 
 			 }
		}) 
	});
	$('#update_service_provider_profile').click(function(){
	$('#update_service_provider_profile').attr("disabled", true);
	  $('#update_service_provider_profile_form input').css('border', '1px solid #ccc');
	  $('#success_message').html('');
	  $('.error').html('');
		 $.ajax({
		  url: urls.serviceProviderSaveUpdateProfile,
		  type: "POST",
		  data: new FormData($("#update_service_provider_profile_form")[0]),
		  async: false,
		  cache: false,
		  contentType: false,
		  processData: false,
		  success: function (ajaxresponse) { 
			  response=JSON.parse(ajaxresponse);
			  if(!response['status']){
				  $.each(response['response'], function(key, value) {
					  $('#' + key).css('border', '1px solid #cc0000');
					  $('#'+key+'_error').html(value);
				  });
				  $('#success_message').html('<div class="alert alert-danger">'+response['message']+'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
				  $('#update_service_provider_profile').removeAttr("disabled");
			  }else{
				  $('#success_message').html('<div class="alert alert-success">'+response['message']+'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
				   setTimeout(function(){
					  location.reload();
				  }, 500);
					 
			  } 
			}
			
	  }) 
  });



  $('#add_update_provider_service').click(function(){
  	$('#add_update_provider_service').attr("disabled", true);
	  $('#add_update_provider_service_form input,select').css('border', '1px solid #ccc');
	  $('#success_message').html('');
	  $('.error').html('');
		 $.ajax({
		  url: urls.providerSaveService,
		  type: "POST",
		  data: new FormData($("#add_update_provider_service_form")[0]),
		  async: false,
		  cache: false,
		  contentType: false,
		  processData: false,
		  success: function (ajaxresponse) { 
			  response=JSON.parse(ajaxresponse);
			  if(!response['status']){
				  $.each(response['response'], function(key, value) {
					  $('#' + key).css('border', '1px solid #cc0000');
					  $('#'+key+'_error').html(value);
				  });
				  $('#success_message').html('<div class="alert alert-danger">'+response['message']+'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
				  $('#add_update_provider_service').removeAttr("disabled");
			  }else{
				  $('#success_message').html('<div class="alert alert-success">'+response['message']+'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
				   setTimeout(function(){
					window.location.href = response['url']; 
				  }, 500);
					 
			  } 
			}
			
	  }) 
  });
	


});


function initAutocomplete() {
        
	var input = document.getElementById('address');
	var options = {
	types: ['(regions)'],
	componentRestrictions: {country:'in'}
};
   // var autocomplete = new google.maps.places.Autocomplete(input,options);
	var autocomplete = new google.maps.places.Autocomplete(input);
	
	
	google.maps.event.addListener(autocomplete, 'place_changed', function () {
   
	var place = autocomplete.getPlace();
	if(place)
	{
	  var lat = place.geometry.location.lat();
	  var long = place.geometry.location.lng();
	  $("#longitude").val(long);
	  $("#latitude").val(lat);
	//   alert(lat);
	}
	// google.maps.event.trigger(map, 'resize');
	});
		// When the user selects an address from the dropdown, populate the address
		// fields in the form.
		// autocomplete.addListener('place_changed', fillInAddress);
	}
	
function fillInAddress() {
		var place = autocomplete.getPlace();       
		console.log(place);
		 //$("#address").val(place.name+' '+place.formatted_address);
		$("#address").val();

		//$("#longitude").val(place.geometry.viewport.ga.l);
		//$("#latitude").val(place.geometry.viewport.na.l);
		$("#longitude").val(place.geometry.viewport.ha.g);
		$("#latitude").val(place.geometry.viewport.da.h);
   }


