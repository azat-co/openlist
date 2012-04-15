<div id="ad-send-message-box">	
	<div id="openform-button-box">
		<?php include 'ad_view_send_message_link.tpl.php';?>
	</div>
	<div id="form-box" class="hide">			
		<h4><?php echo LANG_AD_SM_HEADER?></h4>
		<div id="ad-send-message-output-box">
		</div>
		<form action="<?php echo SITE_URL; ?>ad_send_message.php" method="post" name="send_message" onsubmit="document.getElementById('sendmessagebtn').click();return false;">
			<input type="hidden" value="submit" name="action"/>
			<input type="hidden" value="<?php echo  $this->eprint($this->ad['id'])?>" name="ad_id"/>
			<table>
				<tr>
					<td class="label">
						<?php echo LANG_AD_SM_TEXT?><span class="req-star">*</span>:
					</td>
					<td>
						<textarea name="text" title="<?php echo LANG_AD_SM_TEXT_TITLE?>" cols="60" rows="7"></textarea>
					</td>				
				</tr>		
				<tr>
					<td class="label">
						<?php echo LANG_AD_SM_EMAIL?>:
					</td>
					<td>
						<input type="text" name="email" value="" title="<?php echo LANG_AD_SM_EMAIL_TITLE?>"/>
					</td>
				</tr>
			
				<tr>
					<td colspan="2">
					</td>
				</tr>
				<tr>		
				<tr>
					<td class="label"><?php echo LANG_POST_CODE?>:</td>
					<td>
						<?php include 'captcha.tpl.php'; ?>
					</td>		
				</tr>
				<tr>
					<td class="label"><?php echo LANG_POST_TYPE_CODE?><span class="req-star">*</span>: </td>
					<td ><input type="text" name="captcha_code" class="code"/></td></tr>
				<tr>
					<td></td>
					
					<td class="submit"><input id="sendmessagebtn" type="button" name="send" value="<?php echo LANG_POST_SUBMIT?>" /></td></tr>

			</table>		
		</form>
	</div> <!--id=form-->
	<div id="ad-send-message-success-box" class="hide">
		<?php echo LANG_YOUR_MESSAGE_WAS_SENT; ?> <br/>
		<a href="#" id="send-one-more-message"><?php echo LANG_SEND_ONE_MORE_MSG;?></a>
	</div>
	<script type="text/javascript" language="javascript" src="<?php echo SITE_URL; ?>js/ad_send_message.js"></script>
</div>