/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
function checkAuthor(button)
{
    firstName = $("#firstName");
    firstName_msg = $("#invalid-firstName");
    
    lastName = $("#lastName");
    lastName_msg = $("#invalid-lastName");
    
    var regularExpression = new RegExp("^([a-zA-Z]+)$", "g");
    var error = false;
    
    if (firstName.val().trim() === "")
    {
        firstName_msg.html("The first name field must not be empty");
        firstName.focus();
        error = true;
    } else if (!firstName.val().trim().match(regularExpression)) {
        firstName_msg.html("The first name must only contains letters, no digits or special characters");
        firstName.focus();
        error = true;
    } else {
        firstName_msg.html("");
    }

    if (lastName.val().trim() === "")
    {
        lastName_msg.html("The last name field must not be empty");
        lastName.focus();
        error = true;
    } else if (!lastName.val().trim().match(regularExpression))
    {
        lastName_msg.html("The last name must only contains letters, no digits or special characters");
        lastName.focus();
        error = true;
    } else {
        lastName_msg.html("");
    }
    
    if (!error)
    {
        if (button === "Create")
        {
            $.ajax('/ajaxAuthor', {

                method: 'GET',

                data: {firstName: firstName.val().trim(), lastName: lastName.val().trim()},

                success: function (data) {

                    if (data.found)
                    {
                        error = true;
                        lastName_msg.html("Author already exists in the database");
                    } else {
                        $('form[name=author]').submit();
                    }
                }

            });
        } else {
            authorID = $("input[name=id]").val();

            $.ajax('/ajaxAuthorUpdate', {

                method: 'GET',

                data: {firstName: firstName.val().trim(), lastName: lastName.val().trim(), id: authorID},

                success: function (data) {

                    if (data.found)
                    {
                        error = true;
                        lastName_msg.html("Author already exists in the database");
                    } else {
                        $('form[name=author]').submit();
                    }
                }

            });
        }
    }
    
}

function checkBook(button)
{
    title = $("#title");
    title_msg = $("#invalid-title");
    category_msg = $("#no-category-selection");
    var error = false;

    category_selected = false;
    $("select[multiple] option:selected").each(function() {
        category_selected = true;
    });
    
    if (title.val().trim() === "")
    {
        title_msg.html("The title field must not be empty");
        title.focus();
        error = true;
    } else {
        title_msg.html("");
    }
    if(!category_selected) {
        category_msg.html("At least a category for the book must be selected");
        error = true;
    } else {
        category_msg.html("");
    }
    
    if (!error)
    {
        if (button === "Create")
        {
            $.ajax('/ajaxBook', {

                method: 'GET',

                data: {title: title.val().trim()},

                success: function (result) {

                    if (result.found)
                    {
                        error = true;
                        title_msg.html("Book title already exists in the database");
                    } else {
                        $('form[name=book]').submit();
                    }
                }

            });
        } else {
            bookID = $("input[name=id]").val();

            $.ajax('/ajaxBookUpdate', {

                method: 'GET',

                data: {title: title.val().trim(), id: bookID},

                success: function (result) {

                    if (result.found)
                    {
                        error = true;
                        title_msg.html("Book title already exists in the database");
                    } else {
                        $('form[name=book]').submit();
                    }
                }

            });
        }
    }
}

function checkRegistrationData() {
    registrationName = $("form[id=register-form] input[name=name]");
    registrationEmail = $("form[id=register-form] input[name=email]");
    registrationPasswd = $("form[id=register-form] input[name=password]");
    registrationPasswdRepeat = $("form[id=register-form] input[name=confirm-password]");

    regName_msg = $("#invalid-registrationName");
    regEmail_msg = $("#invalid-registrationEmail");
    regPasswd_msg = $("#invalid-registrationPasswd");
    passwdConfirm_msg = $("#invalid-passwdConfirm");

    var emailRegularExpression = new RegExp(/^[A-Za-z0-9]+(\.[A-Za-z0-9]+)*@[A-Za-z0-9-]+\.[A-Za-z]{2,3}$/, "g");
    error = false;

    if (registrationName.val().trim() === "")
    {
        regName_msg.html("The registration name field must not be empty");
        registrationName.focus();
        error = true;
    } else {
        regName_msg.html("");
    }

    if (registrationEmail.val().trim() === "")
    {
        regEmail_msg.html("The registration email field must not be empty");
        error = true;
    } else if(!registrationEmail.val().trim().match(emailRegularExpression))
    {
        regEmail_msg.html("Wrong registration email");
        error = true;
    } else {
        regEmail_msg.html("");
    }

    if (registrationPasswd.val().trim() === "")
    {
        regPasswd_msg.html("The password field must not be empty");
        error = true;
    } else if(registrationPasswd.val().length < 8) {
        regPasswd_msg.html("The password must have a length of at least 8 characters");
        error = true;
    } else {
        regPasswd_msg.html("");
    }

    if((registrationPasswdRepeat.val().trim === "")||(registrationPasswdRepeat.val() != registrationPasswd.val()))
    {
        passwdConfirm_msg.html("This field does not match with the password field");
        error = true;
    } else {
        passwdConfirm_msg.html("");
    }

    if(!error) {
        $.ajax('/registrationEmailCheck', {

            method: 'GET',

            data: {email: registrationEmail.val().trim()},

            success: function (result) {

                if (result.found)
                {
                    error = true;
                    regEmail_msg.html("This email already exists in the database");
                } else {
                    $('form[id=register-form]').submit();
                }
            }

        });   
    }
}