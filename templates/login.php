<?php
$pass = 'ops';
if (isset($_POST['submit'])){
	
	$password = $_POST['password'];
	
	if($password == $pass){
		if (isset($_POST['rememberme'])){
			setcookie('password', ($_POST['password']), time()+60*60*25*365);
			header('location:?action');
			}
			 else {
            /* Cookie expires when browser closes */
            setcookie('password', $_POST['password'], false);
			header('location:?action');
			}
		}
		else{
			echo 'password invalid';
			}
}else {
				echo 'supply a password';
				}