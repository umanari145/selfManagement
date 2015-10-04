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
	    
    {assign var=key1 value="address1"}
    {assign var=key2 value="address2"}
	<dt>{$arrForm[$key1]['disp_name']}</dt>
   	<dd>{$arrForm[$key1]['value']} {$arrForm[$key2]['value']} </dt>

    {assign var=key value="skill_language"}
	 <dt>{$arrForm[$key]['disp_name']}</dt>
   	<dd>
    {foreach from=$arrForm[$key]['value'] item=val}
    {$arrLanguage[$val]}
    {/foreach}
    </dd>
</dl>
