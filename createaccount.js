function checkPassword()
{
  if(document.getElementById("password").value ==
      document.getElementById("confirmpassword").value)
  {

    if(document.getElementById("password").value !== "" &&
        document.getElementById("confirmpassword").value !== "")
    {
      document.getElementById("password_message").innerHTML = " Passwords match.";
      document.getElementById("password_message").style.color = "green";
      return true;
    }
  }

  else
  {
    document.getElementById("password_message").innerHTML = " Passwords don't match.";
    document.getElementById("password_message").style.color = "red";
    return false;
  }
}

var submit = false;

function captchaFilled()
{
  submit = true;
}

function captchaExpired()
{
  submit = false;
}

function checkCaptcha()
{
  return submit;
}

function checkSubmit()
{
  if(checkPassword() && checkCaptcha())
    return true;

  if(!checkCaptcha())
  {
    document.getElementById("submit_message").innerHTML = " Please fill in Captcha.";
    document.getElementById("submit_message").style.color = "red";
  }

  if(!checkPassword())
  {
    document.getElementById("submit_message").innerHTML = " Please match passwords.";
    document.getElementById("submit_message").style.color = "red";
  }

  return false;
}
