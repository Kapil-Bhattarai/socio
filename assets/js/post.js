$(document).ready(function(){

	 $(document).on('click', '#postStatus',function(){
	 	$(this).closest('.uploadStatusForm').submit();
	  });

	  $(document).on('submit','.uploadStatusForm', function(e){
				e.preventDefault();

				var formData = new FormData($(this)[0]);

				/*	str = JSON.stringify(formData);
				str = JSON.stringify(formData, null, 4); // (Optional) beautiful indented output.
				console.log(str);*/


				formData.append('file', $('#uploadFile')[0].files[0]);
				

			

				$.ajax({
					url: "http://localhost/socio/core/ajax/post.php",
					type: "POST",
					data: formData,
					success: function(data){
						/*result = JSON.parse(data);
						var imgurl ='http://localhost/socio/'+result.msg;
						console.log('imgurl  :'+imgsrc);
						if(parseInt(result.status)==1){
									var imgsrc = '<img src='+' " '+imgurl+' " '+ '/>';
										console.log('imgsrc  :'+imgsrc);
									$('.profile-img').html(imgsrc);
						}else{
							alert(result.msg);
						}*/

						$('.user_post_show').prepend(data);
						//$('.uploadStatusForm').trigger("reset");
						resetForm('statusUpId');
						resetForm('uploadFile');
						$('.body-right .text-type').val('');
						$('#body-bottom').hide();
						$('#preview').attr('src','');

					},
					cache: false,
					contentType: false,
					processData: false
				});
	 });

			function resetForm(id) {
			    $('#' + id).val(function() {
			        return this.defaultValue;
			    });
			}
});