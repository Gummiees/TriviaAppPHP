<?php 

$page_title = 'Register';
include ('includes/header.html');

//

?>
<div class="container ">
    <div class="row justify-content-center">
        <div class="col-2">

            <h1>Register</h1>

            <form action="register.php" method="post" >
	           
                <div></div><p>Nick: <input type="text" name="nick" size="15" maxlength="20" value="<?php if (isset($_POST['first_name'])) echo $_POST['first_name']; ?>" /></p>
	           <p>Email Address: <input type="text" name="email" size="20" maxlength="60" value="<?php if (isset($_POST['email'])) echo $_POST['email']; ?>"  /> </p>
	           <p>Password: <input type="password" name="pass1" size="10" maxlength="20" value="<?php if (isset($_POST['pass1'])) echo $_POST['pass1']; ?>"  /></p>
	           <p>Confirm Password: <input type="password" name="pass2" size="10" maxlength="20" value="<?php if (isset($_POST['pass2'])) echo $_POST['pass2']; ?>"  /></p>
	           <p><input type="submit" name="submit" value="Register" /></p>
            </form>
        </div>
    </div>
</div>
<?php include ('includes/footer.html'); ?>