$(document).ready(function(){

   $(document).on('click', '.reaction',function(){   // like click
  
	var data_reaction = $(this).attr("data-reaction");
	var newReactionId = $(this).attr("data-newReactionId");

	var emoDom   =  $(this).closest('.like-btn').children('.like-btn-emo'); 
	var textDom  =  $(this).closest('.like-btn').children('.like-btn-text');

	var postId 			=    $(this).parent('.reactions-box').attr('data-postId');
  var postUserId 		= $(this).parent('.reactions-box').attr('data-postUserId');
  var oldReactionId    = $(this).parent('.reactions-box').attr('data-oldReactionId');
  var reactionlatest   = $(this).parent('.reactions-box').attr('data-reactionlatest');
  var level            = $(this).parent('.reactions-box').attr('data-level');

  level = parseInt(level);
  var commentId;
  var subCommentId;
  if(level==2){
   commentId   = $(this).parent('.reactions-box').attr('data-commentId');
  }else if(level==3){
    commentId   = $(this).parent('.reactions-box').attr('data-commentId');
   subCommentId   = $(this).parent('.reactions-box').attr('data-subCommentId');
  }
  
	if(parseInt(oldReactionId)!= parseInt(newReactionId)){
	
	emoDom.removeClass().addClass('like-btn-emo').addClass('like-btn-'+data_reaction.toLowerCase());
	textDom.text(data_reaction).removeClass().addClass('like-btn-text').addClass('like-btn-text-'+data_reaction.toLowerCase()).addClass("active");
  

        if(level==1){
          var textEmo  =  $(this).closest('.post-show').children('.post-meta').find('.like-emo'); 
          var textEmoDetails  =  $(this).closest('.post-show').children('.post-meta').find('.like-details'); 
           var textEmo  =  $(this).closest('.post-show').children('.post-meta').children('.post-reaction-wrapper'); 

        }else if(level==2){
           var textEmo  =  $(this).closest('.comment-display-details-meta-left').siblings('.comment-display-details-meta-right').children('.like-emo'); 
           var textEmoDetails  = $(this).closest('.comment-display-details-meta-left').siblings('.comment-display-details-meta-right').children('.comment-count'); 
           var textEmo = $(this).closest('.comment-display-details-meta-left').siblings('.comment-display-details-meta-right');
        }else if(level==3){
           var textEmo  =  $(this).closest('.post-show').children('.post-meta').find('.like-emo'); 
          var textEmoDetails  =  $(this).closest('.post-show').children('.post-meta').find('.like-details'); 
          var textEmo  =  $(this).closest('.sub-comment-display-details-meta').children('.comment-display-details-meta-right'); 

        }

  

  //textDom1.html('<span class="like-btn-like"></span><span class="like-btn-'+data_reaction.toLowerCase()+'"></span><span class="like-btn-angry"></span><span class="like-btn-sad"></span>');

	
  if(level==1){
    addReaction(1,textEmo,textEmoDetails,reactionlatest,postUserId,newReactionId,oldReactionId,postId,null,null);
  }else if(level==2){
   addReaction(2,textEmo,textEmoDetails,reactionlatest,postUserId,newReactionId,oldReactionId,postId,commentId,null);
  }else if(level==3){
    addReaction(3,textEmo,textEmoDetails,reactionlatest,postUserId,newReactionId,oldReactionId,postId,commentId,subCommentId);
  }

	$(this).parent('.reactions-box').attr('data-oldReactionId',newReactionId);

	}
	
	
	
	 
  });
  
   $(document).on('click', '.like-btn-text' ,function(){ // undo like click

  		
  		var postId 		              	= $(this).siblings('.reactions-box').attr('data-postId');
  		var postUserId 		            = $(this).siblings('.reactions-box').attr('data-postUserId');
  		var oldReactionId             = $(this).siblings('.reactions-box').attr('data-oldReactionId');
      var reactionlatest            = $(this).siblings('.reactions-box').attr('data-reactionlatest');
      var level                     = $(this).siblings('.reactions-box').attr('data-level');
     

      var textEmo  =  $(this).closest('.post-show').children('.post-meta').find('.like-emo'); 
      if(level==1){
        var textEmo  =  $(this).closest('.post-show').children('.post-meta').children('.post-reaction-wrapper'); 
      }else if(level==2){
        var textEmo = $(this).closest('.comment-display-details-meta').children('.comment-display-details-meta-right');
      }else if(level==3){
         var textEmo = $(this).closest('.sub-comment-display-details-meta').children('.comment-display-details-meta-right');
      }
      var textEmoDetails  =  $(this).closest('.post-show').children('.post-meta').find('.like-details'); 
      var postReaction   = $(this).closest('.post-show').children('.post-meta').children('.post-reaction'); 
        		
        level = parseInt(level);
        var commentId;
        var subCommentId;


        if(level==2){
         commentId   =  $(this).siblings('.reactions-box').attr('data-commentId');
        }else if(level==3){
          commentId   =  $(this).siblings('.reactions-box').attr('data-commentId');
          subCommentId   = $(this).siblings('.reactions-box').attr('data-subCommentId');
        }

        console.log("undo part : level =>"+level+" postId =>"+postId+" commentId =>"+commentId+" subCommentId =>"+subCommentId);

	  if($(this).hasClass("active")){
      console.log("active");
		 $(this).text("Like").removeClass().addClass('like-btn-text');
		 $(this).siblings('.like-btn-emo').removeClass().addClass('like-btn-emo').addClass("fa-thumbs-o-up").addClass('fa');

     if(level==1){
         undoReaction(textEmo,textEmoDetails,postReaction,postId,postUserId,oldReactionId,reactionlatest,level,null,null);
     }else if(level==2){
         undoReaction(textEmo,textEmoDetails,postReaction,postId,postUserId,oldReactionId,reactionlatest,level,commentId,null);
     }else if(level==3){
         undoReaction(textEmo,textEmoDetails,postReaction,postId,postUserId,oldReactionId,reactionlatest,level,commentId,subCommentId);
     }
	
		 $(this).siblings('.reactions-box').attr('data-oldReactionId',0);

	  }else{
      console.log("Not active");
		$(this).siblings('.like-btn-emo').removeClass().addClass('like-btn-emo').addClass('like-btn-like');
		$(this).text('Like').removeClass().addClass('like-btn-text').addClass('like-btn-text-like').addClass("active");
		
    	if(level==1){
        addReaction(1,textEmo,textEmoDetails,reactionlatest,postUserId,1,oldReactionId,postId,null,null);
      }else if(level==2){
       addReaction(2,textEmo,textEmoDetails,reactionlatest,postUserId,1,oldReactionId,postId,commentId,null);
      }else if(level==3){
        addReaction(3,textEmo,textEmoDetails,reactionlatest,postUserId,1,oldReactionId,postId,commentId,subCommentId);
      }

		$(this).siblings('.reactions-box').attr('data-oldReactionId',1);

		
	 }  
  });
  
 /*  $(".like-btn-emo").on("click",function(){ // undo like click

	  if($(this).siblings('.like-btn-text').hasClass("active")){
		 $(this).siblings('.like-btn-text').text("Like").removeClass().addClass('like-btn-text');
		 $(this).removeClass().addClass('like-btn-emo').addClass("like-btn-default");
		 
	  }else{
		 $(this).removeClass().addClass('like-btn-emo').addClass('like-btn-like');
		  $(this).siblings('.like-btn-text').text('Like').removeClass().addClass('like-btn-text').addClass('like-btn-text-like').addClass("active");
	 	  
	 }  
  })*/
  
  	function undoReaction(textEmo, textEmoDetails,postReaction, postId,postUserId,oldReactionId,oldReactionLatest,level,commentId,subCommentId){

  		var oldReactionId;
      oldReactionLatest=     oldReactionLatest.split(', ,').join(',')
  		switch(parseInt(oldReactionId)){
  			case 1:
  					oldReactionIdName= 'likeCount';
  					break;
  			case 2:
  					oldReactionIdName= 'loveCount';
  					break;
  			case 3:
  					oldReactionIdName= 'hahaCount';
  					break;
  			case 4:
  					oldReactionIdName = 'wowCount';
  					break;
  			case 5:
  					oldReactionIdName = 'sadCount';
  					break;
  			case 6:
  					oldReactionIdName = 'angryCount';
  					break;
  			default:
  					oldReactionIdName=    'socio';

  		}

  	

         var dataString='';
        if(level==1){
           var dataString =  'removeReaction='+true+'&postId='+postId+'&postUserId='+postUserId+'&oldReactionId='+oldReactionId+'&oldReactionIdName='+oldReactionIdName+'&oldReactionLatest='+oldReactionLatest+'&level='+1;
        
         }else if(level==2){
            var dataString =  'removeReaction='+true+'&postId='+postId+'&postUserId='+postUserId+'&oldReactionId='+oldReactionId+'&oldReactionIdName='+oldReactionIdName+'&oldReactionLatest='+oldReactionLatest+'&level='+2+'&commentId='+commentId;
         }else if(level==3){
           var dataString =  'removeReaction='+true+'&postId='+postId+'&postUserId='+postUserId+'&oldReactionId='+oldReactionId+'&oldReactionIdName='+oldReactionIdName+'&oldReactionLatest='+oldReactionLatest+'&level='+3+'&commentId='+2+'&subCommentId='+subCommentId;
         }
      
      $.ajax({
        type: "POST",
        url: "http://localhost/socio/core/ajax/reaction.php",
        data: dataString,
        cache: false,
        success: function(data){
          
             /* var data = parseInt(data);
                if(data<1){
                  
                   postReaction.hide();
                   textEmoDetails.html("");
                }else{
                  postReaction.show();
                  var exludeUserValue = data;
                  textEmoDetails.html(exludeUserValue+" People Reacted");
                }*/
                textEmo.html(data);
          

        }
      })
  	}

  	function addReaction(level,textEmo,textEmoDetails,oldReactionLatest, postUserId,newReactionId,oldReactionId,postId,commentId,subCommentId){
  		var oldReactionIdName;
  		var newReactionIdName;
      oldReactionLatest=     oldReactionLatest.split(', ,').join(',')
    
  		switch(parseInt(oldReactionId)){
  			case 1:
  					oldReactionIdName= 'likeCount';
  					break;
  			case 2:
  					oldReactionIdName= 'loveCount';
  					break;
  			case 3:
  					oldReactionIdName= 'hahaCount';
  					break;
  			case 4:
  					oldReactionIdName = 'wowCount';
  					break;
  			case 5:
  					oldReactionIdName = 'sadCount';
  					break;
  			case 6:
  					oldReactionIdName = 'angryCount';
  					break;
  			default:
  					oldReactionIdName=    'socio';

  		}
  		switch(parseInt(newReactionId)){
  			case 1:
  					newReactionIdName= 'likeCount';
  					break;
  			case 2:
  					newReactionIdName= 'loveCount';
  					break;
  			case 3:
  					newReactionIdName= 'hahaCount';
  					break;
  			case 4:
  					newReactionIdName = 'wowCount';
  					break;
  			case 5:
  					newReactionIdName = 'sadCount';
  					break;
  			case 6:
  					newReactionIdName = 'angryCount';
  					break;
  			default:
  					newReactionIdName=    'socio';

  		}

        var dataString='';
        if(level==1){
           var dataString =  'addReaction='+true+'&postId='+postId+'&postUserId='+postUserId+'&newReactionIdName='+newReactionIdName+'&oldReactionIdName='+oldReactionIdName+'&newReactionId='+newReactionId+'&oldReactionId='+oldReactionId+'&oldReactionLatest='+oldReactionLatest+'&level='+1;
         }else if(level==2){
           var dataString =  'addReaction='+true+'&postId='+postId+'&postUserId='+postUserId+'&newReactionIdName='+newReactionIdName+'&oldReactionIdName='+oldReactionIdName+'&newReactionId='+newReactionId+'&oldReactionId='+oldReactionId+'&oldReactionLatest='+oldReactionLatest+'&commentId='+commentId+'&level='+2;
         }else if(level==3){
          var dataString =  'addReaction='+true+'&postId='+postId+'&postUserId='+postUserId+'&newReactionIdName='+newReactionIdName+'&oldReactionIdName='+oldReactionIdName+'&newReactionId='+newReactionId+'&oldReactionId='+oldReactionId+'&oldReactionLatest='+oldReactionLatest+'&commentId='+commentId+'&subCommentId='+subCommentId+'&level='+3;
         }
      
      $.ajax({
        type: "POST",
        url: "http://localhost/socio/core/ajax/reaction.php",
        data: dataString,
        cache: false,
        success: function(data){
        //  console.log("data: json "+data);
/*
          var obj = jQuery.parseJSON(data);

         /* console.log("reactionList "+obj.reactionlist);
          console.log("value "+obj.value);

           var reactionlist = obj.reactionlist;
           reactionlist=     reactionlist.split(', ,').join(',')
           var data = parseInt(obj.value);*/

           // console.log("final list "+reactionlist);

        textEmo.html(data);

        }
      })


  	}
});