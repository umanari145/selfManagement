<table border="1">
{foreach from=$arrMember item=member}
	<tr>
    <td>{$member['member_id']}</td>
    <td>{$member['family_name']}</td>
    <td><a href="{$smarty.const.URL}{$controller}/view/{$member['member_id']}" >詳細を見る</a></td>
    <td><a href="{$smarty.const.URL}{$controller}/edit/{$member['member_id']}" >編集する</a></td>
    </tr>
{/foreach}
{include file="pager.tpl"}
</table>
