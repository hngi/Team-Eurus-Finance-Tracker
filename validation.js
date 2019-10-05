
    function validateForm() {
        var name = document.regForm.name.value;
        if (name == "") {
        alert("Please input your name");
        name.focus();
        return false;
        }else if(name.length<4){
        alert("name must be more than 3 characters");
        name.focus();
        return false;
        }
        var email = document.regForm.email.value;
        if (email == "") {
        alert("Please input your email address");
        email.focus();
        return false;
        }
        var title = document.regForm.title.value;
        if (title == "") {
        alert("Please input your title");
        title.focus();
        return false;
        }
        var message = document.regForm.message.value;
        if (message == "") {
        alert("Please input your message");
        message.focus();
        return false;
        }else if(message.length<20){
        alert("Message must be more than 20 characters");
        message.focus();
        return false;
        }
    }
    