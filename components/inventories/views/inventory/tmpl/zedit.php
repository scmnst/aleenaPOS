<?php
defined('_MEXEC') or die ('Restricted Access');
$user = core::getUser();
$pa =  $user->pageAccess(16);
//echo $pa;exit;
if(!$pa){
	echo '<h3 class="error">Access denied!</h3>';
	exit;
}
/* if(isset($_GET['create_record']) && $this->row ){
	createRecord();
} */
?><div class="com-head">
<script type="text/javascript">

</script>
</div>

<div><form class="form-inline" method="post" name="frm" action="?com=inventories&view=inventory<?php if($this->id){echo '&id='.$this->id;} ?>">
		<fieldset class="form">
		<legend>Inventory</legend>
		<div class="form grid">
			<input type="hidden" id="form_type" name="form_type" value="inventory_main" />
			<input type="hidden" id="frm_main_state" name="frm_main_state" value="<?php
				if(isset($this->row)){
					echo 'edit';
				}else{
					echo 'unset';
				}
			?>" />
			<input type="hidden" name="status" value="<?php if(isset($this->row)){ echo $this->row['inv_status'];}?>" />
			<input type="hidden" id="id" name="id" value="<?php if($this->id){echo $this->row['id'];}else{echo '0';} ?>"  />
			<div class="row well-sm">
				<div class="col-sm-1 grid-label"><label class="control-label" for="article_code">Item Code:</label></div><div class="col-sm-2"><input name="article_code" class="inputbox form-control input-sm number" value="" /></div>
				<div class="col-sm-1 grid-label"><label class="control-label" for="inv_status">Status:</label></div><div class="col-sm-1"><input name="inv_status" class="inputbox form-control input-sm" value="<?php if(isset($this->row)){ echo $this->row['inv_status'];}?>" tabindex="-1" readonly /></div>
			</div>
			<hr/>
			<div class="row well-sm">
				<div class="col-sm-1 grid-label"><label class="control-label" for="remarks">Remarks:</label></div><div class="col-sm-8"><input name="remarks" class="inputbox form-control input-sm" value="<?php if(isset($this->row)){ echo $this->row['remarks'];}?>" tabindex="-1" /></div>
			</div>
			</div><div class="clear"></div>
			<fieldset>
			<div class="btn-group">
				<div class="row well-sm">
					<span><input type="reset" id="Cancel" class="btn btn-default" value="Cancel" onclick="history.back()" tabindex="-1" /></span>
					<span><input class="btn btn-default" type="reset" name="reset" id="reset-pa" value="Reset" tabindex="-1" /></span>
					<span><button id="save" name="save" class="btn btn-success" tabindex="-1"><?php 
						$btn_title="Create New";
						if($this->id){$btn_title="Update";}
						echo $btn_title;
					?></button></span>
				</div>
			</div>
			</fieldset>
		</fieldset></form>
		<div class="form grid" style="margin-top:20px;">
			<div class="row well-sm">
				<label class="control-label col-sm-1" for="search_filter">Search:</label><div class="col-sm-3"><input id="search_filter" name="search_filter" class="inputbox form-control input-sm" value="" style="display:inline-block;width:90% !important;" /></div>
			</div>
		</div>
		
</div>