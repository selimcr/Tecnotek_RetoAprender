
$(document).ready(function() {
	
	// Expand Panel
	$("#open").click(function(){		
		$("div#panel").slideDown("slow");		
	});	
	
	// Collapse Panel
	$("#close").click(function(){			
		/*if($("div#login_container").css("display") != "none"){
			setTimeout( function(){
				$("div#login_container").css('display','none');
   			},800);
		}*/
		$("div#panel").slideUp("slow");
	});		
	
	// Switch buttons from "Log In" to "Close" on click
	$("#toggle a").click(function () {
		$("#toggle a").toggle();
	});
});