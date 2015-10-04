<form name="form1" id="form1"  class="form-horizontal" action="" method="POST" >
<input type="hidden" id="method" name="method" value="regist">
<input type="hidden" id="mode" name="mode" value="">

<dl>
    {assign var=key value="family_name"}
    <dt>{$arrForm[$key]['disp_name']}</dt>
   	<dd>{$arrForm[$key]['value']}</dd>

    {assign var=key value="first_name"}
    <dt>{$arrForm[$key]['disp_name']}</dt>
   	<dd>{$arrForm[$key]['value']}</dd>

    {assign var=key value="sex"}
    <dt>{$arrForm[$key]['disp_name']}</dt>
   	<dd>{$arrSex[$arrForm[$key]['value']]}</dd>

    {assign var=key1 value="birth_year"}
    {assign var=key2 value="birth_month"}
    {assign var=key3 value="birth_day"}
    <dt>{$arrForm[$key3]['disp_name']}</dt>
   	<dd>{$arrForm[$key1]['value']}年{$arrForm[$key2]['value']}月{$arrForm[$key3]['value']}日</dd>

    {assign var=key1 value="zip1"}
    {assign var=key2 value="zip2"}
    <dt>{$arrForm[$key1]['disp_name']}</dt>
   	<dd>{$arrForm[$key1]['value']}-{$arrForm[$key2]['value']}</dd>

    {assign var=key2 value="address1"}
    {assign var=key3 value="address2"}
    <dt>{$arrForm[$key2]['disp_name']}</dt>
   	<dd>{$arrForm[$key2]['value']}{$arrForm[$key3]['value']}</dd>
    
    {assign var=key value="skill_language"}
    <dt>{$arrForm[$key]['disp_name']}</dt>
   	<dd>
    {foreach from=$arrForm[$key]['value'] item=val }
        {$arrLanguage[$val]}
    {/foreach}
    </dd>


</dl>    
   

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
