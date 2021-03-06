<?php /* Smarty version 2.6.19, created on 2014-12-31 16:32:24
         compiled from logic-area-out-stock/check.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'logic-area-out-stock/check.tpl', 22, false),)), $this); ?>
<form name="myForm1" id="myForm1">
<input type="hidden" name="logic_area" size="20" value="<?php echo $this->_tpl_vars['logic_area']; ?>
" />
<input type="hidden" name="bill_status" size="20" value="<?php echo $this->_tpl_vars['data']['bill_status']; ?>
" />
<input type="hidden" name="bill_type" size="20" value="<?php echo $this->_tpl_vars['data']['bill_type']; ?>
" />
<input type="hidden" name="bill_no" size="20" value="<?php echo $this->_tpl_vars['data']['bill_no']; ?>
" />
<input type="hidden" name="item_no" size="20" value="<?php echo $this->_tpl_vars['data']['item_no']; ?>
" />
<input type="hidden" name="is_cancel" size="20" value="<?php echo $this->_tpl_vars['data']['is_cancel']; ?>
" />
<input type="hidden" name="is_check" id="is_check" size="20" value="<?php echo $this->_tpl_vars['data']['is_check']; ?>
" />
<input type="hidden" name="is_back" size="20" value="<?php echo $this->_tpl_vars['data']['is_back']; ?>
" />
<div class="title">出库单审核</div>
<div class="content">
<table cellpadding="0" cellspacing="0" border="0" width="100%" class="table_form">
<tbody>
    <tr>
      <td width="12%"><strong>单据类型</strong></td>
      <td><?php echo $this->_tpl_vars['billType'][$this->_tpl_vars['data']['bill_type']]; ?>
</td>
      <td width="12%"><strong>单据编号</strong></td>
      <td><?php echo $this->_tpl_vars['data']['bill_no']; ?>
</td>
    </tr>
    <tr>
      <td><strong>制单日期</strong> * </td>
      <td><?php echo ((is_array($_tmp=$this->_tpl_vars['data']['add_time'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y-%m-%d") : smarty_modifier_date_format($_tmp, "%Y-%m-%d")); ?>
</td>
      <td><strong>制单人</strong> * </td>
      <td><?php echo $this->_tpl_vars['data']['admin_name']; ?>
</td>
    </tr>
    <tr>
      <td><strong>备注</strong></td>
      <td colspan="3">&nbsp;<?php echo $this->_tpl_vars['data']['remark']; ?>
</td>
    </tr>
</tbody>
</table>

<table cellpadding="0" cellspacing="0" border="0" class="table">
<thead>
<tr>
    <td>序号</td>
    <td>产品编码</td>
    <td>产品名称</td>
    <td>产品批次</td>
    <td>状态</td>
    <td>应发数量</td>
    </tr>
</thead>
<tbody>
	<?php $_from = $this->_tpl_vars['details']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['d']):
?>
	<tr>
	<td><?php echo $this->_tpl_vars['key']+1; ?>
</td>
	<td><?php echo $this->_tpl_vars['d']['product_sn']; ?>
<input type="hidden" name="product_id[]" value="<?php echo $this->_tpl_vars['d']['product_id']; ?>
"></td>
	<td><?php echo $this->_tpl_vars['d']['goods_name']; ?>
 (<font color="#FF3333"><?php echo $this->_tpl_vars['d']['goods_style']; ?>
</font>)</td>
	<td><?php if ($this->_tpl_vars['d']['batch_no']): ?><?php echo $this->_tpl_vars['d']['batch_no']; ?>
<?php else: ?>无批次<?php endif; ?><input type="hidden" name="batch_id[]" value="<?php if ($this->_tpl_vars['d']['batch_id']): ?><?php echo $this->_tpl_vars['d']['batch_id']; ?>
<?php else: ?>0<?php endif; ?>"></td>
	<td><?php echo $this->_tpl_vars['status'][$this->_tpl_vars['d']['status_id']]; ?>
<input type="hidden" name="status[]" value="<?php echo $this->_tpl_vars['d']['status_id']; ?>
"></td>
	<td><?php echo $this->_tpl_vars['d']['number']; ?>
<input type="hidden" name="number[]" value="<?php echo $this->_tpl_vars['d']['number']; ?>
"></td>
	</tr>
	<?php endforeach; endif; unset($_from); ?>
</tbody>
</table>
<div style="text-align:right;padding:10px 20px">
  <?php if ($this->_tpl_vars['data']['bill_type'] == '2'): ?>
  <strong>退款金额：</strong><?php echo $this->_tpl_vars['data']['amount']; ?>

  <input type="hidden" name="amount" value="<?php echo $this->_tpl_vars['data']['amount']; ?>
">
  <input type="hidden" name="supplier_id" value="<?php echo $this->_tpl_vars['data']['supplier_id']; ?>
">
  <?php endif; ?>
  <strong>应发合计：</strong><?php echo $this->_tpl_vars['data']['total_number']; ?>

</div>

<?php if ($this->_tpl_vars['op_cancel']): ?>
<table cellpadding="0" cellspacing="0" border="0" width="100%" class="table_form">
<tbody>
    <tr>
      <td width="12%" style="color:red"><strong>申请取消</strong></td>
      <td colspan="5"></td>
    </tr>
    <tr>
      <td width="12%"><strong>申请日期</strong></td>
      <td width="20%"><?php echo ((is_array($_tmp=$this->_tpl_vars['op_cancel']['op_time'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y-%m-%d") : smarty_modifier_date_format($_tmp, "%Y-%m-%d")); ?>
</td>
      <td width="12%"><strong>申请人</strong></td>
      <td><?php echo $this->_tpl_vars['op_cancel']['admin_name']; ?>
</td>
      <td></td>
      <td></td>
    </tr>
    <tr>
      <td><strong>说明</strong></td>
      <td colspan="5"><?php echo $this->_tpl_vars['op_cancel']['remark']; ?>
</td>
    </tr>
</tbody>
</table>
<?php endif; ?>

</div>

<div class="submit">
<?php if ($this->_tpl_vars['data']['lock_name'] == $this->_tpl_vars['auth']['admin_name'] && ! $this->_tpl_vars['hideButton']): ?>
说明：<input type="text" name="remark" id="remark" size="80" value="" /><br>
<input type="button" name="dosubmit1" id="dosubmit1" value="同意" onclick="dosubmit(1)"/>
<input type="button" name="dosubmit2" id="dosubmit2" value="拒绝" onclick="dosubmit(2)"/>
<?php endif; ?>
</div>

</form>
<script language="JavaScript">
function dosubmit(check)
{
	$('is_check').value=check;
	if (check==1){
		var info = '同意此申请吗?'
	}else{
		if($('remark').value.trim()==''){alert('请填写说明');return false;}
		var info = '拒绝此申请吗?'
	}
	if(confirm(info)){
		$('dosubmit'+check).value = '处理中';
		$('dosubmit'+check).disabled = true;
		ajax_submit($('myForm1'),'<?php echo $this -> callViewHelper('url', array());?>');
	}
}

function failed(check)
{
	if (check==1){
	    var info = '同意'
	}else{
	    var info = '拒绝'
	}
	$('dosubmit'+check).value = info;
	$('dosubmit'+check).disabled = false;
}

</script>