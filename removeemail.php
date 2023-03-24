<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
 >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Mailer - Remove Email</title>
  <link rel="stylesheet" href="shoelace.css">
  <link rel="stylesheet" href="styles.css">
</head>

<body >

<div class="container">

            <h1>Mailer</h1>
            <p class="page-description">Mailer 你的邮箱好助手</p>	
            <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>"> 
			
   <div class="app"> 
                <h3 >群发对象编辑栏</h3>
    <div class="input-single">
  

  <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">


<?php
  $dbc = mysqli_connect('localhost', 'root', 'root', 'elvis_store')
    or die('Error connecting to MySQL server.');

  // Delete the customer rows (only if the form has been submitted)
  if (isset($_POST['submit'])) {
	  foreach($_POST['todelete'] as $delete_id)
	  {
		  $query = "DELETE FROM email_list WHERE id = $delete_id";
		  mysqli_query($dbc,$query)
		    or die('Error querying database.');
	  }
       

    echo 'Customer(s) removed.<br />';
  }

  // Display the customer rows with checkboxes for deleting
  $query = "SELECT * FROM email_list";
  $result = mysqli_query($dbc, $query);
  while ($row = mysqli_fetch_array($result)) {
	echo '<br />';
    echo '<input type="checkbox" value="' . $row['id'] . '" name="todelete[]"  style="vertical-align:middle;"/>';
    echo ' '. $row['first_name'];
    echo ' '. $row['last_name'] ;
    echo ' ' . $row['email'];
    echo '<br />';

  }

  mysqli_close($dbc);
?>
  <br />
  <br />
  <button type="submit" name="submit"  style="background:#2894FF">删除对象</button>  
    </div>
 </div>
 </form>
   
  
</body>
</html>
