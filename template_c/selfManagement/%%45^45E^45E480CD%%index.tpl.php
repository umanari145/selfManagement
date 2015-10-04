<?php /* Smarty version 2.6.25-dev, created on 2015-10-04 06:32:02
         compiled from index.tpl */ ?>
<table border="1">
<?php $_from = $this->_tpl_vars['arrMember']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['member']):
?>
	<tr>
    <td><?php echo $this->_tpl_vars['member']['member_id']; ?>
</td>
    <td><?php echo $this->_tpl_vars['member']['family_name']; ?>
</td>
    <td><a href="<?php echo @URL; ?>
<?php echo $this->_tpl_vars['controller']; ?>
/view/<?php echo $this->_tpl_vars['member']['member_id']; ?>
" >詳細を見る</a></td>
    <td><a href="<?php echo @URL; ?>
<?php echo $this->_tpl_vars['controller']; ?>
/edit/<?php echo $this->_tpl_vars['member']['member_id']; ?>
" >編集する</a></td>
    </tr>
<?php endforeach; endif; unset($_from); ?>
</table>