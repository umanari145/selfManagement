
<dl>
	
    <p>{$memberDetail['family_name']}</p>
    <p>{$memberDetail['first_name']}</p>
    <p>{$memberDetail['birth_day']|date_format:"%Y/%m/%d"}</p>
    <p>{$arrSex[$memberDetail['sex']]}</p>
    <p>{$memberDetail['zip1']}-{$memberDetail['zip2']}</p>
    <p>{$memberDetail['address1']}</p>
    <p>{$memberDetail['address2']}</p>
    <p>
    {foreach from=$memberDetail['skill_language'] item=val}
    {$arrLanguage[$val]}
    </p>
    {/foreach}
</dl>
