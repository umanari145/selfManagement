<?php /* Smarty version 2.6.25-dev, created on 2015-10-07 07:22:01
         compiled from selfManagement/index.tpl */ ?>
<table border="1">
<?php $_from = $this->_tpl_vars['arrDailyReports']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['dailyReports']):
?>
	<tr>
    <td><a href="<?php echo @URL; ?>
<?php echo $this->_tpl_vars['controller']; ?>
/edit/<?php echo $this->_tpl_vars['dailyReports']['id']; ?>
" ><?php echo $this->_tpl_vars['dailyReports']['report_date']; ?>
</a></td>
    </tr>
<?php endforeach; endif; unset($_from); ?>
</table>