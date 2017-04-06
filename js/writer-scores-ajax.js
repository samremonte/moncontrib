
jQuery(document).ready(function($){

    $("#listofusers").change(function(){
    	var listofusers = $(this).val();

        data = {
            action: "writer_scores",
            user: listofusers
        };
        $.post( ajaxurl, data, function(response){
            $(".user-information").html(response);
        });
    });
    
});
