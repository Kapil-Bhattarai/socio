$(function(){


              $(".profile-img").hover(function(){
                  $('.profile-hover-wrapper').toggleClass('showEdit');
                  });

              $(".profile-hover-wrapper").hover(function(){
                $('.profile-hover-wrapper').toggleClass('showEdit');
                 $('.profile-hover-wrapper').toggleClass('darkBackground');
             });


            
              $(".fb-profile-block-thumb").hover(function(){
              $('.cover-hover-wrapper').toggleClass('showEdit');
              });

              $(".cover-hover-wrapper").hover(function(){
                $('.cover-hover-wrapper').toggleClass('showEdit');
                 $('.cover-hover-wrapper').toggleClass('darkBackground');
             });

              

                $('.profile-hover-wrapper').click(function(){
      
                  $("#uploadProfileFile").click();
              });

              $('.cover-hover-wrapper').click(function(){
      
                  $("#uploadCoverFile").click();
              });


          
    		 $('#uploadProfileFile').on("change", function(){ 
               	$(this).closest('.profileForm').submit();
            });         
    		  $('#uploadCoverFile').on("change", function(){ 
    		  	console.log('here we are to change the cover profile');
               	$(this).closest('.coverForm').submit();
            }); 



   		 $(document).on('submit','.profileForm', function(e){
				e.preventDefault();

				
				var formData = new FormData($(this)[0]);
				formData.append('file', $('#uploadProfileFile')[0].files[0]);
				formData.append('type',1);
			
				 
			

				$.ajax({
					url: "http://localhost/socio/core/ajax/uploadProfileImages.php",
					type: "POST",
					data: formData,
					success: function(data){
						result = JSON.parse(data);
						var imgurl ='http://localhost/socio/'+result.msg;
						console.log('imgurl  :'+imgsrc);
						if(parseInt(result.status)==1){
									var imgsrc = '<img src='+' " '+imgurl+' " '+ '/>';
										console.log('imgsrc  :'+imgsrc);
									$('.profile-img').html(imgsrc);


									//now upload profile Upload post from here

									$.post('http://localhost/socio/core/ajax/post.php', {status:"",privacy:0,postType:1,url:result.msg}, function (response) {
		 			
							 				$('.user_post_show').prepend(response);

							 				
							      });


						}else{
							alert(result.msg);
						}
					},
					cache: false,
					contentType: false,
					processData: false
				});
			});

   		  $(document).on('submit','.coverForm', function(e){
				e.preventDefault();

				
				var formData = new FormData($(this)[0]);
				formData.append('file', $('#uploadCoverFile')[0].files[0]);
				formData.append('type',2);
			
				
				$.ajax({
					url: "http://localhost/socio/core/ajax/uploadProfileImages.php",
					type: "POST",
					data: formData,
					success: function(data){
						result = JSON.parse(data);
						var imgurl ='http://localhost/socio/'+result.msg;

						/*console.log('imgurl before :'+imgurl);
						imgurl = encodeURIComponent(imgurl);

						console.log('imgurl after :'+imgurl);
							*/

						
/*
						console.log('imgsrc finally :'+imgsrc);

						console.log('data :'+result);
						console.log('data :'+result.msg);*/
						if(parseInt(result.status)==1){
									var imgsrc = '<img src='+' " '+imgurl+' " '+' style= ' +' " ' + ' width:100%;'+ ' " '+ '/>';
									$('.fb-profile-block-thumb').html(imgsrc);

									//now upload profile cover post from here

									$.post('http://localhost/socio/core/ajax/post.php', {status:"",privacy:0,postType:2,url:result.msg}, function (response) {
		 			
							 				$('.user_post_show').prepend(response);

							 				
							      });
						}else{
							alert(result.msg);
						}
				

					},
					cache: false,
					contentType: false,
					processData: false
				});
			});
              
						
               

});