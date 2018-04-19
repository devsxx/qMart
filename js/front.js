if(!(globalSize)) {
   var globalSize = new Array();
}
var ajaxcart = 1;
var contactAjax = 1, checkoutAjax = 1;
var productImage = 0, addImage = 0, generateCouponAjax = 1, addImageError = 0;
var mapClick = 1;
var offercheck = 1;
var followval = 1;
var unfollowval = 1;
var mobile_mapClick = 1;
var rating = 0, urgent = 0, ads = 0;
var specials = /[`~!@#$%^&*()_|+\-=?;:'",.<>\{\}\[\]\\\/]/gi;
var alpha = /[a-zA-Z]/gi;
var numric = /[0-9]/gi;
var mailcheck = 1;
var locationTracker = 1;
var likeAjax = 1, dislikeAjax = 1;
var messageUserScrollPosition = 0;
$("#offer-form").hide();

$(document).on('keyup','.card-cvv, .card-number', function() {
	var $th = $(this);
	$th.val($th.val().replace(/[^0-9]/g, function(str) {
		return '';
	}));
});
$(document).on('keyup','.card-first-name, .card-last-name', function() {
	var $th = $(this);
	$th.val($th.val().replace(/[^a-zA-Z]/g, function(str) {
		return '';
	}));
});
$(document).on('click', '.revieworder-li', function() {
	if($('.revieworder-li').hasClass('active')){
		return false;
	}else{
		$('.paymentdetails-li').removeClass('active');
		$('.revieworder-li').addClass('active');
		$('.payment-details').hide();
		$('.revieworder-details').fadeIn();
		return false;
	}
});
$(document).on('click', '.dropdown-toggle.profile', function(){
	if ($('.dropdown.profile-drop-li').hasClass('open')) {
		$('.dropdown.profile-drop-li').removeClass('open');
	} else {
		$('.dropdown.profile-drop-li').addClass('open');
	}
});
$(document).on('click', '.smlght', function() {
	$('.smlght').removeClass('active');
	$(this).addClass('active');
	var srcToChange = $(this).data("img-src");
	// $('#fullimgtag').attr('src',srcToChange);
	$('#image').css('background-image', 'url(' + srcToChange + ')');
	return false;
});
$(document).on('click', '.payment-side-menu ul li', function() {
	var previouspage = $('.payment-side-menu ul li.active').data("page");
	$('.side-menu').removeClass('active');
	$(this).addClass('active');
	var pagenumber = $(this).data("page");
	// $('#fullimgtag').attr('src',srcToChange);
	$('.page-'+previouspage).hide();
	$('.page-'+pagenumber).show();
	return false;
});

$(document).on('click', '.new-coupon-link', function() {
	$('.new-coupon-link').hide();
	$(".coupon-code").hide();
	$('.couponValue').val('');
	$(".generate-coupon-container").fadeIn(1500);
});

$(document).on('keyup', '#Sitesettings_apiPassword', function() {
	$('#show_apipassword').val($('#Sitesettings_apiPassword').val());
});

$(document).on('keyup', '#show_apipassword', function() {
	$('#Sitesettings_apiPassword').val($('#show_apipassword').val());
});

$(document).on('keyup', '.option, .quantity, .price', function() {
	if($('.option-add-btn').is(':disabled')) { 
		$('.option-add-btn').removeAttr('disabled');
	}
});

//Modal dialog did not close when click outside

/*$('#confirm_popup_container').modal({
    backdrop: 'static',
    keyboard: false
});*/

$('#nearmemodals').on('shown.bs.modal', function () {
	//console.log("On Modal-1");
	var currCenter = map.getCenter();
    google.maps.event.trigger(map, "resize");
    map.setCenter(currCenter);
});
$('#nearmemodals').on('shown', function() {
	//console.log("On Modal-2");
	var currCenter = map.getCenter();
    google.maps.event.trigger(map, "resize");
    map.setCenter(currCenter);
});

var productPropertyUpdate = 0;
$(document).on('change','#Products_category', function(){
	var selectedCategory = $('#Products_category').val();
	console.log('Products_category on change call');
	if(productPropertyUpdate == 0){
		productPropertyUpdate = 1;
		$.ajax({
			url: yii.urls.base + '/products/productproperty/',
			type: "post",
			data: {'selectedCategory':selectedCategory, 'productId': productId},
			dataType: "html",
			success: function(responce){
				responce = responce.trim();
				//console.log("Responce string: "+responce);
				propertyData = eval(responce);
				if(propertyData[0] == 0){
					$('.dynamicProperty').html(propertyData[1]);
					$('.dynamic-section').hide();
				}else{
					$('.dynamicProperty').html(propertyData[1]);
					$('.dynamic-section').show();
				}
				$('#Products_subCategory').html(propertyData[2]);
				productPropertyUpdate = 0;
			}
		});
	}
});

$(document).on(
		'click',
		'.left-controller',
		function() {
			if (currentLeftClick > 0 && currentRightClick != 0) {
				currentPosition = currentPosition + 80;
				$('.product-figure-list').css({
					"left" : currentPosition
				});
				currentLeftClick -= 1;
				currentRightClick -= 1;
			}
			console.log("Left: " + currentLeftClick + " Totalimage: "
					+ totalMoreImage);
		});

$(document).on(
		'click',
		'.right-controller',
		function() {
			if (currentRightClick < totalMoreImage) {
				currentPosition = currentPosition - 80;
				$('.product-figure-list').css({
					"left" : currentPosition
				});
				currentRightClick += 1;
				currentLeftClick += 1;
			}
			console.log("Right: " + currentRightClick + " Totalimage: "
					+ totalMoreImage);
		});

$(document).keydown(function(e) {
	var keycode = e.keyCode;

	if (keycode == 27) {
		$('#popup_container').hide();
		$('#popup_container').css({
			"opacity" : "0"
		});
		$('#choose-option-popup').hide();
		$('#show-exchange-popup').hide();
		$('#show-invoice-popup').hide();
		$('#show-coupon-popup').hide();
		$('#contact-me-popup').hide();
		$('body').css({
			"overflow" : "auto"
		});
	}
});
$(document).on('click', '#Products_instantBuy', function() {
	if ($('#Products_instantBuy').is(':checked')) {
		$('.instant-buy-details').fadeIn('slow');
	} else {
		$('.instant-buy-details').fadeOut('fast');
	}
});
$(document).on('click', '.ly-close, .close-contact', function() {
	$('#popup_container').hide();
	$('#popup_container').css({
		"opacity" : "0"
	});
	$('#choose-option-popup').hide();
	$('#show-exchange-popup').hide();
	$('#show-invoice-popup').hide();
	$('#show-coupon-popup').hide();
	$('#contact-me-popup').hide();
	$('.contact-textarea').val('');
	$('body').css({
		"overflow" : "auto"
	});
});
$(document).on('keyup',
		'#Products_price, #Products_quantity, .quantity, .price', function() {
			var $th = $(this);
			$th.val($th.val().replace(/[^0-9]/g, function(str) {
				return '';
			}));
		});
$(document).on('mouseup', '#popup_container', function(e) {
	var container = $(".popup");

	if (!container.is(e.target) // if the target of the click isn't the
			// container...
			&& container.has(e.target).length === 0) // ... nor a descendant
	// of the container
	{
		container.hide();
		$('#popup_container').hide();
		$('#popup_container').css({
			"opacity" : "0"
		});
		$('#choose-option-popup').hide();
		$('#show-exchange-popup').hide();
		$('#show-coupon-popup').hide();
		$('#show-invoice-popup').hide();
		$('#contact-me-popup').hide();
		$('body').css({
			"overflow" : "auto"
		});
	}
});

$(document).on('click', '.chat-link.userNameLink', function(e){
	e.preventDefault();
	var userId = $(this).data("userid");
	var userRead = parseInt($(this).data("userread"));
	if(userId != ""){
		messageUserScrollPosition = $('.message-vertical-tab-container').scrollTop();
		console.log("messageUserScrollPosition: "+messageUserScrollPosition);
		$.ajax({
			url: yii.urls.base + '/message/' + userId,
			type: "post",
			dataType: "html",
			success: function(responce){
				$('#content').html(responce);
				$('.message-vertical-tab-container').scrollTop(messageUserScrollPosition);
				if(userRead == 1){
					var readCount = parseInt($('.message-count').html());
					if(readCount == 1){
						$('.message-count').addClass('message-hide');
					}else{
						readCount -= 1;
						$('.message-count').html(readCount);
					}
					liveCount -= 1;
				}
				if(!$('.chat-message-container').is(':visible')){
					$('.message-vertical-tab-container').hide();
					$('.chat-message-container').show();
				}
			}
		});
	}else{
		console.log("userId Empty");
	}
});

// function to set the height on fly
function autoHeight() {
  $('#content').css('min-height', 0);
  $('#content').css('min-height', (
    $(document).height() 
    - $('.qMart-menu').height() 
    - $('.footer').height()
  ));
}

// onDocumentReady function bind
$(document).ready(function() {
  autoHeight();
  	
});

window.setInterval(function(){
  if ($('body').css('overflow') == 'auto'){
	  	$('body').css('overflow','visible');
	}
}, 1000);

// onResize bind of the function
$(window).resize(function() {
  autoHeight();
});

function loadChatDetails(userId){
	if(userId != ""){
		$.ajax({
			url: yii.urls.base + '/message/' + userId,
			type: "post",
			dataType: "html",
			success: function(responce){
				$('#content').html(responce);
			}
		});
	}else{
		console.log("userId Empty");
	}
	return false;
}

/*$(document).ready(function() {
	$('.commenter-text').keydown(function(e) {
		var user = $('.logindetails').val();
		if (user == '') {
			window.location = yii.urls.base+ '/login';
		} else {
			var keycode = e.keyCode;

			if (keycode == 13) {
				var reg =/<(.|\n)*?>/g; 
				var comment = $('.commenter-text').val();
				var itemId = $('.item-id').val();
				$('.commenter-text').val('');
				var commentCount = $("#commentCount").val();
				$('.commenter-button').attr('disaled');
				if (comment != '') {
					if (reg.test(comment) == true) {
						$('.comment-error').html(Yii.t('app','Comment cannot have html'));
						$(".comment-error").fadeIn();
						setTimeout(function() {
									$(".comment-error").fadeOut();
						}, 3000);
					}else{
						// alert(comment);
						$.ajax({
							url : yii.urls.base+ '/item/products/savecomment',
							type : "post",
							dataType : "html",
							data : {'comment' : comment,'itemId' : itemId},
							beforeSend : function() {
									$('.commenter-button').html(Yii.t('app','Posting')+ '...');
							},
							success : function(responce) {
									$("#countdown").val(120);
									$('.commenter-button').html('Post');
									$('.commenter-button').removeAttr('disaled');
									var output = responce.trim();
									if (output) {
										$(".empty-comment").hide();
										$('.comment ol').append(output);
										$('.commenter-text').val('');
										var incCmnt = Number(commentCount)+ Number(1);
										$("#commentcnt").html('('+ incCmnt+ ')');
										$("#commentCount").val(incCmnt);
										$(".comment").scrollTop($(".comment")[0].scrollHeight);
									} else {
										$('.comment-error').html(Yii.t('app','Comment cannot be empty'));
										$('.commenter-text').val('');
										$(".comment-error").fadeIn();
										setTimeout(function() {
														$(".comment-error").fadeOut();
										},3000);
									}
							}
						});
					}
				} else {
					$('.comment-error').html(Yii.t('app','Comment cannot be empty'));
					$(".comment-error").fadeIn();
					setTimeout(function() {
								$(".comment-error").fadeOut();
					}, 3000);
				}
				return false;
			}
		}
	});
});*/

function paymentMethod(){
	$('.revieworder-head ul li').removeClass('active');
	$('.paymentdetails-li').addClass('active');
	$('.revieworder-details').hide();
	$('.payment-details').fadeIn();
}

function confirmModal(type, data, param){
	//$('.modal-backdrop').show();
	//$('body').addClass('modal-open');
	if(type == 'method'){
		var button = '<a class="margin-bottom-0 post-btn" href="#"' 
			+ 'onclick="$(\'#confirm_popup_container\').modal(\'hide\');'+data+'(\''+param+'\');">'
			+Yii.t('app','ok')+'</a>';
		/*var button = '<button type="button" class="btn btn-sm btn-success btn-confirm-ok btn-done" '+
			'id="btn-doneid" '+ 'onclick="$(\'#confirm_popup_container\').hide();$(\'#confirm-popup\').hide();'+data+'(\''+param+'\');">'
			+Yii.t('app','ok')+'</button>';*/
	}else if(type == 'link'){
		if(param == 'fullLink'){
			var callUrl = data;
		}else{
			var callUrl = yii.urls.base+'/'+data+param;
		}
		var button = '<a href="'+callUrl+'" '+'class="post-btn margin-bottom-0" >'+ 
						Yii.t('app','ok')+'</button>';
	}
	
	$('.confirm-btn').html(button);
	//$('#confirm_popup_container').show();
	$('#confirm_popup_container').modal('show')   
	//$('#confirm_popup_container').css({'opacity':'1'});
	//$('#confirm-popup').show();
}

function closeConfirm() {
	$('#confirm_popup_container').modal('hide');
	//$('#confirm_popup_container').css({'opacity':'0'});
	//$('#confirm-popup').hide();
}

function deleteShipping(id) {
	window.location.href = yii.urls.base+ '/buynow/useraction/delete/id/'+id;
}

function deleteItem(id) {
	window.location.href = yii.urls.base+ '/products/delete/'+id;
}

function soldItems(id, value) {
	/*var value = 0;
	if ($('#soldOut').is(':checked')) {
		value = 1;
	}*/
	$.ajax({
		type : 'POST',
		url : yii.urls.base + '/item/products/soldItem',
		data : {
			id : id,
			value : value
		},
		success : function(data) {
			var appendText = '';
			if(value == 0){
				appendText = '<a href="javascript: void(0);" data-loading-text="Posting..." id="load" data-toggle="modal" '
								+'class="sold-btn" onclick="soldItems(\''+id+'\', \'1\')">'
								+Yii.t('app','Mark as sold')+'</a>';
			}else{
				appendText = '<a href="javascript: void(0);" data-loading-text="Posting..." id="load" data-toggle="modal" '
								+'class="sold-btn sale-btn" onclick="soldItems(\''+id+'\', \'0\')">'
								+Yii.t('app','Back to sale')+'</a>';
			}
			appendText += '<a data-target="#" data-toggle="modal" href="javascript:void(0);" class="delete-btn" '
							+'onclick="confirmModal(\'method\', \'deleteItem\', \''+id+'\')">'
								+Yii.t('app','Delete Sale')+'</a>'
			$('.edit-btn').html(appendText);
			console.log('success');
		}
	});
}

function chatandbuy() {
	var user = $('.logindetails').val();
	if (user == '') {
		window.location = yii.urls.base + '/login';
	} else {
		$('#popup_container').show();
		$('#popup_container').css({
			"opacity" : "1"
		});
		$('#contact-me-popup').show();
		$('body').css({
			"overflow" : "hidden"
		});
	}
}

function addshippingContainer() {
	var shippingSelect = $('.country').val();
	// console.log(shippingSelect);
	if (shippingSelect != '') {
		var shipdetails = shippingSelect.split("-");
		// console.log(shipdetails);
		if (shippingArray.indexOf(shipdetails[0]) < 0) {
			shippingArray.push(shipdetails[0]);
			var output = "";
			output += '<ul class="shipping-details-' + shipdetails[0] + '">';
			output += '<li>' + shipdetails[1] + '</li>';
			output += '<li><input type="text" value="" name="Products[shipping][' + shipdetails[0]
					+ ']" style="margin-left: 3px;" class="form-control ship-to-' + shipdetails[0]
					+ '" onkeypress="return isNumber(event)" maxlength="9"/></li>';
			output += '<li><p onclick="delectShipping(' + shipdetails[0]
					+ ')"><i class="fa fa-trash-o"></i></p></li>';
			output += '</ul>';
			$('.shipping-details').append(output);
			console.log(shippingArray);
		} else {
			console.log(shippingArray.indexOf(shipdetails[0]));
		}
	}
	$(".country option:selected").removeAttr("selected");
}

function delectShipping(shippingId) {
	var deleteSelector = ".shipping-details-" + shippingId;
	$(deleteSelector).remove();
	var deleteIndex = shippingArray.indexOf(shippingId.toString());
	console.log('shippingId: ' + shippingId + " index: " + deleteIndex);
	console.log(shippingArray);
	shippingArray.splice(deleteIndex, 1);
	$(".country option:selected").removeAttr("selected");
	console.log(shippingArray);
}

function composeOptions() {
	// Products[productCondition]
	var alpha = /[a-zA-Z]/gi;
	$('#Products_sizeOption_em_').hide();
	var size = $('.option').val().trim();
	var quantity = $('.quantity').val().trim();
	var price = $('.price').val().trim();
	var output = '';
	var quantity = quantity.replace(/\s/g, "");
	var price = price.replace(/\s/g, "");
	$('.quantity').val(quantity);
	$('.price').val(price);
	if (specials.test(size) || specials.test(quantity) || specials.test(price)) {
		$('#Products_sizeOption_em_').html(
				Yii.t('admin', 'Special Characters not allowed.'));
		$('#Products_sizeOption_em_').show();
		$('.option-add-btn').attr('disabled', 'disabled');
		setTimeout(function() {
			$('#Products_sizeOption_em_').fadeOut();
		}, 5000);
		return false;
	}

	if (alpha.test(quantity) || alpha.test(price)) {
		$('#Products_sizeOption_em_').html(
				Yii.t('admin', 'Only numbers are allowed for quantity and price.'));
		$('#Products_sizeOption_em_').show();
		$('.option-add-btn').attr('disabled', 'disabled');
		setTimeout(function() {
			$('#Products_sizeOption_em_').fadeOut();
		}, 5000);

		return false;
	}

	if (size == '' || quantity == '' || price == '') {
		$('#Products_sizeOption_em_').html(
				Yii.t('admin', 'Variant or Quantity or Price cannot be empty'));
		$('#Products_sizeOption_em_').show();
		$('.option-add-btn').attr('disabled', 'disabled');
		setTimeout(function() {
			$('#Products_sizeOption_em_').fadeOut();
		}, 5000);
		return false;
	}else if(size.length > 80){
		$('#Products_sizeOption_em_').html(
				Yii.t('admin', 'Variant should not exceed 80 characters'));
		$('#Products_sizeOption_em_').show();
		$('.option-add-btn').attr('disabled', 'disabled');
		setTimeout(function() {
			$('#Products_sizeOption_em_').fadeOut();
		}, 5000);
		return false;
	}

	if (price < 1 || quantity < 1) {
		$('#Products_sizeOption_em_').html(
				Yii.t('admin', 'Price and Quantity should be greater than zero'));
		$('#Products_sizeOption_em_').show();
		$('.option-add-btn').attr('disabled', 'disabled');
		setTimeout(function() {
			$('#Products_sizeOption_em_').fadeOut();
		}, 5000);
		return false;
	}
	if (globalSize.indexOf(size) == -1) {
		globalSize.push(size);
		var sizeClass = size.replace(/\s/g, "-");
		output += '<div class="option-' + sizeClass + '">';
		output += '<input class="disp-size" type="text" style="width: 100px; margin-right: 4px;" name="Products[productOptions]['
				+ size
				+ '][option]" value="'
				+ size
				+ '" readonly onfocus="this.blur()">';
		output += '<input class="disp-qty" type="text" style="width: 100px; margin-right: 4px;" name="Products[productOptions]['
				+ size
				+ '][quantity]" value="'
				+ quantity
				+ '" readonly onfocus="this.blur()">';
		output += '<input class="disp-price" type="text" style="width: 100px; margin-right: 4px;" name="Products[productOptions]['
				+ size
				+ '][price]" value="'
				+ price
				+ '" readonly onfocus="this.blur()">';
		output += '<span class="display-delete" style="cursor: pointer; color: rgb(255, 51, 51); font-weight: bold; margin-left: 18px;" onclick="deleteOption(\''
				+ size + '\')">X</span></div>';
		$('.added-options').append(output);
	} else {
		$('#Products_sizeOption_em_').html('Varient already exist');
		$('#Products_sizeOption_em_').show();
		setTimeout(function() {
			$('#Products_sizeOption_em_').fadeOut();
		}, 5000);
	}
	$('.option').val('');
	$('.quantity').val('');
	$('.price').val('');
	$('.option').focus();
	return false;
}

function deleteOption(size) {
	var deleteIndex = globalSize.indexOf(size);
	if (deleteIndex != -1) {
		globalSize.splice(deleteIndex, 1);
		var sizeClass = size.replace(/\s/g, "-");
		$('.option-' + sizeClass).remove();
	}
}

function postcomment() {
	var comment = $('.commenter-text').val();
	var itemId = $('.item-id').val();
	var commentCount = $("#commentCount").val();
	$('.commenter-button').attr('disaled');
	if (comment != '') {
		// alert(comment);
		$.ajax({
			url : yii.urls.base + '/item/products/savecomment',
			type : "post",
			dataType : "html",
			data : {
				'comment' : comment,
				'itemId' : itemId
			},
			beforeSend : function() {
				$('.commenter-button').html('Posting...');
			},
			success : function(responce) {
				$('.commenter-button').html('Post');
				$('.commenter-button').removeAttr('disaled');

				var output = responce.trim();
				if (output) {
					$('.comment ol').append(output);
					$('.commenter-text').val('');
					var incCmnt = Number(commentCount) + Number(1);
					$("#commentcnt").html('(' + incCmnt + ')');
					$("#commentCount").val(incCmnt);
				} else {
					$('.comment-error').html('Please try later...');
					$(".comment-error").fadeIn();
					setTimeout(function() {
						$(".comment-error").fadeOut();
					}, 3000);
				}
			}
		});
	} else {
		$('.comment-error').html('Comment cannot be empty');
		$(".comment-error").css('display','inline-block');
		
	}
}

function selectSize() {
	var size = $(".item-qty").val();
	var price = $(".item-qty option:selected").attr("pricetag")
	// var currency = $("#currency_symbol").val();
	// var value = $("#currency_value").val();
	// var original = price * value;
	// var size_price = currency+" "+original;
	$('.buy-price').html(price);
	// $('.out').html(size);
}

function selectedOptionPrice() {
	var price = $(".item-qty option:selected").attr("pricetag");
	$('.option-price').css({
		"opacity" : "1"
	});
	$('.option-price-value').html(price);
}

function addToCart() {
	var itemId = $('.item-id').val();
	var option = $('.item-option').val();
	var selectedOption = "";
	$('.carterror').html('');
	if (option == 1) {
		selectedOption = $('.item-qty').val();
		if (selectedOption == '') {
			$('.carterror').html('Select a option to continue');
			return false;
		}
	}
	if (ajaxcart == 1) {
		ajaxcart = 0;
		$.ajax({
			url : yii.urls.base + '/item/products/addtocart',
			type : "post",
			dataType : "html",
			data : {
				'selectedOption' : selectedOption,
				'itemId' : itemId
			},
			beforeSend : function() {
				$('.add-cart').html('Adding...');
			},
			success : function(responce) {
				$('.add-cart').html('Add to cart');
				var output = responce.trim();
				if (output) {
					window.location = output;
				} else {
					$('.carterror').html('Please try later...');
				}
				ajaxcart = 1;
			}
		});
	}
}

function updatecart(merchantId, itemId) {
	var cartGrid = '.shop' + merchantId;
	var qtySelector = '.cart-qty-' + itemId;
	var selectedQty = $(qtySelector).val();

	if (typeof (qtyCart) == 'undefined') {
		qtyCart = new Array();
	}

	if (typeof (qtyCart[itemId]) == 'undefined' || qtyCart[itemId] == 0) {
		qtyCart[itemId] = 1;
		$.ajax({
			url : yii.urls.base + '/cart',
			type : "post",
			dataType : "html",
			data : {
				'selectedQty' : selectedQty,
				'itemId' : itemId,
				'merchantId' : merchantId
			},
			beforeSend : function() {
				// $('.add-cart').html('Adding...');
			},
			success : function(responce) {
				// $('.add-cart').html('Add to cart');
				var output = responce.trim();
				if (output != 'false') {
					$(cartGrid).html(output);
				}
				qtyCart[itemId] = 0;
			}
		});
	}
}
/*function initialize() {
	autocomplete = new google.maps.places.Autocomplete((document
			.getElementById('Products_location')), {
		types : [ 'geocode' ]
	});
	google.maps.event.addListener(autocomplete, 'place_changed', function() {
		fillInAddress();
	});
}*/

//google.maps.event.addDomListener(window, 'load', initialize);

function fillInAddress() {
	var lat = (document.getElementById('latitude'));
	var place = autocomplete.getPlace();
	var latitude = place.geometry.location.lat();
	var longitude = place.geometry.location.lng();
	var placeDetails = place.address_components;
	var count = placeDetails.length;
	var country = "";
	while(count != 0 && country == ""){
		if(placeDetails[count-1].types[0] == "country"){
			country = placeDetails[count-1].short_name;
			$('#shippingcountry').val(country);
		}
		count--;
	}
	//console.log(country);
	$("#latitude").val(latitude);
	$("#longitude").val(longitude);
}

function getLatLong(initialLoad){
	initialLoad = typeof initialLoad !== 'undefined' ? initialLoad : 0;
	var baseurl= yii.urls.base ;
	var grid = document.querySelector('#fh5co-board');
	var kilometer = 25;
	var lat;
	var lon;
	
	$('.search-location').hide();
	$('.btn-worldwide').hide();
	$('.loading-btn').show();
	
	if (initialLoad == 0){
		window.google = window.google || {};
		google.maps = google.maps || {};
		(function() {
		  
		  function getScript(src) {
		    var s = document.createElement('script');
		    
		    s.src = src;
		    document.body.appendChild(s);
		  }
		  
		  var modules = google.maps.modules = {};
		  google.maps.__gjsload__ = function(name, text) {
		    modules[name] = text;
		  };
		  
		  google.maps.Load = function(apiLoad) {
		    delete google.maps.Load;
		    apiLoad([0.009999999776482582,[[["https://mts0.googleapis.com/vt?lyrs=m@281000000\u0026src=api\u0026hl=en-US\u0026","https://mts1.googleapis.com/vt?lyrs=m@281000000\u0026src=api\u0026hl=en-US\u0026"],null,null,null,null,"m@281000000",["https://mts0.google.com/vt?lyrs=m@281000000\u0026src=api\u0026hl=en-US\u0026","https://mts1.google.com/vt?lyrs=m@281000000\u0026src=api\u0026hl=en-US\u0026"]],[["https://khms0.googleapis.com/kh?v=162\u0026hl=en-US\u0026","https://khms1.googleapis.com/kh?v=162\u0026hl=en-US\u0026"],null,null,null,1,"162",["https://khms0.google.com/kh?v=162\u0026hl=en-US\u0026","https://khms1.google.com/kh?v=162\u0026hl=en-US\u0026"]],[["https://mts0.googleapis.com/vt?lyrs=h@281000000\u0026src=api\u0026hl=en-US\u0026","https://mts1.googleapis.com/vt?lyrs=h@281000000\u0026src=api\u0026hl=en-US\u0026"],null,null,null,null,"h@281000000",["https://mts0.google.com/vt?lyrs=h@281000000\u0026src=api\u0026hl=en-US\u0026","https://mts1.google.com/vt?lyrs=h@281000000\u0026src=api\u0026hl=en-US\u0026"]],[["https://mts0.googleapis.com/vt?lyrs=t@132,r@281000000\u0026src=api\u0026hl=en-US\u0026","https://mts1.googleapis.com/vt?lyrs=t@132,r@281000000\u0026src=api\u0026hl=en-US\u0026"],null,null,null,null,"t@132,r@281000000",["https://mts0.google.com/vt?lyrs=t@132,r@281000000\u0026src=api\u0026hl=en-US\u0026","https://mts1.google.com/vt?lyrs=t@132,r@281000000\u0026src=api\u0026hl=en-US\u0026"]],null,null,[["https://cbks0.googleapis.com/cbk?","https://cbks1.googleapis.com/cbk?"]],[["https://khms0.googleapis.com/kh?v=84\u0026hl=en-US\u0026","https://khms1.googleapis.com/kh?v=84\u0026hl=en-US\u0026"],null,null,null,null,"84",["https://khms0.google.com/kh?v=84\u0026hl=en-US\u0026","https://khms1.google.com/kh?v=84\u0026hl=en-US\u0026"]],[["https://mts0.googleapis.com/mapslt?hl=en-US\u0026","https://mts1.googleapis.com/mapslt?hl=en-US\u0026"]],[["https://mts0.googleapis.com/mapslt/ft?hl=en-US\u0026","https://mts1.googleapis.com/mapslt/ft?hl=en-US\u0026"]],[["https://mts0.googleapis.com/vt?hl=en-US\u0026","https://mts1.googleapis.com/vt?hl=en-US\u0026"]],[["https://mts0.googleapis.com/mapslt/loom?hl=en-US\u0026","https://mts1.googleapis.com/mapslt/loom?hl=en-US\u0026"]],[["https://mts0.googleapis.com/mapslt?hl=en-US\u0026","https://mts1.googleapis.com/mapslt?hl=en-US\u0026"]],[["https://mts0.googleapis.com/mapslt/ft?hl=en-US\u0026","https://mts1.googleapis.com/mapslt/ft?hl=en-US\u0026"]],[["https://mts0.googleapis.com/mapslt/loom?hl=en-US\u0026","https://mts1.googleapis.com/mapslt/loom?hl=en-US\u0026"]]],["en-US","US",null,0,null,null,"https://maps.gstatic.com/mapfiles/","https://csi.gstatic.com","https://maps.googleapis.com","https://maps.googleapis.com",null,"https://maps.google.com"],["https://maps.gstatic.com/maps-api-v3/api/js/19/2","3.19.2"],[630100503],1,null,null,null,null,null,"initialize",null,null,1,"https://khms.googleapis.com/mz?v=162\u0026",null,"https://earthbuilder.googleapis.com","https://earthbuilder.googleapis.com",null,"https://mts.googleapis.com/vt/icon",[["https://mts0.googleapis.com/vt","https://mts1.googleapis.com/vt"],["https://mts0.googleapis.com/vt","https://mts1.googleapis.com/vt"],null,null,null,null,null,null,null,null,null,null,["https://mts0.google.com/vt","https://mts1.google.com/vt"],"/maps/vt",281000000,132],2,500,["https://geo0.ggpht.com/cbk","https://g0.gstatic.com/landmark/tour","https://g0.gstatic.com/landmark/config","","https://www.google.com/maps/preview/log204","","https://static.panoramio.com.storage.googleapis.com/photos/",["https://geo0.ggpht.com/cbk","https://geo1.ggpht.com/cbk","https://geo2.ggpht.com/cbk","https://geo3.ggpht.com/cbk"]],["https://www.google.com/maps/api/js/master?pb=!1m2!1u19!2s2!2sen-US!3sUS!4s19/2","https://www.google.com/maps/api/js/widget?pb=!1m2!1u19!2s2!2sen-US"],1,0], loadScriptTime);
		  };
		  var loadScriptTime = (new Date).getTime();
		  //getScript(baseurl+"/js/main.js");
		})();
	}

	  // Try HTML5 geolocation
	  if(navigator.geolocation) {
		  
	    navigator.geolocation.getCurrentPosition(function(position) {
	    	
	      var pos = new google.maps.LatLng(position.coords.latitude,
	                                       position.coords.longitude);
	      	//alert(pos);
			lat = pos.lat();
			lon = pos.lng();
			if (initialLoad == 0){
				var latlng = new google.maps.LatLng(lat, lon);
			    //placeMarker(event.latLng);
			    marker.setPosition(latlng)
			    geocoder.geocode({'latLng': latlng}, function(results, status) {
			        if (status == google.maps.GeocoderStatus.OK) {
			        console.log(results)
			          if (results[1]) {
			           //alert(results[0].formatted_address)
			         
			               document.getElementById("pac-input").value = results[0].formatted_address;
			               document.getElementById("map-latitude").value = lat;
			               document.getElementById("map-longitude").value = lon;
			               map.setCenter(latlng); // Set map center to marker position
			               map.setZoom(10);
	
			          } else {
			            alert("No results found");
			          }
			        } else {
			          alert("Geocoder failed due to: " + status);
			        }
			      });
			}else{
				var latlng = new google.maps.LatLng(lat, lon);
			    marker.setPosition(latlng);
			    map.setCenter(latlng); // Set map center to marker position
	            map.setZoom(10);
				document.getElementById("map-latitude").value = lat;
				document.getElementById("map-longitude").value = lon;
				getLocationData(1);
			}
			
			
			/*$.post(baseurl+'/site/loadresults', {"lat":lat, "lon":lon,"loadMore":1},
				function(datas) {
				    //console.log(datas);
				    var splitt = datas.split("~");
				    $('.search-location').hide();
				    $('.loading-btn').hide();
					$('.btn-worldwide').html(splitt[0]);
					$('#Products_location').val(splitt[0]);
					$('.loading-btn').show();
					$('.session-data').removeClass('hidden');
					$('.session-data').show();
					$("#products").html($.trim(splitt[1]));  
					initialize();
					offset = 32;
				}
			);*/
			
	    },
        function (error) {
	        /*   $.post(baseurl+'/site/loadresults', {"loadMore":1},
					function(datas) {
	        	   var splitt = datas.split("~");
				    $('.search-location').hide();
				    $('.loading-btn').hide();
					$('.btn-worldwide').html(splitt[0]);
					$('#Products_location').val(splitt[0]);
					if(splitt[1] == '1')
						$('.show-world-wide').show();
					else
						$('.show-world-wide').hide();
					$('.loading-btn').show();
					$('.session-data').removeClass('hidden');
					$('.session-data').show();
					$("#fh5co-board").html($.trim(splitt[2])); 
					salvattore.recreateColumns(grid);
					if (splitt[0] != "")
						$('.miles').html(Yii.t('admin', splitt[0]));
					if(initialLoad == 0)
						$('#nearmemodals').modal('toggle');
					$(".more-listing").show();
					customCheckbox("sport[]");
					//initialize();
					offset = 32;
					adsoffset = 8;
					locationTracker = 1;
					/*
					    $('.loading-btn').hide();
				//var output = responce.trim(); 
				//console.log(responce); 
				//$('.btn-worldwide').html(splitt[0]);
				//$('#Products_location').val(splitt[0]);
				$('.btn-worldwide').removeClass('session-data');
				$('.btn-worldwide').removeClass('btn-worldwide-placename');
				$('.btn-worldwide').removeClass('hidden');
				//$('.session-data').show();
				//$('.btn-worldwide').html(Yii.t('app','World wide '));
	           
	            $('.loading-btn').hide();
				$('.btn-worldwide').show();
				$('.loading-btn').hide();
				$("#products").html($.trim(responce));  
				initialize();*
					}
				); */
	         if (error.code == error.PERMISSION_DENIED)
	            console.log("you denied me :-(");
	    });

	  }else{
		  console.log('Browser not support Geo Location');
	  }
	  
	  
}

function promotionsearch(searchType){
	var searchTypeSelector = "."+searchType;
	var hiddenfieldSelector = searchTypeSelector+"-filter";
	
	if($(searchTypeSelector).is(':checked'))
	    $(hiddenfieldSelector).val('1');  // checked
	else
		$(hiddenfieldSelector).val('0'); 
	
	urgent = $('.urgent-filter').val();
	ads = $('.ads-filter').val();
	
	getLocationData(1);
}

function gotogetLocationData(){
	if($('#pac-input').val().trim() == ''){
		return false;
	}else{
		getLocationData();
	}
}
function getLocationData(initialLoad){
	
	initialLoad = typeof initialLoad !== 'undefined' ? initialLoad : 0;
	var grid = document.querySelector('#fh5co-board');
	
	$('#Products_location').removeClass('warning');
	/*var lat = $('#latitude').val();
	var lon = $('#longitude').val();*/
	var lat = $('#map-latitude').val();
	var lon = $('#map-longitude').val();
	var distance = $('#select-mapdistance').val();
	var baseurl= yii.urls.base ;
	var category = $('.category-filter').val();
	var search = $('.search-filter').val();
	var subcategory = $('.subcategory-filter').val();
	var urgent = $('.urgent-filter').val();
	var ads = $('.ads-filter').val();
	var catrest = $('#catrest').val();
	/*var locationText = $('#Products_location').val();
	if(locationText == ""){
		$('#Products_location').addClass('warning');
		return false;
	}*/
	if(urgent == "0"){
		urgent = '';
	}

	if(ads == "0"){
		ads = '';
	}
	if(locationTracker == 1){
		locationTracker = 0;
		$.ajax({
			type : 'POST',
			url : yii.urls.base + '/site/loadresults',
			data : {
				lat : lat,
				lon : lon,
				distance : distance,
				"loadMore" : 1,
				category : category, 
				search : search, 
				subcategory : subcategory, 
				urgent : urgent, 
				ads : ads,
				catrest : catrest
			},
			beforeSend : function(){
				$('.search-location').hide();
				$('.btn-worldwide').hide();
				$('.loading-btn').show();
				// alert(urgent);
				// alert(ads);
			},
			success : function(datas) {
				//console.log(datas);
			    var splitt = datas.split("~");
			    $('.search-location').hide();
			    $('.loading-btn').hide();
				$('.btn-worldwide').html(splitt[0]);
				$('#Products_location').val(splitt[0]);
				if(splitt[1] == '1')
					$('.show-world-wide').show();
				else
					$('.show-world-wide').hide();
				$('.loading-btn').show();
				$('.session-data').removeClass('hidden');
				$('.session-data').show();
				$("#fh5co-board").html($.trim(splitt[2])); 
				salvattore.recreateColumns(grid);
				if (splitt[0] != "")
					$('.miles').html(Yii.t('admin', splitt[0]));
				if(initialLoad == 0)
					$('#nearmemodals').modal('toggle');
				$(".more-listing").show();
				customCheckbox("sport[]");
				//initialize();
				offset = 32;
				adsoffset = 8;
				locationTracker = 1;
			}
		});
	}
	
	return false;
}



function showexchangepopup() {
	var user = $('.logindetails').val();
	if (user == '') {
		window.location = yii.urls.base + '/login';
	} else {
		$('#popup_container').show();
		$('#popup_container').css({
			"opacity" : "1"
		});
		// $(".btn-area-exchange").hide();
		$('#show-exchange-popup').show();
		$('body').css({
			"overflow" : "hidden"
		});
	}
}

function showcouponpopup() {
	$('#popup_container').show();
	$('#popup_container').css({
		"opacity" : "1"
	});
	$('#show-coupon-popup').show();
	$('body').css({
		"overflow" : "hidden"
	});
}

/******************Rating Starts**************************/

function showreviewpopup(exid,userid){
	$('.exchangeid').val(exid);
	$('.review-receiver').val(userid);
	$('#popup_container').show();
	$('#popup_container').css({
		"opacity" : "1"
	});
	$('#review-user-popup').show();
	$('body').css({
		"overflow" : "hidden"
	});
}
function editreview(id){
	$('.reviewid').val(id);
	var textarea = $('#review'+id).val();
	var ratings = $('#ratings'+id).val();
	$('#popup_container').show();
	$('#popup_container').css({
		"opacity" : "1"
	});
	$('.review-textarea').val(textarea);
	$('.current-rate').html(ratings);
	$('#rateval').val(ratings);
	
	if (ratings != 0){
		switch(ratings){
			case '5':
				$('.rating').addClass('active'); 
				
				$('.rating').addClass('fa-star'); 
				$('.rating').removeClass('fa-star-o');
				break;
			case '4':
				$('.four').addClass('active'); 
				
				$('.one').addClass('fa-star'); 
				$('.one').removeClass('fa-star-o');
				$('.two').addClass('fa-star'); 
				$('.two').removeClass('fa-star-o');
				$('.three').addClass('fa-star'); 
				$('.three').removeClass('fa-star-o');
				$('.four').addClass('fa-star'); 
				$('.four').removeClass('fa-star-o');
				$('.five').removeClass('fa-star'); 
				$('.five').addClass('fa-star-o');
				break;
			case '3':
				$('.three').addClass('active'); 
				
				$('.one').addClass('fa-star'); 
				$('.one').removeClass('fa-star-o');
				$('.two').addClass('fa-star'); 
				$('.two').removeClass('fa-star-o');
				$('.three').addClass('fa-star'); 
				$('.three').removeClass('fa-star-o');
				$('.four').removeClass('fa-star'); 
				$('.four').addClass('fa-star-o');
				$('.five').removeClass('fa-star'); 
				$('.five').addClass('fa-star-o');
				break;
			case '2':
				$('.two').addClass('active'); 
				
				$('.one').addClass('fa-star'); 
				$('.one').removeClass('fa-star-o');
				$('.two').addClass('fa-star'); 
				$('.two').removeClass('fa-star-o');
				$('.three').removeClass('fa-star'); 
				$('.three').addClass('fa-star-o');
				$('.four').removeClass('fa-star'); 
				$('.four').addClass('fa-star-o');
				$('.five').removeClass('fa-star'); 
				$('.five').addClass('fa-star-o');
				break;
			case '1':
				$('.one').addClass('active');
				
				$('.one').addClass('fa-star'); 
				$('.one').removeClass('fa-star-o');
				$('.two').removeClass('fa-star'); 
				$('.two').addClass('fa-star-o');
				$('.three').removeClass('fa-star'); 
				$('.three').addClass('fa-star-o');
				$('.four').removeClass('fa-star'); 
				$('.four').addClass('fa-star-o');
				$('.five').removeClass('fa-star'); 
				$('.five').addClass('fa-star-o');
				break;
		}
	}
	
	$('#review-edit-popup').show();
	$('.review-body-section').show();
	$('.review-response-message').hide();
	$('#').show();
	$('body').css({
		"overflow" : "hidden"
	});
}

function editsavereview(){
	var id = $('.reviewid').val();
	var reviews = $('.review-textarea').val(); //$('#review'+id).val();
	var ratings = $('.current-rate').text(); //$('#ratings'+id).val();
	
	if(ratings == 0){
		$('.review-error').show();
		$('.review-error').html(Yii.t('app', 'Please give your ratings'));
		$('.review-error').fadeIn();
		setTimeout(function() {
			$('.review-error').fadeOut();
		}, 2000);
		return;
	}
	
	if (reviews == "") {
		$('.review-textarea').val('');
		$('.review-error').show();
		$('.review-error').html(Yii.t('app', 'Please write your review'));
		$('.review-error').fadeIn();
		setTimeout(function() {
			$('.review-error').fadeOut();
		}, 2000);
		return;
	}
	
	$.ajax({
		url :  yii.urls.base + '/item/exchanges/editsavereview/',
		type : "post",
		data : {
			'reviewId' : id,
			'reviews' : reviews,
			'ratings' : ratings
		},
		beforeSending : function() {
			 $('.send-button').html('Sending...');
		},
		success : function(response) {
			
			if(response == 'success'){
				//$('.review-body-section').hide('');
				html = "<h4 class='text-center thanks-message'>"+Yii.t('app', 'Thanks for your review')+"</h4>";
				
				$('.review-body-section').hide();
				$('.review-response-message').show();
				$('.review-response-message').html(html);
				
			}else if(response == 'error'){
				//$('.review-body-section').hide('');
				html = "<h4 class='text-center thanks-message-err'>"+Yii.t('app', 'Unfortunately Your review is not sent')+
						"</h4> <h6 class='thanks-message-err text-center'>"+Yii.t('app',' Please try again Later ')+"</h6>";
				
				$('.review-body-section').hide();
				$('.review-response-message').show();
				$('.review-response-message').html(html);
			}
			setTimeout(function() {
				$('#review-user-popup').hide();
				$('#popup_container').hide();
			}, 3000);
			
			$('#review'+id).val(reviews);
			$('#ratings'+id).val(ratings);
			$('.review_subject'+id).html(reviews);
			switch(ratings){
			case "5":
				$('.review_rating .static-rating').addClass('active'); 
				$('.review_rating .static-rating').addClass('fa-star'); 
				$('.review_rating .static-rating').removeClass('fa-star-o');
				
				break;
			case "4":
				$('.edit-4'+id).addClass('active'); 
				/*
				if ($('.edit-1'+id).hasClass('active')){
					$('.edit-1'+id).addClass('fa-star'); 
					$('.edit-1'+id).removeClass('fa-star-o');
				}
				if ($('.edit-2'+id).hasClass('active')){
					$('.edit-2'+id).addClass('fa-star'); 
					$('.edit-2'+id).removeClass('fa-star-o');
				}
				if ($('.edit-3'+id).hasClass('active')){
					$('.edit-3'+id).addClass('fa-star'); 
					$('.edit-3'+id).removeClass('fa-star-o');
				}
				if ($('.edit-4'+id).hasClass('active')){
					$('.edit-4'+id).addClass('fa-star'); 
					$('.edit-4'+id).removeClass('fa-star-o');
				}
				if ($('.edit-5'+id).hasClass('fa-star')){
					$('.edit-5'+id).removeClass('fa-star'); 
					$('.edit-5'+id).addClass('fa-star-o');
				}*/
				$('.edit-1'+id).addClass('fa-star'); 
				$('.edit-1'+id).removeClass('fa-star-o');
				$('.edit-2'+id).addClass('fa-star'); 
				$('.edit-2'+id).removeClass('fa-star-o');
				$('.edit-3'+id).addClass('fa-star'); 
				$('.edit-3'+id).removeClass('fa-star-o');
				$('.edit-4'+id).addClass('fa-star'); 
				$('.edit-4'+id).removeClass('fa-star-o');
				$('.edit-5'+id).removeClass('fa-star'); 
				$('.edit-5'+id).addClass('fa-star-o');
				
				break;
			case '3':
				$('.edit-3'+id).addClass('active'); 
				
				$('.edit-1'+id).addClass('fa-star'); 
				$('.edit-1'+id).removeClass('fa-star-o');
				$('.edit-2'+id).addClass('fa-star'); 
				$('.edit-2'+id).removeClass('fa-star-o');
				$('.edit-3'+id).addClass('fa-star'); 
				$('.edit-3'+id).removeClass('fa-star-o');
				$('.edit-4'+id).removeClass('fa-star'); 
				$('.edit-4'+id).addClass('fa-star-o');
				$('.edit-5'+id).removeClass('fa-star'); 
				$('.edit-5'+id).addClass('fa-star-o');
				break;
			case '2':
				$('.edit-2'+id).addClass('active'); 
				
				$('.edit-1'+id).addClass('fa-star'); 
				$('.edit-1'+id).removeClass('fa-star-o');
				$('.edit-2'+id).addClass('fa-star'); 
				$('.edit-2'+id).removeClass('fa-star-o');
				$('.edit-3'+id).removeClass('fa-star'); 
				$('.edit-3'+id).addClass('fa-star-o');
				$('.edit-4'+id).removeClass('fa-star'); 
				$('.edit-4'+id).addClass('fa-star-o');
				$('.edit-5'+id).removeClass('fa-star'); 
				$('.edit-5'+id).addClass('fa-star-o');
				break;
			case '1':
				$('.edit-1'+id).addClass('active'); 
				
				$('.edit-1'+id).addClass('fa-star'); 
				$('.edit-1'+id).removeClass('fa-star-o');
				$('.edit-2'+id).removeClass('fa-star'); 
				$('.edit-2'+id).addClass('fa-star-o');
				$('.edit-3'+id).removeClass('fa-star'); 
				$('.edit-3'+id).addClass('fa-star-o');
				$('.edit-4'+id).removeClass('fa-star'); 
				$('.edit-4'+id).addClass('fa-star-o');
				$('.edit-5'+id).removeClass('fa-star'); 
				$('.edit-5'+id).addClass('fa-star-o');
				break;
		}
		$('.current-rate').html(ratings);
		$('#rateval').val(ratings);
		
		}
	});
	
	
}
function saveReviewPopup(){
	
	var sender = $('.review-sender').val();
	var receiver = $('.review-receiver').val();
	var msg = $('.review-textarea').val();
	var exchangeId = $('.exchangeid').val();
	var reviewType = $('#reviewType').val();
	var message = msg.trim();
	
	if(rating == 0){
		$('.review-error').show();
		$('.review-error').html(Yii.t('app', 'Please give your ratings'));
		$('.review-error').fadeIn();
		setTimeout(function() {
			$('.review-error').fadeOut();
		}, 2000);
		return;
	}
	
	if (message == "") {
		$('.review-textarea').val('');
		$('.review-error').show();
		$('.review-error').html(Yii.t('app', 'Please write your review'));
		$('.review-error').fadeIn();
		setTimeout(function() {
			$('.review-error').fadeOut();
		}, 2000);
		return;
	}
	
	$.ajax({
		
			url :  yii.urls.base + '/item/exchanges/savereview/',
			type : "post",
			//dataType : "html",
			data : {
				'sender' : sender,
				'receiver' : receiver,
				'message' : message,
				'exchangeId':exchangeId,
				'rating':rating,
				'reviewType':reviewType
			},
			beforeSend : function() {
				 $('.send-button').html('Sending...');
			},
			success : function(response) {
				
				$('.review-btn'+exchangeId).hide();
				if(response == 'success'){
					//$('.review-body-section').hide('');
					html = "<h4 class='text-center thanks-message'>"+Yii.t('app', 'Thanks for your review')+"</h4>";
					$('.review-body-section').html(html);
				}else if(response == 'error'){
					//$('.review-body-section').hide('');
					html = "<h4 class='text-center thanks-message-err'>"+Yii.t('app', 'Unfortunately Your review is not sent')+
							"</h4> <h6 class='thanks-message-err text-center'>"+Yii.t('app',' Please try again Later ')+"</h6>";
					$('.review-body-section').html(html);
				}
				setTimeout(function() {
					$('#review-user-popup').hide();
					$('#popup_container').hide();
				}, 3000);
				
			}
		
		
	});
	
}
$(document).on('mouseover', '.one', function(){
	$('.rating').removeClass('active'); 
	$('.one').addClass('hover');  
	$('.two').removeClass('hover'); 
	$('.three').removeClass('hover'); 
	$('.four').removeClass('hover'); 
	$('.five').removeClass('hover');
	if ($('.one').hasClass('fa-star-o')){
		$('.one').addClass('fa-star'); 
		$('.one').removeClass('fa-star-o');
	}
	$('.current-rate').html('1');
});
$(document).on('mouseover', '.two', function(){
	$('.rating').removeClass('active'); 
	$('.one').addClass('hover'); 
	$('.two').addClass('hover'); 
	$('.three').removeClass('hover'); 
	$('.four').removeClass('hover'); 
	$('.five').removeClass('hover'); 
	if ($('.one').hasClass('fa-star-o')){
		$('.one').addClass('fa-star'); 
		$('.one').removeClass('fa-star-o');
	}
	if ($('.two').hasClass('fa-star-o')){
		$('.two').addClass('fa-star'); 
		$('.two').removeClass('fa-star-o');
	}
	
	$('.current-rate').html('2');
});
$(document).on('mouseover', '.three', function(){
	$('.rating').removeClass('active'); 
	$('.one').addClass('hover'); 
	$('.two').addClass('hover'); 
	$('.three').addClass('hover'); 
	$('.four').removeClass('hover'); 
	$('.five').removeClass('hover'); 
	
	if ($('.one').hasClass('fa-star-o')){
		$('.one').addClass('fa-star'); 
		$('.one').removeClass('fa-star-o');
	}
	if ($('.two').hasClass('fa-star-o')){
		$('.two').addClass('fa-star'); 
		$('.two').removeClass('fa-star-o');
	}
	if ($('.three').hasClass('fa-star-o')){
		$('.three').addClass('fa-star'); 
		$('.three').removeClass('fa-star-o');
	}
	
	
	$('.current-rate').html('3');
});
$(document).on('mouseover', '.four', function(){
	$('.rating').removeClass('active'); 
	$('.one').addClass('hover'); 
	$('.two').addClass('hover'); 
	$('.three').addClass('hover'); 
	$('.four').addClass('hover'); 
	$('.five').removeClass('hover'); 
	
	if ($('.one').hasClass('fa-star-o')){
		$('.one').addClass('fa-star'); 
		$('.one').removeClass('fa-star-o');
	}
	if ($('.two').hasClass('fa-star-o')){
		$('.two').addClass('fa-star'); 
		$('.two').removeClass('fa-star-o');
	}
	if ($('.three').hasClass('fa-star-o')){
		$('.three').addClass('fa-star'); 
		$('.three').removeClass('fa-star-o');
	}
	if ($('.four').hasClass('fa-star-o')){
		$('.four').addClass('fa-star'); 
		$('.four').removeClass('fa-star-o');
	}
	$('.one').addClass('fa-star'); 
	$('.one').removeClass('fa-star-o');
	$('.two').addClass('fa-star'); 
	$('.two').removeClass('fa-star-o');
	$('.three').addClass('fa-star'); 
	$('.three').removeClass('fa-star-o');
	$('.four').addClass('fa-star'); 
	$('.four').removeClass('fa-star-o');
	$('.current-rate').html('4');
});
$(document).on('mouseover', '.five', function(){
	$('.rating').removeClass('active'); 
	$('.one').addClass('hover'); 
	$('.two').addClass('hover'); 
	$('.three').addClass('hover'); 
	$('.four').addClass('hover'); 
	$('.five').addClass('hover'); 
	
	if ($('.rating').hasClass('fa-star-o')){
		$('.rating').addClass('fa-star'); 
		$('.rating').removeClass('fa-star-o');
	}
	
	$('.current-rate').html('5');
});
$(document).on('mouseout', '.rating', function(){
	$('.rating').removeClass('hover');
	if ($('.rating').hasClass('fa-star')){
		$('.rating').addClass('fa-star-o'); 
		$('.rating').removeClass('fa-star');
	}
	$('.rating').removeClass('fa-star'); 
	$('.rating').addClass('fa-star-o');
	if (rating != 0){
		switch(rating){
			case '5':
				$('.rating').addClass('active'); 
				
				$('.rating').addClass('fa-star'); 
				$('.rating').removeClass('fa-star-o');
				break;
			case '4':
				$('.four').addClass('active'); 
				
				$('.one').addClass('fa-star'); 
				$('.one').removeClass('fa-star-o');
				$('.two').addClass('fa-star'); 
				$('.two').removeClass('fa-star-o');
				$('.three').addClass('fa-star'); 
				$('.three').removeClass('fa-star-o');
				$('.four').addClass('fa-star'); 
				$('.four').removeClass('fa-star-o');
				$('.five').removeClass('fa-star'); 
				$('.five').addClass('fa-star-o');
				break;
			case '3':
				$('.three').addClass('active'); 
				
				$('.one').addClass('fa-star'); 
				$('.one').removeClass('fa-star-o');
				$('.two').addClass('fa-star'); 
				$('.two').removeClass('fa-star-o');
				$('.three').addClass('fa-star'); 
				$('.three').removeClass('fa-star-o');
				$('.four').removeClass('fa-star'); 
				$('.four').addClass('fa-star-o');
				$('.five').removeClass('fa-star'); 
				$('.five').addClass('fa-star-o');
				break;
			case '2':
				$('.two').addClass('active'); 
				
				$('.one').addClass('fa-star'); 
				$('.one').removeClass('fa-star-o');
				$('.two').addClass('fa-star'); 
				$('.two').removeClass('fa-star-o');
				$('.three').removeClass('fa-star'); 
				$('.three').addClass('fa-star-o');
				$('.four').removeClass('fa-star'); 
				$('.four').addClass('fa-star-o');
				$('.five').removeClass('fa-star'); 
				$('.five').addClass('fa-star-o');
				break;
			case '1':
				$('.one').addClass('active');
				
				$('.one').addClass('fa-star'); 
				$('.one').removeClass('fa-star-o');
				$('.two').removeClass('fa-star'); 
				$('.two').addClass('fa-star-o');
				$('.three').removeClass('fa-star'); 
				$('.three').addClass('fa-star-o');
				$('.four').removeClass('fa-star'); 
				$('.four').addClass('fa-star-o');
				$('.five').removeClass('fa-star'); 
				$('.five').addClass('fa-star-o');
				break;
		}
	}
	$('.current-rate').html(rating);
});

function ratingClick (value){
	switch(value){
		case "5":
			$('.rating').addClass('active'); 
			$('.rating').addClass('fa-star'); 
			$('.rating').removeClass('fa-star-o');
			
			break;
		case "4":
			$('.four').addClass('active'); 
			
			if ($('.rating.one').hasClass('active')){
				$('.one').addClass('fa-star'); 
				$('.one').removeClass('fa-star-o');
			}
			if ($('.rating.two').hasClass('active')){
				$('.two').addClass('fa-star'); 
				$('.two').removeClass('fa-star-o');
			}
			if ($('.rating.three').hasClass('active')){
				$('.three').addClass('fa-star'); 
				$('.three').removeClass('fa-star-o');
			}
			if ($('.rating.four').hasClass('active')){
				$('.four').addClass('fa-star'); 
				$('.four').removeClass('fa-star-o');
			}
			if ($('.rating.five').hasClass('fa-star')){
				$('.five').removeClass('fa-star'); 
				$('.five').removeClass('fa-star-o');
			}
			break;
		case '3':
			$('.three').addClass('active'); 
			
			$('.one').addClass('fa-star'); 
			$('.one').removeClass('fa-star-o');
			$('.two').addClass('fa-star'); 
			$('.two').removeClass('fa-star-o');
			$('.three').addClass('fa-star'); 
			$('.three').removeClass('fa-star-o');
			$('.four').removeClass('fa-star'); 
			$('.four').addClass('fa-star-o');
			$('.five').removeClass('fa-star'); 
			$('.five').addClass('fa-star-o');
			break;
		case '2':
			$('.two').addClass('active'); 
			
			$('.one').addClass('fa-star'); 
			$('.one').removeClass('fa-star-o');
			$('.two').addClass('fa-star'); 
			$('.two').removeClass('fa-star-o');
			$('.three').removeClass('fa-star'); 
			$('.three').addClass('fa-star-o');
			$('.four').removeClass('fa-star'); 
			$('.four').addClass('fa-star-o');
			$('.five').removeClass('fa-star'); 
			$('.five').addClass('fa-star-o');
			break;
		case '1':
			$('.one').addClass('active'); 
			
			$('.one').addClass('fa-star'); 
			$('.one').removeClass('fa-star-o');
			$('.two').removeClass('fa-star'); 
			$('.two').addClass('fa-star-o');
			$('.three').removeClass('fa-star'); 
			$('.three').addClass('fa-star-o');
			$('.four').removeClass('fa-star'); 
			$('.four').addClass('fa-star-o');
			$('.five').removeClass('fa-star'); 
			$('.five').addClass('fa-star-o');
			break;
	}
	$('.current-rate').html(value);
	$('#rateval').val(value);
	rating = value;
}
/*************************Rating Ends***************************/

function showexchangehistory(exchangeId) {
	//$('#popup_container').show();
	//$('#popup_container').css({
	//	"opacity" : "1"
	//});
	//$('#show-coupon-popup').show();
	//$('body').css({
	//	"overflow" : "hidden"
	//});
	$.ajax({
		type : 'POST',
		url : yii.urls.base + '/item/exchanges/historyview',
		data : {
			exchangeId : exchangeId
		},
		success : function(data) {
			$("#exchangeHistory").html(data);
		}
	});
}

function showcheckoutpopup() {
	var user = $('.logindetails').val();
	if (user == '') {
		window.location = yii.urls.base + '/login';
	} else {
		var itemOption = $('.item-option').val();
		var itemCartURL = $('.item-cartdata').val();
		if (itemOption == 1) {
			$('#popup_container').show();
			$('#popup_container').css({
				"opacity" : "1"
			});
			$('#choose-option-popup').show();
			$('body').css({
				"overflow" : "hidden"
			});
		} else {
			window.location = yii.urls.base + '/revieworder/' + itemCartURL;
		}
	}
}

function optionCheck() {
	var itemOption = $('.item-option').val();
	var selectOption = $('.item-qty').val();
	$('.option-error').html('');
	if (itemOption == 1 && selectOption != '') {
		$('#popup_container').hide();
		$('#popup_container').css({
			"opacity" : "0"
		});
		$('#choose-option-popup').hide();
		$('body').css({
			"overflow" : "auto"
		});
		window.location = yii.urls.base + '/revieworder/' + selectOption;
	} else {
		$('.option-error').html(
				Yii.t('app', 'Please select a Option to proceed'));
	}
}

function checkout() {
	var productId = $('.review-order-product-id').val();
	var optionChoosed = $('.product-option-hidden').val();
	var quantityChoosed = $('.product-quantity-hidden').val();

	var shippingChoosed = $('.selected-shipping').val();
	var couponCode = $('.coupon-code-hidden').val();

	if (checkoutAjax == 1) {
		checkoutAjax = 0;
		$.ajax({
			url : yii.urls.base + '/placeorder',
			type : "post",
			dataType : "html",
			data : {
				'productId' : productId,
				'optionChoosed' : optionChoosed,
				'quantityChoosed' : quantityChoosed,
				'shippingChoosed' : shippingChoosed,
				'couponCode' : couponCode
			},
			beforeSend : function() {
				$('.check-out-button').html('Please wait...');
			},
			success : function(responce) {
				// $('.send-button').html('Send');
				var output = responce.trim();
				if (output != 'false') {
					$('.payment-form').html(output);
					$('#paypal-form').submit();
				} else {
					$('.check-out-button').html('Please try again!!');
					$('.check-out-button').css({
						"background-color" : "#fd2525"
					});
				}
				checkoutAjax = 1;
			},
			failed : function() {
				$('.check-out-button').html('Please try again!!');
				$('.check-out-button').css({
					"background-color" : "#fd2525"
				});
			}
		});
	}
}

function changeCard(type){
	$('.card-type-view.active').removeClass('fa-dot-circle-o');
	$('.card-type-view.active').addClass('fa-circle-o');
	$('.card-type-view').removeClass('active');
	$('.card-type-view.'+type).removeClass('fa-circle-o');
	$('.card-type-view.'+type).addClass('fa-dot-circle-o');
	$('.card-type-view.'+type).addClass('active');
	$('.card-type').val(type);
	if(type == 'amex'){
		$('.card-cvv').attr('maxlength', '4');
	}else{
		$('.card-cvv').attr('maxlength', '3');
	}
	$('.card-cvv').val('');
}

function cardcheckout() {
	$('.ccError').html('');
	$('.ccError').hide();
	var productId = $('.review-order-product-id').val();
	var optionChoosed = $('.product-option-hidden').val();
	var quantityChoosed = $('.product-quantity-hidden').val();

	var shippingChoosed = $('.selected-shipping').val();
	var couponCode = $('.coupon-code-hidden').val();
	
	var cardType = $('.card-type').val();
	var cardNumber = $('.card-number').val();
	var expiryDate = $('.card-expiry').val();
	var cvv = $('.card-cvv').val();
	var firstname = $('.card-first-name').val();
	var lastname = $('.card-last-name').val();
	var errorFlag = 0;
	var expityvalid = /^(0[1-9]|1[0-2])\/(19|20)\d{2}$/;

	if (cardType == ''){
		$('.card-type-error').html('Select your card type');
		$('.card-type-error').show();
		errorFlag = 1;
	}
	if (cardNumber == ''){
		$('.card-number-error').html('Enter your card number');
		$('.card-number-error').show();
		errorFlag = 1;
	}else if(!numric.test(cardNumber)){
		$('.card-number-error').html('Not a valid card number');
		$('.card-number-error').show();
		errorFlag = 1;
	}
	if (expiryDate == ''){
		$('.card-expiry-error').html('Enter your card expiry date');
		$('.card-expiry-error').show();
		errorFlag = 1;
	}else if(!expityvalid.test(expiryDate)){
		$('.card-expiry-error').html('Enter a valid card expiry date MM/YYYY');
		$('.card-expiry-error').show();
		errorFlag = 1;
	}
	if (cvv == ''){
		$('.card-cvv-error').html('Enter your cvv');
		$('.card-cvv-error').show();
		errorFlag = 1;
	}else if(!numric.test(cvv)){
		$('.card-cvv-error').html('Not a valid cvv');
		$('.card-cvv-error').show();
		errorFlag = 1;
	}
	if (firstname == ''){
		$('.card-first-name-error').html('Enter your first name');
		$('.card-first-name-error').show();
		errorFlag = 1;
	}else if(!alpha.test(firstname)){
		$('.card-first-name-error').html('Not a valid first name');
		$('.card-first-name-error').show();
		errorFlag = 1;
	}
	if (lastname == ''){
		$('.card-last-name-error').html('Enter your last name');
		$('.card-last-name-error').show();
		errorFlag = 1;
	}else if(!alpha.test(lastname)){
		$('.card-last-name-error').html('Not a valid last name');
		$('.card-last-name-error').show();
		errorFlag = 1;
	}

	if (checkoutAjax == 1 && errorFlag == 0) {
		checkoutAjax = 0;
		$.ajax({
			url : yii.urls.base + '/creditcardcheckout',
			type : "post",
			dataType : "html",
			data : {
				'productId' : productId,
				'optionChoosed' : optionChoosed,
				'quantityChoosed' : quantityChoosed,
				'shippingChoosed' : shippingChoosed,
				'couponCode' : couponCode,
				'cardType' : cardType,
				'cardNumber' : cardNumber,
				'expiryDate' : expiryDate,
				'firstname' : firstname,
				'lastname' : lastname,
				'cvv' : cvv,
			},
			beforeSend : function() {
				$('.check-out-button').html('Please wait...');
				$('.check-out-button').attr('disabled', 'disabled');
			},
			success : function(responce) {
				// $('.send-button').html('Send');
				var output = responce.trim();
				if (output != 'false') {
					$('.payment-form').html(output);
					$('#paypal-form').submit();
				} else {
					$('.check-out-button').html('Please try again!!');
					$('.check-out-button').css({
						"background-color" : "#fd2525"
					});
				}
				checkoutAjax = 1;
			},
			failed : function() {
				$('.check-out-button').html('Please try again!!');
				$('.check-out-button').css({
					"background-color" : "#fd2525"
				});
			}
		});
	}
}
function generateCoupon(pid, uid, price, currency) {
	$('#couponValue').bind('input',function(){
		var couponValue = this.value;
	});
	var couponValue = $("#couponValue").val().trim();
	if (couponValue == "") {
		$('.option-error').show();
		$("#couponValue").val('');
		$(".option-error").html(Yii.t('app', 'Coupon value cannot be empty'));
		setTimeout(function() {
			$('.option-error').fadeOut();
		}, 3000);
	} else {
		$(".option-error").hide();
		if (generateCouponAjax == 1) {

			if (specials.test(couponValue)) {
				$('.option-error').show();
				$(".option-error").html(
						'<b>' + Yii.t('app', 'Special Characters not allowed.')
								+ '</b>');
				$("#couponValue").val('');
				setTimeout(function() {
					$('.option-error').fadeOut();
				}, 500);
				return false;
			} else if (alpha.test(couponValue)) {
				$('.option-error').show();
				$(".option-error").html(
						'<b>' + Yii.t('app', 'Only Numeric values allowed.')
								+ '</b>');
				$("#couponValue").val('');
				setTimeout(function() {
					$('.option-error').fadeOut();
				}, 500);
				return false;
			} else if (Number(price) <= Number(couponValue)) {
				$('.option-error').show();
				$(".option-error")
						.html(
								'<b>'
										+ Yii
												.t('app',
														'Coupon value is equal to or greater than product price.')
										+ '</b>');
				setTimeout(function() {
					$('.option-error').fadeOut();
				}, 3000);
				return false;
			} else {
				if (generateCouponAjax == 1) {
					generateCouponAjax = 0;
					$.ajax({
						type : 'POST',
						url : yii.urls.base + '/products/generateCoupon',
						data : {
							productId : pid,
							userId : uid,
							price : price,
							couponValue : couponValue,
							currency : currency,
						},
						success : function(data) {
							$(".generate-coupon-container").hide();
							$('.new-coupon-link').show();
							$(".coupon-code").html(
									"<div style='font-size:25px'>"
											+ Yii.t('app', 'Coupon Code')
											+ " :" + "<b>" + data
											+ "</b></div>");
							$(".coupon-code").fadeIn(1500);
							generateCouponAjax = 1;
						}
					});
				}
			}
		}
	}
}
function keyHandler(k) {
	var lkey = document.getElementById('lastkey').value;
	var message = document.getElementById('contact-textarea').value;
	var keypr = (window.event) ? event.keyCode : k.keyCode;
	var newmessage;

	if ((keypr == 32) || (keypr == 190) || (keypr == 188) || (keypr == 186)) {
		newmessage = message.substr(0, message.length - 1);
		if (lkey == keypr) {
			document.getElementById('contact-textarea').value = newmessage;
		}
		document.getElementById('lastkey').value = keypr;
	} else {
		newmessage = message.substr(0, message.length);
		document.getElementById('lastkey').value = keypr;
		if (lkey == '2')
			document.getElementById('contact-textarea').value = newmessage;
	}

}

function keyban(k) {
	var message = document.getElementById('contact-textarea').value;
	var keypr = (window.event) ? event.keyCode : k.keyCode;
	if (keypr != '16') {
		var reg = /^[^\da-zA-Z]$/;
		if (message.length < 2) {
			if (reg.test(String.fromCharCode(keypr)))
				document.getElementById('contact-textarea').value = '';
		}
	}
	var limitNum = 500;
	if (message.length > limitNum) {
		var textValue = $('.contact-textarea').val().substring(0, limitNum);
		$('.contact-textarea').val(textValue);
		$('.contactme-error').show();
		$('.contactme-error').html(
				Yii.t('app', "Maximum Character limit") + " 500");
		$('.contactme-error').fadeIn();
		setTimeout(function() {
			$('.contactme-error').fadeOut();
		}, 3000);
	}
}

function keyban_msg(k) {
	var message = document.getElementById('contact-textarea').value;
	var keypr = (window.event) ? event.keyCode : k.keyCode;
	if (keypr != '16') {
		var reg = /^[^\da-zA-Z]$/;
		if (message.length < 2) {
			if (reg.test(String.fromCharCode(keypr)))
				document.getElementById('contact-textarea').value = '';
		}
	}
	var limitNum = 500;
	if (message.length == limitNum) {
		var textValue = $('.contact-textarea').val().substring(0, limitNum);
		$('.contact-textarea').val(textValue);
		$('.contactme-error').show();
		$('.contactme-error').html(
				Yii.t('app', "Maximum Character limit") + " 500");
		$('.contactme-error').fadeIn();
		setTimeout(function() {
			$('.contactme-error').fadeOut();
		}, 3000);
	}
}

function contactMePopup() {
	$('.contactme-error').hide();
	var sender = $('.contact-sender').val();
	//alert(sender);
	var receiver = $('.contact-receiver').val();
	var msg = $('.contact-textarea').val();
	var sourceId = $('.item-id').val();
	var message = msg.trim();
	if($.trim(sender) == '') {
		window.location = yii.urls.base + '/login';
	}
	if (message == "") {
		$('.contact-textarea').val('');
		$('.contactme-error').show();
		$('.contactme-error').html(Yii.t('app', 'Enter some Message to send'));
		$('.contactme-error').fadeIn();
		setTimeout(function() {
			$('.contactme-error').fadeOut();
		}, 3000);
		return;
	}

	if (contactAjax == 1) {
		$('.seller-chat-btn').html('Sending...');
		$('.seller-chat-btn').attr('disabled');
		contactAjax = 0;
		$.ajax({
			url : yii.urls.base + '/initiatechat',
			type : "post",
			dataType : "html",
			data : {
				'sender' : sender,
				'receiver' : receiver,
				'message' : message,
				'messageType' : "normal",
				'sourceId' : sourceId,
			},
			beforeSend : function() {
				//$('.send-button').html(Yii.t('app', 'Sending') + '...');
			},
			success : function(responce) {
				$('.seller-chat-btn').html('Send');
				$('.seller-chat-btn').removeAttr('disabled');
				var output = responce.trim();
				if (output != 'failed') {
					$('.contact-textarea').val('');
					//$('#chat-with-seller-modal').hide();
					$('#chat-with-seller-success-modal').show();
					$('#chat-with-seller-success-modal').modal('show');
					//$('#chat-with-seller-modal').removeClass("in");
					//$("#chat-with-seller-success-modal").addClass("in");
					$('.sent-text').html('Message sent');
				}
				contactAjax = 1;
			}
		});
	}

}

function close_popup() {
	//$("#chat-with-seller-success-modal").modal('hide');
	$('#chat-with-seller-success-modal').hide();
	$('#offer-success-modal').hide();
	$('#chat-with-seller-success-modal').removeClass("in");
	$('#offer-success-modal').removeClass("in");
	$(".modal-backdrop").hide();
	$('.sent-text').html('');
	$('body').removeClass("modal-open");
	$('body').css({
		"overflow" : "auto"
	});
	//$("body").css({ 'padding-right' : ''});
	//$("#chat-with-seller-modal").css({ 'padding-right' : ''});*/
}

function validsigninfrm() {
	var email = $('#LoginForm_username').val();
	var password = $('#LoginForm_password').val();
	if (email == '') {
		$("#LoginForm_username_em_").show();
		$('#LoginForm_username_em_')
				.text(Yii.t('app', 'Email cannot be blank'));
		$('#LoginForm_username').focus();
		$('#LoginForm_username').keydown(function() {
			$('#LoginForm_username_em_').hide();
		});
		"<?= $phpVar ?>";
		return false;
	}
	if (!(isValidEmailAddress(email))) {
		$("#LoginForm_username_em_").show();
		$('#LoginForm_username_em_').text(
				Yii.t('app', 'Please Enter a valid Email'));
		$('#LoginForm_username').focus();
		return false;
	}
	if (password == '') {
		$("#LoginForm_password_em_").show();
		$("#LoginForm_username_em_").hide();
		$('#LoginForm_password_em_').text(
				Yii.t('app', 'Password cannot be blank'));
		$('#LoginForm_password').focus();
		return false;
	}
}

function isValidEmailAddress(email) {
	var emailreg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
	return emailreg.test(email);
}

function adminsignform() {
	var fullname = $('#Users_name').val().trim();
	var username = $('#Users_username').val().trim();
	username = username.replace(" ", "");
	$('#Users_username').val(username);
	var email = $('#Users_email').val().trim();
	var password = $('#Users_password').val().trim();
	var reg = /[0-9]/gi;
	if (fullname == '') {
		$("#Users_name_em_").show();
		$("#badmessage").hide();
		$('#Users_name_em_').text(Yii.t('admin', 'Name is required'));
		$('#Users_name').val('');
		$('#Users_name').focus();
		$('#Users_name').keydown(function() {
			$('#Users_name_em_').hide();
		});
		return false;
	} else {
		fullname = fullname.replace(/\s{2,}/g, ' ');
		$('#Users_name').val(fullname);
		$('#Users_name_em_').hide();
	}
	if (fullname.length < 3) {
		$("#Users_name_em_").show();
		$('#Users_name_em_').text(
				Yii.t('admin', 'Name should have minimum 3 characters'));
		$('#Users_name').keydown(function() {
			$('#Users_name_em_').hide();
		});
		return false;
	} else {
		$('#Users_name_em_').hide();
	}
	if (specials.test(fullname)) {
		$("#Users_name_em_").show();
		$('#Users_name_em_').text(
				Yii.t('admin', 'Special Characters not allowed.'));
		return false;
	} else {
		$('#Users_name_em_').hide();
	}

	if (reg.test(fullname)) {
		$("#Users_name_em_").closest('div.form-group').removeClass('success');
		$("#Users_name_em_").closest('div.form-group').addClass('error');
		$("#Users_name_em_").show();
		$('#Users_name_em_').text(Yii.t('app', 'Numbers not allowed.'));
		return false;
	} else {
		$('#Users_name_em_').hide();
	}

	if (username == '') {
		$("#Users_username_em_").show();
		$('#Users_username_em_').text(Yii.t('admin', 'Username is required'));
		$('#Users_username').val('');
		$('#Users_username').keydown(function() {
			$('#Users_username_em_').hide();
		});
		return false;
	} else {
		$('#Users_username_em_').hide();
	}
	/*if (reg.test(username)) {
		$("#Users_username_em_").closest('div.form-group').removeClass(
				'success');
		$("#Users_username_em_").closest('div.form-group').addClass('error');
		$("#Users_username_em_").show();
		$('#Users_username_em_').text(Yii.t('app', 'Numbers not allowed.'));
		return false;
	} else {
		$('#Users_username_em_').hide();
	}*/

	/*
	 * if (username.length < 4) { $("#Users_username_em_").show();
	 * $('#Users_username_em_').text( Yii.t('admin', 'Username should have
	 * minimum 4 characters')); $('#Users_username').keydown(function() {
	 * $('#Users_username_em_').hide(); }); return false; } else {
	 * $('#Users_username_em_').hide(); }
	 */
	if (specials.test(username)) {
		$("#Users_username_em_").show();
		$('#Users_username_em_').text(
				Yii.t('admin', 'Special Characters not allowed.'));
		return false;
	} else {
		$('#Users_username_em_').hide();
	}

	if (email == '') {
		$("#Users_email_em_").show();
		$("#badmessage").hide();
		$('#Users_email_em_').text(Yii.t('admin', 'Email is required'));
		$('#Users_email').focus();
		$('#Users_email').val('');
		$('#Users_email').keydown(function() {
			$('#Users_email_em_').hide();
		});
		return false;
	} else {
		$('#Users_email_em_').hide();
	}

	if (!(isValidEmailAddress(email))) {
		$("#Users_email_em_").show();
		$("#badmessage").hide();
		$('#Users_email_em_').text(Yii.t('admin', 'Enter a valid email'));
		$('#Users_email').focus();
		$('#Users_email').keydown(function() {
			$('#Users_email_em_').hide();
		});
		return false;
	} else {
		$('#Users_email_em_').hide();
	}

	if (password == '') {
		$("#Users_password_em_").show();
		$("#badmessage").hide();
		$('#Users_password_em_').text(
				Yii.t('admin', 'Password should not be empty'));
		$('#Users_password').focus();
		$('#Users_password').val('');
		$('#Users_password')
				.keydown(
						function() {
							$('#Users_password_em_')
									.text(
											Yii
													.t('admin',
															'Password must be greater than 5 characters long'));
						});

		return false;
	} else {
		$('#Users_password_em_').hide();
	}
	if (password.length < 6) {
		$("#Users_password_em_").show();
		$("#badmessage").hide();
		$('#Users_password_em_').text(
				Yii.t('admin',
						'Password must be greater than 5 characters long'));
		$('#Users_password').focus();

		$('#Users_password').keydown(function() {
			$('#Users_password_em_').hide();
		});
		return false;
	} else {
		$('#Users_password_em_').hide();
	}

}
function signform() {
	var fullname = $('#Users_name').val().trim();
	var username = $('#Users_username').val().trim();
	var email = $('#Users_email').val().trim();
	var password = $('#Users_password').val().trim();
	var confirmpassword = $('#Users_confirm_password').val().trim();
	var reg = /[0-9]/gi;
	if (fullname == '') {
		$("#Users_name_em_").closest('div.row').removeClass('success');
		$("#Users_name_em_").closest('div.row').addClass('error');
		$("#Users_name_em_").show();
		$("#badmessage").hide();
		$('#Users_name_em_').text(Yii.t('admin', 'Name is required'));
		$('#Users_name').val('');
		$('#Users_name').focus();
		$('#Users_name').keydown(function() {
			$('#Users_name_em_').hide();
		});
		return false;
	} else {
		fullname = fullname.replace(/\s{2,}/g, ' ');
		$('#Users_name').val(fullname);
		$('#Users_name_em_').hide();
	}
	if (fullname.length < 3) {
		$("#Users_name_em_").closest('div.row').removeClass('success');
		$("#Users_name_em_").closest('div.row').addClass('error');
		$("#Users_name_em_").show();
		$('#Users_name_em_').text(
				Yii.t('admin', 'Name should have minimum 3 characters'));
		$('#Users_name').keydown(function() {
			$('#Users_name_em_').hide();
		});
		return false;
	} else {
		$('#Users_name_em_').hide();
	}
	if (specials.test(fullname)) {
		$("#Users_name_em_").closest('div.row').removeClass('success');
		$("#Users_name_em_").closest('div.row').addClass('error');
		$("#Users_name_em_").show();
		$('#Users_name_em_').text(
				Yii.t('admin', 'Special Characters not allowed.'));
		return false;
	} else {
		$('#Users_name_em_').hide();
	}

	if (reg.test(fullname)) {
		
		$("#Users_name_em_").closest('div.row').removeClass('success');
		$("#Users_name_em_").closest('div.row').addClass('error');
		$("#Users_name_em_").show();
		$('#Users_name_em_').text(Yii.t('app', 'Numbers not allowed.'));
		return false;
	} else {
		$('#Users_name_em_').hide();
	}

	if (username == '') {
		$("#Users_username_em_").closest('div.row').removeClass('success');
		$("#Users_username_em_").closest('div.row').addClass('error');
		$("#Users_username_em_").show();
		$('#Users_username_em_').text(Yii.t('admin', 'Username is required'));
		$('#Users_username').val('');
		$('#Users_username').keydown(function() {
			$('#Users_username_em_').hide();
		});
		return false;
	} else {
		$('#Users_username_em_').hide();
	}

	/*
	 * if (username.length < 4) { $("#Users_username_em_").show();
	 * $('#Users_username_em_').text( Yii.t('admin', 'Username should have
	 * minimum 4 characters')); $('#Users_username').keydown(function() {
	 * $('#Users_username_em_').hide(); }); return false; } else {
	 * $('#Users_username_em_').hide(); }
	 */
	if (specials.test(username)) {
		$("#Users_username_em_").closest('div.row').removeClass('success');
		$("#Users_username_em_").closest('div.row').addClass('error');
		$("#Users_username_em_").show();
		$('#Users_username_em_').text(
				Yii.t('admin', 'Special Characters not allowed.'));
		return false;
	} else {
		$('#Users_username_em_').hide();
	}
	/*
	 * if (reg.test(username)) {
	 * $("#Users_username_em_").closest('div.form-group').removeClass(
	 * 'success');
	 * $("#Users_username_em_").closest('div.form-group').addClass('error');
	 * $("#Users_username_em_").show();
	 * $('#Users_username_em_').text(Yii.t('app', 'Numbers not allowed.'));
	 * return false; } else { $('#Users_username_em_').hide(); }
	 */
	if (email == '') {
		$("#Users_email_em_").closest('div.row').removeClass('success');
		$("#Users_email_em_").closest('div.row').addClass('error');
		$("#Users_email_em_").show();
		$("#badmessage").hide();
		$('#Users_email_em_').text(Yii.t('admin', 'Email is required'));
		$('#Users_email').focus();
		$('#Users_email').val('');
		$('#Users_email').keydown(function() {
			$('#Users_email_em_').hide();
		});
		return false;
	} else {
		$('#Users_email_em_').hide();
	}

	if (!(isValidEmailAddress(email))) {
		$("#Users_email_em_").closest('div.row').removeClass('success');
		$("#Users_email_em_").closest('div.row').addClass('error');
		$("#Users_email_em_").show();
		$("#badmessage").hide();
		$('#Users_email_em_').text(Yii.t('admin', 'Enter a valid email'));
		$('#Users_email').focus();
		$('#Users_email').keydown(function() {
			$('#Users_email_em_').hide();
		});
		return false;
	} else {
		$('#Users_email_em_').hide();
	}

	if (password == '') {
		$("#Users_password_em_").closest('div.row').removeClass('success');
		$("#Users_password_em_").closest('div.row').addClass('error');
		$("#Users_password_em_").show();
		$("#badmessage").hide();
		$('#Users_password_em_').text(
				Yii.t('admin', 'Password should not be empty'));
		$('#Users_password').focus();
		$('#Users_password').val('');
		$('#Users_password')
				.keydown(
						function() {
							$('#Users_password_em_')
									.text(
											Yii
													.t('admin',
															'Password must be greater than 5 characters long'));
						});

		return false;
	} else {
		$('#Users_password_em_').hide();
	}
	if (confirmpassword == '') {
		$("#Users_confirm_password_em_").closest('div.row').removeClass('success');
		$("#Users_confirm_password_em_").closest('div.row').addClass('error');
		$("#Users_confirm_password_em_").show();
		$('#Users_confirm_password_em_').text(
				Yii.t('admin', 'Confirm Password should not be empty'));
		$('#Users_confirm_password').focus();
		$('#Users_confirm_password').val('');
		$('#Users_confirm_password')
				.keydown(
						function() {
							$('#Users_confirm_password_em_')
									.text(
											Yii
													.t('admin',
															'Confirm Password must be greater than 5 characters long'));
						});

		return false;
	} else {
		$('#Users_confirm_password_em_').hide();
	}

	if (password.length < 6) {
		$("#Users_password_em_").closest('div.row').removeClass('success');
		$("#Users_password_em_").closest('div.row').addClass('error');
		$("#Users_password_em_").show();
		$("#badmessage").hide();
		$('#Users_password_em_').text(
				Yii.t('admin',
						'Password must be greater than 5 characters long'));
		$('#Users_password').focus();

		$('#Users_password').keydown(function() {
			$('#Users_password_em_').hide();
		});
		return false;
	} else {
		$('#Users_password_em_').hide();
	}

	if (confirmpassword.length < 6) {
		$("#Users_confirm_password_em_").closest('div.row').removeClass('success');
		$("#Users_confirm_password_em_").closest('div.row').addClass('error');
		$("#Users_confirm_password_em_").show();
		$('#Users_confirm_password_em_').text(
				Yii.t('admin',
						'Password must be greater than 5 characters long'));
		$('#Users_confirm_password').focus();

		$('#Users_confirm_password').keydown(function() {
			$('#Users_confirm_password_em_').hide();
		});
		return false;
	} else {
		$('#Users_confirm_password_em_').hide();
	}
	if (password != confirmpassword) {
		$("#Users_confirm_password_em_").closest('div.row').removeClass(
				'success');
		$("#Users_confirm_password_em_").closest('div.row').addClass('error');
		$("#Users_confirm_password_em_").show();
		$('#Users_confirm_password_em_').text(
				Yii.t('admin', 'Confirm password does not match'));
		$('#Users_confirm_password').focus();

		$('#Users_confirm_password').keydown(function() {
			$('#Users_confirm_password_em_').hide();
		});
		return false;
	} else {
		$('#Users_confirm_password_em_').hide();
	}

}

function validforgot() {
	var email = $('.forgetpasswords').val();
	//alert(email);
	if (email == '')
		email = $('#Users_email.forget-input').val();
	if (email == '' || email == undefined) {
		$('#Users_emails_em_').show();
		$('#Users_emails_em_').text(Yii.t('app', 'Email cannot be blank'));
		return false;
	} else if (!isValidEmailAddress(email)) {
		$('#Users_emails_em_').show();
		$('#Users_emails_em_').text(Yii.t('app', 'Please Enter a valid Email'));
		return false;
	} else {
		if(mailcheck == '1') {
			$.ajax({
				url : yii.urls.base + '/user/check_mailstatus',
				type : "post",
				dataType : "html",
				data : {
					'email' : email,
				},
				
				success : function(responce) {
					var result = responce.split('-');
					if($.trim(result[0]) == '0') {
						$('#Users_emails_em_').show();
						$('#Users_emails_em_').text(Yii.t('app', 'Email not found'));
					} else if($.trim(result[0]) == '1') {
						$('#Users_emails_em_').show();
						$('#Users_emails_em_').text(Yii.t('app', 'User is not verified. Activate the account to click the following link '));
						$('#Users_emails_em_').append('<a href="'+yii.urls.base+'/user/verify_mail?id='+result[1]+'" id="email_verify_link">Click</a>');
					} else {
						mailcheck = 0;
						$('#Users_emails_em_').hide();
						$('#forgetpassword-form').submit();
						
					}
				}
			});
			return false;
		}
		return true;
		
	}

	/*$(document).on('submit', '#forgetpassword-form', function() {
		$('.forgotBtn').attr('disabled', 'disabled');
	});*/
}

function validreset(){
	var resetpassword = $('#Resetpassword_resetpassword').val();
	var confirmpassword = $('#Resetpassword_confirmpassword').val();
	$('.errorMessage').hide();
	if (resetpassword == '') {
		$('#resetpassword_em_').show();
		$('#resetpassword_em_').text(Yii.t('app', 'Password cannot be blank'));
		return false;
	} else if (confirmpassword == '') {
		$('#confirmpassword_em_').show();
		$('#confirmpassword_em_').text(Yii.t('app', 'Confirm password cannot be blank'));
		return false;
	} else if (confirmpassword != resetpassword) {
		$('#confirmpassword_em_').show();
		$('#confirmpassword_em_').text(Yii.t('app', 'Confirm password should match with password'));
		return false;
	} else {
		$('#resetpassword_em_').hide();
		$('#confirmpassword_em_').hide();
	}

	$(document).on('submit', '#resetpassword-form', function() {
		$('.forgotBtn').attr('disabled', 'disabled');
	});
}

function validaddship() {
	var name = $('#Tempaddresses_name').val();
	var nickName = $('#Tempaddresses_nickname').val();
	var country = $('#Tempaddresses_country').val();
	var state = $('#Tempaddresses_state').val();
	var add1 = $('#Tempaddresses_address1').val();
	var add2 = $('#Tempaddresses_address2').val();
	var city = $('#Tempaddresses_city').val();
	var zip = $('#Tempaddresses_zipcode').val();
	var phone = $('#Tempaddresses_phone').val();
	var reg = /[0-9]/gi;

	if (nickName == '') {
		$("#Tempaddresses_nickname_em_").show();
		$("#badMessage").hide();
		$('#Tempaddresses_nickname_em_').text(
				Yii.t('app', 'Enter your nickname'));
		$('#Tempaddresses_nickname').focus();
		$('#Tempaddresses_nickname').keydown(function() {
			$('#Tempaddresses_nickname_em_').hide();
		});
		return false;
	} else {
		var nick = nickName.replace(/\s/g, '');
		$('#Tempaddresses_nickname').val(nick);
		if (specials.test(nickName)) {
			$("#Tempaddresses_nickname_em_").closest('div.form-group')
					.removeClass('success');
			$("#Tempaddresses_nickname_em_").closest('div.form-group')
					.addClass('error');
			$("#Tempaddresses_nickname_em_").show();
			$('#Tempaddresses_nickname_em_').text(
					Yii.t('app', 'Special Characters not allowed.'));
			return false;
		} else {
			$('#Tempaddresses_nickname_em_').hide();
		}
		if (reg.test(nickName)) {
			$("#Tempaddresses_nickname_em_").closest('div.form-group')
					.removeClass('success');
			$("#Tempaddresses_nickname_em_").closest('div.form-group')
					.addClass('error');
			$("#Tempaddresses_nickname_em_").show();
			$('#Tempaddresses_nickname_em_').text(
					Yii.t('app', 'Numbers not allowed.'));
			return false;
		} else {
			$('#Tempaddresses_nickname_em_').hide();
		}
	}
	if (name == '') {
		$("#Tempaddresses_name_em_").show();
		$("#badMessage").hide();
		$('#Tempaddresses_name_em_')
				.text(Yii.t('app', 'Full name is required'));
		$('#Tempaddresses_name').focus();
		$('#Tempaddresses_name').keydown(function() {
			$('#Tempaddresses_name_em_').hide();
		});
		return false;
	} else {
		name = name.replace(/\s{2,}/g, ' ');
		$('#Tempaddresses_name').val(name);
		if (specials.test(name)) {
			$("#Tempaddresses_name_em_").closest('div.form-group').removeClass(
					'success');
			$("#Tempaddresses_name_em_").closest('div.form-group').addClass(
					'error');
			$("#Tempaddresses_name_em_").show();
			$('#Tempaddresses_name_em_').text(
					Yii.t('app', 'Special Characters not allowed.'));
			return false;
		} else {
			$('#Tempaddresses_name_em_').hide();
		}
		if (reg.test(name)) {
			$("#Tempaddresses_name_em_").closest('div.form-group').removeClass(
					'success');
			$("#Tempaddresses_name_em_").closest('div.form-group').addClass(
					'error');
			$("#Tempaddresses_name_em_").show();
			$('#Tempaddresses_name_em_').text(
					Yii.t('app', 'Numbers not allowed.'));
			return false;
		} else {
			$('#Tempaddresses_name_em_').hide();
		}
		if (name.length < 3){
			$("#Tempaddresses_name_em_").closest('div.form-group').removeClass(
			'success');
			$("#Tempaddresses_name_em_").closest('div.form-group').addClass(
					'error');
			$("#Tempaddresses_name_em_").show();
			$('#Tempaddresses_name_em_').text(
					Yii.t('app', 'Name should be minimum 3 characters.'));
			return false;
		} else {
			$('#Tempaddresses_name_em_').hide();
		}
	}

	if (country == '') {
		$("#Tempaddresses_country_em_").show();
		$("#badMessage").hide();
		$('#Tempaddresses_country_em_')
				.text(Yii.t('app', 'Enter your country'));
		$('#Tempaddresses_country').focus();
		$('#Tempaddresses_country').keydown(function() {
			$('#Tempaddresses_country_em_').hide();
		});
		return false;
	}

	if (add1 == '') {
		$("#Tempaddresses_address1_em_").show();
		$("#badMessage").hide();
		$('#Tempaddresses_address1_em_').text(
				Yii.t('app', 'Enter your address'));
		$('#Tempaddresses_address1').focus();
		$('#Tempaddresses_address1').keydown(function() {
			$('#Tempaddresses_address1_em_').hide();
		});
		return false;
	}else if (add1.length < 3){
		$("#Tempaddresses_address1_em_").show();
		$("#badMessage").hide();
		$('#Tempaddresses_address1_em_').text(
				Yii.t('app', 'Address should be minimum 3 characters.'));
		$('#Tempaddresses_address1').focus();
		$('#Tempaddresses_address1').keydown(function() {
			$('#Tempaddresses_address1_em_').hide();
		});
		return false;
	}  else {
		/*
		 * if (specials.test(add1)) {
		 * $("#Tempaddresses_address1_em_").closest('div.form-group')
		 * .removeClass('success');
		 * $("#Tempaddresses_address1_em_").closest('div.form-group')
		 * .addClass('error'); $("#Tempaddresses_address1_em_").show();
		 * $('#Tempaddresses_address1_em_').text( Yii.t('admin', 'Special
		 * Characters not allowed.')); return false; } else {
		 */
		$('#Tempaddresses_address1_em_').hide();
		/* } */
	}

	/*
	 * if (specials.test(add2)) {
	 * $("#Tempaddresses_address2_em_").closest('div.form-group').removeClass(
	 * 'success');
	 * $("#Tempaddresses_address2_em_").closest('div.form-group').addClass(
	 * 'error'); $("#Tempaddresses_address2_em_").show();
	 * $('#Tempaddresses_address2_em_').text( Yii.t('admin', 'Special Characters
	 * not allowed.')); return false; } else {
	 * $('#Tempaddresses_address2_em_').hide(); }
	 */

	if (city == '') {
		$("#Tempaddresses_city_em_").show();
		$("#badMessage").hide();
		$('#Tempaddresses_city_em_').text(Yii.t('app', 'Enter your city'));
		$('#Tempaddresses_city').focus();
		$('#Tempaddresses_city').keydown(function() {
			$('#Tempaddresses_city_em_').hide();
		});
		return false;
	} else {
		if (specials.test(city)) {
			$("#Tempaddresses_city_em_").closest('div.form-group').removeClass(
					'success');
			$("#Tempaddresses_city_em_").closest('div.form-group').addClass(
					'error');
			$("#Tempaddresses_city_em_").show();
			$('#Tempaddresses_city_em_').text(
					Yii.t('app', 'Special Characters not allowed.'));
			return false;
		} else {
			$('#Tempaddresses_city_em_').hide();
		}
		if (reg.test(city)) {
			$("#Tempaddresses_city_em_").closest('div.form-group').removeClass('success');
			$("#Tempaddresses_city_em_").closest('div.form-group').addClass('error');
			$("#Tempaddresses_city_em_").show();
			$('#Tempaddresses_city_em_').text(Yii.t('app', 'Numbers not allowed.'));
			return false;
		}else if (city.length < 2){
			$("#Tempaddresses_city_em_").closest('div.form-group').removeClass('success');
			$("#Tempaddresses_city_em_").closest('div.form-group').addClass('error');
			$("#Tempaddresses_city_em_").show();
			$('#Tempaddresses_city_em_').text(Yii.t('app', 'City should be minimum 2 characters.'));
			return false;
		} else {
			$('#Tempaddresses_city_em_').hide();
		}
	}
	if (state == '') {
		$("#Tempaddresses_state_em_").show();
		$("#badMessage").hide();
		$('#Tempaddresses_state_em_').text(Yii.t('app', 'Enter your state'));
		$('#Tempaddresses_state').focus()
		$('#Tempaddresses_state').keydown(function() {
			$('#Tempaddresses_state_em_').hide();
		})
		return false;
	} else {
		if (specials.test(state)) {
			$("#Tempaddresses_state_em_").closest('div.form-group')
					.removeClass('success');
			$("#Tempaddresses_state_em_").closest('div.form-group').addClass(
					'error');
			$("#Tempaddresses_state_em_").show();
			$('#Tempaddresses_state_em_').text(
					Yii.t('app', 'Special Characters not allowed.'));
			return false;
		} else {
			$('#Tempaddresses_state_em_').hide();
		}
		if (reg.test(state)) {
			$("#Tempaddresses_state_em_").closest('div.form-group').removeClass('success');
			$("#Tempaddresses_state_em_").closest('div.form-group').addClass('error');
			$("#Tempaddresses_state_em_").show();
			$('#Tempaddresses_state_em_').text(Yii.t('app', 'Numbers not allowed.'));
			return false;
		}else if (state.length < 2){
			$("#Tempaddresses_state_em_").closest('div.form-group').removeClass('success');
			$("#Tempaddresses_state_em_").closest('div.form-group').addClass('error');
			$("#Tempaddresses_state_em_").show();
			$('#Tempaddresses_state_em_').text(Yii.t('app', 'State should be minimum 2 characters.'));
			return false;
		} else {
			$('#Tempaddresses_state_em_').hide();
		}
	}
	if (zip == '') {
		$("#Tempaddresses_zipcode_em_").show();
		$("#badMessage").hide();
		$('#Tempaddresses_zipcode_em_').text(Yii.t('app', 'Enter your area code'));
		$('#Tempaddresses_zipcode').focus();
		$('#Tempaddresses_zipcode').keydown(function() {
			$('#Tempaddresses_zipcode_em_').hide();
		});
		return false;
	} else {
		if (specials.test(zip)) {
			$("#Tempaddresses_zipcode_em_").closest('div.form-group')
					.removeClass('success');
			$("#Tempaddresses_zipcode_em_").closest('div.form-group').addClass(
					'error');
			$("#Tempaddresses_zipcode_em_").show();
			$('#Tempaddresses_zipcode_em_').text(
					Yii.t('app', 'Special Characters not allowed.'));
			return false;
		} else {
			$('#Tempaddresses_zipcode_em_').hide();
		}
	}
	if (phone == '') {
		$("#Tempaddresses_phone_em_").show();
		$("#badMessage").hide();
		$('#Tempaddresses_phone_em_').text(Yii.t('app', 'Enter your phone no'));
		$('#Tempaddresses_phone').focus();
		$('#Tempaddresses_phone').keydown(function() {
			$('#Tempaddresses_phone_em_').hide();
		});
		return false;
	} else {
		var check = /^[0-9]+$/;
		if (reg.test(phone)) {
			$("#Tempaddresses_phone_em_").hide();

		} else {
			$("#Tempaddresses_phone_em_").html(
					Yii.t('app', 'Only numbers allowed.'));
			return false;
		}
	}
	return true;
}

function couponValidate() {
	if ($("#couponValue").val() == "") {
		$("#Coupons_couponValue_em_").show();
		$("#Coupons_couponValue_em_").html(
				Yii.t('app', "Coupon Value cannot be blank"));
	} else {
		$("#Coupons_couponValue_em_").hide();
	}
	if ($("#Coupons_startDate").val() == "") {
		$("#Coupons_startDate_em_").show();
		$("#Coupons_startDate_em_").html(
				Yii.t('app', "Coupon Start date cannot be blank"));
	} else {
		$("#Coupons_startDate_em_").hide();
	}
	if ($("#Coupons_endDate").val() == "") {
		$("#Coupons_endDate_em_").show();
		$("#Coupons_endDate_em_").html(
				Yii.t('app', "Coupon End date cannot be blank"));
	} else {
		$("#Coupons_endDate_em_").hide();
	}

}

function isNumber(eve) {
	var charCode = (eve.which) ? eve.which : event.keyCode;
	if (charCode > 31 && (charCode < 48 || charCode > 57)) {
		return false;
	}
	return true;
}

function validateProduct() {
	var name = $("#Products_name").val().trim();
	var desc = $("#Products_description").val().trim();
	var cat = $("#Products_category").val();
	var price = $("#Products_price").val().trim();
	//var qty = $("#Products_quantity").val().trim();
	var insbuy = $("#Products_instantBuy").val();
	var proCond = $("#Products_productCondition").val();
	var location = $("#Products_location").val();
	var latitude = $("#latitude").val();
	var longitude = $("#longitude").val();
	var pattern = /^\d+$/;

	if (productImage == 0) {
		$("#image_error").show();
		$("#badMessage").hide();
		$('#image_error').text(
				Yii.t('admin', 'Minimum one image is required with good resolution'));
		return false;
	}
	if (cat == "") {
		$("#Products_category_em_").show();
		$("#badMessage").hide();
		$('#Products_category_em_').text(
				Yii.t('admin', 'Product Category cannot be blank'));
		$('#Products_category').focus();
		$('#Products_category').change(function() {
			$('#Products_category_em_').hide();
		});
		return false;
	}
	if (name == "") {
		$("#Products_name_em_").show();
		$("#badMessage").hide();
		$('#Products_name_em_').text(
				Yii.t('admin', 'Product Name cannot be blank'));
		$('#Products_name').focus();
		$('#Products_name').keydown(function() {
			$('#Products_name_em_').hide();
		});
		return false;
	} else {
		name = name.replace(/\s{2,}/g, ' ');
		$('#Products_name').val(name);
		$('#Products_name_em_').hide();
	}
	if (desc == "") {
		$("#Products_description_em_").show();
		$("#badMessage").hide();
		$('#Products_description_em_').text(
				Yii.t('admin', 'Product Description cannot be blank'));
		$('#Products_description').focus();
		$('#Products_description').keydown(function() {
			$('#Products_description_em_').hide();
		});
		return false;
	}
	if (price == "" || price == 0) {
		$("#Products_price_em_").show();
		$("#badMessage").hide();
		$('#Products_price_em_').text(
				Yii.t('admin', 'Product Price cannot be blank'));
		$('#Products_price').focus();
		$('#Products_price').keydown(function() {
			$('#Products_price_em_').hide();
		});
		return false;
	}else if(!pattern.test(price)){
		console.log(price);
		$("#Products_price_em_").show();
		$("#badMessage").hide();
		$('#Products_price_em_').text(
				Yii.t('admin', 'Product Price should be numeric'));
		$('#Products_price').focus();
		$('#Products_price').keydown(function() {
			$('#Products_price_em_').hide();
		});
		return false;
	}
	/*if (qty == "" || qty < 1) {
		$("#Products_quantity_em_").show();
		$("#badMessage").hide();
		$('#Products_quantity_em_').text(
				Yii.t('admin', 'Product Quantity cannot be blank or less than 1'));
		$('#Products_quantity').focus();
		$('#Products_quantity').keydown(function() {
			$('#Products_quantity_em_').hide();
		});
		return false;
	}*/
	if (proCond == "") {
		console.log("product condition: "+proCond);
		$("#Products_productCondition_em_").show();
		$("#badMessage").hide();
		$('#Products_productCondition_em_').text(
				Yii.t('admin', 'Product Condition cannot be blank'));
		$('#Products_productCondition').focus();
		$('#Products_productCondition').change(function() {
			$('#Products_productCondition_em_').hide();
		});
		return false;
	}
	/*var buyoption = 0;
	if ($('#Products_chatAndBuy').is(':checked') == true) {
		buyoption = 1;
	} else if ($('#Products_exchangeToBuy').is(':checked') == true) {
		buyoption = 1;
	} else if ($('#Products_instantBuy').is(':checked') == true) {
		buyoption = 1;
	}

	if (buyoption == 0) {
		$("#Products_instantBuy_em_").show();
		$("#badMessage").hide();
		$('#Products_instantBuy_em_').text(
				Yii.t('admin', 'Select a payment option'));
		return false;
	}
	*/
	if ($('#Products_instantBuy').is(':checked') == true) {
		var paypalid = $('#Products_paypalid').val();
		var shippingCost = $('#Products_shippingCost').val();
		//var shippingTime = $('#Products_shippingTime').val();
		if (paypalid == '') {
			$("#Products_paypalid_em_").show();
			$("#badMessage").hide();
			$('#Products_paypalid_em_').text(
					Yii.t('admin', 'Paypal ID cannot be blank'));
			$('#Products_instantBuy').focus();
			$('#Products_paypalid').keydown(function() {
				$('#Products_paypalid_em_').hide();
			});
			return false;
		} else if (!(isValidEmailAddress(paypalid))) {
			$("#Products_paypalid_em_").show();
			$("#badMessage").hide();
			$('#Products_paypalid_em_').text(
					Yii.t('admin', 'Paypal ID should be a valid email id'));
			$('#Products_instantBuy').focus();
			$('#Products_paypalid').keydown(function() {
				$('#Products_paypalid_em_').hide();
			});
			return false;
		}
		if (shippingCost == ''){
			$("#Products_shippingCost_em_").show();
			$("#badMessage").hide();
			$('#Products_shippingCost_em_').text(
					Yii.t('admin', 'Shipping Cost cannot be blank'));
			$('#Products_shippingCost').focus();
			$('#Products_shippingCost').keydown(function() {
				$('#Products_shippingCost_em_').hide();
			});
			return false;
		}
		/*
		if (shippingTime == '') {
			$("#Products_shippingTime_em_").show();
			$("#badMessage").hide();
			$('#Products_shippingTime_em_').text(
					Yii.t('admin', 'Product Should have an shipping time'));
			$('#Products_shippingTime').focus();
			$('#Products_shippingTime').change(function() {
				$('#Products_shippingTime_em_').hide();
			});
			return false;
		}
		var shippingCount = shippingArray.length;
		if ((shippingArray == '' || shippingArray == 0)
				&& $(".ship-to-0").val().trim() == '') {
			$("#Products_shipping_em_").show();
			$("#badMessage").hide();
			$('#Products_shipping_em_').text(
					Yii.t('admin', 'Add atleast a single shipping'));
			return false;
		}
		var shipCheck = 0;
		var value = $(".ship-to-0").val();
		if(value) {
		value = value.replace(/\s/g, '');
		$(".ship-to-0").val(value);
	    }
		

		for ( var i = 1; i < shippingCount; i++) {
			var selector = ".ship-to-" + shippingArray[i];
			var selectorVal = $(selector).val();
			var selectorVal = selectorVal.replace(/\s/g, "");
			$(selector).val(selectorVal);
			if ($(selector).val().trim() == "") {
				shipCheck = 1;
				break;
			} else {
				if (specials.test($(selector).val())
						|| alpha.test($(selector).val())) {
					$(selector).val().replace(/\s/g, '');
					$("#Products_shipping_em_").show();
					$("#badMessage").hide();
					$(selector).val('');
					$('#Products_shipping_em_').text(
							Yii.t('admin', 'Special Characters not allowed.'));
					return false;
				}
			}
		}
		$('#Products_shipping_em_').text('');
		$("#Products_shipping_em_").hide();
		if (shipCheck == 1) {
			$("#Products_shipping_em_").show();
			$("#badMessage").hide();
			$('#Products_shipping_em_').text(
					Yii.t('admin', 'Shipping Amount cannot be empty'));
			return false;
		} else if ($(".ship-to-0").val().trim() == "" && shippingCount == 0) {
			$("#Products_shipping_em_").show();
			$("#badMessage").hide();
			$('#Products_shipping_em_').text(
					Yii.t('admin', 'Add atleast a single shipping'));
			return false;
		}

		if (specials.test($(".ship-to-0").val())
				|| alpha.test($(".ship-to-0").val())) {
			$("#Products_shipping_em_").show();
			$("#badMessage").hide();
			$(".ship-to-0").val('');
			$('#Products_shipping_em_').text(
					Yii.t('admin', 'Only numeric values allowed.'));
			return false;
		}*/
	}
	if (location == "") {
		console.log("location: "+location);
		$("#Products_location_em_").show();
		$("#badMessage").hide();
		$('#Products_location_em_').text(Yii.t('admin', 'Location Required'));
		$('#Products_location').focus();
		$('#Products_location').keydown(function() {
			$('#Products_location_em_').hide();
		});
		return false;
	}
	if (latitude == "" || longitude == "" || latitude == "0"
			|| longitude == "0") {
		console.log("latitude: "+latitude);
		console.log("longitude: "+longitude);
		$("#Products_location_em_").show();
		$("#badMessage").hide();
		$('#Products_location_em_').text(
				Yii.t('admin',
						'Invalid Location.Select Location From Drop Down.'));
		$('#Products_location').focus();
		$('#Products_location').text('');
		$('#Products_location').keydown(function() {
			$('#Products_location_em_').hide();
		});
		return false;
	} else {
		$('#Products_location_em_').hide();
	}
	
	var updateFlag = $('.product-update-flag').val();
	
	if(updateFlag == 0){
		$('.btnUpdate').attr('disabled', 'disabled');
		$.post($('#products-form').attr('action'), $('#products-form').serialize(), function(res){
	        // Do stuff with your response data!
			var resultData = res.split('-_-');
			$('.promotion-cancel').attr('href', resultData[1]);
			$('.promotion-product-id').val(resultData[0]);
	        $('#post-your-list').modal('show');
	    });
		return false;
	}else{
		$(document).on('submit', '#products-form', function() {
			$('.btnUpdate').attr('disabled', 'disabled');
		});
	}
}

function updatePromotion(promotionId){
	$('#promotion-addtype').val(promotionId);
}

function showListingPromotion(productId){
	$('.promotion-product-id').val(productId);
	$('#post-your-list').modal('show');
}

function promotionUpdate(promotionType){
	//$('#promotion-type').val(promotionType);
	//$('#products-form').submit();
	var promotionId = $('#promotion-addtype').val();
	var productId = $('.promotion-product-id').val();
	var errorSelector = "."+promotionType+"-promote-error";
	
	if(promotionType == "adds" && promotionId == ""){
		$(errorSelector).html(Yii.t('app', 'Select a Promotion'));
		$(errorSelector).show();
		setTimeout(function() {
			$(errorSelector).html('');
			$(errorSelector).hide();
		}, 1500);
	}else{
		$.ajax({
			url: yii.urls.base + '/item/products/promotionpaymentprocess/',
			type: "post",
			dataType: "html",
			data: {
				promotionType : promotionType,
				promotionId : promotionId,
				productId : productId
			},
			success: function(responce){
				responce = responce.trim();
				if(responce == 0){
					$(errorSelector).html(Yii.t('app', 'Already Promoted'));
					$(errorSelector).show();
					setTimeout(function() {
						$(errorSelector).html('');
						$(errorSelector).hide();
					}, 1500);
				}else if(responce == 1){
					$(errorSelector).html(Yii.t('app', 'Sold Product Cannot Be Promoted'));
					$(errorSelector).show();
					setTimeout(function() {
						$(errorSelector).html('');
						$(errorSelector).hide();
					}, 1500);
				}else{
					$('.paypal-form-container').html(responce);
					$('#paypal-form').submit();
				}
			}
		});
	}
}

function IsAlphaNumeric(e) {
	var specialKeys = new Array();
	specialKeys.push(8); // Backspace
	specialKeys.push(9); // Tab
	specialKeys.push(46); // Delete
	specialKeys.push(36); // Home
	specialKeys.push(35); // End
	specialKeys.push(37); // Left
	specialKeys.push(39); // Right
	specialKeys.push(27); // Space
	var keyCode = e.keyCode == 0 ? e.charCode : e.keyCode;
	var ret = ((keyCode >= 48 && keyCode <= 57)
			|| (keyCode >= 65 && keyCode <= 90) || (keyCode == 32)
			|| (keyCode >= 97 && keyCode <= 122) || (specialKeys
			.indexOf(e.keyCode) != -1 && e.charCode != e.keyCode));
	return ret;
}

function IsAlphaNumericnospace(e) {
	var specialKeys = new Array();
	specialKeys.push(8); // Backspace
	specialKeys.push(9); // Tab
	specialKeys.push(46); // Delete
	specialKeys.push(36); // Home
	specialKeys.push(35); // End
	specialKeys.push(37); // Left
	specialKeys.push(39); // Right
	var keyCode = e.keyCode == 0 ? e.charCode : e.keyCode;
	var ret = ((keyCode >= 48 && keyCode <= 57)
			|| (keyCode >= 65 && keyCode <= 90) || (keyCode != 32)
			|| (keyCode >= 97 && keyCode <= 122) || (specialKeys
			.indexOf(e.keyCode) != -1 && e.charCode != e.keyCode));
	return ret;
}

function isAlpha(e) {
	var specialKeys = new Array();
	specialKeys.push(8); // Backspace
	specialKeys.push(9); // Tab
	specialKeys.push(46); // Delete
	specialKeys.push(36); // Home
	specialKeys.push(35); // End
	specialKeys.push(37); // Left
	specialKeys.push(39); // Right
	specialKeys.push(27); // Space
	var keyCode = e.keyCode == 0 ? e.charCode : e.keyCode;
	var ret = ((keyCode >= 65 && keyCode <= 90) || (keyCode == 32)
			|| (keyCode >= 97 && keyCode <= 122) || (specialKeys
			.indexOf(e.keyCode) != -1 && e.charCode != e.keyCode));
	return ret;
}

function isNumber(evt) {
	var charCode = (evt.which) ? evt.which : event.keyCode;
	if (charCode > 31 && (charCode < 48 || charCode > 57)) {
		return false;
	}
	return true;
}

/*function isofferNumber(field,evt) {
	var charCode = (evt.which) ? evt.which : event.keyCode;
	/*var regex = /^\d{0,9}(\.\d{1,2})?$/g;
	if(charCode == '46' && field.value.length > 6) {
		$(".my-offer-rate").attr("maxlength", 11);
	}
	if (charCode > 31 && (charCode < 45 || charCode > 57) && charCode != 47) {
		return false;
	}
	return true;
}*/


function validateProfile() {
	var name = $("#Admins_name").val().trim();
	var password = $("#Admins_password").val();
	var email = $("#Admins_email").val();
	if (name == "") {
		$("#Admins_name_em_").show();
		$("#Admins_name_em_").html(Yii.t('admin', "Name cannot be blank"));
		$('#Admins_name').val('');
		$('#Admins_name').focus();
		$('#Admins_name').keydown(function() {
			$('#Admins_name_em_').hide();
		});
		return false;
	} else {
		name = name.replace(/\s{2,}/g, ' ');
		$('#Admins_name').val(name);
		if (specials.test(name)) {
			$("#Admins_name_em_").show();
			$("#Admins_name_em_").html(
					Yii.t('admin', 'Special Characters not allowed.'));
			$('#Admins_name').val('');
			$('#Admins_name').focus();
			return false;
		} else {
			$('#Admins_name_em_').hide();
		}

		var reg = /[0-9]/gi;
		if (reg.test(name)) {
			$("#Admins_name_em_").show();
			$("#Admins_name_em_").html(Yii.t('admin', 'Numbers not allowed.'));
			$('#Admins_name').val('');
			$('#Admins_name').focus();
			return false;
		} else {
			$('#Admins_name_em_').hide();
		}
	}
	if (email == "") {
		$("#Admins_email_em_").show();
		$("#Admins_email_em_").html(Yii.t('admin', "Email cannot be blank"));
		$('#Admins_email').focus();
		$('#Admins_email').keydown(function() {
			$('#Admins_email_em_').hide();
		});
		return false;
	}
	if (!isValidEmailAddress(email)) {
		$('#Admins_email_em_').show();
		$('#Admins_email_em_').text(
				Yii.t('admin', 'Please Enter a valid Email'));
		return false;
	}

	if (password == "") {
		$("#Admins_password_em_").show();
		$("#Admins_password_em_").html(
				Yii.t('admin', "Password cannot be blank"));
		$('#Admins_password').focus();
		$('#Admins_password').keydown(function() {
			$('#Admins_password_em_').hide();
		});
		return false;
	}
	if (password.length < 6) {
		$("#Admins_password_em_").show();
		$("#Admins_password_em_").html(
				Yii.t('admin',
						"Password must be greater than 5 characters long"));
		$('#Admins_password').focus();
		$('#Admins_password').keydown(function() {
			$('#Admins_password_em_').hide();
		});
		return false;
	} else {
		$('#Admins_password_em_').hide();
	}

}

function validateCategory() {
	var name = $("#Categories_name").val();
	var image = $("#hiddenImage").val();
	var hidImage = $("#Categories_image").val();
	if (name == "") {
		$("#Categories_name_em_").show();
		$("#Categories_name_em_").html(Yii.t('admin', "Name cannot be blank"));
		$('#Categories_name').focus()
		$('#Categories_name').keydown(function() {
			$('#Categories_name_em_').hide();
		});
		return false;
	} else {
		name = name.replace(/\s{2,}/g, ' ');
		$('#Categories_name').val(name);
		$('#Categories_name_em_').hide();
	}
	if ($("#dropCat").val() == 0) {
		if (image == "" && hidImage == "") {
			$("#Categories_image_em_").show();
			$("#Categories_image_em_").html(
					Yii.t('admin', "Image cannot be blank"));
			$('#Categories_image').focus()
			$('#Categories_image').keydown(function() {
				$('#Categories_image_em_').hide();
			});
			return false;
		}
	}
}

function validateCurrency() {
	var name = $("#Currencies_currency_name").val();
	var shortcode = $("#Currencies_currency_shortcode").val();
	var symbol = $("#Currencies_currency_symbol").val();

	if (name == "") {
		$("#Currencies_currency_name_em_").show();
		$("#Currencies_currency_name_em_").html(
				Yii.t('admin', "Name cannot be blank"));
		$('#Currencies_currency_name').focus();
		$('#Currencies_currency_name').keydown(function() {
			$('#Currencies_currency_name_em_').hide();
		})
		return false;
	}
	if (shortcode == "") {
		$("#Currencies_currency_shortcode_em_").show();
		$("#Currencies_currency_shortcode_em_").html(
				Yii.t('admin', "Shortcode cannot be blank"));
		$('#Currencies_currency_shortcode').focus()
		$('#Currencies_currency_shortcode').keydown(function() {
			$('#Currencies_currency_shortcode_em_').hide();
		})
		return false;
	}
	if (symbol == "") {
		$("#Currencies_currency_symbol_em_").show();
		$("#Currencies_currency_symbol_em_").html(
				Yii.t('admin', "Symbol cannot be blank"));
		$('#Currencies_currency_symbol').focus()
		$('#Currencies_currency_symbol').keydown(function() {
			$('#Currencies_currency_symbol_em_').hide();
		})
		return false;
	}
}

function validateCommission() {
	var com = $("#commission").val();
	var min = $("#minrange").val().trim();
	var max = $("#maxrange").val().trim();

	var com1 = com.replace( /[`~!@#$%^&*()_|+\-=?;:'",.<>\{\}\[\]\\\/a-zA-Z]/gi, "");
	var min1 = min.replace( /[`~!@#$%^&*()_|+\-=?;:'",.<>\{\}\[\]\\\/a-zA-Z]/gi, "");
	var max1 = max.replace( /[`~!@#$%^&*()_|+\-=?;:'",.<>\{\}\[\]\\\/a-zA-Z]/gi, "");
	
	if (com == "") {
		$("#commission-error").show();
		$("#commission-error").html(
				Yii.t('admin', "Commission Amount cannot be blank"));
		$('#commission').focus();
		$('#commission').keydown(function() {
			$('#commission-error').hide();
		});
		return false;
	} else {
		if (com1 != com) {
			$("#commission-error").show();
			$('#commission-error').html(
					Yii.t('admin', 'Only numeric values allowed.'));
			setTimeout(function() {
				$("#commission").val('');
				$("#commission").focus();
				$("#commission-error").fadeOut();
			}, 1500);
			return false;
		} else {
			$('#commission-error').hide();
		}
	}
	
	com = com.replace(/\s/g, "");
	min = min.replace(/\s/g, "");
	max = max.replace(/\s/g, "");
	$('#commission').val(com);
	$('#minrange').val(min);
	$("#maxrange").val(max);
	
	if (com < 1 || com > 100) {
		$("#commission-error").show();
		$("#commission-error").html(
				Yii.t('admin',
						"Commission percentage should be between 1% to 100%."));
		$('#commission').focus();
		$('#commission').keydown(function() {
			$('#commission-error').hide();
		});
		return false;
	} else {
		$('#commission-error').hide();
	}
	if (min == "") {
		$("#minError").show();
		$("#minError").html(Yii.t('admin', "Minimum Range cannot be blank"));
		$('#minrange').focus();
		$('#minrange').keydown(function() {
			$('#minError').hide();
		});
		return false;
	} else if (min <= 0) {
		$("#minError").show();
		$("#minError").html(Yii.t('admin', "Minimum Range should be greater than zero"));
		$('#minrange').focus();
		$('#minrange').keydown(function() {
			$('#minError').hide();
		});
		return false;
	} else {
		if (min1 != min) {
			$("#minError").show();
			$('#minError').html(Yii.t('admin', 'Only numeric values allowed.'));
			setTimeout(function() {
				$("#minrange").val('');
				$("#minrange").focus();
				$("#minError").fadeOut();
			}, 1500);
			return false;
		} else {
			$('#minError').hide();
		}
	}
	if (max == "") {
		$("#maxError").show();
		$("#maxError").html(Yii.t('admin', "Maximum Range cannot be blank"));
		$('#maxrange').focus();
		$('#maxrange').keydown(function() {
			$('#maxError').hide();
		});
		return false;
	} else {
		if (max1 != max) {
			$("#maxError").show();
			$('#maxError').html(Yii.t('admin', 'Only numeric values allowed.'));
			setTimeout(function() {
				$("#maxrange").val('');
				$("#maxrange").focus();
				$("#maxError").fadeOut();
			}, 1500);
			return false;
		} else {
			$('#maxError').hide();
		}
	}

	if (Number(min) >= Number(max)) {
		$("#maxError").show();
		$("#maxError").html(
				Yii.t('admin',
						"Maximum Range should be greater than minimum value."));
		$('#maxrange').focus();
		$('#maxrange').keydown(function() {
			$('#maxError').hide();
		});
		return false;
	}
	return true;
}

function dropCategory() {
	$("#catImage").show();
	if ($("#dropCat").val() != "") {
		$("#catImage").hide();
		$("#itemCondition").hide();
		$("#exchangetoBuy").hide();
		$("#myOffer").hide();
		$("#contactSeller").hide();
		
	} else {
		$("#catImage").show();
		$("#itemCondition").show();
		$("#exchangetoBuy").show();
		$("#myOffer").show();
		$("#contactSeller").show();
	}
}

function limitText(limitNum, evt) {
	if ($(".commenter-text").val().length > limitNum) {
		var textValue = $(".commenter-text").val().substring(0, limitNum);
		$(".commenter-text").val(textValue);
	} else {
		var countValue = limitNum - $(".commenter-text").val().length;
		$("#countdown").html(countValue);
	}
}

function limitMessageText(limitNum, evt) {
	if ($("#MyOfferForm_message").val().length > limitNum) {
		var textValue = $("#MyOfferForm_message").val().substring(0, limitNum);
		$("#MyOfferForm_message").val(textValue);
	} else {
		var countValue = limitNum - $("#MyOfferForm_message").val().length;
		$("#msgcountdown").val(countValue);
	}
}

function limitMessage(limitNum, evt) {
	if ($("#messageInput").val().length > limitNum) {
		var textValue = $("#messageInput").val().substring(0, limitNum);
		$("#messageInput").val(textValue);
		$('#messageInput').addClass('has-error');
		$(".message-limit").html(
				Yii.t('app', "Maximum Character limit") + " 500");
		$(".message-limit").fadeIn();
		setTimeout(function() {
			$('#messageInput').removeClass('has-error');
			$(".message-limit").fadeOut();
		}, 3000);
	}
	var message = $("#messageInput").val();
	var keypr = (window.event) ? event.keyCode : evt.keyCode;
	if (keypr != '16') {
		var reg = /^[^\da-zA-Z]$/;
		if (message.length < 2) {
			if (reg.test(String.fromCharCode(keypr)))
				$("#messageInput").val('');
		}
	}
}
function limitDescription(limitNum) {
	if ($("#Products_description").val().length > limitNum) {
		var textValue = $("#Products_description").val().substring(0, limitNum);
		$("#Products_description").val(textValue);
		$("#Products_description_em_").show();
		$("#Products_description_em_").html(
				Yii.t('admin', "Maximum Character limit Exceeded"));
		$("#Products_description_em_").fadeIn();
		setTimeout(function() {
			$("#Products_description_em_").fadeOut();
		}, 3000);
	}
}

function postcomment() {
	var user = $('.logindetails').val();
	if (user == '') {
		window.location = yii.urls.base+ '/login';
	} else {
		var reg =/<(.|\n)*?>/g; 
		var comment = $('.commenter-text').val();
		var itemId = $('.item-id').val();
		$('.commenter-text').val('');
		var commentCount = $("#commentCount").val();
		$('#post-comment').attr('disabled');
		if (comment != '') {
			if (reg.test(comment) == true) {
				$('.comment-error').html(Yii.t('app','Comment cannot have html'));
				$(".comment-error").fadeIn();
				setTimeout(function() {
					$(".comment-error").fadeOut();
				}, 3000);
			}else{
				// alert(comment);
				$.ajax({
					url : yii.urls.base+ '/item/products/savecomment',
					type : "post",
					dataType : "html",
					data : {'comment' : comment,'itemId' : itemId},
					beforeSend : function() {
						$('#post-comment').html(Yii.t('app','Posting')+ '...');
					},
					success : function(responce) {
						$("#countdown").html('120');
						$('#post-comment').html('Post Comment');
						$('#post-comment').removeAttr('disabled');
						var output = responce.trim();
						$(".empty-comment").hide();
						$('.comment-section').prepend(output);
						$('.commenter-text').val('');
						var incCmnt = Number(commentCount)+ Number(1);							
						$("#commentCount").val(incCmnt);
					}		
				});
			}
		} else {
			$('.comment-error').html(Yii.t('app','Comment cannot be empty'));
			$(".comment-error").css('display','inline-block');
			
		}
		return false;
	}
}

function showmorecomment() {
	$('.view_more_comnts').slideDown();
	$('.view-more-comnt').hide();
	$('.hide-more-comnt').show();
	$('.comment-section').css('max-height','600px');
	$('.comment-section').css('min-height','300px');
}

function hidemorecomment() {
	$('.view_more_comnts').slideUp();
	$('.hide-more-comnt').hide();
	$('.view-more-comnt').show();
	$('.comment-section').css('height','auto');
}

function showmoredesc() {
	$('.ellipses').hide();
	$('.moredesc').slideToggle();
	$('.moredesc').css('display','inline');
	$('.showmoredesc').hide();
	$('.hidemoredesc').show();
}

function lessmoredesc() {
	$('.ellipses').show();
	$('.moredesc').slideToggle();
	$('.moredesc').css('display','none');
	$('.showmoredesc').show();
	$('.hidemoredesc').hide();
}

function selectExchangeproduct(id) {
	$('.exchange-product-grid').removeClass('active');
	$('.exchange'+id).addClass('active');
	$('#exchange_product_id').val(id);
}

function createExchange(mainProductId, requestTo) {
	var exchangeProductId = $("#exchange_product_id").val();
	if (exchangeProductId != '') {
		$
				.ajax({
					type : 'POST',
					url : yii.urls.base + "/item/products/requestExchange",
					data : {
						mainProductId : mainProductId,
						exchangeProductId : exchangeProductId,
						requestTo : requestTo
					},
					success : function(data) {
						
						if (data == 'success') {
							
						} else if (data == 'blocked') {
							$(".option-error").show();
							$(".option-error").focus();
							$(".option-error")
									.html(
											'<div class="col-md-12" style = "color:red;text-align:center;">'
													+ Yii
															.t('app',
																	'Exchange Request for this product has been blocked.')
													+ '</div>');
							// $(".btn-area").hide();

						} else if (data == 'sent') {
							$(".option-error").show();
							$(".option-error").focus();
							$(".option-error")
									.html(
											'<div class="col-md-12" style = "color:red;text-align:center;">'
													+ Yii
															.t('app',
																	'Exchange Request exists.Please check Your Exchanges.')
													+ '</div>');
							// $(".btn-area").hide();

						} else if (data == 'sold') {
							$(".option-error").show();
							$(".option-error").focus();
							$(".option-error")
									.html(
											'<div class="col-md-12" style = "color:red;text-align:center;">'
													+ Yii
															.t('app',
																	'Product has been soldout unexpectedly.')
													+ '</div>');
							$('.exchange-to-buy').hide();
						} else if (data == 'exchangesold') {
							$(".option-error").show();
							$(".option-error").focus();
							$(".option-error")
									.html(
											'<div class="col-md-12" style = "color:red;text-align:center;">'
													+ Yii
															.t('app',
																	'Your choosen Product has been soldout, choose a different one.')
													+ '</div>');
							$('#product_view_' + exchangeProductId).hide();
						} else {
							$(".option-error").show();
							$(".option-error").focus();
							$(".option-error")
									.html(
											'<div class="col-md-12" style = "color:red;text-align:center;">'
													+ Yii
															.t('app',
																	'Please select atleast one product to request exchange.')
													+ '</div>');
						}
						setTimeout(function() {
							$(".option-error").hide();
						}, 2000);
                        if (data == 'success') {
                           setTimeout(function() {
				   $('.exchange-product-grid').removeClass('active');
				   $('#exchange_product_id').val('');
		                   $('#exchange-modal').hide();
				   $('#chat-with-seller-success-modal').show();
				   $("#chat-with-seller-success-modal").addClass("in");
				   $('.sent-text').html('Exchange Request Sent');
                           }, 2000);
                        }
						/*
						 * setTimeout(function() { $('#popup_container').hide();
						 * $('#popup_container').css({ "opacity" : "0" });
						 * $('#show-exchange-popup').hide();
						 * $(".option-error").hide(); $('body').css({ "overflow" :
						 * "auto" }); }, 4000);
						 */
					}
				});
	} else {
		$(".option-error").show();
		$(".option-error")
				.html(
						Yii
								.t('app',
										"You've not selected any Item for exchange.Please select an Item To Proceed"));
		$(".option-error").focus();
	}
}
function genpass(type) {
	var charset = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz';
	var charshuffle = shuffle(charset);
	var password = charshuffle.substring(0, 8);
	if (type == "update"){
		if (confirm(Yii.t('admin', "Are you sure, you want to change password?"))) {
			$('#Users_password').val(password);
		}
	}else{
		$('#Users_password').val(password);
	}
}

function generateapipassword() {
	var charset = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz';
	var charshuffle = shuffle(charset);
	var password = charshuffle.substring(0, 8);
	if (confirm(Yii.t('admin', "Are you sure, you want to change password?"))) {
		$('#Sitesettings_apiPassword').val(password);
		$('#show_apipassword').val(password);
	}
}

function showapipassword() {
	if ($('.show-button').hasClass('fa-eye')) {
		$('.show-button').removeClass('fa-eye');
		$('.show-button').addClass('fa-eye-slash');
		$('#Sitesettings_apiPassword').hide();
		$('#show_apipassword').show();
	} else {
		$('.show-button').removeClass('fa-eye-slash');
		$('.show-button').addClass('fa-eye');
		$('#Sitesettings_apiPassword').show();
		$('#show_apipassword').hide();
	}
	return false;
}

function shuffle(string) {
	var parts = string.split('');
	for ( var i = parts.length; i > 0;) {
		var random = parseInt(Math.random() * i);
		var temp = parts[--i];
		parts[i] = parts[random];
		parts[random] = temp;
	}
	return parts.join('');
}

function changeQuantity() {
	var selectedQty = $(".product-quantity").val();
	$(".product-quantity-hidden").val(selectedQty);
	var unitPrice = $(".product-unit-price").val();
	var currency = $('.currency').val();
	var total = selectedQty * unitPrice;
	var oldTotal = total;
	var couponType = $(".coupon-type-hidden").val();
	var couponValue = $(".coupon-value-hidden").val();
	var shipping = $(".item-shipping").val();

	if (couponType == "1") {
		if (couponValue > 0) {
			total = Number(total) - (selectedQty * Number(couponValue));
			$(".product-coupon-discount")
					.val(selectedQty * Number(couponValue));
			$(".coupon-discount")
					.html(
							Yii.t('app', 'Discount')
									+ ': ( - ) <span class="amnt product-item-coupondiscount">'
									+ Number(selectedQty) * couponValue + " "
									+ currency + '</span>');
		}
	} else {
		discount = (Number(total) * (Number(couponValue) / 100));
		if (discount > 0) {
			if ($(".coupon-max-hidden").val() != ""
					&& $(".coupon-max-hidden").val() < discount) {
				discount = $(".coupon-max-hidden").val();
			}
			total = Number(total) - Number(discount);
			$(".product-coupon-discount").val(discount);
			$(".coupon-discount")
					.html(
							Yii.t('app', 'Discount')
									+ ': ( - ) <span class="amnt product-item-coupondiscount">'
									+ discount + " " + currency + '</span>');
		}
	}
	var grandTotal = Number(total) + Number(shipping);

	$(".product-sub-total").html(
			Yii.t('app', 'Subtotal')
					+ ':<span class="amnt product-item-total"> ' + oldTotal
					+ " " + currency + ' </span>');
	$('.product-sub-total-hidden').val(oldTotal);
	$(".sub-total-hidden").val(total);
	$(".product-grand-total").html(
			Yii.t('app', 'Order Total')
					+ ': <span class="amnt product-item-grandtotal"> '
					+ grandTotal + " " + currency + ' </span>');
}
function checkRange(country) {
	var shipp = $(".shipping-range-hidden").val();
	$
			.ajax({
				type : 'POST',
				url : yii.urls.base + '/item/buynow/checkrange',
				data : {
					country : country,
					shippingRange : shipp
				},
				success : function(data) {
					if (data == 'false') {
						$(".country-error")
								.html(
										Yii
												.t('app',
														"Item cannot be shipped to your location"));
						$(".country-error").show();
						document.getElementById("check-out-button")
								.setAttribute("disabled", "disabled");
					} else {
						$(".country-error").hide();
						$("#check-out-button").removeAttr("disabled");
					}
				}
			});
}

function shippingChange() {
	var shipCost = $(".shipping-cost-hidden").val();
	var shipp = $(".shipping-range-hidden").val();
	var shippingReturn = $(".shipping-addresses").val().split('-');
	var nickname = shippingReturn[1];
	var shippingId = shippingReturn[0];
	$(".country-error").hide();
	$.ajax({
		type : 'POST',
		url : yii.urls.base + '/item/buynow/getShippingAddress',
		data : {
			nickname : nickname,
			shippingId : shippingId,
			shipCost : shipCost,
			shippingRange : shipp
		},
		success : function(data) {
			var output = JSON.parse(data);
			checkRange(output.country);
			var currency = $('.currency').val();
			$(".selected-shipping").val(output.shippingId);
			$(".fullname").val(output.username);
			$(".address1").val(output.address1);
			$(".address2").val(output.address2);
			$(".city").val(output.city);
			$(".pincode").val(output.pincode);
			$(".state").val(output.state);
			$(".country").val(output.country);
			$(".phone").val(output.phone);
			$(".product-item-shippingcost").html(
					output.shipPrice + " " + currency);
			$(".item-shipping").val(output.shipPrice);
			var subtotal = $(".product-sub-total-hidden").val();
			var discount = $(".product-coupon-discount").val();
			var shipping = $(".item-shipping").val();
			var grandTotal = (Number(subtotal) + Number(shipping))
					- Number(discount);
			console.log(subtotal + " " + shipping + " " + discount);
			$(".product-item-grandtotal").html(grandTotal + " " + currency);
		}
	});
}

function applyCoupon() {
	var couponCode = $(".couponCode").val();
	var currency = $('.currency').val();
	var productId = $(".review-order-product-id").val();
	var sellerId = $(".review-order-seller-id").val();
	if (couponCode == "") {
		$(".option-error").show();
		$(".option-error").html(Yii.t('app', "Please Enter your Coupon Code"));
		$(".option-error").fadeIn();
		setTimeout(function() {
			$(".option-error").fadeOut();
		}, 3000);
	} else {
		$(".option-error").hide();
		if (couponCode.length != 8) {
			$(".option-error").show();
			$(".option-error").html(Yii.t('app', "Invalid Coupon Code"));
			$(".option-error").fadeIn();
			setTimeout(function() {
				$(".option-error").fadeOut();
				$(".couponCode").val("");
			}, 3000);
		} else {
			$
					.ajax({
						type : 'POST',
						url : yii.urls.base + '/item/buynow/applyCoupon',
						data : {
							couponCode : couponCode,
							sellerId : sellerId,
							productId : productId
						},
						success : function(data) {
							if (data != "") {
								var output = JSON.parse(data);
								var couponId = output.couponId;
								var couponValue = output.couponValue;
								var couponType = output.couponType;
								var startDate = output.startDate;
								var endDate = output.endDate;
								var maxAmount = output.maxAmount;

								var selectedQty = $(".product-quantity-hidden")
										.val();
								var unitPrice = $(".product-unit-price").val();
								var total = selectedQty * unitPrice;
								var shipping = $(".item-shipping").val();
								var subtotal;
								var grandTotal;
								var date = new Date();
								curYear = date.getFullYear();
								curMonth = date.getMonth() + 1;
								curDate = date.getDate();
								if (curDate < 10) {
									curDate = '0' + curDate;
								}
								if (curMonth < 10) {
									curMonth = '0' + curMonth;
								}
								var curDate = curYear + '-' + curMonth + '-'
										+ curDate;
								$(".coupon-type-hidden").val(couponType);
								$(".coupon-code-hidden").val(couponCode);
								if (couponType == '1') {
									if (couponValue > total) {
										$(".option-error").show();
										$(".option-error").html(
												Yii.t('app',
														"Invalid Coupon Code"));
										$(".option-error").fadeIn();
										setTimeout(function() {
											$(".option-error").fadeOut();
											$(".couponCode").val("");
										}, 3000);
									} else {
										$(".coupon-value-hidden").val(
												couponValue);
										subtotal = Number(total)
												- Number(selectedQty)
												* Number(couponValue);
										grandTotal = Number(subtotal)
												+ Number(shipping);
										if (grandTotal < 0) {
											$(".option-error").show();
											$(".option-error")
													.html(
															Yii
																	.t('app',
																			"Invalid Coupon Code"));
											$(".option-error").fadeIn();
											setTimeout(function() {
												$(".option-error").fadeOut();
												$(".couponCode").val("");
											}, 3000);
										} else {
											$(".product-coupon-discount").val(
													Number(selectedQty)
															* couponValue);
											$(".coupon-discount")
													.html(
															Yii.t('app',
																	'Discount')
																	+ ': ( - ) <span class="amnt product-item-coupondiscount">'
																	+ Number(selectedQty)
																	* couponValue
																	+ " "
																	+ currency
																	+ '</span>');
											$(".product-grand-total")
													.html(
															Yii
																	.t('app',
																			'Order Total')
																	+ ': <span class="amnt product-item-grandtotal"> '
																	+ grandTotal
																	+ " "
																	+ currency
																	+ ' </span>');
											setTimeout(function() {
												$(".couponCode").val("");
											}, 3000);
										}
									}
								} else {
									if (curDate >= startDate
											&& curDate <= endDate) {
										discount = (Number(total) * (Number(couponValue) / 100));
										if (maxAmount > 0) {
											if (discount > maxAmount) {
												discount = maxAmount;
											}
											$(".coupon-max-hidden").val(
													maxAmount);
										}
										subtotal = Number(total) - discount;
										grandTotal = Number(subtotal)
												+ Number(shipping);
										$(".product-coupon-discount").val(
												discount);
										$(".coupon-value-hidden").val(
												couponValue);
										$(".coupon-discount")
												.html(
														Yii
																.t('app',
																		'Discount')
																+ ': ( - ) <span class="amnt product-item-coupondiscount">'
																+ discount
																+ " "
																+ currency
																+ '</span>');
										$(".sub-total-hidden").val(subtotal);
										$(".product-grand-total")
												.html(
														Yii.t('app',
																'Order Total')
																+ ': <span class="amnt product-item-grandtotal"> '
																+ grandTotal
																+ " "
																+ currency
																+ ' </span>');
										setTimeout(function() {
											$(".couponCode").val("");
										}, 3000);
									} else {
										$(".option-error").show();
										$(".option-error")
												.html(
														Yii
																.t('app',
																		"Expired or Invalid Coupon Code"));
										$(".option-error").fadeIn();
										setTimeout(function() {
											$(".option-error").fadeOut();
											$(".couponCode").val("");
										}, 3000);
									}
								}
							} else {
								$(".option-error").show();
								$(".option-error").html(
										Yii.t('app', "Invalid Coupon Code"));
								$(".option-error").fadeIn();
								setTimeout(function() {
									$(".option-error").fadeOut();
									$(".couponCode").val("");
								}, 3000);
							}
						},
						error : function() {
							$(".option-error").show();
							$(".option-error").html(
									Yii.t('app', "Invalid Coupon Code"));
							$(".option-error").fadeIn();
							setTimeout(function() {
								$(".option-error").fadeOut();
								$(".couponCode").val("");
							}, 3000);
						},
					});
		}
	}
}
function changeOrderStatus(status, orderId) {
	var pages = $(".page-value-hidden").val();
	$.ajax({
		type : 'POST',
		url : yii.urls.base + '/buynow/useraction/changestatus',
		data : {
			status : status,
			orderId : orderId,
			pages : pages
		},
		success : function(data) {
			if (pages == "") {
				$(".item-view").load("orders");
			} else {
				$(".item-view").load("orders?page=" + pages);
			}
		}
	});
}
function changeSalesStatus(status, orderId) {
	var pages = $(".page-value-hidden").val();
	$.ajax({
		type : 'POST',
		url : yii.urls.base + '/buynow/useraction/changestatus',
		data : {
			status : status,
			orderId : orderId,
			pages : pages
		},
		success : function(data) {
			$(".process"+orderId).hide();
			if (pages == "") {
				$(".item-view").load("sales");
			} else {
				$(".item-view").load("sales?page=" + pages);
			}
		}
	});
}

function edit_tracking(trackid,orderid)
{
	$.ajax({
		type : 'POST',
		url : yii.urls.base + '/buynow/useraction/edit_tracking_details',
		data : {
			trackid : trackid,
			orderid : orderid,
		},
		success : function(data) {
			if(trackid != 0)
			{
				var obj = jQuery.parseJSON(data);
				$("#Trackingdetails_orderid").val(obj['orderid']);
				$("#Trackingdetails_shippingdate").val(obj['shippingdate']);
				$("#Trackingdetails_couriername").val(obj['couriername']);
				$("#Trackingdetails_courierservice").val(obj['courierservice']);
				$("#Trackingdetails_trackingid").val(obj['trackingid']);
				$("#Trackingdetails_notes").val(obj['notes']);
			}
			else if(trackid == 0)
			{
				$("#Trackingdetails_orderid").val(orderid);
			}
		}
	});
}

function claimorder(btn,orderid)
{
	$.ajax({
		type : 'POST',
		url : yii.urls.base + '/buynow/useraction/claimorder',
		data : {
			orderid : orderid,
		},
		success : function(data) {
			$(btn).hide()
		}
	});	
}

function validatetracking()
{
		shipdate = $("#Trackingdetails_shippingdate").val();
		couriername = $("#Trackingdetails_couriername").val();
		shippingservice = $("#Trackingdetails_courierservice").val();
		trackingid = $("#Trackingdetails_trackingid").val();
		if(shipdate == "")
		{
			$("#Trackingdetails_shippingdate_em_").show();
			$('#Trackingdetails_shippingdate_em_').text(
					Yii.t('app', 'Enter shipment date'));
			$('#Trackingdetails_shippingdate').focus();
			$('#Trackingdetails_shippingdate').blur(function() {
				$('#Trackingdetails_shippingdate_em_').hide();
			});
			return false;
		}
		if($.trim(couriername) == "")
		{
			$("#Trackingdetails_couriername_em_").show();
			$('#Trackingdetails_couriername_em_').text(
					Yii.t('app', 'Enter courier name'));
			$('#Trackingdetails_couriername').focus();
			$('#Trackingdetails_couriername').keydown(function() {
				$('#Trackingdetails_couriername_em_').hide();
			});
			return false;			
		}
		if($.trim(shippingservice) == "")
		{
			$("#Trackingdetails_courierservice_em_").show();
			$('#Trackingdetails_courierservice_em_').text(
					Yii.t('app', 'Enter shipping service'));
			$('#Trackingdetails_courierservice').focus();
			$('#Trackingdetails_courierservice').keydown(function() {
				$('#Trackingdetails_courierservice_em_').hide();
			});
			return false;				
		}
		if($.trim(trackingid) == "")
		{
			$("#Trackingdetails_trackingid_em_").show();
			$('#Trackingdetails_trackingid_em_').text(
					Yii.t('app', 'Enter shipping service'));
			$('#Trackingdetails_trackingid').focus();
			$('#Trackingdetails_trackingid').keydown(function() {
				$('#Trackingdetails_trackingid_em_').hide();
			});
			return false;				
		}		
		return true;
}

function showinvoicepopup(invoiceId) {
	$('#popup_container').show();
	$('#popup_container').css({
		"opacity" : "1"
	});
	$('body').css({
		"overflow" : "hidden"
	});
	getInvoiceData(invoiceId);
	$('#show-exchange-popup').show();
}

function getInvoiceData(invoiceId) {
	$.ajax({
		type : 'POST',
		url : yii.urls.base + '/useractivity/useraction/getInvoiceData',
		data : {
			invoiceId : invoiceId
		},
		success : function(data) {
			$('#show-exchange-popup').html(data);
		}
	});
}

function shippingConfirmValidation() {
	if ($("#subject").val() == "") {
		$(".empty-error-sub").html(Yii.t('app', "Subject Cannot be Empty"));
		return false;
	} else if ($("#message").val() == "") {
		$(".empty-error-sub").hide();
		$(".empty-error-msg").html(Yii.t('app', "Message Cannot be Empty"));
		return false;
	}
}
function addtracking() {
	var BaseURL = getBaseURL();
	var shippingdate = $('#shipmentdate').val();
	var couriername = $('#couriername').val();
	var courierservice = $('#courierservice').val();
	var trackid = $('#trackingid').val();
	var notes = $('#notes').val();
	var orderid = $('#hiddenorderid').val();
	var buyeremail = $('#hiddenbuyeremail').val();
	var buyername = $('#hiddenbuyername').val();
	var orderstatus = $('#hiddenorderstatus').val();
	var address = $('#hiddenbuyeraddress').val();
	var id = $('#trackid').val();
	$('.error').html('');

	if (shippingdate == '') {
		$('.shipmentdateerror').html(
				Yii.t('app', 'Shipment Date cannot be empty'));
		return false;
	} else if (couriername == '') {
		$('.couriernameerror').html(
				Yii.t('app', 'Courier Name cannot be empty'));
		return false;
	} else if (trackid == '') {
		$('.trackingiderror').html(Yii.t('app', 'Tracking ID cannot be empty'));
		return false;
	}
	$.ajax({
		url : BaseURL + "tracking",
		type : "post",
		data : {
			'orderid' : orderid,
			'buyeremail' : buyeremail,
			'orderstatus' : orderstatus,
			'address' : address,
			'buyername' : buyername,
			'shippingdate' : shippingdate,
			'couriername' : couriername,
			'trackid' : trackid,
			'notes' : notes,
			'courierservice' : courierservice,
			'id' : id
		},
		beforeSend : function() {
			$('.updatetrackingloader').show();
		},
		success : function(responce) {
			$('.updatetrackingloader').hide();
			window.location = BaseURL + 'orders';
		}
	});
}
function like(id) {
	var user = $('.logindetails').val();
	var productId = $(".item-id").val();
	var like_count = $('#like_counter').html();
	if (user == '') {
		window.location = yii.urls.base + '/login';
	} else {
		/*$(".favs")
				.html(
						'<a class="btn like-btn" href="javascript:void(0)"><i class="fa fa-heart-o btn-lg"></i></a>');*/
		if(likeAjax == 1){
			likeAjax = 0;
			$.ajax({
				type : 'POST',
				url : yii.urls.base + '/item/products/like/id/' + id,
				success : function(data) {
					var real_count = parseInt(like_count) + parseInt(1);
					$('#like_counter').html(real_count);
					$("#favs").html(
							'<a href="javascript:void(0)" onclick="dislike('
									+ productId
									+ ')"><div class="product-like col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding pull-right" id="liked"></div></i></a>');
					likeAjax = 1;
				}
			});
		}
	}
}
function dislike(id) {
	var user = $('.logindetails').val();
	var productId = $(".item-id").val();
	var like_count = $('#like_counter').html();
	if (user == '') {
		window.location = yii.urls.base + '/login';
	} else { 
		/*$(".favs")
				.html(
						'<a class="btn like-btn" href="javascript:void(0)"><i class="fa fa-heart btn-lg"></i></a>');*/
		if(dislikeAjax == 1){
			dislikeAjax = 0;
			$.ajax({
				type : 'POST',
				url : yii.urls.base + '/item/products/dislike/id/' + id,
				success : function(data) {
					var real_count = parseInt(like_count) - parseInt(1);
					$('#like_counter').html(real_count);
					$("#favs").html('<a href="javascript:void(0)" onclick="like('
							+ productId
							+ ')"><div class="product-like col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding pull-right"></div></i></a>');
					dislikeAjax = 1;
				}
			});
		}
	}
}
function mobile_like(id) {
	var user = $('.logindetails').val();
	var productId = $(".item-id").val();
	var like_count = $('#mobile_like_counter').html();
	if (user == '') {
		window.location = yii.urls.base + '/login';
	} else {
		$(".favs")
				.html(
						'<a class="btn like-btn" href="javascript:void(0)"><i class="fa fa-heart-o btn-lg"></i></a>');
		$.ajax({
			type : 'POST',
			url : yii.urls.base + '/item/products/like/id/' + id,
			success : function(data) {
				var real_count = parseInt(like_count) + parseInt(1);
				$('#mobile_like_counter').html(real_count);
				$("#mobile_favs").html(
						'<a href="javascript:void(0)" onclick="mobile_dislike('
								+ productId
								+ ')"><div class="product-like col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding pull-right" id="liked"></div></i></a>');
			}
		});
	}
}
function mobile_dislike(id) {
	var user = $('.logindetails').val();
	var productId = $(".item-id").val();
	var like_count = $('#mobile_like_counter').html();
	if (user == '') {
		window.location = yii.urls.base + '/login';
	} else {
		$(".favs")
				.html(
						'<a class="btn like-btn" href="javascript:void(0)"><i class="fa fa-heart btn-lg"></i></a>');
		$
				.ajax({
					type : 'POST',
					url : yii.urls.base + '/item/products/dislike/id/' + id,
					success : function(data) {
						var real_count = parseInt(like_count) - parseInt(1);
						$('#mobile_like_counter').html(real_count);
						$("#mobile_favs").html('<a href="javascript:void(0)" onclick="mobile_like('
								+ productId
								+ ')"><div class="product-like col-xs-12 col-sm-12 col-md-12 col-lg-12 no-hor-padding pull-right"></div></i></a>');
					}
				});
	}
}
function mapView() {
	var location = $(".product-location-name").val();
	var latitude = $(".product-location-lat").val();
	var longitude = $(".product-location-long").val();
	$('#map_canvas').delay('700').fadeIn();
	$('#mobile_map_canvas').delay('700').fadeIn();
	if (mapClick == 1) {
		setTimeout(function() {
			showMap(location, latitude, longitude);
			mobile_showMap(location, latitude, longitude);
		}, 1000);
		mapClick = 0;
	}
}

function myoffer() {
	var offerRate = $("#MyOfferForm_offer_rate").val();
	var productPrice = $(".product-price-hidden").val();
	var productId = $('.item-id').val();
	var name = $("#MyOfferForm_name").val().trim();
	var email = $("#MyOfferForm_email").val();
	var phone = $("#MyOfferForm_phone").val().trim();
	var message = $("#MyOfferForm_message").val().trim();
	var currency = $(".price-option-hidden").val();
	var sellerId = $(".product-user-id").val();
	var numbers = /[0-9]/gi;
	var offer = offerRate.replace(/\s/g, '');
	$("#MyOfferForm_offer_rate").val(offer);
	if($.trim(offerRate) == '') {
		$('#errorMessage').show();
		$('#errorMessage').html('Offer value can not be empty');
		return false;
	}
	if(parseInt(offerRate) == '0') {
		$('#errorMessage').show();
		$('#errorMessage').html('Offer value should not be zero');
		return false;
	}
	if (message == "") {
		$('#errorMessage').show();
		$("#errorMessage").html(Yii.t('app', 'Message cannot be blank'));
		$("#MyOfferForm_message").val('');
		return false;
	}
	if(parseInt(offerRate) >= parseInt(productPrice)) {
		$('#errorMessage').show();
		$('#errorMessage').html('Offer Price should be less than Product Price.');
		return false;
	}
	if($.trim(phone) == '') {
		phone = 'NILL';
	}
	
	if (name != "" && email != "" && message != ""
			&& offerRate > 0) {
		var imageUrl = yii.urls.base + '/images/loader.gif';
		$('.offer-send-btn').html('Sending...');
		$('.offer-send-btn').attr('disabled');
		if(offercheck == 1) {
			offercheck = 0;
			$.ajax({
				type : 'POST',
				url : yii.urls.base + '/products/myoffer',
				data : {
					offerRate : offerRate,
					name : name,
					email : email,
					phone : phone,
					message : message,
					sellerId : sellerId,
					currency : currency,
					productId : productId
				},
				success : function(data) {
					$('.offer-send-btn').html('Send');
					$('.offer-send-btn').removeAttr('disabled');
					$("#MyOfferForm_offer_rate").val('');
					$("#MyOfferForm_message").val('');
					$('#offer-modal').hide();
					$('#offer-success-modal').show();
					$("#offer-success-modal").addClass("in");
					$('.sent-text').html('Your Offer sent');
					offercheck = 1;
				}
			});
		}
	}
}
function decline(exchangeId) {
	$.ajax({
		type : 'POST',
		url : yii.urls.base + '/item/exchanges/decline?id=' + exchangeId,
		data : {'ajax':1},
		success : function(data) {
			if (data == 1){
				window.location.href = yii.urls.base + '/item/exchanges?type=failed';
			}else{
				window.location.href = yii.urls.base + '/item/exchanges?type=incoming';
			}
		},
	});
}
function cancel(exchangeId) {
	$.ajax({
		type : 'POST',
		url : yii.urls.base + '/item/exchanges/cancel?id=' + exchangeId,
		data : {'ajax':1},
		success : function(data) {
			if (data == 1){
				window.location.href = yii.urls.base + '/item/exchanges?type=failed';
			}else if (data == 2){
				window.location.href = yii.urls.base + '/item/exchanges?type=success';
			}else{
				window.location.href = yii.urls.base + '/item/exchanges?type=outgoing';
			}
		},
	});
}
function sold(exchangeId) {
	$.ajax({
		type : 'POST',
		url : yii.urls.base + '/item/exchanges/sold?id=' + exchangeId,
		success : function(data) {
			window.location.href = yii.urls.base
					+ '/item/exchanges?type=failed';
		},
	});
}

function cancelExchange(exchangeId) {
	$(".no-more-" + exchangeId).html(
		'<span class="exchange-btn" id="exc-success">'
		+ Yii.t('app', 'Requesting...') + '</span>');
	$.ajax({
		type : 'POST',
		url : yii.urls.base + '/item/exchanges/cancelExchange?id=' + exchangeId,
		success : function(data) {
					$(".no-more-" + exchangeId).html(
						'<span class="exchange-btn" id="exc-success" onclick="allowExchange('
						+ exchangeId + ')">'
						+ Yii.t('app','Allow Exchanges') + '</span>');
					},
	});
}

function allowExchange(exchangeId) {
	$(".no-more-" + exchangeId).html(
		'<span class="exchange-btn" id="exc-success">'
			+ Yii.t('app', 'Requesting...') + '</span>');
	$.ajax({
		type : 'POST',
		url : yii.urls.base + '/item/exchanges/allowExchange?id=' + exchangeId,
		success : function(data) {
					$(".no-more-" + exchangeId).html(
						'<span class="exchange-btn" id="exc-failed" onclick="cancelExchange('
						+ exchangeId + ')">'
						+ Yii.t('app','Block Exchanges') + '</span>');
				},
	});
}

function accept(exchangeId) {
	var successUrl = yii.urls.base + '/item/exchanges/success?id=' + exchangeId;
	var failedUrl = yii.urls.base + '/item/exchanges/failed?id=' + exchangeId;
	$.ajax({
		type : 'POST',
		url : yii.urls.base + '/item/exchanges/accept?id=' + exchangeId,
		data : {'ajax':1},
		success : function(data) {
			if (data == 1){
				$(".exchange-status-" + exchangeId).html(Yii.t('app', 'Current Status')
						+ ":<label class='label-lg label-success'>" + Yii.t('app', 'ACCEPTED')
						+ "</label>");
				/*$(".exchange-action-" + exchangeId).html("<a type='button' href='" + successUrl
						+ "' class='btn-choose-option btn-done' id='btn-doneid' style='font-size: 13px; float: left;text-decoration:none;'>"
						+ Yii.t('app', 'SUCCESS') + "</a><a type='button' href='" + failedUrl
						+ "' class='btn-choose-option btn-done' id='btn-doneid' style='font-size: 13px; float: right;text-decoration:none;'>"
						+ Yii.t('app', 'FAILED') + "</a>");*/
				$(".exchange-action-" + exchangeId).html("<span type='button' class='exchange-btn' id='exc-success' " +
						"onclick='confirmModal(\"link\", \"item/exchanges/success?id=\", "+exchangeId+")' " +
								"style='font-size: 13px; float: left;text-decoration:none;'>"+ Yii.t('app','SUCCESS') +"</span>" +
										"<span type='button' class='exchange-btn' id='exc-failed' " +
						"onclick='confirmModal(\"link\", \"item/exchanges/failed?id=\", "+exchangeId+")' " +
								"style='font-size: 13px; float: left;text-decoration:none;'>"+ Yii.t('app','FAILED') +"</span>");
				$('#confirm_popup_container').modal('hide'); 
			}else{
				window.location.href = yii.urls.base + '/item/exchanges?type=failed';
			}
					
		},
	});
}

function showTop() {
	var priority1 = $("#priority1").val();
	var priority2 = $("#priority2").val();
	var priority3 = $("#priority3").val();
	var priority4 = $("#priority4").val();
	var priority5 = $("#priority5").val();
	if (priority1 == "empty") {
		$("#priority1Error").html(
				Yii.t('admin', 'Priority') + ' 1 '
						+ Yii.t('admin', 'cannot be blank'));
		return false;
	} else {
		$("#priority1Error").hide();
	}
	if (priority5 != "empty"
			&& (priority5 == priority1 || priority5 == priority2
					|| priority5 == priority3 || priority5 == priority4)) {
		$("#priority5Error").html(
				Yii.t('admin', 'Priority') + ' 5 '
						+ Yii.t('admin', 'should be unique'));
		$(this).val("");
		return false;
	} else {
		$("#priority5Error").hide();
	}
	if (priority4 == "empty" && (priority5 != "empty")) {
		$("#priority4Error").html(
				Yii.t('admin', 'Priority') + ' 4 '
						+ Yii.t('admin', 'cannot be blank'));
		return false;
	} else {
		if (priority4 != "empty"
				&& (priority4 == priority1 || priority4 == priority2
						|| priority4 == priority3 || priority4 == priority5)) {
			$("#priority4Error").html(
					Yii.t('admin', 'Priority') + ' 4 '
							+ Yii.t('admin', 'should be unique'));
			$(this).val("");
			return false;
		} else {
			$("#priority4Error").hide();
		}
	}

	if (priority3 == "empty" && (priority4 != "empty" || priority5 != "empty")) {
		$("#priority3Error").html(
				Yii.t('admin', 'Priority') + ' 3 '
						+ Yii.t('admin', 'cannot be blank'));
		return false;
	} else {
		if (priority3 != "empty"
				&& (priority3 == priority1 || priority3 == priority2
						|| priority3 == priority4 || priority3 == priority5)) {
			$("#priority3Error").html(
					Yii.t('admin', 'Priority') + ' 3 '
							+ Yii.t('admin', 'should be unique'));
			$(this).val("");
			return false;
		} else {
			$("#priority3Error").hide();
		}
	}

	if (priority2 == "empty"
			&& (priority3 != "empty" || priority4 != "empty" || priority5 != "empty")) {
		$("#priority2Error").html(
				Yii.t('admin', 'Priority') + ' 2 '
						+ Yii.t('admin', 'cannot be blank'));
		return false;
	} else {
		if (priority2 != "empty"
				&& (priority2 == priority1 || priority2 == priority3
						|| priority2 == priority4 || priority2 == priority5)) {
			$("#priority2Error").html(
					Yii.t('admin', 'Priority') + ' 2 '
							+ Yii.t('admin', 'should be unique'));
			$(this).val("");
			return false;
		} else {
			$("#priority2Error").hide();
		}
	}
	if (priority1 == "empty"
			&& (priority2 != "empty" || priority3 != "empty"
					|| priority4 != "empty" || priority5 != "empty")) {
		$("#priority1Error").html(
				Yii.t('admin', 'Priority') + ' 1 '
						+ Yii.t('admin', 'cannot be blank'));
		return false;
	} else {
		$("#priority1Error").show();
		if (priority1 != "empty"
				&& (priority1 == priority2 || priority1 == priority3
						|| priority1 == priority4 || priority1 == priority5)) {
			$("#priority1Error").html(
					Yii.t('admin', 'Priority') + ' 1 '
							+ Yii.t('admin', 'should be unique'));
			$(this).val("");
			return false;
		} else {
			$("#priority1Error").hide();
		}
	}

}

function showTopCat() {
	var priority1 = $("#catpriority1").val();
	var priority2 = $("#catpriority2").val();
	var priority3 = $("#catpriority3").val();
	var priority4 = $("#catpriority4").val();
	var priority5 = $("#catpriority5").val();
	var priority6 = $("#catpriority6").val();
	var priority7 = $("#catpriority7").val();
	var priority8 = $("#catpriority8").val();
	var priority9 = $("#catpriority9").val();
	var priority10 = $("#catpriority10").val();
	
	
	if (priority1 == "empty") {
		$("#priority1Error").html(
				Yii.t('admin', 'Priority') + ' 1 '
						+ Yii.t('admin', 'cannot be blank'));
		return false;
	} else {
		$("#priority1Error").hide();
	}
	
	if (priority10 != "empty"
			&& (priority10 == priority1 || priority10 == priority2 || priority10 == priority3 || priority10 == priority4 || priority10 == priority5
					|| priority10 == priority6 || priority10 == priority7 || priority10 == priority8 || priority10 == priority9)) {
		$("#priority10Error").html(
				Yii.t('admin', 'Priority') + ' 10 '
						+ Yii.t('admin', 'should be unique'));
		$("#priority10Error").show();
		$(this).val("");
		return false;
	} else {
		$("#priority10Error").hide();
	}
	console.log(priority9+priority10);
	if (priority9 == "empty" && (priority10 != "empty")) {

		if(priority1 == "empty"){
			$("#priority1Error").html(
					Yii.t('admin', 'Priority') + ' 1 '
							+ Yii.t('admin', 'cannot be blank'));
			}
		if(priority2 == "empty"){
			$("#priority2Error").html(
					Yii.t('admin', 'Priority') + ' 2 '
							+ Yii.t('admin', 'cannot be blank'));
			}
		if(priority3 == "empty"){
		$("#priority3Error").html(
				Yii.t('admin', 'Priority') + ' 3 '
						+ Yii.t('admin', 'cannot be blank'));
		}
		if(priority4 == "empty"){
			$("#priority4Error").html(
					Yii.t('admin', 'Priority') + ' 4 '
							+ Yii.t('admin', 'cannot be blank'));
		}
		if(priority5 == "empty"){
			$("#priority5Error").html(
					Yii.t('admin', 'Priority') + ' 5 '
							+ Yii.t('admin', 'cannot be blank'));
		}
		if(priority6 == "empty"){
			$("#priority6Error").html(
					Yii.t('admin', 'Priority') + ' 6 '
							+ Yii.t('admin', 'cannot be blank'));
		}
		if(priority7 == "empty"){
			$("#priority7Error").html(
					Yii.t('admin', 'Priority') + ' 7 '
							+ Yii.t('admin', 'cannot be blank'));
		}
		if(priority8 == "empty"){
			$("#priority8Error").html(
					Yii.t('admin', 'Priority') + ' 8 '
							+ Yii.t('admin', 'cannot be blank'));
		}
		if(priority9 == "empty"){
			$("#priority9Error").html(
					Yii.t('admin', 'Priority') + ' 9 '
							+ Yii.t('admin', 'cannot be blank'));
		}
		return false;
	} else {
		if (priority9 != "empty"
				&& (priority9 == priority1 || priority9 == priority2 || priority9 == priority3 || priority9 == priority4 || priority9 == priority5
						|| priority9 == priority6 || priority9 == priority7 || priority9 == priority8 || priority9 == priority10)) {
			$("#priority9Error").html(
					Yii.t('admin', 'Priority') + ' 9 '
							+ Yii.t('admin', 'should be unique'));
			$("#priority9Error").show();
			$(this).val("");
			return false;
		} else {
			$("#priority9Error").hide();
		}
	}
	
	if (priority8 == "empty" && (priority9 != "empty")) {
		
		if(priority1 == "empty"){
			$("#priority1Error").html(
					Yii.t('admin', 'Priority') + ' 1 '
							+ Yii.t('admin', 'cannot be blank'));
			}
		if(priority2 == "empty"){
			$("#priority2Error").html(
					Yii.t('admin', 'Priority') + ' 2 '
							+ Yii.t('admin', 'cannot be blank'));
			}
		if(priority3 == "empty"){
		$("#priority3Error").html(
				Yii.t('admin', 'Priority') + ' 3 '
						+ Yii.t('admin', 'cannot be blank'));
		}
		if(priority4 == "empty"){
			$("#priority4Error").html(
					Yii.t('admin', 'Priority') + ' 4 '
							+ Yii.t('admin', 'cannot be blank'));
		}
		if(priority5 == "empty"){
			$("#priority5Error").html(
					Yii.t('admin', 'Priority') + ' 5 '
							+ Yii.t('admin', 'cannot be blank'));
		}
		if(priority6 == "empty"){
			$("#priority6Error").html(
					Yii.t('admin', 'Priority') + ' 6 '
							+ Yii.t('admin', 'cannot be blank'));
		}
		if(priority7 == "empty"){
			$("#priority7Error").html(
					Yii.t('admin', 'Priority') + ' 7 '
							+ Yii.t('admin', 'cannot be blank'));
		}
		if(priority8 == "empty"){
			$("#priority8Error").html(
					Yii.t('admin', 'Priority') + ' 8 '
							+ Yii.t('admin', 'cannot be blank'));
		}
		return false;
	} else {
		if (priority8 != "empty"
				&& (priority8 == priority1 || priority8 == priority2 || priority8 == priority3 || priority8 == priority4 || priority8 == priority5
						|| priority8 == priority6 || priority8 == priority7 || priority8 == priority9 || priority8 == priority10)) {
			$("#priority8Error").html(
					Yii.t('admin', 'Priority') + ' 8 '
							+ Yii.t('admin', 'should be unique'));
			$(this).val("");
			$("#priority8Error").show();
			return false;
		} else {
			$("#priority8Error").hide();
		}
	}
	
	if (priority7 == "empty" && (priority8 != "empty")) {
		if(priority1 == "empty"){
			$("#priority1Error").html(
					Yii.t('admin', 'Priority') + ' 1 '
							+ Yii.t('admin', 'cannot be blank'));
			}
		if(priority2 == "empty"){
			$("#priority2Error").html(
					Yii.t('admin', 'Priority') + ' 2 '
							+ Yii.t('admin', 'cannot be blank'));
			}
		if(priority3 == "empty"){
		$("#priority3Error").html(
				Yii.t('admin', 'Priority') + ' 3 '
						+ Yii.t('admin', 'cannot be blank'));
		}
		if(priority4 == "empty"){
			$("#priority4Error").html(
					Yii.t('admin', 'Priority') + ' 4 '
							+ Yii.t('admin', 'cannot be blank'));
		}
		if(priority5 == "empty"){
			$("#priority5Error").html(
					Yii.t('admin', 'Priority') + ' 5 '
							+ Yii.t('admin', 'cannot be blank'));
		}
		if(priority6 == "empty"){
			$("#priority6Error").html(
					Yii.t('admin', 'Priority') + ' 6 '
							+ Yii.t('admin', 'cannot be blank'));
		}
		if(priority7 == "empty"){
			$("#priority7Error").html(
					Yii.t('admin', 'Priority') + ' 7 '
							+ Yii.t('admin', 'cannot be blank'));
		}
		return false;
	} else {
		if (priority7 != "empty"
				&& (priority7 == priority1 || priority7 == priority2 || priority7 == priority3 || priority7 == priority4 || priority7 == priority5
						|| priority7 == priority6 || priority7 == priority8 || priority7 == priority9 || priority7 == priority10)) {
			$("#priority7Error").html(
					Yii.t('admin', 'Priority') + ' 7 '
							+ Yii.t('admin', 'should be unique'));
			$("#priority7Error").show();
			$(this).val("");
			return false;
		} else {
			$("#priority7Error").hide();
		}
	}
	
	if (priority6 == "empty" && (priority7 != "empty")) {
		
		if(priority1 == "empty"){
			$("#priority1Error").html(
					Yii.t('admin', 'Priority') + ' 1 '
							+ Yii.t('admin', 'cannot be blank'));
			}
		if(priority2 == "empty"){
			$("#priority2Error").html(
					Yii.t('admin', 'Priority') + ' 2 '
							+ Yii.t('admin', 'cannot be blank'));
			}
		if(priority3 == "empty"){
		$("#priority3Error").html(
				Yii.t('admin', 'Priority') + ' 3 '
						+ Yii.t('admin', 'cannot be blank'));
		}
		if(priority4 == "empty"){
			$("#priority4Error").html(
					Yii.t('admin', 'Priority') + ' 4 '
							+ Yii.t('admin', 'cannot be blank'));
		}
		if(priority5 == "empty"){
			$("#priority5Error").html(
					Yii.t('admin', 'Priority') + ' 5 '
							+ Yii.t('admin', 'cannot be blank'));
		}
		if(priority6 == "empty"){
			$("#priority6Error").html(
					Yii.t('admin', 'Priority') + ' 6 '
							+ Yii.t('admin', 'cannot be blank'));
		}
			return false;
	} else {
		if (priority6 != "empty"
				&& (priority6 == priority1 || priority6 == priority2 || priority6 == priority3 || priority6 == priority4 || priority6 == priority5
						|| priority6 == priority7 || priority6 == priority8 || priority6 == priority9 || priority6 == priority10)) {
			$("#priority6Error").html(
					Yii.t('admin', 'Priority') + ' 6 '
							+ Yii.t('admin', 'should be unique'));
			$("#priority6Error").show();
			
			$(this).val("");
			return false;
		} else {
			$("#priority6Error").hide();
		}
	}
	
	if (priority5 == "empty" && (priority6 != "empty")) {
		
		if(priority1 == "empty"){
			$("#priority1Error").html(
					Yii.t('admin', 'Priority') + ' 1 '
							+ Yii.t('admin', 'cannot be blank'));
			}
		if(priority2 == "empty"){
			$("#priority2Error").html(
					Yii.t('admin', 'Priority') + ' 2 '
							+ Yii.t('admin', 'cannot be blank'));
			}
		if(priority3 == "empty"){
		$("#priority3Error").html(
				Yii.t('admin', 'Priority') + ' 3 '
						+ Yii.t('admin', 'cannot be blank'));
		}
		if(priority4 == "empty"){
			$("#priority4Error").html(
					Yii.t('admin', 'Priority') + ' 4 '
							+ Yii.t('admin', 'cannot be blank'));
		}
		if(priority5 == "empty"){
			$("#priority5Error").html(
					Yii.t('admin', 'Priority') + ' 5 '
							+ Yii.t('admin', 'cannot be blank'));
		}
		return false;
	} else {
		if (priority5 != "empty"
				&& (priority5 == priority1 || priority5 == priority2 || priority5 == priority3 || priority5 == priority4 || priority5 == priority6
						|| priority5 == priority7 || priority5 == priority8 || priority5 == priority9 || priority5 == priority10)) {
			$("#priority5Error").html(
					Yii.t('admin', 'Priority') + ' 5 '
							+ Yii.t('admin', 'should be unique'));
			$("#priority5Error").show();
			return false;
		} else {
			$("#priority5Error").hide();
		}
	}
	
	if (priority4 == "empty" && priority5 != "empty") {
		
		if(priority1 == "empty"){
			$("#priority1Error").html(
					Yii.t('admin', 'Priority') + ' 1 '
							+ Yii.t('admin', 'cannot be blank'));
			}
		if(priority2 == "empty"){
			$("#priority2Error").html(
					Yii.t('admin', 'Priority') + ' 2 '
							+ Yii.t('admin', 'cannot be blank'));
			}
		if(priority3 == "empty"){
		$("#priority3Error").html(
				Yii.t('admin', 'Priority') + ' 3 '
						+ Yii.t('admin', 'cannot be blank'));
		}
		if(priority4 == "empty"){
			$("#priority4Error").html(
					Yii.t('admin', 'Priority') + ' 4 '
							+ Yii.t('admin', 'cannot be blank'));
		}
		return false;
	} else {
		if (priority4 != "empty"
				&& (priority4 == priority1 || priority4 == priority2 || priority4 == priority3 || priority4 == priority5 || priority4 == priority6
						|| priority4 == priority7 || priority4 == priority8 || priority4 == priority9 || priority4 == priority10)) {
			$("#priority4Error").html(
					Yii.t('admin', 'Priority') + ' 4 '
							+ Yii.t('admin', 'should be unique'));
			$("#priority4Error").show();
			$(this).val("");
			return false;
		} else {
			$("#priority4Error").hide();
		}
	}
	if (priority3 == "empty" && (priority4 != "empty" || priority5 != "empty")) {
		if(priority1 == "empty"){
			$("#priority1Error").html(
					Yii.t('admin', 'Priority') + ' 1 '
							+ Yii.t('admin', 'cannot be blank'));
			}
		if(priority2 == "empty"){
			$("#priority2Error").html(
					Yii.t('admin', 'Priority') + ' 2 '
							+ Yii.t('admin', 'cannot be blank'));
			}
		$("#priority3Error").html(
				Yii.t('admin', 'Priority') + ' 3 '
						+ Yii.t('admin', 'cannot be blank'));
		return false;
	} else {
		if (priority3 != "empty"
				&& (priority3 == priority1 || priority3 == priority2 || priority3 == priority4 || priority3 == priority5 || priority3 == priority6
						|| priority3 == priority7 || priority3 == priority8 || priority3 == priority9 || priority3 == priority10)) {
			$("#priority3Error").html(
					Yii.t('admin', 'Priority') + ' 3 '
							+ Yii.t('admin', 'should be unique'));
			$("#priority3Error").show();
			$(this).val("");
			return false;
		} else {
			$("#priority3Error").hide();
		}
	}

	if (priority2 == "empty"
			&& (priority3 != "empty" || priority4 != "empty" || priority5 != "empty")) {
		if(priority1 == "empty"){
			$("#priority1Error").html(
					Yii.t('admin', 'Priority') + ' 1 '
							+ Yii.t('admin', 'cannot be blank'));
			}
		
		$("#priority2Error").html(
				Yii.t('admin', 'Priority') + ' 2 '
						+ Yii.t('admin', 'cannot be blank'));
		return false;
	} else {
		if (priority2 != "empty"
				&& (priority2 == priority1 || priority2 == priority3 || priority2 == priority4 || priority2 == priority5 || priority2 == priority6
						|| priority2 == priority7 || priority2 == priority8 || priority2 == priority9 || priority2 == priority10)) {
			$("#priority2Error").html(
					Yii.t('admin', 'Priority') + ' 2 '
							+ Yii.t('admin', 'should be unique'));
			$("#priority2Error").show();
			$(this).val("");
			return false;
		} else {
			$("#priority2Error").hide();
		}
	}
	if (priority1 == "empty"
			&& (priority2 != "empty" || priority3 != "empty"
					|| priority4 != "empty" || priority5 != "empty")) {
		$("#priority1Error").html(
				Yii.t('admin', 'Priority') + ' 1 '
						+ Yii.t('admin', 'cannot be blank'));
		return false;
	} else {
		$("#priority1Error").show();
		if (priority1 != "empty"
				&& (priority1 == priority2 || priority1 == priority3 || priority1 == priority4 || priority1 == priority5 || priority1 == priority6
						|| priority1 == priority7 || priority1 == priority8 || priority1 == priority9 || priority1 == priority10)) {
			$("#priority1Error").html(
					Yii.t('admin', 'Priority') + ' 1 '
							+ Yii.t('admin', 'should be unique'));
			$("#priority1Error").show();
			$(this).val("");
			return false;
		} else {
			$("#priority1Error").hide();
		}
	}

}

function changeCategory(no,sel){
	var nextNo = no + 1;
	var value = sel.value;
	if(value != 'empty')
		$("#catpriority"+nextNo).removeAttr('disabled');
	else
		for($i=nextNo; $i <= 10; $i++){
			$("#catpriority"+$i).prop('selectedIndex',0);
			$("#catpriority"+$i).attr('disabled', 'disabled');
		}
		
	
}
function defaultSettings() {
	var name = $("#Sitesettings_sitename").val();
	var googleapikey = $("#Sitesettings_googleapikey").val();
	if (name == "") {
		$("#Sitesettings_sitename_em_").show();
		$("#Sitesettings_sitename_em_").html(
				Yii.t('admin', "Site Name") + ' '
						+ Yii.t('admin', "cannot be blank"));
		$("#Sitesettings_sitename").focus();
		return false;
	} else {
		$('#Sitesettings_sitename_em_').hide();
	}
	if (googleapikey == "") {
		$("#Sitesettings_googleapikey_em_").show();
		$("#Sitesettings_googleapikey_em_").html(
				Yii.t('admin', "Google api key") + ' '
						+ Yii.t('admin', "cannot be blank"));
		$("#Sitesettings_googleapikey").focus();
		return false;
	} else {
		$('#Sitesettings_googleapikey_em_').hide();
	}	
	if (specials.test(name)) {
		$("#Sitesettings_sitename_em_").show();
		$('#Sitesettings_sitename_em_').text(
				Yii.t('admin', 'Special Characters not allowed.'));
		return false;
	} else {
		$('#Sitesettings_sitename_em_').hide();
	}
}

function myOfferRate() {
	var offerRate = $("#MyOfferForm_offer_rate").val();
	var productPrice = $(".product-price-hidden").val();
	
	var offer = offerRate.replace(/\s/g, '');
	/*var regex = /^\d{0,9}(\.\d{1,2})?$/g;
	if (offerRate.match(regex) == null) {
		$("#errorMessage").show();
		$("#errorMessage").html('Please enter valid price. eg:123456789.10');
		return false;
	}*/
	//$("#MyOfferForm_offer_rate").val(offer);
	if ($(".my-offer-rate").val() != "" && $(".my-offer-rate").val() > 0) {
		if (Number(offerRate) >= Number(productPrice)) {
			$(".offer-form").hide();
			//$("#MyOfferForm_offer_rate").val('');
			$("#errorMessage").show();
			$("#errorMessage").html(
					Yii.t('app',
							'Offer Price should be less than Product Price.'));
			
			setTimeout(function() {
				$("#errorMessage").fadeToggle();
			}, 3000);
		} else {
			$("#errorMessage").hide();
			$(".offer-form").show();
		}

	} else {
		$(".offer-form").hide();
	}
}
function cancelOffer() {
	$(".offer-form").hide();
}

function mobile_verification() {

	var mobile = $('#mobile_number').val();
	var verifymobile = $('#verify_mobile_number').val();
	$('#otp-error').hide();
	$('#verification_error').html('');
	if(mobile == '') {
		$('.mobile-error').css('display','inline-block');
		$('.mobile-error').html('Enter your mobile number');
		return false;
	}
	if(mobile == verifymobile){
		$('.mobile-error').css('display','inline-block');
		$('.mobile-error').html('This account is already verified using this number');
		return false;
	}
	$.ajax({
		type : 'POST',
		url : yii.urls.base + '/user/mobile_verificationCode',
		data : {mobile:mobile},
		success : function(data) {
			$('#mobile-otp').addClass('in');
			$('body').addClass('modal-open');
			$('body').append('<div class="modal-backdrop fade in"></div>');
			$('#mobile-otp').css('display','block');	
			$('.rand_code').html(data);
			var phlast = mobile.slice(-4);
			phlast = '****'+phlast;
			$('.mob_code').html(phlast);
		}
	});


}

function close_otp() {
	$('#mobile-otp').removeClass('in');
	$('body').removeClass('modal-open');
	$('.modal-backdrop').remove();
	$('#mobile-otp').css('display','none');
	$('#otp_code').val('');
	$('.otp-error').hide();
}

function verify_otp() {
	var otp_code = $('#otp_code').val();
	var mobile = $('#mobile_number').val();
	if(otp_code != '') {
		$('#verify_text').html('Verifying...');
		$('#verification_error').html('');
		$.ajax({
		type : 'POST',
		url : yii.urls.base + '/user/mobile_verificationStatus',
		data : {otp_code:otp_code,mobile:mobile},
		success : function(data) {
			if($.trim(data) == '1') {
				$('#verify_text').html('Verify');
				$('#n_number').html(mobile);
				$('#otp_code').val('');
				$('#mobile_number').val('');
				$('#mobile-otp').removeClass('in');
				$('body').removeClass('modal-open');
				$('.modal-backdrop').remove();
				$('#mobile-otp').css('display','none');
				$('#profile-mobile-details').hide();
				$('#mobile-verification').css('display','block');
				$('.profile-email-txt.add-phone').hide();
				document.getElementById('add-phone').style.display = 'block';
			} else {
				$('#verify_text').html('Verify');
				$('.otp-error').css('display','inline');
			}
		}
		});
	}else{
		$('#verification_error').html('Enter Verification Code....');
		$('#otp-error').hide();
	}
}

function dosearch(){

	var searchval = $('input[name=search]').val();
	searchval = searchval.trim();

	if(searchval == ''){
		//alert(searchval);
		return false;
	}
}
function validateNumeric(thi, e) {
	var specialKeys = new Array();
	specialKeys.push(8); // Backspace
	specialKeys.push(9); // Tab
	specialKeys.push(46); // Delete
	specialKeys.push(36); // Home
	specialKeys.push(35); // End
	specialKeys.push(37); // Left
	specialKeys.push(39); // Right
	specialKeys.push(27); // Space
	if (window.event)
		keycode = window.event.keyCode;
	else if (e)
		keycode = e.which;
	else
		return true;

	if (((keycode >= 65) && (keycode <= 90))
			|| (keycode == 32)
			|| ((keycode >= 97) && (keycode <= 122))
			|| (specialKeys.indexOf(e.keyCode) != -1 && e.charCode != e.keyCode)) {
		return true;
	} else {
		return false;
	}
}

function profileVal() {
	var name = $("#Users_name").val();
	if (name == "") {
		$("#Users_name_em_").show();
		$("#Users_name_em_").html(
				Yii.t('admin', "Name") + ' '
						+ Yii.t('admin', "cannot be blank"));
		$("#Users_name_em_").focus();
		return false;
	} else {
		name = name.replace(/\s{2,}/g, ' ');
		$('#Users_name').val(name);
		$('#Users_name_em_').hide();
	}
	if (specials.test(name)) {
		$("#Users_name_em_").show();
		$('#Users_name').val('');
		$('#Users_name_em_').text(
				Yii.t('app', 'Special Characters not allowed.'));
		return false;
	} else {
		$('#Users_name_em_').hide();
	}

	var reg = /[0-9]/gi;
	if (reg.test(name)) {
		$("#Users_name_em_").show();
		$("#Users_name_em_").html(Yii.t('admin', 'Numbers not allowed.'));
		$('#Users_name').val('');
		$('#Users_name').focus();
		return false;
	} else {
		$('#Users_name_em_').hide();
	}
}

function resetLatLong() {
	$("#latitude").val('');
	$("#longitude").val('');
	$("#map-latitude").val('');
	$("#map-longitude").val('');
}

function showMap(loc, lat, long) {
	var cityCircle;
	var location = loc;
	var myLatlng = new google.maps.LatLng(lat, long);
	var myOptions = {
		zoom : 15,
		center : myLatlng,
		mapTypeId : google.maps.MapTypeId.ROADMAP
	}
	var map = new google.maps.Map(document.getElementById("map_canvas"),myOptions);
	var marker = new google.maps.Marker({
		position : myLatlng,
		title : location,
	});
	
	var circleOptions = {
		strokeColor : '#2FDAB8',
		strokeOpacity : 0.8,
		strokeWeight : 2,
		fillColor : '#2FDAB8',
		fillOpacity : 0.35,
		map : map,
		center : myLatlng,
		radius : 300
	};
	cityCircle = new google.maps.Circle(circleOptions);
	marker.setMap(map);
}

function mobile_showMap(loc, lat, long) {
	var cityCircle;
	var location = loc;
	var myLatlng = new google.maps.LatLng(lat, long);
	var myOptions = {
		zoom : 15,
		center : myLatlng,
		mapTypeId : google.maps.MapTypeId.ROADMAP
	}
	var map = new google.maps.Map(document.getElementById("mobile_map_canvas"),
			myOptions);
	var marker = new google.maps.Marker({
		position : myLatlng,
		title : location,
	});
	var circleOptions = {
		strokeColor : '#2FDAB8',
		strokeOpacity : 0.8,
		strokeWeight : 2,
		fillColor : '#2FDAB8',
		fillOpacity : 0.35,
		map : map,
		center : myLatlng,
		radius : 300
	};

	cityCircle = new google.maps.Circle(circleOptions);
	marker.setMap(map);
}

//$('.btn-worldwide').click(function(){
$(document).on('click', '.btn-worldwide', function() {
	//alert('hi');
	
	$(this).addClass('hidden');
	$('#location-search-remove').hide();
	$('.search-location').show();
		
});

$(document).on('click', '.btn-worldwide-placename', function() {

	$('#location-search-remove').show();

});

function removeLocation() {
	var grid = document.querySelector('#fh5co-board');
	var category = $('.category-filter').val();
	var search = $('.search-filter').val();
	var subcategory = $('.subcategory-filter').val();
	var urgent = $('.urgent-filter').val();
	var ads = $('.ads-filter').val();
	
	if(urgent == "0"){
		urgent = '';
	}

	if(ads == "0"){
		ads = '';
	}
	
	 $('.search-location').hide();
	 $('.loading-btn').show();
	 var remove = 'remove' ;

	 if(locationTracker == 1){
		 locationTracker = 0;
		$.ajax({
			url : yii.urls.base + '/site/loadresults',
			type : "post",
			dataType : "html",
			data : {'remove' : remove,
				"loadMore" : 1, category : category, search : search, 
				subcategory : subcategory, urgent : urgent, ads : ads},
			beforeSend : function() {
				 $('.loading-btn').show();
			},
			success : function(responce) {
				$('.loading-btn').hide();
				$('.btn-worldwide').removeClass('session-data');
				$('.btn-worldwide').removeClass('btn-worldwide-placename');
				$('.btn-worldwide').removeClass('hidden');
				$('.btn-worldwide').html(Yii.t('app','World wide '));
				$('.btn-worldwide').show();
				$('.loading-btn').hide();
				$("#fh5co-board").html($.trim(responce)); 
				salvattore.recreateColumns(grid);
				$('.miles').html(Yii.t('admin', 'World Wide...'));
				$('#nearmemodals').modal('toggle');
				$(".more-listing").show();
				$("#pac-input").val('');
				$('.show-world-wide').hide();
				locationTracker = 1;
			}
				
		});
	 }
	
}

function getfollows(userid) {
	
	 
	var user_id = "#follow"+userid;
	var sellerfollow = $('#seller_follow').val();
	if(followval == 1) {
		followval = 0;
		$.ajax({
			url : yii.urls.base + '/user/getfollow/',
			type : "post",
			dataType : "html",
			data : {'fuserid' : userid},
			beforeSend : function() {
				// $('.loading-btn').show();
				
			},
			success : function(responce) {
				//alert(responce);
				if($.trim(sellerfollow) == '1') {
					var followcount = $('.follower-count').html();
					following_count = parseInt(followcount) + parseInt(1);
					$('.follower-count').html(following_count);
					$('#follow'+userid).removeClass('btn-make-an-offer');
					$('#follow'+userid).addClass('btn-chat-with-seller');
					$('#follow'+userid).css('border','1px solid #2bc248');
					$('#sellerfollow'+userid).css('color','#ffffff');
					$('#sellerfollow'+userid).html(Yii.t('app','Following'));
				} else {
					$(user_id).html(Yii.t('app','Following'));
				}
				$(user_id).attr("onclick", "return deletefollows("+userid+");");
				followval = 1;
			}
				
		});
	}
	
}
function deletefollows(userid) {
	
	
	var user_id = "#follow"+userid;
	var sellerfollow = $('#seller_follow').val();
	if(unfollowval == 1) {
		unfollowval = 0;
		$.ajax({
			url : yii.urls.base + '/user/deletefollow/',
			type : "post",
			dataType : "html",
			data : {'userid' : userid},
			beforeSend : function() {
				// $('.loading-btn').show();
				
			},
			success : function(responce) {
				//alert(user_id);
				if($.trim(sellerfollow) == '1') {
					var followcount = $('.follower-count').html();
					following_count = parseInt(followcount) - parseInt(1);
					$('.follower-count').html(following_count);
					$('#follow'+userid).addClass('btn-make-an-offer');
					$('#follow'+userid).removeClass('btn-chat-with-seller');
					$('#follow'+userid).css('margin-top','20px');
					$('#follow'+userid).css('border','1px solid #d0dbe5');
					$('#sellerfollow'+userid).css('color','#515e6a');
					$('#sellerfollow'+userid).html(Yii.t('app','Follow'));
				} else {
					$(user_id).html(Yii.t('app','Follow'));
				}
				$(user_id).attr("onclick", "return getfollows("+userid+");");
				unfollowval = 1;
			}
				
		});
	}
	
}


$(document).on('click', '#reportflag', function(){
	//alert("report");
	var user = $('.logindetails').val();
	//alert(user);
	var loguserid = $('.product-user-id').val();
	if (user == '') {
		window.location = yii.urls.base+ '/login';
	} else {
		var itemid = $(".item-id").val();
		if(confirm("Report this as inappropriate or broken ?")) {
			$.ajax({
			      url: yii.urls.base+ '/item/products/reportitem',
			      type: "GET",
			      data: { 'itemid':itemid, 'userid':loguserid},
			      beforeSend: function () {
			    	  $('.reportloader').show();
			    	  },
			      success: function(responce){
			    	  $(".report-text").html(Yii.t('app','Undo reporting'));
			          $(".item-report").attr("id", "unreportflag");
				  $('.report-active').removeClass('exclamatory-icon');
				  $('.report-active').addClass('exclamatory-icon-active');
			      }  
			}); 
		}
	}
	
});

$(document).on('click', '#unreportflag', function(){
	//alert("unreport");
	var user = $('.logindetails').val();
	var loguserid = $('.product-user-id').val();
	if (user == '') {
		window.location = yii.urls.base+ '/login';
	} else {
		var itemid = $(".item-id").val();
		if(confirm("Cancel Report this ?")) {
			$.ajax({
			      url: yii.urls.base+ '/item/products/undoreportitem',
			      type: "GET",
			      data: { 'itemid':itemid, 'userid':loguserid},
			      beforeSend: function () {
			    	  $('.reportloader').show();
			    	  },
			      success: function(responce){
			    	  $(".report-text").html(Yii.t('app','Report inappropriate'));
			          $(".item-report").attr("id", "reportflag");
			    	  $('.report-active').removeClass('exclamatory-icon-active');
				  $('.report-active').addClass('exclamatory-icon');
			      }  
			}); 
		}
	}
	
});

$(document).on('click', '#mob_reportflag', function(){
	//alert("report");
	var user = $('.logindetails').val();
	//alert(user);
	var loguserid = $('.product-user-id').val();
	if (user == '') {
		window.location = yii.urls.base+ '/login';
	} else {
		var itemid = $(".item-id").val();
		if(confirm("Report this as inappropriate or broken ?")) {
			$.ajax({
			      url: yii.urls.base+ '/item/products/reportitem',
			      type: "GET",
			      data: { 'itemid':itemid, 'userid':loguserid},
			      beforeSend: function () {
			    	  $('.reportloader').show();
			    	  },
			      success: function(responce){
			    	  $(".mob-report-text").html(Yii.t('app','Undo reporting'));
			          $(".mob-item-report").attr("id", "mob_unreportflag");
				  $('.report-mob-active').removeClass('exclamatory-icon');
				  $('.report-mob-active').addClass('exclamatory-icon-active');
			      }  
			}); 
		}
	}
	
});

$(document).on('click', '#mob_unreportflag', function(){
	//alert("unreport");
	var user = $('.logindetails').val();
	var loguserid = $('.product-user-id').val();
	if (user == '') {
		window.location = yii.urls.base+ '/login';
	} else {
		var itemid = $(".item-id").val();
		if(confirm("Cancel Report this ?")) {
			$.ajax({
			      url: yii.urls.base+ '/item/products/undoreportitem',
			      type: "GET",
			      data: { 'itemid':itemid, 'userid':loguserid},
			      beforeSend: function () {
			    	  $('.reportloader').show();
			    	  },
			      success: function(responce){
			    	  $(".mob-report-text").html(Yii.t('app','Report inappropriate'));
			          $(".mob-item-report").attr("id", "mob_reportflag");
			    	  $('.report-mob-active').removeClass('exclamatory-icon-active');
				  $('.report-mob-active').addClass('exclamatory-icon');
			      }  
			}); 
		}
	}
	
});

function popitup(type) {
	var url = yii.urls.base+ '/user/getSocialAccess?provider=facebook';
	var  screenX    = typeof window.screenX != 'undefined' ? window.screenX : window.screenLeft,
		 screenY    = typeof window.screenY != 'undefined' ? window.screenY : window.screenTop,
		 outerWidth = typeof window.outerWidth != 'undefined' ? window.outerWidth : document.body.clientWidth,
		 outerHeight = typeof window.outerHeight != 'undefined' ? window.outerHeight : (document.body.clientHeight - 22),
		 width    = 600,
		 height   = 400,
		 left     = parseInt(screenX + ((outerWidth - width) / 2), 10),
		 top      = parseInt(screenY + ((outerHeight - height) / 2.5), 10),
		 features = 'width=' + width + ',height=' + height + ',left=' + left + ',top=' + top;
	newwindow=window.open(url,'Social Login',features);
	if (window.focus) {newwindow.focus();}
	return false;
}

function selectpromotion(){
	$(".promotion-error").hide();
	$(".promotion-success").hide();
	var currency = $('#selectedoption').val();
	if(currency == 0){
		$(".promotion-error").html(
				Yii.t('admin','Please select any one of the Currency'));
		$(".promotion-error").show();
		return false;
	}
	$.ajax({
	      url: yii.urls.base+ '/admin/promotion/promotioncurrencies',
	      type: "GET",
	      data: { 'currency':currency},
	      beforeSend: function () {
	    	  $('.promotionloader').show();
	    	  },
	      success: function(responce){
	    	 // $(".selectedpromotion").html(responce);
	    	  if(responce !=  ''){
	    		  $('.promotionloader').hide();
	    		  $('.promotion-success').html(Yii.t('app','Promotion Currency Updated'));
	    		  $('.promotion-success').show();
	    	  }
	    	  
	    	
	      }  
	}); 
	
}

function switchVisible_promotion(id) {
	$.ajax({
	      url: yii.urls.base+ '/user/promotiondetails/',
	      type: "POST",
	      data: { 'id':id},
	      success: function(responce){
	    	$('#promotion-content').css('display','none');
		$('#promotion-details').css('display','block');
		$('#promotion-details').html(responce);
	      }  
	});
}

function switchVisible_promotionback() {
	$('#promotion-details').css('display','none');
	$('#promotion-content').css('display','block');
	$('.promotions-content-cnt').remove();
}

function urgentpromotion(){
	var urgentprice = $('#urgentprice').val();
	if (urgentprice == "") {
		$("#urgentpriceError").show();
		$("#urgentpriceError").html(
				Yii.t('admin', "Price Amount cannot be blank"));
		$('#urgentprice').focus();
		$('#urgentprice').keydown(function() {
			$('#urgentpriceError').hide();
		});
		return false;
	}else if(isNaN(urgentprice)) {
		$("#urgentpriceError").show();
		$("#urgentpriceError").html(
				Yii.t('admin', "Price Amount should be numeric"));
		$('#urgentprice').focus();
		$('#urgentprice').keydown(function() {
			$('#urgentpriceError').hide();
		});
		return false;
	}
	
}

function select_shipping(shippingId)
{
	$("#selectedshipping").val(shippingId);
	$(".qMart-acc-addr-cnt").css("box-shadow","none");
	$("#highlight"+shippingId).css("box-shadow","0 0 0 3px #2bc248 inset");
	$(".address-active").hide();
	$("#activeaddr"+shippingId).show();
}

function edit_shipping(addressId)
{
		$.ajax({
	      url: yii.urls.base+ '/buynow/useraction/getshipping/',
	      type: "POST",
	      data: { 'id':addressId},
	      success: function(responce){
	      	var obj = jQuery.parseJSON(responce);
	      	countrysel = obj['countryCode']+"-"+obj['country'];
	      	$("#Tempaddresses_nickname").val(obj['nickname']);
	      	$("#Tempaddresses_name").val(obj['name']);
	      	$("#Tempaddresses_address1").val(obj['address1']);
	      	$("#Tempaddresses_address2").val(obj['address2']);
	      	$("#Tempaddresses_city").val(obj['city']);
	      	$("#Tempaddresses_state").val(obj['state']);
	      	$("#Tempaddresses_zipcode").val(obj['zipcode']);
	      	$("#Tempaddresses_phone").val(obj['phone']);
	      	$("#shippingId").val(obj['slug']);
	      	$('option[value='+countrysel+']').attr('selected','selected');
	      }  
	});
}