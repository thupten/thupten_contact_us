<?php // no direct access
defined( '_JEXEC' ) or die( 'Restricted access' ); ?>
<div class="contact-form">
	<form action=<?php echo "'".$PHP_SELF."'";?> method="post">
		<div class="entry">
			<label for="name">Name</label><input id="name" name="name" placeholder="Name" /> 
			<span class="error">*</span>
		</div>
		
		<div class="entry">
			<label for="email">Email</label><input id="email" name="email" placeholder="your@email.com" /> 
			<span class="error">*</span>
		</div>
		
		<div class="entry">
			<label for="message">Message</label>
			<textarea name="notes" rows="7" cols="40"></textarea>
		</div>
		
		<div class="entry">
			<label for="userinput_Captcha">Type the following word</label>
			<img src=<?php echo "'".$img_path."'";?>/>
			<input id='userinput_Captcha' name='userinput_Captcha' type='text'/>
			<textarea name="notes" rows="7" cols="40"></textarea>
			<input id='img_path' name='img_path' type='hidden' value=<?php echo "'".$img_path."'";?>/>
		</div>
		
		<div class="entry">
			<input name="contactsubmit" id="contactsubmit" type="submit" value=" Send"/>
		</div>
	</form>
</div>