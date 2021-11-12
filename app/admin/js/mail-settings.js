(function ($) {
    
        $("form#form-mail-settings").submit(function(event){
            var emailObject  = $("#email-object").val();
            var msg_alert   = "Merci de remplir le champs ci-dessus";

            
            if (emailObject == "") {
                
                if (emailObject == "") {
                    $("#msg_email-object").html(msg_alert).show(300);
                } else if (emailObject != "") {
                    $("#msg_email-object").hide(300);
                }
            
            } else {
                var formId = '#' + this.id;
                $.ajax({
                    type : "POST",
                    url: $(this).attr("action"),
                    data: $(this).serialize(),
                    success : function() {
                        $(formId + ' .modal-body').html("<div class='form-success-msg'><h4>Configuration envoyée avec succès !</h4></div>");
                    },
                    error: function() {
                        $(formId).html("<div class='form-success-msg'><h4>Erreur d'appel, le formulaire ne peut pas fonctionner</h4></div>");
                    }
                });
            }
            return false;
        });
      
})(jQuery);