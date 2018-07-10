$(document).ready(function(){

		// send the request 

		 $(document).on('click', '.send-request-btn',function(){
		 	var profileId = $(this).attr("data-profileId");
		 	var  btn = $(this);
		 	btn.attr("disabled", "disabled");

		 	
		 	btn.html(' <i class="fa fa-spinner" style="padding-right:5px;"></i><span >Processing...</span>  ');


		 	$.post('http://localhost/socio/core/ajax/friend.php', {sendRequest:true,profileId:profileId}, function (response) {
		 				btn.removeAttr('disabled');
		 				btn.removeClass().addClass('action-button-friend').addClass('request-sent-btn');
		 				btn.html(' <i class="fa fa-user" style="padding-right:5px;"></i><span >Cancel Request</span>  ');
		      });

		 });

		 // cancel friend request 

		 $(document).on('click', '.request-sent-btn',function(){
		 	var profileId = $(this).attr("data-profileId");
		 	var  btn = $(this);
		 	btn.attr("disabled", "disabled");
		 	
		 	
		 	btn.html(' <i class="fa fa-spinner" style="padding-right:5px;"></i><span >Processing...</span>  ');


		 	$.post('http://localhost/socio/core/ajax/friend.php', {cancelRequest:true,profileId:profileId}, function (response) {
		 			
		 				btn.removeAttr('disabled');
		 				btn.removeClass().addClass('action-button-friend').addClass('send-request-btn');
		 				btn.html(' <i class="fa fa-user-plus" style="padding-right:5px;"></i><span >Add Friend</span>  ');

		 				
		      });

		 });

		 


		 		 // cancel friend request 

		 $(document).on('click', '.request-received-btn',function(){
		 	var profileId = $(this).attr("data-profileId");
		 	var  btn = $(this);
		 	btn.attr("disabled", "disabled");
			var action_button_wrapper = $('.action-button-wrapper');
		 	
		 	btn.html(' <i class="fa fa-spinner" style="padding-right:5px;"></i><span >Processing...</span>  ');


		 	$.post('http://localhost/socio/core/ajax/friend.php', {acceptRequest:true,profileId:profileId}, function (response) {
		 				btn.removeAttr('disabled');
		 				btn.removeClass().addClass('action-button-friend').addClass('friends-btn');
		 				btn.html(' <i class="fa fa-check" style="padding-right:5px;"></i><span >You are Friends</span>  ');
		 				action_button_wrapper.append('<button class="action-button-message message-btn"  data-profileId="profileId"><i class="fa fa-envelope" style="padding-right:10px;"></i><span >Message</span></button>' );
		   
		      });

		 });

		 //change friends-btn on hover to unfriend the user

		 $(".friends-btn").hover(function(event){

		 	  	event.preventDefault();
				var  btn = $(this);

                btn.removeClass().addClass('action-button-friend').addClass('unfriend-btn');
                btn.html(' <i class="fa fa-user" style="padding-right:5px;"></i><span >Click to Unfriend</span>  ');
                	
             },function(){
             		 event.preventDefault();
					var  btn = $(this);

				
					
					btn.removeClass().addClass('action-button-friend').addClass('friends-btn');
             		btn.html(' <i class="fa fa-check" style="padding-right:5px;"></i><span >You are Friends</span>  ');

				
			
				 
             });
	

		 		 // unfriend the  

		 $(document).on('click', '.unfriend-btn',function(){

		 	var profileId = $(this).attr("data-profileId");
		 	var  btn = $(this);
		 	btn.attr("disabled", "disabled");

		 	var messageBtn = $('.message-btn');
		 	
		 	btn.html(' <i class="fa fa-spinner" style="padding-right:5px;"></i><span >Processing...</span>  ');


		 	$.post('http://localhost/socio/core/ajax/friend.php', {unfriend:true,profileId:profileId}, function (response) {
		 				btn.removeAttr('disabled');
		 				btn.unbind("mouseenter mouseleave");
		 				messageBtn.hide();
		 				btn.removeClass().addClass('action-button-friend').addClass('send-request-btn');
		 				btn.html(' <i class="fa fa-user-plus" style="padding-right:5px;"></i><span >Add Friend</span>  ');

		      });

		 });

});