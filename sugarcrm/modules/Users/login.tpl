<!--
/*********************************************************************************
 * SugarCRM is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2010 SugarCRM Inc.
 * 
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation with the addition of the following permission added
 * to Section 15 as permitted in Section 7(a): FOR ANY PART OF THE COVERED WORK
 * IN WHICH THE COPYRIGHT IS OWNED BY SUGARCRM, SUGARCRM DISCLAIMS THE WARRANTY
 * OF NON INFRINGEMENT OF THIRD PARTY RIGHTS.
 * 
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE.  See the GNU Affero General Public License for more
 * details.
 * 
 * You should have received a copy of the GNU Affero General Public License along with
 * this program; if not, see http://www.gnu.org/licenses or write to the Free
 * Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA
 * 02110-1301 USA.
 * 
 * You can contact SugarCRM, Inc. headquarters at 10050 North Wolfe Road,
 * SW2-130, Cupertino, CA 95014, USA. or at email address contact@sugarcrm.com.
 * 
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU Affero General Public License version 3.
 * 
 * In accordance with Section 7(b) of the GNU Affero General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the "Powered by
 * SugarCRM" logo. If the display of the logo is not reasonably feasible for
 * technical reasons, the Appropriate Legal Notices must display the words
 * "Powered by SugarCRM".
 ********************************************************************************/
/*********************************************************************************

 ********************************************************************************/
-->
<script type='text/javascript'>
var LBL_LOGIN_SUBMIT = '{$MOD.LBL_LOGIN_SUBMIT}';
var LBL_REQUEST_SUBMIT = '{$MOD.LBL_REQUEST_SUBMIT}';
</script>
<table cellpadding="0" align="center" width="100%" cellspacing="0" border="0">
	<tr>
		<td align="center">
		<div class="dashletPanelMenu" style="width: 460px;">
		<div class="hd"><div class="tl"></div><div class="hd-center"></div><div class="tr"></div></div>
		<div class="bd">	
		<div class="ml"></div>
		<div class="bd-center">
			<div class="loginBox">
			<table cellpadding="0" cellspacing="0" border="0" align="center">
				<tr>
					<td align="left"><b>{$MOD.LBL_LOGIN_WELCOME_TO}</b><br>
						<IMG src="include/images/sugar_md_open.png" alt="Sugar" width="340" height="25" style="margin: 5px 0;">
					</td>
				</tr>
				<tr>
					<td align="center">
						<div class="login">
							<form action="index.php" method="post" name="DetailView" id="form" onsubmit="return document.getElementById('cant_login').value == ''">
								<table cellpadding="0" cellspacing="2" border="0" align="center" width="100%">
									{if $LOGIN_ERROR !=''}
									<tr>
										<td scope="row" colspan="2"><span class="error">{$LOGIN_ERROR}</span></td>
						    	{if $WAITING_ERROR !=''}
							        <tr>
							            <td scope="row" colspan="2"><span class="error">{$WAITING_ERROR}</span></td>
									</tr>
								{/if}
									</tr>
								{else}
									<tr>
										<td scope="row" width='1%'></td>
										<td scope="row"><span id='post_error' class="error"></span></td>
									</tr>
								{/if}
									<tr>
										<td scope="row" colspan="2" width="100%" style="font-size: 12px; font-weight: normal; padding-bottom: 4px;">{$APP.NTC_LOGIN_MESSAGE}
										<input type="hidden" name="module" value="Users">
										<input type="hidden" name="action" value="Authenticate">
										<input type="hidden" name="return_module" value="Users">
										<input type="hidden" name="return_action" value="Login">
										<input type="hidden" id="cant_login" name="cant_login" value="">
										<input type="hidden" name="login_module" value="{$LOGIN_MODULE}">
										<input type="hidden" name="login_action" value="{$LOGIN_ACTION}">
										<input type="hidden" name="login_record" value="{$LOGIN_RECORD}">
										</td>
									</tr>
									<tr>
										<td scope="row" width="30%">{$MOD.LBL_USER_NAME}:</td>
										<td width="70%"><input type="text" size='35' tabindex="1" id="user_name" name="user_name"  value='{$LOGIN_USER_NAME}'</td>
									</tr>
									<tr>
										<td scope="row">{$MOD.LBL_PASSWORD}:</td>
										<td width="30%"><input type="password" size='26' tabindex="2" id="user_password" name="user_password" value=''</td>
									</tr>
									{if !empty($SELECT_LANGUAGE)}
									<tr>
										<td colspan="2" class="login_more"><div  style="cursor: hand; cursor: pointer; display:{$LOGIN_DISPLAY}" onclick='toggleDisplay("more");'><IMG src="index.php?entryPoint=getImage&themeName='+SUGAR.themes.theme_name+'&imageName=advanced_search.gif" border="0" alt="Hide Options" id="more_options">&nbsp;<a href='javascript:void(0)'>{$MOD.LBL_LOGIN_OPTIONS}</a></div>
											<div id='more' style='display: none'>
												<table cellpadding="0" cellspacing="2" border="0" align="center" width="100%">
												    <tr>
														<td scope="row">{$MOD.LBL_LANGUAGE}</td>
														<td><select style='width: 152px' name='login_language'>{$SELECT_LANGUAGE}</select></td>
													</tr>
												</table>
											</div>
										</td>
									</tr>
									{/if}
									<tr>
										<td>&nbsp;</td>
										<td><input title="{$MOD.LBL_LOGIN_BUTTON_TITLE}" accessKey="{$MOD.LBL_LOGIN_BUTTON_TITLE}" class="button primary" type="submit" tabindex="3" id="login_button" name="Login" value="{$MOD.LBL_LOGIN_BUTTON_LABEL}"><br>&nbsp;</td>		
									</tr>
								</table>
							</form>
							<form action="index.php" method="post" name="fp_form" id="fp_form" >
								<table cellpadding="0" cellspacing="2" border="0" align="center" width="100%">
									<tr>
										<td colspan="2" class="login_more">
										<div  style="cursor: hand; cursor: pointer; display:{$DISPLAY_FORGOT_PASSWORD_FEATURE};" onclick='toggleDisplay("forgot_password_dialog");'>
											<IMG src="index.php?entryPoint=getImage&themeName='+SUGAR.themes.theme_name+'&imageName=advanced_search.gif" border="0" alt="Hide Options" id="forgot_password_dialog_options">
											<a href='javascript:void(0)'>{$MOD.LBL_LOGIN_FORGOT_PASSWORD}</a>
										</div>
											<div id="forgot_password_dialog" style="display:none" > 
												<input type="hidden" name="entryPoint" value="GeneratePassword">
												<table cellpadding="0" cellspacing="2" border="0" align="center" width="100%" >
													<tr>
														<td colspan="2">
															<div id="generate_success" class='error' style="display:inline;"> </div>
														</td>
													</tr>
													<tr>
														<td scope="row" width="30%">{$MOD.LBL_USER_NAME}:</td>
														<td width="70%"><input type="text" size='26' id="fp_user_name" name="fp_user_name"  value='{$LOGIN_USER_NAME}'</td>
													</tr>
													<tr>
											            <td scope="row" width="30%">{$MOD.LBL_EMAIL}:</td>
											            <td width="70%"><input type="text" size='26' id="fp_user_mail" name="fp_user_mail"  value='' ></td>
											     	</tr>
													{$CAPTCHA}
													<tr>
													    <td scope="row" width="30%"><div id='wait_pwd_generation'></div></td>
														<td width="70%"><input title="Email Temp Password" class="button" type="button" style="display:inline" onclick="validateAndSubmit(); return document.getElementById('cant_login').value == ''" id="generate_pwd_button" name="fp_login" value="{$MOD.LBL_LOGIN_SUBMIT}"></td>		
													</tr>
												</table>
											</div>
										</td>
									</tr>
								</table>
							</form>
						</div>
						
						
					</td>
				</tr>
			</table>
			</div>
			</div>
			<div class="mr"></div>
			</div>
<div class="ft"><div class="bl"></div><div class="ft-center"></div><div class="br"></div></div>
</div>
		</td>
	</tr>
</table>
<br>
<br>