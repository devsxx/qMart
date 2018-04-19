//To use nodejs with http enable the below line by removing the // at the start of the line
//var socket = io.connect('http://qMartscript.com:8080');

//To use nodejs with http command the below line by adding a // at the start of the line
var socket = io.connect('https://www.10qmart.com:8080', {secure: true});

var typingTrack = 0;
var timerId;
var livenotifytimer;

$(document).on('keydown', '#messageInput', function(e) {
	var keycode = e.keyCode;
	var sourceId = $('#sourceId').val();
	var keyPress = e;
	var message = $('#messageInput').val();
	var messageLength = message.length;
	/*if ( keyPress &&
	        ( ( ( keyPress.which >= 32 // not a control character
	              //|| keyPress.which == 8  || // \b
	              //|| keyPress.which == 9  || // \t
	              //|| keyPress.which == 10 || // \n
	              //|| keyPress.which == 13    // \r
	              ) &&
	            !( keyPress.which >= 63232 && keyPress.which <= 63247 ) && // not special character in WebKit < 525
	            !( keyPress.which == 63273 )                            && //
	            !( keyPress.which >= 63275 && keyPress.which <= 63277 ) && //
	            !( keyPress.which === event.keyCode && // not End / Home / Insert / Delete (i.e. in Opera < 10.50)
	               ( keyPress.which == 35  || // End
	                 keyPress.which == 36  || // Home
	                 keyPress.which == 45  || // Insert
	                 keyPress.which == 46  || // Delete
	                 keyPress.which == 144    // Num Lock
	                 )
	               )
	            ) ||
	          keyPress.which === undefined // normal character in IE < 9.0
	          ) &&
	        keyPress.charCode !== 0 // not special character in Konqueror 4.3
	        ) {*/
		if(typingTrack == 0 && keycode != 13 && messageLength < 500){
			var senderId = $('#receiveingsource').val();
			var receiverId = $('#appendinggsource').val();
			console.log('senderId: '+senderId+' receiverId: '+receiverId);
			
			if (sourceId != '') {
				socket.emit('exmessageTyping', {
					senderId : senderId,
					receiverId: receiverId,
					sourceId : sourceId,
					message : "type"
				});
			}else{
				socket.emit('messageTyping', {
					senderId : senderId,
					receiverId: receiverId,
					message : "type"
				});
			}
			typingTrack = 1;
		}
	//}
	
	if (keycode == 13) {
		sendMessage();
		return false;
	}
	if (typeof timerId != 'undefined'){
		clearInterval(timerId);
	}
	timerId = setInterval(function() {
		typingTrack = 0;
		var senderId = $('#receiveingsource').val();
		var receiverId = $('#appendinggsource').val();
		console.log('senderId: '+senderId+' receiverId: '+receiverId);
		if (sourceId != '') {
			socket.emit('exmessageTyping', {
				senderId : senderId,
				receiverId: receiverId,
				sourceId : sourceId,
				message : "untype"
			});
		}else{
			socket.emit('messageTyping', {
				senderId : senderId,
				receiverId: receiverId,
				message : "untype"
			});
		}
		clearInterval(timerId);
	},1000);
});

/*if (typeof typetimerId != 'undefined'){
	clearInterval(typetimerId);
}
var typetimerId = setInterval(function() {
	if(typingTrack == 0){
		var senderId = $('#receiveingsource').val();
		socket.emit('messageTyping', {
			senderId : senderId,
			message : "untype"
		});
	}
},1000);*/

$(document).on('click', ".submit", function() {
	sendMessage();
	return false;
});

socket.on('message', function(data) {
	var appendId = $('#receiveingsource').val();
	if(appendId == data.receiver){
		var accessId = ".live-messages-ol-" + data.sender + "-" + data.receiver;
		var newMsgContent = constructData('left', data.message, 'message');// data.message;
		var currentScrollHeight = $("#live-msg-container")[0].scrollHeight;
		var currentScrollPosition = $("#live-msg-container").scrollTop();
		var currentInnerHeight = $("#live-msg-container").innerHeight();
		$(accessId).append(newMsgContent);
		if((currentScrollPosition + currentInnerHeight) == currentScrollHeight){
			$("#live-msg-container").scrollTop(
					$("#live-msg-container")[0].scrollHeight);
		}
		$.ajax({
			url : yii.urls.base + '/updatechat',
			type : "POST",
			data : {
				type : "markread",
				sender : data.sender,
				receiver : data.receiver
			},
			success : function(data) {
				console.log(data);
			}
		});
	}else{
		var notifyContent = constructLiveNotify(data.message);
		var chatlistSelector = ".chatlist-"+data.receiver;
		var messageContainer = chatlistSelector+" .short-message";
		var messageUnreadMarker = chatlistSelector+" .message-prof-pic";
		var readCount = chatlistSelector+" .userNameLink";
		var totalData = data.message;
		var newChatStatus = $(readCount).data("userread");
		var liveMessage = totalData.message;
		console.log('li: '+chatlistSelector+" div: "+messageContainer+" data: "+liveMessage);
		$(readCount).attr("data-userread", "1");
		$(chatlistSelector).addClass('instant-notify');
		$(messageContainer).html(liveMessage);
		$(messageUnreadMarker).html('<div class="message-unread-count"></div>');
		
		
		$('.chatnotify-container').html(notifyContent);
		$('.chatnotify-container').show();
		if (typeof livenotifytimer != 'undefined'){
			clearInterval(livenotifytimer);
		}
		livenotifytimer = setInterval(function() {
			$('.chatnotify-container').hide();
			clearInterval(livenotifytimer);
		},3000);
		
		/*var data = parseInt($('.message-count ').html());
		if(newChatStatus == '0'){
			data += 1;
			$('.message-count').html(data);
			$(readCount).data("userread", 1);
			$('.message-count').removeClass('message-hide');
		}*/
		
		$.ajax({
			url : yii.urls.base + '/updatechat',
			type : "POST",
			data : {
				type : "getcount",
				userName : data.sender
			},
			success : function(data) {
				if(data != '0' && liveCount != data){
					liveCount = data;
					$('.message-count').html(data);
					$(readCount).data("userread", 1);
					$('.message-count').removeClass('message-hide');
				}
			}
		});
	}
});

socket.on('messageTyping', function(data) {
	var accessId = ".live-messages-typing";
	var receivingSource = $('#receiveingsource').val();
	console.log("Type message: "+data.message+" receiverId: "+data.receiverId);
	if(receivingSource == data.receiverId){
		if (data.message == "untype")
			$(accessId).css('opacity',"0");
		else
			$(accessId).css('opacity',"1");
	}
});

socket.on('exmessage', function(data) {
	var appendId = $('#receiveingsource').val();
	var sourceId = $('#sourceId').val();
	var accessId = ".live-messages-ol-" + data.sender + "-" + data.receiver + "-" + data.sourceId;
	var newMsgContent = constructData('left', data.message, 'exmessage');// data.message;
	var currentScrollHeight = $("#live-msg-container")[0].scrollHeight;
	var currentScrollPosition = $("#live-msg-container").scrollTop();
	var currentInnerHeight = $("#live-msg-container").innerHeight();
	$(accessId).append(newMsgContent);
	//console.log(".live-messages-ol-" + data.sender + "-" + data.receiver
	//		+ "-" + data.sourceId+"Message:"+newMsgContent);
	if((currentScrollPosition + currentInnerHeight) == currentScrollHeight){
		$("#live-msg-container").scrollTop(
			$("#live-msg-container")[0].scrollHeight);
	}
});

socket.on('exmessageTyping', function(data) {
	var accessId = ".live-messages-typing";
	var sourceId = $('#sourceId').val();
	console.log("Type message: "+data.message+" receiverId: "+data.receiverId);
	if(sourceId == data.sourceId){
		if (data.message == "untype")
			$(accessId).css('opacity',"0");
		else
			$(accessId).css('opacity',"1");
	}
});

function constructData(align, data, type) {
	var output = '<div class="conversation-container col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">'
		+'<div class="conversation-bargain-container col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">'
		+'<div class="conversation-text">'+ data.message + '</div></div></div>'
		//Old----->
		/*+'<div class="chat-grid-userimage"><img src="' + data.userImage
			+ '" alt="' + data.userName + '">'
			+ '</div><div class="chat-grid-details"><p class="chat-grid-msgs">'
			+ data.message + '</p><p class="chat-grid-time">' + data.chatTime
			+ '</p></div>';*/
	var outputData = "";
	if (align == "right") {
		var gridAlign = "user-conv";
		var messageContainerAlign = "message-conversation-right-cnt";
		var gridArrowAlign = "arrow-right";
		var userImageAlign = "id='user'";
		
		outputData = '<li><div class="'+gridAlign+' message-conversation-container col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">'
			+'<div '+userImageAlign+' class="conversation-prof-pic no-hor-padding">'
			+'<div class="message-prof-pic" style="background-image: url(\''+data.userImage+'\')"></div></div>'
			+'<div class="'+messageContainerAlign+' col-xs-9 col-sm-9 col-md-9 col-lg-7 no-hor-padding">'
			+'<div class="'+gridArrowAlign+'"></div>'
			+'<div class="message-conversation col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">'
			+ output +'</div><div class="conversation-date col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">'
			+ data.chatTime
			+'</div></div></div></li>';
			//Old------------>
			/*+"<li><div class='msg-grid-right'>" + output
				+ "</div></li>";*/
	} else {
		var gridAlign = "";
		var messageContainerAlign = "message-conversation-left-cnt";
		if(type == "exmessage"){
			var gridArrowAlign = "exchange-arrow-left";
			var messageContainer = "exchange-message-conversation";
		}else{
			var gridArrowAlign = "arrow-left";
			var messageContainer = "message-conversation";
		}
		var userImageAlign = "";
		
		outputData = '<li><div class="'+gridAlign+' message-conversation-container col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">'
		+'<div '+userImageAlign+' class="conversation-prof-pic no-hor-padding">'
		+'<div class="message-prof-pic" style="background-image: url(\''+data.userImage+'\')"></div></div>'
		+'<div class="'+messageContainerAlign+' col-xs-9 col-sm-9 col-md-9 col-lg-7 no-hor-padding">'
		+'<div class="'+gridArrowAlign+'"></div>'
		+'<div class="'+messageContainer+' col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">'
		+ output +'</div><div class="conversation-date col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">'
		+ data.chatTime
		+'</div></div></div></li>';
		//outputData = "<li><div class='msg-grid-left'>" + output + "</div></li>";
	}
	return outputData;
}

function constructLiveNotify(data){
	var output = '<a href="'+data.chatURL+'" target="_blank" title="'+data.userName+'" >'
				+'<div class="message-floating-div-cnt col-xs-12 col-sm-4 col-md-3 col-lg-3 no-hor-padding">'
					+'<div class="floating-div no-hor-padding pull-right">'
						+'<div class="message-icon no-hor-padding">'
							+'<div class="message-user-prof-pic" id="floating-div-pic" style="background-image:url(\''+data.userImage+'\');"></div>'
						+'</div>'
						+'<div class="message-user-info-cnt no-hor-padding">'
							+'<div class="message-user-name col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding">'+data.userName+'</div>'
							+'<div class="message-user-info">'+data.message+'</div>'
						+'</div></div></div></a>';
	return output;
}

function sendMessage() {
	console.log('calling');
	var chatId = $("#sourcce").val();
	var message = $("#messageInput").val();
	var senderId = $('#sendingsource').val();
	var messageType = $('#sourccetype').val();
	var source = $('#chatsourcce').val();
	var receiveId = $('#receiveingsource').val();
	var appendId = $('#appendinggsource').val();
	var sourceId = $('#sourceId').val();
	var msg = message.trim();
	if (msg != "") {
		$("#messageInput").val("");
		$.ajax({
			url : yii.urls.base + '/postmessage',
			type : "POST",
			data : {
				chatId : chatId,
				message : msg,
				senderId : senderId,
				messageType : messageType,
				source : source,
				sourceId : sourceId
			},
			success : function(data) {
				data = data.trim();
				if (data != ""){
					data = JSON.parse(data);
					
					// var sendData = "<li><div class='msg-grid-left'>" + data
					// + "</div></li>";
					// var appendData = "<li><div class='msg-grid-right'>" + data
					// + "</div></li>";
					if (sourceId != '') {
						var appendData = constructData('right', data, 'exmessage');
						socket.emit('exmessage', {
							receiverId : appendId,
							senderId : receiveId,
							message : data,
							sourceId : sourceId
						});
						var appendlabel = ".live-messages-ol-" + appendId + "-"
								+ receiveId + "-" + sourceId;
						var msgContainer = "#live-msg-container";
					} else {
						var appendData = constructData('right', data, 'message');
						socket.emit('message', {
							receiverId : appendId,
							senderId : receiveId,
							message : data
						});
						var appendlabel = ".live-messages-ol-" + appendId + "-"
								+ receiveId;
						var msgContainer = "#live-msg-container";
					}
					$("#messageInput").val("");
					var currentScrollHeight = $(msgContainer)[0].scrollHeight;
					var currentScrollPosition = $(msgContainer).scrollTop();
					var currentInnerHeight = $(msgContainer).innerHeight();
					$(appendlabel).append(appendData);
					if((currentScrollPosition + currentInnerHeight) == currentScrollHeight){
						$(msgContainer).scrollTop(
								$(msgContainer)[0].scrollHeight);
					}
					//$("#live-messages").scrollTop(
					//		$("#live-messages")[0].scrollHeight);
				}else{
					$(".message-limit").html(
							Yii.t('app', "Enter some message without html"));
					$('#messageInput').addClass('has-error');
					$(".message-limit").fadeIn();
					setTimeout(function() {
						$('#messageInput').removeClass('has-error');
						$(".message-limit").fadeOut();
					}, 3000);
				}
			}
		});
	} else {
		$("#messageInput").val("");
		$('#messageInput').addClass('has-error');
		$(".message-limit").html(Yii.t('app', "Message Cannot be Empty"));
		$(".message-limit").fadeIn();
		setTimeout(function() {
			$('#messageInput').removeClass('has-error');
			$(".message-limit").fadeOut();
		}, 3000);
	}
}
