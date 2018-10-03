jQuery(document).ready(function(){
	var $j = jQuery.noConflict();
	jQuery("#form-submit").click(function(e){
		var name = 'ragu';
		$j.ajax({ 
			type: 'post',
			url:ajaxurl,
			data: {
				action:"my_ajax_function",
				name:name
			},
			success: function(data) {
				console.log(data);
				// var status = jQuery.parseJSON(data);
				// if(status.success =='ok'){
				// 	$j("#message").html("<b>File Uploaded Successfully</b>");
				// }
				

			// $j("#message").html("<b>File Uploaded Successfully</b>");
				// console.log(url);
				// console.log(data); //should print out the name since you sent it along
				// location. reload(true);
			},
			error: function(errorThrown){
				// console.log(errorThrown);
				// location. reload(true);
			} 
		});
	});

	jQuery("#add_dropbox_account_details").click(function(e){
		var app_key = jQuery("#app_key").val();
		var app_secret = jQuery("#app_secret").val();
		var access_token = jQuery("#access_token").val();
		$j.ajax({
			type: 'post',
			url:ajaxurl,
			data: {
				action:"add_dropbox_account_details",
				app_key:app_key,app_secret:app_secret,access_token:access_token,
			},
			success: function(data) {
				console.log(data);
				// $j("#message").html("<b>Dropbox Account Details Added Successfully</b>");
				// console.log(data); //should print out the name since you sent it along
			},
			error: function(errorThrown){
				// console.log(errorThrown);
				location. reload(true);
			} 
		});

	});
	
});