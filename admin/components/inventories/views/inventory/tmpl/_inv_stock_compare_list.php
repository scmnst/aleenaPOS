<?php
defined('_MEXEC') or die ('Restricted Access');

//print_r($this->pur_arts);exit;
if(isset($this->pur_arts) && $this->pur_arts){
?><table  class="table table-bordered table-hover table-condenseds">
<thead><tr><th>Item#</th><th>Title</th><th>Category</th><th>Location</th><th>System Qty</th><th>Physical Qty</th><th>Difference</th><th>Actions</th></tr></thead>
	<tbody id="tblContentBody"><?php
		$x=1;
		foreach ($this->pur_arts as $pa){
			$inv_id=0;
			if(isset($this->row)){ $inv_id = $this->row['id'];}
			if(!$inv_id){ $inv_id = $this->inv_id;}
		$inv_qty = 0;
		if($pa['inv_qty']){$inv_qty = $pa['inv_qty'];}
		$actual_stock = 0;
		if($pa['actual_stock']){$actual_stock = $pa['actual_stock'];}
		$difference=$inv_qty-$actual_stock;
		/*
			if $difference < 0 its mean stock need to be reduce
			if $difference > 0 its mean increase stock by difference
		*/
		//echo  $difference . '<br>';
		if($difference !== 0){
	?><tr id="row-<?php echo $x; ?>"><?php 
	//echo ($pa['actual_stock']) . ' . ';
		//echo '<td id="id-' . $x . '">' .  $inv_id. '</td>'; 
		echo '<td id="article_code-' . $x . '">' . $pa['article_code'] . '</td>'; 
		echo '<td>' . $pa['art_title'] . '</td>'; 
		echo '<td class="cat">' . $pa['pcat_name'] . ' - ' . $pa['cat_name'] . '</td>'; 
		echo '<td class="loc">' . $pa['loc_section'] . ' - ' . $pa['loc_rack'] . ' - ' . $pa['loc'] . '</td>'; 
		echo '<td>' . $pa['actual_stock'] . '</td>';
		echo '<td>' . $pa['inv_qty'] . '</td>';
		echo '<td>' . $difference . '</td>';
		$js = "saveInvItem({$inv_id},'{$pa['article_code']}', " . "'#inv_qty-" . $x . "');$(this).hide();return false;";
		echo '<td>'; 
		//echo '<a onclick="' . $js . '" href="#" title="Adjust" tabindex="-1">Adjust</a>'; 
		echo '</td>'; 
		$x++;
	?></tr><?php
		}
		}
	?></tbody>
</table><?php 
}