<form name="form1" id="form1"  class="form-horizontal" action="" method="POST" >
<input type="hidden" id="method" name="method" value="regist">
<input type="hidden" id="mode" name="mode" value="">
<div class="container">
	<div class="page-header">
		<h1>テンプレート編集</h1>
	</div>
	
	<div id="container">
		<div id="main_contents">
			<table class="table  table-striped table-bordered table-hover" >
				<input type="hidden" name="id" value="{$arrForm.id.value}" />
				<tr>
					<th>日報作成日</th>                   
					<td><input type="text" id="datepicker" name="report_date" value="{$arrForm.report_date.value}" size="5"  ></td>                              
				</tr>
				<tr>
					<p>ルーティン</p>
					<dl>					
						{html_checkboxes name="checked_routing" options=$arrRoutingContents checked=$arrForm.checked_routing.value separator="<br />"}
					</dl>	
				</tr>
				<tr>
					<th>本日の作業</th>                   
					<td>
						<table >
							<tr>
								<th>タスク名</th>
								<th>作業内容</th>
								<th>作業時間</th>
								<th>追加/削除</th>
							</tr>
							
							{foreach  from=$arrForm.task_id.value key=n item=task}					
								<tr class="task_row" id="task_row_{$n+1}" >
									<td id="td_task_master_id_{$n+1}">
										<select name="task_master_id[]"  style="" id="task_master_id_{$n+1}">
											{html_options options=$arrTaskContents selected=$arrForm.task_master_id.value.$n} 
										</select>
										<input type="hidden" name="task_id[]" value="{$arrForm.task_id.value.$n}">
									</td>
									<td id="td_contents_id_{$n+1}">
										<textarea id="contents_id_{$n+1}" col="200"  rows="5" name="contents[]">{$arrForm.contents.value.$n}</textarea>
									</td>
									<td class="work_time" id="td_work_time_id_{$n+1}">
										<input type="text" name="work_time[]" size="2" id="work_time_id_{$n+1}" value="{$arrForm.work_time.value.$n}">
									</td>
									<td class="_time" id="delete_button_id">
									  <input type="button" id="delete_task_button_{$n+1}" class="delete_task_button" name="delete_task" value="削除">
									</td>
								</tr>
							{/foreach}	
							
						</table>
						<input type="button" class="btn btn-success" value="パターンを追加する" id="addPattern"/>
					</td>                              
				</tr>
				<tr>
					<th rowspan="2" >食事</th>                   
					<td><input type="text" name="calorie" size="3" value="{$arrForm.calorie.value}">kcal</td></tr>
				</tr>
				<tr>
					<td><input type="text" name="weight" size="3" value="{$arrForm.weight.value}" >kg</td>
				</tr>
				<tr>
					<th>本日の反省</th>                   
					<td><textarea name="reflection" col="200" rows="10">{$arrForm.reflection.value}</textarea></td>                              
				</tr>				
			</table>
		</div>	
	</div>

	<input type="hidden" id="member_id" name="member_id" value="">
	<input type="button" name="send" value="一覧に戻る" class="btn btn-success submit_button" id="index_button" />
	<input type="button" name="send" value="登録する" class="btn btn-success submit_button" id="confirm_button" />
</div>

</form>
