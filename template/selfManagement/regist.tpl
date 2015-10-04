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
				<tr>
					<th>日報作成日</th>                   
					<td><input type="text" id="datepicker" name="report_date" size="5" ></td>                              
				</tr>
				<tr>
					<p>ルーティン</p>
					<dl>					
					{foreach from=$arrRoutingContents key=key item=routine}
						<dt><input type="checkbox" name="checked_routing[]" id="task_id_{$key}" value="{$key}" ></dt>
						<dd><label for="task_id_{$key}">{$routine}</label></dd>
					{/foreach}
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
						
							<tr class="task_row" id="task_row_1">
								<td class=" classcategory_id1" id="td_classcategory_id1_1">
									<select name="task_master_id[]"  style="" class="classcategory_id1" id="task_master_id_1">
										{html_options options=$arrTaskContents selected=""} 
									</select>
								</td>
								<td class="classcategory_id2" id="td_classcategory_id2_1">
									<textarea id="contents_id_1" col="200"  rows="5" name="contents[]"></textarea>
								</td>
								<td class="work_time" id="td_work_time_id">
									<input type="text" name="work_time[]" size="2" class="box_color" id="work_time_id_1">
								</td>
								<td class="_time" id="delete_button_id">
								  <input type="button" id="delete_task_button_1" class="delete_task_button" name="delete_task" value="削除">
								</td>
							</tr>					
						</table>
						<input type="button" class="btn btn-success" value="パターンを追加する" id="addPattern"/>
					</td>                              
				</tr>
				<tr>
					<th rowspan="2" >食事</th>                   
					<td><input type="text" name="calorie" size="3">kcal</td></tr>
				</tr>
				<tr>
					<td><input type="text" name="weight" size="3">kg</td>
				</tr>
				<tr>
					<th>本日の反省</th>                   
					<td><textarea name="reflection" col="200" rows="10"></textarea></td>                              
				</tr>				
			</table>
		</div>	
	</div>

	<input type="hidden" id="member_id" name="member_id" value="">
	<input type="button" name="send" value="一覧に戻る" class="btn btn-success submit_button" id="index_button" />
	<input type="button" name="send" value="登録する" class="btn btn-success submit_button" id="confirm_button" />
</div>

</form>
