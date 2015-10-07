<?php /* Smarty version 2.6.25-dev, created on 2015-10-07 10:03:05
         compiled from selfManagement/regist.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_checkboxes', 'selfManagement/regist.tpl', 20, false),array('function', 'html_options', 'selfManagement/regist.tpl', 38, false),)), $this); ?>
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
				<input type="hidden" name="id" value="<?php echo $this->_tpl_vars['arrForm']['id']['value']; ?>
" />
				<tr>
					<th>日報作成日</th>                   
					<td><input type="text" id="datepicker" name="report_date" value="<?php echo $this->_tpl_vars['arrForm']['report_date']['value']; ?>
" size="5"  ></td>                              
				</tr>
				<tr>
					<p>ルーティン</p>
					<dl>					
						<?php echo smarty_function_html_checkboxes(array('name' => 'checked_routing','options' => $this->_tpl_vars['arrRoutingContents'],'checked' => $this->_tpl_vars['arrForm']['checked_routing']['value'],'separator' => "<br />"), $this);?>

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
							
							<?php $_from = $this->_tpl_vars['arrForm']['task_id']['value']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['n'] => $this->_tpl_vars['task']):
?>					
								<tr class="task_row" id="task_row_<?php echo $this->_tpl_vars['n']+1; ?>
" >
									<td id="td_task_master_id_<?php echo $this->_tpl_vars['n']+1; ?>
">
										<select name="task_master_id[]"  style="" id="task_master_id_<?php echo $this->_tpl_vars['n']+1; ?>
">
											<?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['arrTaskContents'],'selected' => $this->_tpl_vars['arrForm']['task_master_id']['value'][$this->_tpl_vars['n']]), $this);?>
 
										</select>
										<input type="hidden" name="task_id[]" value="<?php echo $this->_tpl_vars['arrForm']['task_id']['value'][$this->_tpl_vars['n']]; ?>
">
									</td>
									<td id="td_contents_id_<?php echo $this->_tpl_vars['n']+1; ?>
">
										<textarea id="contents_id_<?php echo $this->_tpl_vars['n']+1; ?>
" col="200"  rows="5" name="contents[]"><?php echo $this->_tpl_vars['arrForm']['contents']['value'][$this->_tpl_vars['n']]; ?>
</textarea>
									</td>
									<td class="work_time" id="td_work_time_id_<?php echo $this->_tpl_vars['n']+1; ?>
">
										<input type="text" name="work_time[]" size="2" id="work_time_id_<?php echo $this->_tpl_vars['n']+1; ?>
" value="<?php echo $this->_tpl_vars['arrForm']['work_time']['value'][$this->_tpl_vars['n']]; ?>
">
									</td>
									<td class="_time" id="delete_button_id">
									  <input type="button" id="delete_task_button_<?php echo $this->_tpl_vars['n']+1; ?>
" class="delete_task_button" name="delete_task" value="削除">
									</td>
								</tr>
							<?php endforeach; endif; unset($_from); ?>	
							
						</table>
						<input type="button" class="btn btn-success" value="パターンを追加する" id="addPattern"/>
					</td>                              
				</tr>
				<tr>
					<th rowspan="2" >食事</th>                   
					<td><input type="text" name="calorie" size="3" value="<?php echo $this->_tpl_vars['arrForm']['calorie']['value']; ?>
">kcal</td></tr>
				</tr>
				<tr>
					<td><input type="text" name="weight" size="3" value="<?php echo $this->_tpl_vars['arrForm']['weight']['value']; ?>
" >kg</td>
				</tr>
				<tr>
					<th>本日の反省</th>                   
					<td><textarea name="reflection" col="200" rows="10"><?php echo $this->_tpl_vars['arrForm']['reflection']['value']; ?>
</textarea></td>                              
				</tr>				
			</table>
		</div>	
	</div>

	<input type="hidden" id="member_id" name="member_id" value="">
	<input type="button" name="send" value="一覧に戻る" class="btn btn-success submit_button" id="index_button" />
	<input type="button" name="send" value="登録する" class="btn btn-success submit_button" id="confirm_button" />
</div>

</form>