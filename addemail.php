<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>

  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Mailer - Add Email</title>
  
  <link rel="stylesheet" href="shoelace.css">
  <link rel="stylesheet" href="styles.css">
</head>
<body>



  <?php
  
  if(isset($_POST['submit']))
  {
  $first_name = $_POST['firstname'];
  $last_name = $_POST['lastname'];
  $email = $_POST['email'];
  if(!empty($first_name)&&!empty($last_name)&&!empty($email)){
	  
  $dbc = mysqli_connect('localhost','root','root','elvis_store')
  or die("Error connecting to MYSQL sever");
  
	  
  $query = "INSERT INTO email_list(first_name,last_name,email)".
  "VALUES('$first_name','$last_name','$email')";
  
  mysqli_query($dbc,$query)
  or die("Error querying database");
  
  echo 'Customer added.';
  
  mysqli_close($dbc);
  }
	}
  else{
	 
	  if(empty($first_name) )//必要的初始化
	  {$first_name='';}
      if(empty($last_name))//必要的初始化
	  {$last_name='';}
	  if(empty($email))//必要的初始化
	  {$email='';}	  
  }
  ?>
  
    <div class="container">

            <h1>Mailer</h1>
            <p class="page-description">Mailer 你的邮箱好助手</p>
			
            <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>"> 
			
   <div class="app"> 
                <h3 >群发对象添加栏</h3>
    <div class="input-single">
  

    <label for="firstname" id="lablef">First name:</label>
	<textarea id="firstname" name="firstname"  placeholder="请输入对方firstname..." rows="2"   ></textarea>	
    <label for="lastname">Last name:</label>
	<textarea id="lastname" name="lastname"  placeholder="请输入对方lastname..." rows="2"   ></textarea>	
    <label for="email">Email:</label>
	<textarea id="email" name="email"  placeholder="请输入对方email..." rows="2"   ></textarea>
	</div> 
	<button type="submit" name="submit"  style="background:#2894FF">添加对象</button>


	
   </div>
  </div>
	  
	
  </form>
</body>
</html>
