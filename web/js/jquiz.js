$(document).ready(function() {

	var count = 0;
	var howmanyquestions = $("#quizContainer > .question").length;

	//the function for a clicked item
	$(".optionInput").click(function(){
		if (!($(this).parent("div").parent("div").hasClass("answered"))) {
		
			// removes unanswered class and adds answered class so they cannot change answer
			$(this).parent("div").parent("div").addClass("answered");

            $(this).parent("div").parent("div").find(".optionInput").each(function(i) {
                jQuery(this).attr('disabled', 'disabled');
            });

			// runs if they clicked the incorrect answer
			if (!($(this).hasClass("correct"))) {
				// puts strike-through wrong answer and makes their answer red for incorrect

				$(this).parent("div").addClass("wronganswer");
				$(this).parent("div").parent("div").find(".correct").parent("div").addClass("realanswer");
				// animate explanation & add styling depending on answer
				//$(this).parent().parent().children("div").prepend('<p>INCORRECT</p>');
				$(this).parent("div").parent("div").parent("div").removeClass("unaswered").addClass("wrongbox");
				$(this).parent().parent().fadeTo(500, 1);
			}
			
			// runs if they clicked the correct answer
			if ($(this).hasClass("correct")) {
				//adds one to quiz total correct tally
				count++;
				// makes correct answer green
				$(this).parent("div").addClass("correctanswer");
                $(this).parent("div").parent("div").parent("div").removeClass("unaswered").addClass("rightbox");
				$(this).parent().parent().children("div").fadeTo(750, 1);
			}

            $(this).parent("div").parent("div").parent("div").find(".explanation").fadeTo(750, 1);

			if ($('div.answered').length == howmanyquestions) {
				$('#quizremarks').fadeIn('slow');
				$('#quiztotal').html('Obtuviste '+count+' de '+howmanyquestions+' en esta oportunidad.');
			}
		}
	});

});