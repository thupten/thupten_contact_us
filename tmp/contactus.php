<?php
defined('_JEXEC') OR defined('_VALID_MOS') OR die( "Direct Access Is Not Allowed" );
include_once('forms/captcha/thupcaptcha.class.php');

function displayForm(){ ?>
		<div class="contact-form">
		<form action=<?php echo "'".$PHP_SELF."'";?> method="post">
		Name<br/>
		<input size="31" id="name" name="name" value="<?php echo addslashes(htmlspecialchars($_REQUEST['name']));?>" /> <font style="font-size:xx-small;color:#ff0000;">Required</font><br/> 
		  	  
		Email<br/><input size="31" name="visitormail"  value="<?php echo addslashes(htmlspecialchars($_REQUEST['visitormail']));?>" /><br/><br/>
		Message<br/>
		<textarea name="notes" rows="7" cols="40">
		<?php echo addslashes(htmlspecialchars($_REQUEST['notes']));?>
		</textarea><br/><br/>
		<?php $captcha = new ThupCaptcha(); $img_path = $captcha->getRandomImage(); ?>
		Type the word below<br/>
		<img src=<?php echo "'".$img_path."'";?>/>
		<br/>
		<input id='userinput_Captcha' name='userinput_Captcha' type='text'/>
		<input id='img_path' name='img_path' type='hidden' value=<?php echo "'".$img_path."'";?>/><br/><br/>
								  
		<input name="contactsubmit" id="contactsubmit" type="submit" value=" Send"/>
		</form>
		</div>
<?php }


function displayContent(){?>
<div class="contact-content">
<h2>Contact us</h2>
	<div itemscope itemtype="http://schema.org/Organization" style="width: 264px; border: #eee 1px solid; padding: 5px;">
	Telephone: <span itemprop="telephone">(416) 492-6498</span> <br />
	Toll-Free: <span itemprop="telephone">1(866) 639-6498</span> (Outside Toronto)<br />
	Fax: <span itemprop="faxnumber">(416) 492-8464</span><br />
	Email: info@proccounting.com <br />
	Employment: hr@proccounting.com
	</div>

	<div style="width: 264px; border: #eee 1px solid; padding: 5px;margin-top:10px;">
	<p>Address:</p>
	<span itemscope itemtype="http://schema.org/Organization">
	 <span itemprop="name">Proccounting Inc.</span><br />
	</span>
	<span itemscope itemtype="http://schema.org/Address">
	 <span itemprop="street-address">250 Consumers Road, Suite 515</span><br />
	 <span itemprop="locality">Toronto</span>, <span itemprop="region">Ontario</span> <span itemprop="postal-code">M2J 4V6</span>
	</span>
	</div>
	<div class="qr">
		<img src="images/stories/qr-proccounting-contact.gif" border="0" alt="Scan this with your mobile" />
	</div>
</div>
<?php }



if (!isset($_REQUEST['contactsubmit'])){
	//dislplay form in html
	displayContent();
	displayForm();
	}
	else
	{
	@$userinput_Captcha = addslashes(htmlspecialchars($_POST['userinput_Captcha']));
	@$img_path = addslashes(htmlspecialchars($_POST['img_path']));
	@$name = addslashes(htmlspecialchars($_REQUEST['name']));
	@$email = addslashes(htmlspecialchars($_REQUEST['visitormail']));
	@$message = addslashes(htmlspecialchars($_REQUEST['notes']));
	@$messageString = '';
	
		// Validation/

		if (empty($name)) {
			$messageString .= '<li>Please enter your name name</li>';
		}
		
		if (empty($userinput_Captcha)) {
			$messageString .= '<li> Please enter the captcha. </li>';
		}else{
			$captcha1 = new ThupCaptcha();
			$captcha1->setPathToCsvFile('forms/captcha/solutions.csv');
			$captchaSuccess = $captcha1->checkCaptcha($userinput_Captcha, $img_path);
			if(!$captchaSuccess){
				$messageString .= '<li>The word in the image did not match</li>';
			}
		}
		if($messageString != ''){
		   echo ("<p style='font-size:0.8em;color:#ff0000;'>Please fix the following errors:</p><ul style='font-size:0.8em;color:#ff0000'>" . $messageString . "</ul></font>");
		   displayForm();
		}
		else
		{
		//Sending Email to form owner
		# Email to Owner
		$pfw_header = "From: $email\r\n";
		$pfw_subject = "Contact Us";
		// Change This....
		$pfw_email_to = "info@proccounting.com";
		$pfw_message = "name Name: $name\n"
		. "Email: $email\n"
		."Instruction: $message\n";
		@mail($pfw_email_to, $pfw_subject ,$pfw_message ,$pfw_header ) ;

		//Sending auto respond Email to user
		# Email to Owner
		// Change This....
		$pfw_header = "From: info@proccounting.com";
		$pfw_subject = "Proccounting Inc";
		$pfw_email_to = "$email";
		$pfw_message = "This is an automated message.\r\n Thank you for contacting us. Someone from our office will respond to you as soon as possible.\r\nRegards,\r\nProccounting Team\r\n";
		@mail($pfw_email_to, $pfw_subject ,$pfw_message ,$pfw_header ) ;

		 echo("<p><font face='Arial' size='2' >If you gave us your email, you should receive a confirmation shortly. It may have dropped into your spam or junkmail folder. Please mark as not spam otherwise we may not be able to write back to you.<br>Thank you<br><br><a href=http://www.proccounting.com>Go to Home Page</a></font></p>");
		 }
	}
	
	?>