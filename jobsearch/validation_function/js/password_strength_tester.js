$(function () {
    $("#password").bind("keyup", function () {
        //TextBox left blank.
        if ($(this).val().length == 0) {
            $("#password_strength").html("");
            return;
        }

        //Regular Expressions.
        var regex = new Array();
        regex.push("[A-Z]"); //Uppercase Alphabet.
        regex.push("[a-z]"); //Lowercase Alphabet.
        regex.push("[0-9]"); //Digit.
        regex.push("[$@$!%*#?&]"); //Special Character.

        var passed = 0;

        //Validate for each Regular Expression.
        for (var i = 0; i < regex.length; i++) {
            if (new RegExp(regex[i]).test($(this).val())) {
                passed++;
            }
        }


        //Validate for length of Password.
        if (passed > 2 && $(this).val().length > 8) {
            passed++;
        }

        //Display status.
        var color = "";
        var strength = "Password Strength:";
        switch (passed) {
            case 0:
            case 1:
                strength += "Weak";
                color = "red";
                break;
            case 2:
                strength += "Good";
                color = "darkorange";
                break;
            case 3:
            case 4:
                strength += "Strong";
                color = "green";
                break;
            case 5:
                strength += "Very Strong";
                color = "darkgreen";
                break;
        }
        $("#password_strength").html(strength);
        $("#password_strength").css("color", color);
    });
});
