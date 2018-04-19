function customCheckbox(checkboxName){
			var checkBox = $('input[name="'+ checkboxName +'"]');
			$(checkBox).each(function(){
				$(this).wrap( "<span class='custom-checkbox'></span>" );
				if($(this).is(':checked')){
					$(this).parent().addClass("selected");
				}
			});
			$(checkBox).click(function(){
				$(this).parent().toggleClass("selected");
			});
		}
		$(document).ready(function (){
			customCheckbox("sport[]");
		})