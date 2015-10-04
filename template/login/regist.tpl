<form name="form1" id="form1"  class="form-horizontal" action="" method="POST" >
<input type="hidden" id="method" name="method" value="regist">
<input type="hidden" id="mode" name="mode" value="">
<!--新規はここがないが既存の修正はidを持っている-->
{assign var=key value="member_id"}
{if isset($arrForm[$key]['value'])}
<input type="hidden" id="member_id" name="member_id" value="{$arrForm[$key]['value']}">
{/if}


    {assign var=key value="family_name"}
    <dt>   
    {$arrForm[$key]['disp_name']}{if isset($arrErr[$key]) }<span class="attention">{$arrErr[$key]}</span>{/if}
   	</dt>
   	<dd>
   	<input class="short" type="text" id="{$key}"  name="{$key}" value="{$arrForm[$key]['value']}" />
    </dd>
    
    {assign var=key value="first_name"}
	<dt> 
    {$arrForm[$key]['disp_name']}{if isset($arrErr[$key])}<span class="attention">{$arrErr[$key]}</span>{/if}
	   	</dt>
   	<dd>
	<input class="short" type="text" id="{$key}" name="{$key}" value="{$arrForm[$key]['value']}" />
    </dd>

    {assign var=key value="sex"}
	   <dt> 
	{$arrForm[$key]['disp_name']}{if isset($arrErr[$key]) }<span class="attention">{$arrErr[$key]}</span>{/if}
	   	</dt>
   	<dd>
	{html_radios name="{$key}"  options=$arrSex selected={$arrForm[$key]['value']} separator='<br />'}
	    </dd>
	    
        {assign var=key1 value="birth_year"}
        {assign var=key2 value="birth_month"}
        {assign var=key3 value="birth_day"}
        <dt>
        {$arrForm[$key3]['disp_name']}{if isset($arrErr[$key1]) }<span class="attention">{$arrErr[$key1]}</span>{/if}
        </dt>
        <dd>
        <select name="{$key1}" id="{$key1}" >
        {html_options options=$arrYear selected=$arrForm[$key1]['value']}  
        </select>年
        <select name="{$key2}" id="{$key2}">
        {html_options options=$arrMonth selected=$arrForm[$key2]['value']}  
        </select>月
        <select name="{$key3}" id="{$key3}">
        {html_options options=$arrDay selected=$arrForm[$key3]['value']}  
        </select>日
    </dd>

    {assign var=key1 value="zip1"}
    {assign var=key2 value="zip2"}
	   <dt> 
	   {$arrForm[$key1]['disp_name']}
      {if isset($arrErr[$key1])}<span class="attention">{$arrErr[$key1]}</span>{/if}
      {if isset($arrErr[$key2])}<span class="attention">{$arrErr[$key2]}</span>{/if}
       	</dt>
   	<dd>
	<input type="text" id="{$key1}" class="mini zip" name="{$key1}" value="{$arrForm[$key1]['value']}" />-<input type="text" id="{$key2}" class="mini zip" name="{$key2}" value="{$arrForm[$key2]['value']}" />
	    </dd>
	    
    {assign var=key1 value="address1"}
    {assign var=key2 value="address2"}
	   <dt> {$arrForm[$key1]['disp_name']} {if isset($arrErr[$key1]) }<span class="attention">{$arrErr[$key1]}</span>{/if}
	   	</dt>
   	<dd>
     <input type="text" id="{$key1}" class="long" name="{$key1}" value="{$arrForm[$key1]['value']}" />
        </dd>
     
	   <dt> {$arrForm[$key2]['disp_name']}
	   	</dt>
   	<dd>
     <input type="text" id="{$key2}" class="long" name="{$key2}" value="{$arrForm[$key2]['value']}" /> 
        </dd>

    {assign var=key value="skill_language"}
	 <dt> 
	   {$arrForm[$key]['disp_name']} {if isset($arrErr[$key]) }<span class="attention">{$arrErr[$key]}</span>{/if}
	   	</dt>
   	<dd>
	{html_checkboxes name=$key options=$arrLanguage checked=$arrForm[$key]['value'] separator="<br />"}
    </dd>
</dl>


<input type="button" name="send" value="一覧に戻る" class="btn btn-success submit_button" id="index_button" />
<input type="button" name="send" value="登録する" class="btn btn-success submit_button" id="confirm_button" />

</form>
