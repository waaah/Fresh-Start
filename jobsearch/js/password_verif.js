$("#passform").validate({
        rules: {
            conf_email: {
                required: true,
                email:true
            }
        },
        //For custom messages
        errorElement : 'div',
        errorPlacement: function(error, element) {
          var placement = $(element).data('error');
          if (placement) {
            $(placement).append(error)
          } else {
            error.insertAfter(element);
          }
        }
     });