<form name="email_friend">
	<input type="hidden" name="action" value="<?php echo (!empty($this->value_list['action']))?$this->value_list['action']:'load'; ?>" />
	<input type="hidden" name="ad_id" value="<?php echo $this->value_list['ad_id']; ?>" />
	<?php echo LANG_AD_EF_F_EMAIL;?><span class="req-star">*</span>: <input name="friend_email" value="<?php echo (!empty($this->value_list['friend_email']))?$this->value_list['friend_email']:'';?>"/> 
	<?php echo LANG_AD_EF_EMAIL;?>: <input name="user_email" value="<?php echo (!empty($this->value_list['user_email']))?$this->value_list['user_email']:'';?>"/> 
	<input type="button" name="submit" value="<?php echo LANG_AD_EF_SEND;?>"/>
</form>
<script language="javascript">
	$(document).ready(function () {
		if ($('form[name=email_friend]>input[name=friend_email]').attr('value')=='') {
			$('form[name=email_friend]>input[name=friend_email]').focus();
		}
	});
	$('#ad-email-friend-box').find('input[name=submit]').click(function() {
		$('#ad-email-friend-box').find('div#form-box').load('../ad_email_friend.php', {
			action: $('form[name=email_friend]>input[name=action]').attr('value'),
			ad_id: $('form[name=email_friend]>input[name=ad_id]').attr('value'),
			friend_email: $('form[name=email_friend]>input[name=friend_email]').attr('value'),
			user_email: $('form[name=email_friend]>input[name=user_email]').attr('value')
		});
	});
	$('form[name=email_friend]').keypress(function (e) {  
		if ((e.which && e.which == 13) || (e.keyCode && e.keyCode == 13)) {  
			e.preventDefault();
			$('#ad-email-friend-box').find('input[name=submit]').click();  			
			return false;  
		} else {  
			return true;  
		}  
	}); 
</script>