
    function validateForm() {
        var fname = document.regForm.fname.value;
        if (fname == "") {
        alert("Please input your Fullname");
        fname.focus();
        return false;
        }
        else if(fname.length<4){
        alert("Fullname must be more than 3 characters");
        fname.focus();
        return false;
        }
        var uname = document.regForm.uname.value;
        if (uname == "") {
        alert("Please input your Username");
        uname.focus();
        return false;
        }
        else if(uname.length<4){
        alert("Username must be more than 3 characters");
        uname.focus();
        return false;
        }
        var email = document.regForm.email.value;
        if (email == "") {
        alert("Please input your email address");
        email.focus();
        return false;
        }
        var password1 = document.regForm.password1.value;
        if (password1 == "") {
        alert("Please input your Password");
        password1.focus();
        return false;
        }
        else if(password1.length<6){
        alert("Password must be more than 6 characters");
        password1.focus();
        return false;
        }
        var cnfpassword = document.regForm.cnfpassword.value;
        if (cnfpassword == "") {
        alert("Please input your password");
        cnfpassword.focus();
        return false;
        }
        else if(cnfpassword.length<6 ){
        alert("Password must be more than 6 characters");
        cnfpassword.focus();
        return false;
        }
        if($password1 !== $cnfpassword){
        alert("Password doesnt match");
        cnfpassword.focus();
        return false;
        }
    }
    