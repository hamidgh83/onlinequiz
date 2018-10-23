// Reset form plugin
$.fn.reset = function() {
    var element = $(this);


    if (element.is("form")) {
        // Remove error identification message
        element.find('.form-group').removeClass('has-error');
        
        // Reset text inputs
        element.find('input[type=text]').val('');
        
        // Reset select elements
        element.find('select').prop('selectedIndex', -1);
    }
    
    if (element.is("input")) {
        element.val('');
    }
    
    if (element.is("select")) {
        element.find('select').prop('selectedIndex',0);
    }
};

// Validate form plugin
$.fn.validate = function() {
    var valid = true;
    var form = $(this);

    // console.log(form.is("form"));
    if(form.is("form") == false) {
        console.log('Passing element is not a form.')
        return false;
    }

    // Find all required fields
    var fields = form.find('input[data-required="true"],select[data-required="true"]')

    $.each(fields, function (index, element) {
        if ($(element).val().length == 0) {
            $(element).closest('.form-group').addClass('has-error');
            valid = false;
        }
        else {
            $(element).closest('.form-group').removeClass('has-error');
        }
    });

    return valid;
};

   
$('document').ready(function () {

    // Reset forms on page load
    $('form').reset();

    // Form validatation befor submitting
    $('.home').find('form').on('submit', function() {
        return $(this).validate();
    });

    $('#question-form').on('submit', function() {
        var form  = $(this);

        if (!form.find("input[name='answer']:checked").val()) {
            $('.alert').text('You should select an answer.');
            $('.alert').show();
            return false;
        }

        return true;
    });
});