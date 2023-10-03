<head>
    <!-- for internationl phone number handling -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
</head>

<div class="container form">
    <?php

        $todaysDate = date('Y-m-d');

        $firstName = ''; 
        
        if (isset($_POST['STUDENT']['FNAME'])) { 
            if ($_POST['STUDENT']['FNAME'] != '' && $_POST['STUDENT']['FNAME'] != 'null') { 
                $firstName = $_POST['STUDENT']['FNAME']; 
            }
        }
        
        $middleName = '';
        
        if (isset($_POST['STUDENT']['MNAME'])) { 
            if ($_POST['STUDENT']['MNAME'] != '' && $_POST['STUDENT']['MNAME'] != 'null') { 
                $middleName = $_POST['STUDENT']['MNAME']; 
            }
        }
        
        $lastName = '';
        
        if (isset($_POST['STUDENT']['LNAME'])) { 
            if ($_POST['STUDENT']['LNAME'] != '' && $_POST['STUDENT']['LNAME'] != 'null') { 
                $lastName = $_POST['STUDENT']['LNAME']; 
            }
        }
        
        $fullName = $firstName .' '.$middleName. ' '. $lastName;

        $cellPhone = $_POST['STUDENT']['PHONECL'];
        $homePhone = $_POST['STUDENT']['PHONEH1'];
        $maidName = '';
        
        if ((isset($_POST['STUDENT']['MANAME'])) && ($_POST['STUDENT']['MANAME'] != 'null') && ($_POST['STUDENT']['MANAME'] != '') && ($_POST['STUDENT']['MANAME'] != null))  { 
        $maidName = $_POST['STUDENT']['MANAME']; 
        }

        $_POST['STUDENT']['USERNAME'];

    ?>
    <form class="validate" id="rif-form" method="POST">
        <input type="hidden" name="idnum" value="<?php echo $_POST['STUDENT']['IDNUM']; ?>">
        <input type="hidden" id="location_url" name="location_url" value="<?php echo current_location(); ?>">
        <input type="hidden" id="pidm" name="pidm" value="<?php echo $_POST['STUDENT']['PIDM']; ?>">
        <input type="hidden" id="username" name="username" value="<?php echo $_POST['STUDENT']['USERNAME']; ?>">
            <div class="row">
            <div class="four columns"></div>
            <div class="eight columns">
            <div class="first-step" id="firstStep">
                <div class="row half-bottom-margin">
                    <div class="columns eight mobile-twelve start-rif">
                        <div class="error-box form error-items hide" tabindex="-1">
                            <p class="items-para"></p>
                            <ul class="specific-errors">
                                <il class="first-li hide"></il>
                            </ul>
                        </div>
                        <ul class="text-center">
                            <li><a tabindex="-1" role="link" href="<?=bloginfo('url');?>" title="Liberty Alumni"><img class="alumni-icon"
                                src="<?php echo get_bloginfo('template_url').'/images/request_id_form/LU_Alumni_blue.svg'; ?>" alt="LU Alumni Icon" title="LU Alumni Icon"></a></li>
                            <h2>Digital ID Card Request</h2>
                        </ul>
                    <fieldset>
                        <legend tabindex="0"><h5>STEP 1 OF 2</h5>
                        <p>Verify the pre-filled information below is correct. Please make any changes, if needed.</p>
                        </legend>
                    </div>
                </div>
                <div class="row bottom-margin">
                    <div class="columns six mobile-twelve">
                        <label for="libertyid" class="text">
                            <span class="label" tabindex="0">Liberty ID</span>
                            <input type="text" name="libertyuid" id="libertyid" value="<?php echo $_POST['STUDENT']['LIBERTY_ID']; ?>">
                            <span class="luidexample">e.g. L12345678</span>
                        </label>
                    </div>
                </div>
                <div class="row bottom-margin">
                    <div class="columns six mobile-twelve double-row">
                        <label for="firstname" class="text">
                            <span class="label" tabindex="0">First Name*</span>
                            <input aria-required="true" type="text" name="firstname" id="firstname" class="required" value="<?php echo $firstName; ?>">
                            <span class="errormessage" data-item="firstname">Please enter the First Name.</span>
                        </label>

                        <label for="middlename" class="text">
                            <span class="label" tabindex="0">Middle Name</span>
                            <input type="text" name="middlename" id="middlename" value="<?php echo $middleName; ?>">
                        </label>
                    </div>
                </div>
                <div class="row bottom-margin">
                    <div class="columns six mobile-twelve">
                        <div class="double-row">
                            <label for="lastname" class="text">
                                <span class="label" tabindex="0">Last Name*</span>
                                <input aria-required="true" type="text" name="lastname" id="lastname" class="required" value="<?php echo $lastName; ?>">
                                <span class="errormessage" data-item="lastname">Please enter the Last Name.</span>
                            </label>
                            <label for="suffix" class="text">
                                <span class="label" tabindex="0" id="suffix">Suffix</span>
                                <input type="text" name="suffix" id="suffix" value="<?php echo $suffix; ?>">
                            </label>
                        </div>
                    </div>
                </div>
                <div class="row bottom-margin">
                    <div class="columns six mobile-twelve double-row">   
                        <label for="bday" class="text">
                            <span>Date of Birth*</span>
                            <input aria-required="true" type="date" name="bday" id="bday" class="required" max="<?=$todaysDate?>" value="">
                            <span class="errormessage" data-item="bday">Please enter the Date of Birth.</span>
                        </label>

                        <label for="phone" class="text">
                            <span class="label" tabindex="0">Phone Number*</span>
                            <input type="tel" name="phone" id="phone" class="required" value="<?php echo (isset($cellPhone)) ? $cellPhone : $homePhone; ?>">
                            <span class="errormessage" data-item="phone">Please enter the Phone Number.</span>
                            <script>
                                // gets the international numbers and dropdown
                                var phone_number = window.intlTelInput(document.querySelector("#phone"), {
                                    initialCountry: 'us',
                                    separateDialCode: true,
                                    hiddenInput: "full",
                                    utilsScript: "//cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.3/js/utils.js"
                                });

                                // add country code to number on submit
                                $("#rif-form").submit(function() {
                                    var full_number = phone_number.getNumber(intlTelInputUtils.numberFormat.E164);
                                    full_number = full_number.replace('+', '');
                                    $("input[name=phone]").val(full_number);
                                });
                            </script>
                        </label>
				    </div>
                </div>
                <div class="row bottom-margin">
                    <div class="columns six mobile-twelve">
                        <label for="email" class="text">
                            <span class="label" tabindex="0">Email Address*</span>
                            <input aria-required="true" type="email" name="email" id="email" class="required">
                            <span class="errormessage" data-item="email">Please enter the email.</span>
                        </label>
                    </div>  
                </div>
                <!--
                <div class="row bottom-margin"> 
                    <div class="columns six mobile-twelve">   
                        <label for="maidenName" class="text maiden-name-input">
                            <span class="label" tabindex="0">Maiden Name</span>
                            <input type="text" name="maidenname" id="maidenName" value="<?php echo $maidName; ?>">
                        </label>
                    </div>
                </div>
                -->
            </div>
            </div>
            </fieldset>
            <div class="second-step">
            <fieldset>  
                <legend tabindex="0"><h5>STEP 2 OF 2</h5>
                    <p>Where should we send the alumni card?</p></legend>
                <div class="row no-bottom-margin">
                    <div class="columns six mobile-twelve">
                        <label for="country" class="text country">
                            <span class="label">Country/Region*</span>
                            <select aria-required="true" id="country" name="country" class="required">
                                <option value="" selected disabled hidden>Select</option>
                                <?php echo callNationsURL($environment); ?>                            
                            </select>
                            <div class="drop_down">
                                <span class="drop"></span>
                            </div>
                            <span class="errormessage" data-item="country">Please Select the Country.</span>
                        </label>
                    </div>
                </div>
                <div class="row bottom-margin">
                    <div class="columns six mobile-twelve">
                        <label for="address1" class="text">
                            <span class="label" tabindex="0">Street Address*</span>
                            <input aria-required="true" type="text" name="address1" id="address1" class="required" value="<?php echo $_POST['STUDENT']['ADDRESS1']; ?>">
                            <span class="errormessage" data-item="address1">Please enter the Street Address.</span>
                        </label>
                    </div>  
                </div>
                <div class="row bottom-margin">
                    <div class="columns six mobile-twelve address-style">
                        <label for="address2" class="text">
                            <span class="label" tabindex="0">Address 2</span>
                            <input type="text" id="address2" name="address2">
                            <span class="address2">e.g. Apt #, Unit #</span>
                            <div class="add-address-input">
                            <a class="add-address-line address-three" href="#addaddress">Add Address Line</a>
                            </div>
                        </label>
                    </div>   
                </div>
                <div class="row add-bottom-margin hide">
                    <div class="columns six mobile-twelve address-style">
                        <label for="address3" class="text">
                            <span class="label" tabindex="0">Address 3</span>
                            <input type="text" id="address3" name="address3">
                            <div class="add-address-input">
                            <a class="add-address-line address-four" href="#addaddresslast">Add Address Line</a>
                            </div>
                        </label>
                    </div>
                </div>
                <div class="row add-bottom-margin hide">
                    <div class="columns six mobile-twelve address-style">
                        <label for="address4" class="text">
                            <span class="label" tabindex="0">Address 4</span>
                            <input type="text" id="address4" name="address4">
                        </label>
                    </div>
                </div>
                <div class="row bottom-margin">
                    <div class="columns six mobile-twelve">
                        <label for="city" class="text">
                            <span class="label" tabindex="0">City*</span>
                            <input aria-required="true" type="text" name="city" class="required" id="city" value="<?php echo $_POST['STUDENT']['CITY']; ?>">
                            <span class="errormessage" data-item="city">Please enter the City.</span>
                        </label>
                    </div>  
                </div>
                <div class="row bottom-margin">
                <div class="columns six mobile-twelve states-input">
                    <div class="double-row">
                        <label class="text country us-states" style="display:none;">
                                <span class="label">State*</span>
                                <select class="us-state-dropdown" aria-required="true" id="state" name="state">
                                    <option value="" selected disabled hidden>Select</option>
                                    <?php echo callStatesURL($environment); ?>                            
                                </select>
                                <div class="drop_down">
                                    <span class="drop"></span>
                                </div>
                                <span class="errormessage" data-item="state">Please Select the State.</span>
                        </label>
                        <div class="state-gen">
                            <label for="state" class="text">
                                <span class="label">State/Territory*</span>
                                <input name="state" id="state" class="state-gen-input required">
                                </input>
                                <span class="errormessage" data-item="state">Please enter the State or Territory.</span>
                            </label>
                        </div>
                        <label for="zip" class="text">
                            <span class="label">Zip/Postal Code*</span>
                            <input aria-required="true" name="zip" id="zip" class="required zip-code" value="<?php echo $_POST['STUDENT']['ZIP']; ?>">
                            </input>
                            <span class="errormessage" data-item="zip">Please enter the Zip or Postal Code.</span>
                        </label>
                    </div>
                    <div class="privacy-section double-row">
                        <input id="accept" type="checkbox" required>
                        <span class="privacy-agreement">Consent to Share Personal Information. Liberty University has engaged certain third-party vendor(s) to produce and deliver physical and/or digital Alumni ID cards on its behalf. By submitting this request for LU Alumni ID, I authorize and consent to Liberty University sharing my personal information provided through this form (including, my name, address, and telephone number) with its third-party vendor(s) to produce and deliver the physical and/or digital LU Alumni ID cards to me in accordance with my request, and <a href="https://www.liberty.edu/privacypolicy/">Liberty University's Privacy Policy.</a></span>
                    </div>
                </div>  
                </div>
            </fieldset>
            <div class="form-submit-section">
                    <div class="row">
                        <div class="columns eight mobile-twelve">
                            <input type="submit" value="Submit" name="post" title="Submit" class="btn blue submit">
                        </div>
                    </div>
            </div>
                <div class="form-info-section">
                    <div class="row">
                        <div class="columns twelve mobile-twelve">
                        <div class="question-form-group">
                            <ul>
                                <li><h3><strong>Additional Questions?</strong></h3></li>
                                <li class="question-message">If a digital Alumni ID card is not compatible with your cell phone, please contact the LU Alumni Office at <a href="mailto:alumni@liberty.edu">alumni@liberty.edu</a> or call at <a href="tel:+8006287973">800-628-7973</a>
                                <li><div class="email-group"><img class="email-icon" src="<?php echo get_stylesheet_directory_uri() . '/images/request_id_form/Email_icon.svg'; ?>" alt=""><p class="email-address"><a  role="link" title="Email Liberty University" href="mailto:alumni@liberty.edu">Alumni@liberty.edu</a></p></div></li>
                                <li><div class="phone-group"><img class="phone-icon" src="<?php echo get_stylesheet_directory_uri() . '/images/request_id_form/Phone_icon.svg'; ?>" alt=""><p class="phone-number"><a tabindex="0" role="link" title="Call Liberty University" href="tel:1-800-628-7973">(800) 628-7973</a></p></div></li>
                            </ul>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
</div>

<script>

    // prevent form submission if privacy isnt checked
    $('#rif-form').submit(function(event){
        event.preventDefault();
        if ( $('#accept').is(':checked') ){
            $(this).submit();
        }
        else {
            alert('Please accept the Privacy Policy to submit successfully.')
        }
    });
    }
</script>