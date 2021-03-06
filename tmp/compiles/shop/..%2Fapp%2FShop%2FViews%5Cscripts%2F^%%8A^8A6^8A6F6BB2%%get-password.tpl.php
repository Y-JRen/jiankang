<?php /* Smarty version 2.6.19, created on 2014-12-11 17:09:17
         compiled from auth/get-password.tpl */ ?>


	<div class="register">
		<div class="register_title">找回密码</div>
		<ul class="findStep">
			<li>
				<div><?php if ($this->_tpl_vars['type'] == 1): ?><img src="/public/images/onStep01.png"/><?php else: ?><img src="/public/images/step01.png"/><?php endif; ?></div>
				<p>输入账号</p>
			</li>
			<li>
				<div><?php if ($this->_tpl_vars['type'] == 2): ?><img src="/public/images/onStep02.png"/><?php else: ?><img src="/public/images/step02.png"/><?php endif; ?></div>
				<p>验证身份</p>
			</li>
			<li>
				<div><?php if ($this->_tpl_vars['type'] == 3): ?><img src="/public/images/onStep03.png"/><?php else: ?><img src="/public/images/step03.png"/><?php endif; ?></div>
				<p>设置新密码</p>
			</li>
			<li>
				<div><?php if ($this->_tpl_vars['type'] == 4): ?><img src="/public/images/onStep04.png"/><?php else: ?><img src="/public/images/step04.png"/><?php endif; ?></div>
				<p>完成</p>
			</li>
			<br class="clearfix"/>
		</ul>
		
		<?php if ($this->_tpl_vars['type'] == 1): ?>
		<form action="" method="post" name="getPassword" id="getPassword" onsubmit="return submitPwdInfo();" >
			<input type='hidden' name='type' value='1' />
			<ul class="lostEnter">
				<li class="enterAccount">
					<p>输入账号</p>
					<div class=""><input class="text" name="name" id="name" type="text" /></div>
					<br class="clearfix"/>
				</li>
				<li class="enterCode">
					<p>验证码</p>
					<div class="enterCodeText"><input type="text" id="verifyCode"  name="verifyCode" maxlength="5" onkeyup="parseUpperCase(this)"/></div>
					<div class="enterCodeImg"><img src="/auth/auth-image/space/getPwd/code/<?php echo time(); ?>
" onclick="change_verify('verify_img','getPwd');" id="verify_img" /></div>
					<div class="enterCodeReset"><a href="#" onclick="change_verify('verify_img','getPwd');">换一个</a></div>
					<br class="clearfix"/>
				</li>
			</ul>
			<div class="nextBtn"><input type='submit' style='background:#990000;width:127px;height:31px;color:#fff' value='下一步' /></div>
		</form>
		<iframe src="about:blank" style="width:0px;height:0px;" frameborder="0" name="ifrmSubmit" id="ifrmSubmit"></iframe>
		<script>
			/**
			 * 处理验证码输入框的按键事件，将所有输入的内容转换为大写
			 */
			function pressVerifyCode(obj) {
				obj.value = obj.value.toUpperCase();
			}
			function submitPwdInfo() {
				var email = $.trim($('#name').val());
				var verifyCode = $.trim($('#verifyCode').val());
				var msg = '';
				if (email == '') 
					msg += '请输入您的账号!\n';
				if (verifyCode == '') 
					msg += '请输入验证码!\n';
				if (msg.length > 0) {
					alert(msg);
					return false;
				} else {
					$('#dosubmit').attr('disabled', true);
					return true;
				}
			}
		</script>
		<?php elseif ($this->_tpl_vars['type'] == 2): ?>
			<?php if ($this->_tpl_vars['status'] == 2): ?>
			<form action='' method='post' onsubmit="return submitPwdInfo();">
			<ul class="lostEnter">
				<li>验证码已发送至您的手机，请在3分钟内输入验证码</li>
				<li>验证码：<input type='text' name='code' /><input type='hidden' name='type' value=2 /></li>
				<li><input type='submit' value='确认' /></li>
			</ul>
			</form>
			<script>
			function submitPwdInfo()
			{
				var value = $("input[name='code']").val();
				if(value){
					return true;
				}else{
					alert("请填写手机验证码！");
					return false;
				}
				return false;
			}
			</script>
			<?php elseif ($this->_tpl_vars['status'] == 0): ?>
			<ul class="lostEnter">
				<li>对不起，无法找回你的密码</li>
				<li>您的帐号未绑定手机或邮箱，如需找回密码，请与客服联系</li>
			</ul>
			<?php else: ?>
			<form action='' method='post' onsubmit="return submitPwdInfo();">
				<input type='hidden' value='2' name='type'>
				<ul class="lostEnter">
					<?php if ($this->_tpl_vars['email']): ?>
					<li><input type='radio' name='set_type' value='email'/>通过邮箱找回密码</li>
					<?php endif; ?>
					<?php if ($this->_tpl_vars['mobile']): ?>
					<li><input type='radio' name='set_type' value='mobile' />通过手机找回密码</li>
					<?php endif; ?>
					<li><input type='submit' value='确定' /></li>
				</ul>
			</form>
			<script>
			function submitPwdInfo()
			{
				value = $(":radio[name='set_type']:checked").val();
				if(value){
					return true;	
				}
				alert('选择找回密码方式')
				return false;
			}
			</script>
			<?php endif; ?>
		<?php endif; ?>
	</div>
	
