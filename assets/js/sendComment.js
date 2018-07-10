$(function(){
  $(document).on('keyup', '.post-comment-right .sendCommentToPost',function(e){
   		e.preventDefault()
    if (e.which === 13 || e.type === 'click') {
    	   var textarea = $(this);
    	var comment = textarea.val();
    	var commentedOn = $(this).attr("data-commentedOn");

    	comment = comment.trim();
    	
    	   if(comment){
    	   	 $.post('http://localhost/socio/core/ajax/sendComment.php', {sendComment:true,comment:comment,commentedOn:commentedOn}, function (response) {
		       	textarea.val('');
             textarea.parent().siblings('.show_user_reply').append(response);

		      });
    	   }
     
    }
  });

  $(document).on('keyup','.post-sub-comment-right .sendSubCommentToPost', function(e){
  	
   		e.preventDefault()
    if (e.which === 13 || e.type === 'click') {
    	   var textarea = $(this);
    	var comment = textarea.val();
    	var commentedPost = $(this).attr("data-commentedPost");
    	var commentedOn = $(this).attr("data-commentedOn");

    	comment = comment.trim();
    	
    	   if(comment){
    	   	 $.post('http://localhost/socio/core/ajax/sendComment.php', {sendSubComment:true,comment:comment,commentedPost:commentedPost,commentedOn:commentedOn}, function (response) {
		       	textarea.val('');
           textarea.closest('.sub-comment-reply-wrapper').siblings('.show_user_sub_reply').append(response);
		      });
    	   }
     
    }
  });

 $(".comment-display-details-meta-left .comment-display-details-reply").click(function(){
 	 var wrapper = $(this).closest('.comment-display-details-meta').siblings('.sub-comment-reply-wrapper');
       wrapper.toggle();
   });


 
  $(document).on('click', '.show_user_reply .comment-display-details-reply', function(){
      var wrapper = $(this).parent().siblings('.sub-comment-reply-wrapper');
       wrapper.toggle();
  });


});

