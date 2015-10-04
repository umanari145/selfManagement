<table border="1">
{foreach from=$arrDailyReports item=dailyReports}
	<tr>
    <td>{$dailyReports.member_id}</td>
    <td>{$dailyReportsr.family_name}</td>
    <td><a href="{$smarty.const.URL}{$controller}/view/{$member.member_id}" >詳細を見る</a></td>
    <td><a href="{$smarty.const.URL}{$controller}/edit/{$member.member_id}" >編集する</a></td>
    </tr>
{/foreach}
</table>
