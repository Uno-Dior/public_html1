<?php
session_start();
if (isset($_SESSION["user"])) {
   header("Location: ..\data_page\Registration.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="..\data_image\favicon.png">
    <link rel="stylesheet" type="text/css" href="..\data_style\style-login1.css">
    <title>ResiHive - for Registration</title>
</head>
<body>
    <div class="container">
    <div class="cover1">
        <div class="front">
            <div><a href="..\data_page\ResiHive.php">
                <img src="..\data_image\RESIHIVE SYMBOL2.png" class="logo" alt="logo"></a></div><br><br><br>
            <div class="text"><h3>We sent you a verification code</h3></div><br>
            <div class="text"><h6>it has been sent to your email.</h6></div>
        </div>
    </div>
    <form action="..\database\LO_Register_Process.php" method="post" class="form3">
        <div class="form_content">
            <div class="registration_form">
                <div class="title1">Registration (OTP)</div>
                <div class="input_boxes1">
                    <div id="inputs" class="inputs"> 
                        <input class="input" type="text" 
                            inputmode="numeric" maxlength="1" /> 
                        <input class="input" type="text" 
                            inputmode="numeric" maxlength="1" /> 
                        <input class="input" type="text" 
                            inputmode="numeric" maxlength="1" /> 
                        <input class="input" type="text" 
                            inputmode="numeric" maxlength="1" />
                        <input class="input" type="text" 
                            inputmode="numeric" maxlength="1" /> 
                        <input class="input" type="text" 
                            inputmode="numeric" maxlength="1" /> 
                    </div>
                </div>
                <div class="button input_box">
                        <input type="submit" value="Verify" name="verify">
                </div>
                <div class="text1">Didn't get the code? <label for="">Resend</label></div>
            </div>
        </div>
    </form>
    </div>

<script>
    const inputs = document.getElementById("inputs"); 
  
  inputs.addEventListener("input", function (e) { 
      const target = e.target; 
      const val = target.value; 
    
      if (isNaN(val)) { 
          target.value = ""; 
          return; 
      } 
    
      if (val != "") { 
          const next = target.nextElementSibling; 
          if (next) { 
              next.focus(); 
          } 
      } 
  }); 
    
  inputs.addEventListener("keyup", function (e) { 
      const target = e.target; 
      const key = e.key.toLowerCase(); 
    
      if (key == "backspace" || key == "delete") { 
          target.value = ""; 
          const prev = target.previousElementSibling; 
          if (prev) { 
              prev.focus(); 
          } 
          return; 
      } 
  });
</script>
    
</body>
</html>