<!DOCTYPE html>

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Mailer Application</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/shoelace-css/1.0.0-beta16/shoelace.css">
        <link rel="stylesheet" href="styles.css">

    </head>
	

<?php
 if(isset($_POST['read-btn']))//表单已经被提交过
 {
    $from = '935953068@qq.com';
    $subject = $_POST['note-textarea-object'];
    $text = $_POST['note-textarea'];
    $output_form = false;
	$tag = $_POST['tag'];
	$single = $_POST['note-textarea-email'];
	
	
	 if(empty($subject) || empty($text)) //提交的表单是有部分是空的，需要重写填写并且保留填写的部分
	 {
		 echo '请填写完整！';
		 $output_form = true;
		 
	 }
 }
  else{ //第一次填写表单
         $output_form = true;
  }
  
  
  
 if(!empty($_POST['note-textarea'])&&!empty($_POST['note-textarea-object'])&& !empty($_POST['tag']))
  {
    require("../phpmailer/PHPMailer.php");

    require("../phpmailer/SMTP.php");

    session_start();
	
	$dbc = mysqli_connect('localhost', 'root', 'root', 'elvis_store');
	$query = "SELECT * FROM email_list";
	$result = mysqli_query($dbc,$query) or die('Error querying database.');
	
	$mail = new PHPMailer\PHPMailer\PHPMailer();
	$sendmail = '935953068@qq.com'; //发件人邮箱
	$sendmailpswd = "ykwqtcdqybeubbbj"; //客户端授权密码,而不是邮箱的登录密码，就是手机发送短信之后弹出来的一长串的密码


    $send_name = 'yicheng';// 设置发件人信息，如邮件格式说明中的发件人，
	$mail->isSMTP();// 使用SMTP服务

    $mail->CharSet = "utf8";// 编码格式为utf8，不设置编码的话，中文会出现乱码

    $mail->Host = "smtp.qq.com";// 发送方的SMTP服务器地址

    $mail->SMTPAuth = true;// 是否使用身份验证
	$mail->SMTPSecure = "ssl";// 使用ssl协议方式

    $mail->Port = 465;//  qq端口465或587）
	
	$mail->setFrom($sendmail, $send_name);// 设置发件人信息，如邮件格式说明中的发件人
	
	if(!empty($_POST['note-textarea-email']))
	{
		$mail->Username = $sendmail;//// 发送方的
		$text = $_POST['note-textarea'];
		$toemail = $_POST['note-textarea-email'];
		$mail->Password = $sendmailpswd;//客户端授权密码,而不是邮箱的登录密码！
		$mail->Subject = $_POST['note-textarea-object'];  //"这里是邮件标题";// 邮件标题
		$mail->addAddress($toemail, "先生");// 设置收件人信息，如邮件格式说明中的收件人，
		$mail->addReplyTo($sendmail, $send_name);// 设置回复人信息，指的是收件人收到邮件后，如果要回复，回复邮件将发送到的邮箱地址
		
		$mail->Body = "这是一个测试代码:如果非本人操作无需理会！/n 正文如下:$text";// 邮件正文	
		
		if (!$mail->send()) { 
		// 发送邮件
        echo "倒霉蛋，Message could not be sent.";
        //echo "错误原因告诉你吧：Mailer Error: " . $mail->ErrorInfo;// 输出错误信息
		
       }else {
        echo "不可思议，你的邮件竟然发出去了";
       }	
	 
	mysqli_close($dbc);
		
	}
	
  else{	
		
	while($row = mysqli_fetch_array($result))
	{
		$first_name = $row['first_name'];
		$last_name = $row['last_name'];
		$toemail = $row['email'];
		$text = $_POST['note-textarea'];
	
    $to_name = "$first_name $last_name";   //'hl';//设置收件人信息，如邮件格式说明中的收件人

    $mail->Username = $sendmail;//// 发送方的

    $mail->Password = $sendmailpswd;//客户端授权密码,而不是邮箱的登录密码！

    $mail->addAddress($toemail, $to_name);// 设置收件人信息，如邮件格式说明中的收件人，

    $mail->addReplyTo($sendmail, $send_name);// 设置回复人信息，指的是收件人收到邮件后，如果要回复，回复邮件将发送到的邮箱地址

    $mail->Subject = $_POST['note-textarea-object'];  //"这里是邮件标题";// 邮件标题



    $mail->Body = "$first_name 这是一个测试邮件！/n 正文如下:$text";// 邮件正文


    if (!$mail->send()) { // 发送邮件

        echo "倒霉蛋，Message could not be sent.";

    } else {
        echo "不可思议，你的邮件竟然发出去了";
    }	
	 }
	mysqli_close($dbc);
  }
  }
  
  if ($output_form) {
	  if(empty($subject) )//必要的初始化
	  {$subject='';}
      if(empty($text))//必要的初始化
	  {$text='';}
	  if(empty($tag))//必要的初始化
	  {$tag='';}
	  
?>
    <body>
	
     <img src="email.png" width="300px"; height="260px"; style="position:absolute; left:70px; top:100px; ">
        <div class="container">

            <h1>Mailer</h1>
            <p class="page-description">Mailer 你的邮箱好助手</p>

            <h3 class="no-browser-support">您的浏览器不支持Web Speech API，请使用Chrome浏览器打开此应用。</h3>


        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>"> 
            <div class="app"> 
                <h3>信件内容编辑栏</h3>
                <div class="input-single">
				    <textarea id="note-textarea-email" name="note-textarea-email" placeholder="请输入对方邮箱账号,多人邮件发送请勿编辑该栏..." rows="1" ></textarea>			
				    <textarea id="note-textarea-object" name="note-textarea-object" placeholder="请输入信件主题..." rows="2" ><?php echo $subject; ?></textarea>
                    <textarea id="note-textarea" name="note-textarea" placeholder="通过语音或者键盘来输入信件内容..." rows="10"><?php echo $text; ?></textarea>				
					<textarea id="tag" name="tag"  placeholder="欢迎使用Maier！" rows="1" readonly  ><?php echo $tag; ?></textarea>					
                </div>         
                <button   type="button"id="start-record-btn" title="Start Recording" style="background:#2894FF">开始语音输入</button>
                <button   type="button" id="pause-record-btn" title="Pause Recording" style="background:#2894FF">暂停识别</button>
                <button   id="save-note-btn" title="Save email" style="background:#2894FF">保存记录</button>   
				<button   type="button" id="read-btn" title="Read email" style="background:#2894FF">读取内容</button><br/><br/>
				<button   id="send-btn" title="Send email" onClick="compute()" style="background:#2894FF" >发送邮件</button>
				<button   type="button" id="edit-targets" title="edit-targets" onclick="window.open('removeemail.php')" style="background:#2894FF" >编辑群发</button>
				<button   type="button" id="add-targets" title="add-targets" onclick="window.open('addemail.php')" style="background:#2894FF">添加对象</button>
				
				<input id="range" type="range" min="1" max="10" value="1"step="1" οninput="change()" οnchange="change()">
				<span id="value">语速调节</span>
				
		<script type='text/javascript'>
			function change() {
  				var value = document.getElementById('range').value ;
			}
		</script>

				
				
				<script type="text/jscript">
                 function compute(){
                document.getElementById("tag").value="欢迎使用Maier！";
                 }
                </script>		
				 							
                <p id="recording-instructions">按下 <strong>开始识别语音</strong> 按钮并按提示给予相关权限。</p>
                
                <h3>历史记录</h3>
                <ul id="notes">
                    <li>
                        <p class="no-notes">暂无记录</p>
                    </li>
                </ul>

            </div>

        </div>
       </form>
	   

		
	   <?php
  }
?>

	    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="script.js"></script>

    </body>
</html>