<form method="POST" action="" name-"form1" id="form1" >
<input type="hidden" id="method" name="method" value="">
<input type="hidden" id="mode" name="mode" value="">
<dl>
	{assign var=key value="user_id"}
    <dt>{$arrForm[$key]['disp_name']}</dt>
	<dd>
		<input type="text" name="{$key}" value="{$arrForm[$key]['value']}" >
    </dd>
	
    {assign var=key value="password"}
    <dt>{$arrForm[$key]['disp_name']}</dt>
	<dd>
		<input type="text" name="{$key}" value="{$arrForm[$key]['value']}" >
    </dd>
</dl>

<input type="button" name="send" value="ログインする" class="btn btn-success submit_button" id="confirm_button" />
<input type="button" name="send" value="新規登録する" class="btn btn-success submit_button" id="regist_button" />
</form>
