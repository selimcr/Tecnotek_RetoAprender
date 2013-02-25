if (typeof console == "undefined" || typeof console.log == "undefined" || typeof console.debug == "undefined") var console = { log: function() {}, debug: function() {} }; 
if (typeof jQuery !== 'undefined') {
	console.debug("JQuery found!!!");
	(function($) {
		$('#spinner').ajaxStart(function() {
			$(this).fadeIn();
		}).ajaxStop(function() {
			$(this).fadeOut();
		});
	})(jQuery);
} else {
	console.debug("JQuery not found!!!");
}
$(document).ready(function() {
	Tecnotek.init();
});
var Tecnotek = {
		module : "",
		imagesURL : "",
        assetsURL : "",
		isIe: false,
		rowsCounter: 0,
		companiesCounter: 0,
		ftpCounter: 0,
        updateFail: false,
		session : {},
		logout:function(url){
			location.href= url;
		},
		init : function() {
			var module = Tecnotek.module;
			console.debug("Module: " + module)
			if (module) {
				switch (module) {
                case "showActivity":
                    Tecnotek.ShowActivity.init(); break;
                default:
					break;
				}
			}
			Tecnotek.UI.init();
			
		},
        ajaxCall : function(url, params, succedFunction, errorFunction, showSpinner) {
            var request = $.ajax({
                url: url,
                type: "POST",
                data: params,
                dataType: "json"
            });

            request.done(succedFunction);

            request.fail(errorFunction);
        },
        showInfoMessage : function(message, showAlert, divId, showDiv) {
            if ( showAlert ) {
                alert(message);
            }
            if ( showDiv ) {
                $("#" + divId).html(message);
            }
        },
        showErrorMessage : function(message, showAlert, divId, showDiv) {
            if ( showAlert ) {
                alert(message);
            }
            if ( showDiv ) {
                $("#" + divId).html(message);
            }
        },
        showConfirmationQuestion : function(message) {
            return confirm(message);
        },
		UI : {
			translates : {},
			urls : {},
            vars : {},
			intervals : {},
			init : function() {
				Tecnotek.UI.initLocales();
			},
			initLocales: function(){
			},
			btnAccept : "Accept",
			initModal : function(targetDiv, buttonsOpts) {
				$(targetDiv).dialog({
					title : '',
					dialogClass : 'alert',
					closeText : '',
					show : 'highlight',
					hide : 'highlight',
					autoOpen : false,
					bgiframe : true,
					modal : true,
					buttons : buttonsOpts
				});
			},
			closeModal : function(targetDiv) {
				$(targetDiv).dialog('close');
			},
			addModalEvent: function(targetDiv, eventName, toDo){
				
				$(targetDiv).bind( eventName, function(){
					//console.log("closing");
					toDo();					
				});
			},
			modal : function(targetDiv, title, htmlSelector, html, isNewOpen,
					buttonsOpts, width, height) {
				
				Tecnotek.UI.initModal(targetDiv, buttonsOpts);
				/* Assign div content */
				if (html != '' && htmlSelector != '') {
					$(htmlSelector).html(html);
				} else if (html != '') {
					$(targetDiv).html(html);
				}

				/* Assign title */
				if (title != '') {
					$(targetDiv).dialog('option', 'title', title);
				}

				if (width == 0) {
					width = 280;
				}

				$(targetDiv).dialog('option', 'width', width);
				$(targetDiv).dialog('option', 'closeOnEscape', true);

				if (height != 0) {
					$(targetDiv).dialog('option', 'height', height);
				}

				// true if the modal is not open/ flase if the modal is already open
				// with different content
				if (isNewOpen) {

					$(targetDiv).dialog('open');
				}

				$(targetDiv).css("z-index", "5000");
			},
			validateForm : function(formSelector) {
				//alert("validating form");
				var result = $(formSelector).validationEngine('validate');
				//alert("result "+result);
				return result;
			}
		},
        ShowActivity : {
            imageIndex: 1,
            imageIndexS: 1,
            maximunSlide: 0,
            lastDiap: "",
            lastDiapS: "",
            fromNext: false,
            init : function() {
                Tecnotek.ShowActivity.initComponents();
                Tecnotek.ShowActivity.initButtons();
            },
            initComponents : function() {
                /*$("#fullscreenContainer").dialog({
                    height: 140,
                    modal: true
                });*/


                $("img[rel]").overlay({

                    // one configuration property
                    color: '#ccc',
                    closeOnClick: false,
                    mask: {
                        color: '#ebecff',
                        loadSpeed: 200,
                        opacity: 0.9
                    }

                    // ... the rest of the configuration properties
                });

                $(".diapButton").click(function(event){
                    event.preventDefault();
                    var $this = $(this);
                    $('#slideB' + Tecnotek.ShowActivity.imageIndex).fadeOut(function(){
                        $('#btn-before-2').hide();
                        $("#btn-next-2").show();
                        Tecnotek.ShowActivity.lastDiap = $this.attr("href");
                        $($(Tecnotek.ShowActivity.lastDiap)).fadeIn();
                    });
                });

                $(".diapButton_s").click(function(event){
                    event.preventDefault();
                    var $this = $(this);
                    $('#slideB' + Tecnotek.ShowActivity.imageIndexS + "_s").fadeOut(function(){
                        $('#btn-before').hide();
                        $("#btn-next").show();
                        Tecnotek.ShowActivity.lastDiapS = $this.attr("href");
                        $($(Tecnotek.ShowActivity.lastDiapS)).fadeIn();
                    });
                });

                $('#btn-next').click(function(event){
                    if(Tecnotek.ShowActivity.lastDiapS === "") {
                        if(Tecnotek.ShowActivity.imageIndexS < Tecnotek.ShowActivity.maximunSlide) {
                            $('#slideB' + Tecnotek.ShowActivity.imageIndexS + "_s").fadeOut(function(){
                                $("#btn-before").show();
                                Tecnotek.ShowActivity.imageIndexS++;
                                if(Tecnotek.ShowActivity.imageIndexS == Tecnotek.ShowActivity.maximunSlide) {
                                    $("#btn-next").hide();
                                } else {
                                    $("#btn-next").show();
                                }
                                $('#slideB' + Tecnotek.ShowActivity.imageIndexS + "_s").fadeIn();
                            });
                        }
                    } else {
                        $($(Tecnotek.ShowActivity.lastDiapS)).fadeOut(function(){
                            if(Tecnotek.ShowActivity.imageIndexS == 1) {
                                $("#btn-before").hide();
                            } else {
                                $("#btn-before").show();
                            }
                            if(Tecnotek.ShowActivity.imageIndexS == Tecnotek.ShowActivity.maximunSlide) {
                                $("#btn-next").hide();
                            } else {
                                $("#btn-next").show();
                            }
                            $('#slideB' + Tecnotek.ShowActivity.imageIndexS + "_s").fadeIn();
                            Tecnotek.ShowActivity.lastDiapS = "";
                        });
                    }

                });
                $('#btn-before').click(function(event){
                    Tecnotek.ShowActivity.lastDiap = "";
                    if(Tecnotek.ShowActivity.imageIndexS > 1) {
                        $("#btn-next").show();
                        $('#slideB' + Tecnotek.ShowActivity.imageIndexS + "_s").fadeOut(function(){
                            Tecnotek.ShowActivity.imageIndexS--;
                            if(Tecnotek.ShowActivity.imageIndexS == 1) {
                                $("#btn-before").hide();
                            } else {
                                $("#btn-before").show();
                            }
                            $('#slideB' + Tecnotek.ShowActivity.imageIndexS + "_s").fadeIn();
                        });
                    }
                });

                $('#btn-next-2').click(function(event){
                    console.debug("-> " + (Tecnotek.ShowActivity.lastDiap === ""));
                    if(Tecnotek.ShowActivity.lastDiap === "") {

                        if(Tecnotek.ShowActivity.imageIndex < Tecnotek.ShowActivity.maximunSlide) {
                            $('#slideB' + Tecnotek.ShowActivity.imageIndex).fadeOut(function(){
                                $("#btn-before-2").show();
                                Tecnotek.ShowActivity.imageIndex++;
                                if(Tecnotek.ShowActivity.imageIndex == Tecnotek.ShowActivity.maximunSlide) {
                                    $("#btn-next-2").hide();
                                } else {
                                    $("#btn-next-2").show();
                                }
                                $('#slideB' + Tecnotek.ShowActivity.imageIndex).fadeIn();
                            });
                        }
                    } else {
                        $($(Tecnotek.ShowActivity.lastDiap)).fadeOut(function(){
                            if(Tecnotek.ShowActivity.imageIndex == 1) {
                                $("#btn-before-2").hide();
                            } else {
                                $("#btn-before-2").show();
                            }
                            if(Tecnotek.ShowActivity.imageIndex == Tecnotek.ShowActivity.maximunSlide) {
                                $("#btn-next-2").hide();
                            } else {
                                $("#btn-next-2").show();
                            }
                            $('#slideB' + Tecnotek.ShowActivity.imageIndex).fadeIn();
                            Tecnotek.ShowActivity.lastDiap = "";
                        });
                    }

                });
                $('#btn-before-2').click(function(event){
                    Tecnotek.ShowActivity.lastDiap = "";
                    if(Tecnotek.ShowActivity.imageIndex > 1) {
                        $("#btn-next-2").show();
                        $('#slideB' + Tecnotek.ShowActivity.imageIndex).fadeOut(function(){
                            Tecnotek.ShowActivity.imageIndex--;
                            if(Tecnotek.ShowActivity.imageIndex == 1) {
                                $("#btn-before-2").hide();
                            } else {
                                $("#btn-before-2").show();
                            }
                            $('#slideB' + Tecnotek.ShowActivity.imageIndex).fadeIn();
                        });
                    }
                });
            },
            initButtons : function() {
                $('#btnEliminar').click(function(event){
                    if (Tecnotek.showConfirmationQuestion(Tecnotek.UI.translates["confirmDelete"])){
                        location.href = Tecnotek.UI.urls["deleteURL"];
                    }
                });
                $('#btnPrint').click(function(event){
                    $("#report").printElement({printMode:'iframe', pageTitle:$(this).attr('rel')});
                });
                $('#btn-fs').click(function(event){
                    event.preventDefault();
                    $("#normalContainer").hide();

                    //$("#mies1").overlay();
                    //$("#fullscreenContainer").html($("#normalContainer").html());
                    //$( "#fullscreenContainer" ).dialog("open");
                });

            }
        }
	};
