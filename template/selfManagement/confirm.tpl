<form name="form1" id="form1"  class="form-horizontal" action="" method="POST" >
<input type="hidden" id="method" name="method" value="regist">
<input type="hidden" id="mode" name="mode" value="">

{include file="{$controller}/view.tpl"}

{foreach from=$arrForm item=val}
{if is_array($val['value']) !== true}
    <input type="hidden" name="{$val['keyname']}" value="{$val['value']}">
{else}
{foreach from=$val['value'] item=val2}
    <input type="hidden" name="{$val['keyname']}[]" value="{$val2['value']}">
{/foreach}
{/if}
{/foreach}
<input type="button" name="send" value="戻る" class="btn btn-success submit_button" id="back_button" />
<input type="button" name="send" value="登録する" class="btn btn-success submit_button" id="complete_button" />

</form>
