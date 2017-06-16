<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>Contact Form</title>
<style type="text/css">
#contactUs fieldset {
	font-family: Tahoma, Geneva, sans-serif;
	font-size: 14px;
	text-transform: capitalize;
	padding: 12px;
	width: 300px;
	margin-top: 10px;
	margin-right: auto;
	margin-left: auto;
	border-top-style: solid;
	border-right-style: solid;
	border-bottom-style: solid;
	border-left-style: solid;
	border-top-color: #00F;
	border-right-color: #00F;
	border-bottom-color: #00F;
	border-left-color: #00F;
	border-radius: 18px;
}
#contactUs fieldset legend {
	font-size: 22px;
	color: #00C;
}
#contactUs fieldset p #sendit {
	color: #FF0;
	background-color: #00C;
	padding: 12px;
}
</style>
</head>

<body><form action="formProcces.php" method="post" id="contactUs">
<fieldset>
 
    <legend>contact us</legend>
    <p>First Name:<br>
      <input name="first_name" type="text">
    </p>
    <p>
      
      Last Name:<br>
      <input name="last_name" type="text">
    </p>
    <p>Email:<br>
      <input name="email" type="text">
    </p>
    <p>
      <label for="Message">Yout Message<br>
      </label>
      <textarea name="message" id="message" ></textarea>
    </p>
    <p>
      <input type="submit" name="sendit" id="sendit" value="Contact Us">      <input type="reset" name="sendit" id="sendit" value="Reset">

    </p>
  </p>
</fieldset>




</form>
</body>
</html>