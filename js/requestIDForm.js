var requestIdForm = $('#rif-form[name="form"]');

$(document).ready(function () {

    var requestIdForm = $('#rif-form[name="form"]');

    var errorMsg = function ($this) {
        $this.addClass('hasError');
        $('#rif_form .errormessage[data-item="' + $this.attr('name') + '"]').addClass("active");
        $this.closest('label').addClass("active");
        $this.closest('label.active').find('.errormessage:not(.addressError)').addClass("active");
    };

    var successMsg = function ($this) {
        var errorMessage =$('#rif_form .errormessage[data-item="' + $this.attr('name') + '"]');
        $this.removeClass('hasError');
        errorMessage.removeClass("active");
        var erroritem = $this.attr('name');
        $('#rif-form .errormessage[data-item="' + erroritem + '"]').closest('label').removeClass("active");
        errorMessage.closest('label').removeClass("active");
        $this.closest('label').find('.errormessage').removeClass("active");
    };

    requestIdForm.cinch({error: errorMsg, success: successMsg, pickAll: false, onlySubmit: false});

    // focus on error box on error pages
    $('.container.issue .error-box').focus();    
    $('.container.offline .error-box').focus(); 

    // Scrolls to top of page if the form has any errors 
    function letsScroll() {
        var numErrors = $('.hasError');
        if(numErrors.length != 0) {            
            var destination = $('#alumni-forms .error-box.form');
            $("html,body").animate({
                scrollTop: $(destination).offset().top - 100
            });            
            $('#alumni-forms .error-box.form.error-items').focus();
        }

    }
    // add additional address inputs 
    $('#alumni-forms .main-rif-form .add-address-line.address-three').on('click', function () { 
        $('#alumni-forms .row.add-bottom-margin [name="address3"]').parent().parent().parent().show();
        $('#alumni-forms .row.bottom-margin label[for="address2"] .add-address-input').remove();
    });

    $('#alumni-forms .main-rif-form .add-address-line.address-four').on('click', function () { 
        $('#alumni-forms .row.add-bottom-margin [name="address4"]').parent().parent().parent().show();
        $('#alumni-forms .row.add-bottom-margin label[for="address3"] .add-address-input').remove();
    });

    // Switches zip and state inputs based on if US or another country is selected
    $('#alumni-forms [name="country"]').change(function() {
        if ($(this).val() === 'US') {
            $('#alumni-forms .state-gen .text').hide();
            $('#alumni-forms .us-states select').prop('disabled', false);
            $('#alumni-forms .us-states').show();               
            $('#alumni-forms label.us-states').attr('for','state');
            $('#alumni-forms .us-states select').attr('name', 'state');
            $('#alumni-forms .us-states select').addClass('required');
            $('#alumni-forms .us-states select').attr('id', 'state');
            $('#alumni-forms .state-gen select').prop('disabled', true);         
            $('#alumni-forms .state-gen label').removeAttr('for');
            $('#alumni-forms .state-gen .state-gen-input').removeAttr('name'); 
            $('#alumni-forms .state-gen .state-gen-input').removeAttr('id');           
            $('#alumni-forms .state-gen .state-gen-input').removeClass('required');
            $('#alumni-forms label[for="zip"] span.label').text('Zip Code*');           
            $('#alumni-forms label[for="zip"] .errormessage').html('Enter a Zip Code');

        } else {
            $('#alumni-forms .us-states').hide();                        
            $('#alumni-forms .state-gen .state-gen-input').prop('disabled', false); 
            $('#alumni-forms .state-gen .text').show();   
            $('#alumni-forms .state-gen label').attr('for','state');              
            $('#alumni-forms .state-gen .state-gen-input').attr('name', 'state');
            $('#alumni-forms .state-gen .state-gen-input').attr('id', 'state');                     
            $('#alumni-forms .state-gen .state-gen-input').addClass('required');         
            $('#alumni-forms .us-states label').removeAttr('for');
            $('#alumni-forms .us-states select').removeAttr('name'); 
            $('#alumni-forms .us-states select').removeAttr('id');           
            $('#alumni-forms .us-states select').removeClass('required');
            $('#alumni-forms label[for="zip"] span.label').html('Postal Code*');
            $('#alumni-forms label[for="zip"] .errormessage').html('Enter a Postal Code');
        }
    });

    $('.main-rif-form .submit').on('click', function() {
        letsScroll();
        // Error messages at top of form
        var numErrors = $('.hasError').length;
        if(numErrors != 0) { 
            $('#alumni-forms .error-box.form.error-items').show();
            $('#alumni-forms .error-box.form.error-items').focus(); 
            if(numErrors === 1) {  
                $('#alumni-forms .error-box.form.error-items .items-para').replaceWith('<p class="items-para">There is <strong>1 item</strong> that requires your attention:</p>');
            } else {
                $('#alumni-forms .error-box.form.error-items .items-para').replaceWith('<p class="items-para">There are <strong><span class="items">' + numErrors + '</span> items</strong> that require your attention:</p>');
            }

            $('#alumni-forms .specific-errors').html('<il class="first-li hide"></il>');
            $("#alumni-forms label .required" ).each(function() {
                if ($( this ).hasClass( "hasError" )) {
                    var inputId = $(this).attr('id');
                    var inputLabel = $(this).prev().text().replace(/\*/g, '');
                    $('#alumni-forms .specific-errors .first-li').before('<li class="'+inputId+'"><a href="#'+inputId+'">'+inputLabel+'</a></li>');
                }
            });
        }  else {
            $('#alumni-forms .error-box.form').hide();
        }
    });

});


function mylu_v2_success(form, data) {
    if((form.attr('name') === 'start') || (form.attr('name') === 'mylu_error')){
        if(!(data.me)) {
            form.append("<input type='hidden' name='my_lu_error' value='my_lu_error' />");
            form.submit();
        } else {
            form.append("<input type='hidden' name='main' value='main' />");
            form.append("<input type='hidden' name='STUDENT[FNAME]' value='" + data.me.firstName +"' />");
            form.append("<input type='hidden' name='STUDENT[MNAME]' value='" + data.me.middleName +"' />");
            form.append("<input type='hidden' name='STUDENT[LNAME]' value='" + data.me.lastName +"' />");
            form.append("<input type='hidden' name='STUDENT[MANAME]' value='" + data.me.maidenName +"' />");
            form.append("<input type='hidden' name='STUDENT[DOB]' value='" + data.me.birthDate +"' />");
            form.append("<input type='hidden' name='STUDENT[PIDM]' value='" + data.me.pidm +"' />");
            
            let phoneLength = data.me.phones.length;
            for (let i = 0; i <= phoneLength; i++) {
                if (data.me.phones[i] && data.me.phones[i].phone !== '') {
                    if (Object.values(data.me.phones).includes('CL')) {
                        form.append("<input type='hidden' name='STUDENT[PHONECL]' value='" + data.me.phones[i].phone +"' />");
                    } else if (Object.values(data.me.phones).includes('H1')) {
                        form.append("<input type='hidden' name='STUDENT[PHONEH1]' value='" + data.me.phones[i].phone +"' />");
                    } else {
                        form.append("<input type='hidden' name='STUDENT[PHONECL]' value='" + data.me.phones[0].phone +"' />");
                    }
                }
            }

            // loop to check for address array length and find mailing address (if applicable)
            let addressLength = data.me.addresses.length;
            for (let i = 0; i <= addressLength; i++) {
                if (data.me.addresses[i] && data.me.addresses[i].street1 !== '') {
                    if (Object.values(data.me.addresses).includes('Mailing')) {
                        form.append("<input type='hidden' name='STUDENT[ADDRESS1]' value='" + data.me.addresses[i].street1 +"' />");
                        form.append("<input type='hidden' name='STUDENT[CITY]' value='" + data.me.addresses[i].city +"' />");
                        form.append("<input type='hidden' name='STUDENT[STATE]' value='" + data.me.addresses[i].statecode +"' />");
                        form.append("<input type='hidden' name='STUDENT[ZIP]' value='" + data.me.addresses[i].zip +"' />");
                        form.append("<input type='hidden' name='STUDENT[COUNTRY]' value='" + data.me.addresses[i].nationcode +"' />");
                    } else {
                        form.append("<input type='hidden' name='STUDENT[ADDRESS1]' value='" + data.me.addresses[0].street1 +"' />");
                        form.append("<input type='hidden' name='STUDENT[CITY]' value='" + data.me.addresses[0].city +"' />");
                        form.append("<input type='hidden' name='STUDENT[STATE]' value='" + data.me.addresses[0].statecode +"' />");
                        form.append("<input type='hidden' name='STUDENT[ZIP]' value='" + data.me.addresses[0].zip +"' />");
                        form.append("<input type='hidden' name='STUDENT[COUNTRY]' value='" + data.me.addresses[0].nationcode +"' />");
                    }
                }
            }

            form.append("<input type='hidden' name='STUDENT[LIBERTY_ID]' value='" + (data.me.luid).toString() +"' />");
            form.append("<input type='hidden' name='STUDENT[IDNUM]' value='" + data.me.myluid +"' />");
            form.append("<input type='hidden' name='STUDENT[USERNAME]' value='" + data.me.ldapUser +"' />");
            form.submit();
        }
    }
}

function mylu_v2_error(form, request, error) {
    form.append("<input type='hidden' name='my_lu_error' value='my_lu_error' />");
    form.submit();
}