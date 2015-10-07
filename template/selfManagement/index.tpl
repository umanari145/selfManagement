<table border="1">
{foreach from=$arrDailyReports item=dailyReports}
	<tr>
    <td><a href="{$smarty.const.URL}{$controller}/edit/{$dailyReports.id}" >{$dailyReports.report_date}</a></td>
    </tr>
{/foreach}
</table>
