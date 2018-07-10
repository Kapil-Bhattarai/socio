 <script type="text/javascript">
$(document).ready(function(){
    $(".friend_name").keyup(function(){

        var str = $(".friend_name").val();

		var count = 0;

        $(".fb-friends-list .inner_profile").each(function(index){
            if($(this).attr("id")){
				//case insenstive search
                if(!$(this).attr("id").match(new RegExp(str, "i"))){
                    $(this).fadeOut("fast");
                }else{
                    $(this).fadeIn("slow");
					count++;
                }
            }
        }); 
		
		if(str == '') { 
			$("#result").hide(); 
		} else { 
			$("#result").show(); 
		} 
		//display no of results found
		if(count < 1){
			$("#result").text("No results for "+str);
		}else{
			$("#result").text("Top "+count+" results for "+str);
		}
    });
});
</script>
<div class="outer-container">
			<div class="fb-search-container">
				<div class="heading float"> <i class="fa fa-users" style="padding-right:5px;"></i>  <span class='friend_span'>Friends</span></div>
				<div class="textbox float"><input class="friend_name" type="text" autocomplete="off" name="search" placeholder="Search for your friends" value="" /></div>
			</div>
			<div class="fb-friends-list">
				<div id="result"></div>


				<?php $friendClass->getFriendsList($profileId); ?>

				<div style="clear:both"></div>
			</div>
</div>
<script type="text/javascript" >
$(document).ready(function(){

	$(".account").click(function(){
		$(".submenu").hide();
		var X=$(this).attr('id');
		var data_ids=$(this).attr('data-ids');
	

	if(X==1){
		$("#"+data_ids).hide();
		$(this).attr('id', '0');	
	}else{

		$("#"+data_ids).show();
		$(this).attr('id', '1');

	}

	//Mouseup textarea false
		$("#"+data_ids).mouseup(function()
		{
		return false
		});
		$(".account").mouseup(function()
		{
		return false
		});


		//Textarea without editing.
		$(document).mouseup(function()
		{
		$("#"+data_ids).hide();
		$(".account").attr('id', '');
		});
	
		
});

	
});
	
	</script>