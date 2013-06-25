var Tecnotek = Tecnotek || {};

Tecnotek.Account = {
    init : function() {

        $("#editLink").click(function (event){
            event.preventDefault();
            $("#user_firstname").val($("#labelFirstname").html());
            $("#user_lastname").val($("#labelLastname").html());
            $("#user_email").val($("#labelEmail").html());
            $("#accountInfo").hide();
            $("#accountUpdate").show();
        });

        $("#buttonCancelSaveInfo").click(function (event){
            event.preventDefault();
            $("#accountUpdate").hide();
            $("#accountInfo").show();
        });

        $("#buttonSaveInfo").click(function (event){
            event.preventDefault();
            Tecnotek.Account.saveAccountBasicInfo();
        });

        $("#editPassword").click(function (event){
            event.preventDefault();
            $("#user_current").val("");
            $("#user_new").val("");
            $("#user_confirmation").val("");
            $("#accountInfo").hide();
            $("#passwordUpdate").show();
        });

        $("#buttonCancelSavePassword").click(function (event){
            event.preventDefault();
            $("#passwordUpdate").hide();
            $("#accountInfo").show();
        });

        $("#buttonSavePassword").click(function (event){
            event.preventDefault();
            Tecnotek.Account.savePassword();
        });

        $("#cambiarAvatarLink").click(function (event){
            event.preventDefault();
            $("#avatarContainer").hide();
            $("#uploadAvatar").show();
        });

        $("#buttonCancelUploadAvatar").click(function (event){
            event.preventDefault();
            $("#uploadAvatar").hide();
            $("#avatarContainer").show();
        });

        $(".closeAlertBox").click(function(event){
            event.preventDefault();
            $(".alert-box").hide('slide', function() {
            });
        });

    },
    saveAccountBasicInfo : function(){
        var $firstname = $("#user_firstname").val();
        var $lastname = $("#user_lastname").val();
        var $email = $("#user_email").val();

        if($firstname === "" || $lastname === "" || $email === ""){
            Tecnotek.showErrorMessage("Debe incluir todos los datos antes de guardar.",
                true, "", false);
        } else {
            Tecnotek.ajaxCall(Tecnotek.UI.urls["updateUserInfo"],
                {   firstname: $firstname,
                    lastname: $lastname,
                    email: $email
                },
                function(data){
                    if(data.error === true) {
                        Tecnotek.showErrorMessage(data.message,true, "", false);
                    } else {
                        $("#labelFirstname").html($("#user_firstname").val());
                        $("#labelLastname").html($("#user_lastname").val());
                        $("#labelEmail").html($("#user_email").val());
                        $("#accountInfo").show();
                        $("#accountUpdate").hide();
                        Tecnotek.showInfoMessage("Los datos se han actualizado correctamente", true, "", false);
                    }
                },
                function(jqXHR, textStatus){
                    Tecnotek.showErrorMessage("Error al guardar los datos: " + textStatus + ".",
                        true, "", false);
                }, true);
        }
    },
    savePassword : function(){
        var $current = $("#user_current").val();
        var $new = $("#user_new").val();
        var $confirmation = $("#user_confirmation").val();

        if($current === "" || $new === "" || $confirmation === ""){
            Tecnotek.showErrorMessage("Debe incluir todos los datos antes de guardar.",
                true, "", false);
        } else {
            if($new !== $confirmation){
                Tecnotek.showErrorMessage("La confirmacion del nuevo password es incorrecta.",
                    true, "", false);
            } else {
                Tecnotek.ajaxCall(Tecnotek.UI.urls["updatePassword"],
                    {   current: $current,
                        new: $new
                    },
                    function(data){
                        if(data.error === true) {
                            Tecnotek.showErrorMessage(data.message,true, "", false);
                        } else {
                            $("#passwordUpdate").hide();
                            $("#accountInfo").show();
                            Tecnotek.showInfoMessage("El password se ha cambiado correctamente.", true, "", false);
                        }
                    },
                    function(jqXHR, textStatus){
                        Tecnotek.showErrorMessage("Error al guardar los datos: " + textStatus + ".",
                            true, "", false);
                    }, true);
            }

        }
    }
};