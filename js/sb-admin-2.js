$(function() {

    $('#side-menu').metisMenu();

});

//Loads the correct sidebar on window load,
//collapses the sidebar on window resize.
// Sets the min-height of #page-wrapper to window size
$(function() {
    $(window).bind("load resize", function() {
        topOffset = 50;
        width = (this.window.innerWidth > 0) ? this.window.innerWidth : this.screen.width;
        if (width < 768) {
            $('div.navbar-collapse').addClass('collapse')
            topOffset = 100; // 2-row-menu
        } else {
            $('div.navbar-collapse').removeClass('collapse')
        }

        height = (this.window.innerHeight > 0) ? this.window.innerHeight : this.screen.height;
        height = height - topOffset;
        if (height < 1) height = 1;
        if (height > topOffset) {
            $("#page-wrapper").css("min-height", (height) + "px");
        }
    })
})


	$(document).on('click', '#adminpushnot', function() {
		adminData = $('#admin-textarea').val();
		if (adminData == ''){
			
			$('.adminpushnot-error').html(Yii.t('admin', 'Please enter text'));
			setTimeout(function() {
				  $('.adminpushnot-error').fadeOut('slow');
				}, 5000); 
			return;
			
		}
		
		if (adminData != ''){
			$.ajax({
				type : 'POST',
				url : yii.urls.base + '/admin/action/sendpushnot/',
				data : {
					adminData : adminData
				},
				beforeSend : function() {
					$('#adminpushnot').html(Yii.t('app', 'Sending') + '...');
				},
				success : function(data) {
					$('#admin-textarea').val("");
					$('#adminpushnot').html(Yii.t('app', 'Sent'));
					setTimeout(function() {
						  $('#adminpushnot').html(Yii.t('app', 'Send'));
						}, 2000); 
					
					 if (data == "error"){
						$(".adminpushnot-error").html(Yii.t('app', 'Message not sent') + '..!!');
						setTimeout(function() {
							  $('.adminpushnot-error').fadeOut('slow');
							}, 5000); 
						return;
					}
				},
				failure: function(){
					$('#adminpushnot').html(Yii.t('app', 'Sent'));
				}
			});
		}
		
			
	});
