<?php if(!defined('IN_DISCUZ')) exit('Access Denied'); if(CURMODULE != 'logging') { ?>
<script src="<?php echo $_G['setting']['jspath'];?>logging.js?<?php echo VERHASH;?>" type="text/javascript"></script>

<form class="form-inline" method="post" autocomplete="off" id="lsform" action="member.php?mod=logging&amp;action=login&amp;loginsubmit=yes&amp;infloat=yes&amp;lssubmit=yes" onsubmit="<?php if($_G['setting']['pwdsafety']) { ?>pwmd5('ls_password');<?php } ?>return lsSubmit();">

<div class="fastlg cl">
<span id="return_ls" style="display:none"></span>

<div align="center">

<table cellspacing="0" cellpadding="0">
<tr>
<?php if(!$_G['setting']['autoidselect']) { ?>
<td>
<span>
<select name="fastloginfield" id="ls_fastloginfield" width="90" tabindex="900">
<option value="username"><h6>用户名</h6></option>
<?php if(getglobal('setting/uidlogin')) { ?>
<option value="uid"><h6>UID</h6></option>
<?php } ?>
<option value="email"><h6>Email</h6></option>
</select>
</span>
<script type="text/javascript">simulateSelect('ls_fastloginfield')</script>
</td>

<td><input type="text" name="username" id="ls_username" autocomplete="off" class="input-small" tabindex="901" /></td>

<?php } else { ?>

<td><label for="ls_username">帐号</label></td>

<td><input type="text" name="username" id="ls_username" class="px vm xg1" <?php if($_G['setting']['autoidselect']) { ?> value="<?php if(getglobal('setting/uidlogin')) { ?>UID/<?php } ?>用户名/Email" onfocus="if(this.value == '<?php if(getglobal('setting/uidlogin')) { ?>UID/<?php } ?>用户名/Email'){this.value = '';this.className = 'px vm';}" onblur="if(this.value == ''){this.value = '<?php if(getglobal('setting/uidlogin')) { ?>UID/<?php } ?>用户名/Email';this.className = 'px vm xg1';}"<?php } ?> tabindex="901" />
</td>

<?php } ?>

<td><label for="ls_password">密码</label></td>

<td><input type="password" name="password" id="ls_password" class="input-small" autocomplete="off" tabindex="902" /></td>


<td>
<label for="ls_cookietime" class="checkbox">
<input type="checkbox" name="cookietime" id="ls_cookietime" value="2592000" tabindex="903" />
自动登录
</label>
</td>

<td>
<button type="submit" class="btn btn-success" tabindex="904" ><strong>登录</strong></button>
</td>

<td>
<small><a href="javascript:;" onclick="showWindow('login', 'member.php?mod=logging&action=login&viewlostpw=1')">找回密码</a>
<a href="member.php?mod=<?php echo $_G['setting']['regname'];?>"><?php echo $_G['setting']['reglinkname'];?></a>
</small>
</td>

</tr>
</table>
<input type="hidden" name="quickforward" value="yes" />
<input type="hidden" name="handlekey" value="ls" />
</div>
<?php if(!empty($_G['setting']['pluginhooks']['global_login_extra'])) echo $_G['setting']['pluginhooks']['global_login_extra'];?>
</div>
</form>

<?php if($_G['setting']['pwdsafety']) { ?>
<script src="<?php echo $_G['setting']['jspath'];?>md5.js?<?php echo VERHASH;?>" type="text/javascript" reload="1"></script>
<?php } } ?>