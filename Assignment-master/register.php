<html>
<head>
	<title>Register</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/bootstrap.min.css">
  	<script src="js/bootstrap.min.js"></script>
	<style>
	.error{color:red;} <!--Defining red color for this class-->
	</style>
</head>

<body class="container">
<br>
<a href="index.php"><span class="btn btn-primary">Home</span></a> <br />

<?php
	$idErr=$nameErr = $fullnameErr = $emailErr = $genderErr = $phoneErr = $cpassErr ="";
	$passErr="Password Length minimum 6";
	$aiubid = $fullname = $email = $gender = $phone = $showphone = $password = $cpassword = "";
	$fid=$fname=$femail=$fphone=$fpassword=$fcpassword=0;
include("config.php");
//connect to db here
if(isset($_POST["submit"]))
{

	function test_input($data) 
	{
	  $data = trim($data);
	  return $data;
	}
	if (empty($_POST["aiubid"])) {
    $idErr = "ID is required";
  } else {
    $aiubid = test_input($_POST["aiubid"]);
	$fid=1;
    if (!preg_match("^\d{2}-\d{5}-\d{1}^",$aiubid)) {
		$fid=0;
        $idErr = "Enter Id Formate";
		}
	  }
	if (empty($_POST["fullname"])) {
    $fullnameErr = "FullName is required";
	} 
	else 
	{
		$fullname = test_input($_POST["fullname"]);
		$fname=1;
		if (!preg_match("/^[a-zA-Z ]*$/",$fullname)) {
			$fname=0;
		    $fullnameErr = "Only letters and white space allowed";
		}
	}
	if (empty($_POST["email"])) {
    $emailErr = "Email is required";
	} 
	else 
	{
		$email = test_input($_POST["email"]);
		$femail=1;
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$femail=0;
			$emailErr = "Invalid email format";
    }
	}
	if (empty($_POST["phone"])) 
	{
    $phoneErr = "Phone Number is required";
    } 
	else 
	{
    $phone = test_input($_POST["phone"]);
	$fphone=1;
    if (!preg_match("/^[0-9]/", $phone)) {
		$fphone=0;
      $phoneErr = "Invalid phone number";
    }
	if (preg_match("/^[0-9]/", $phone) && strlen($phone)!=11) {
		$fphone=0;
      $phoneErr = "Phone Number should 11 digit";
    }
	}
	if (empty($_POST["password"])) {
    $passErr = "Password is required";
  } else {
	  $passErr="";
	  $fpassword=1;
    $password = test_input($_POST["password"]);
    if (!preg_match("/^[a-zA-Z0-9]{6}/", $password)) {
	  $fpassword=0;
      $passErr = "password is too short";
    }
  }
  if (empty($_POST["cpassword"])) {
    $cpassErr = "Confirm Password is required";
  } else {
	  $fcpassword=1;
    $cpassword = test_input($_POST["cpassword"]);
    if ($cpassword!=$password) {
	  $fcpassword=0;
      $cpassErr = "password does not matched";
    }
  }
}
if($fid==1 && $fname==1 && $femail==1 && $fphone==1 && $femail==1 && $fpassword==1 && $fcpassword==1)
	{
		mysqli_query($conn,"INSERT INTO user(aiubid,fullname,email,phone,password) VALUES('$aiubid','$fullname','$email','$phone', md5('$password'))")
			or die("Could not execute the insert query.");
			
		echo "<hr><div class='alert alert-success'>Registration successfully done. Click Home for login Now</div>";
		echo "<br/><hr>";
		
	}
else
{	
?>

	<center><h2>New User Registration</h2><hr></center>
	<form name="form1" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
		<table class="table table-striped table-bordered table-condensed">
            <tr>
                <td>AIUB ID</td>
                <td>
				<input type="text" name="aiubid"  value="<?php echo $aiubid;?>" class="form-control">
				<span class="error">* <?php echo $idErr;?></span>
				</td>
            </tr>
            <tr>
                <td>Full Name</td>
                <td>
				<input type="text" name="fullname" value="<?php echo $fullname;?>" class="form-control">
				<span class="error">* <?php echo $fullnameErr;?></span>
				</td>
            </tr>
            <tr>
				<td>Email</td>
				<td>
				<input type="text" name="email" value="<?php echo $email;?>" class="form-control">
				<span class="error">* <?php echo $emailErr;?></span>
				</td>
			</tr>
            <tr>
                <td>Phone Number</td>
                <td>
				<input type="text" name="phone" value="<?php echo $phone;?>" class="form-control">
				<span class="error">* <?php echo $phoneErr;?></span>
				</td>
            </tr>
			<tr> 
				<td>Password</td>
				<td>
				<input type="password" name="password" value="<?php echo $password;?>" class="form-control">
				<span class="error">*<?php echo $passErr;?></span>
				</td>
			</tr>
			<tr> 
				<td>Confirm Password</td>
				<td>
				<input type="password" name="cpassword" value="<?php echo $cpassword;?>" class="form-control">
				<span class="error">* <?php echo $cpassErr;?></span>
				</td>
			</tr>
			<tr>
            <td colspan="2"><br></td>
            </tr>
            <tr> 
				
				<td colspan="2"><input type="submit" class="btn btn-success btn-block btn-lg" name="submit" value="Register"></td>
			</tr>
		</table>
	</form>
	<?php
	}
	?>
</body>
</html>