<?php
defined('_MEXEC') or die ('Restricted Access');
//$data_articles = array_column($this->rows,'data_articles');
//print_r ($data_articles);exit;


//var_dump($this->rows);exit;
?><div class="com-head">
	<h3>Itemwise report</h3>
</div>

<div class="form"><?php
?></div>
<div class="table-responsive"><div id="search-date-range">
		<form method="get" action="?" >
			<input type="hidden" name="com" value="sales" />
			<input type="hidden" name="view" value="items_report" />
			<input type="hidden" name="task" value="<?php echo $this->task;?>" />
			<div>
			<div class="date-range">
				<label class="control-label" for="start_date">Start date:</label>
				<input type="date" name="start_date" id="start_date"class="inputbox input-sm date<?php if(!isset($_GET['start_date'])){ echo '-default';}?>" value="<?php if(isset($_GET['start_date'])){ echo strftime("%Y-%m-%d", strtotime($_GET['start_date']));}?>" tabindex="-1" />
				<label class="control-label" for="end_date">End date:</label>
				<input type="date" name="end_date" id="end_date" class="inputbox input-sm date<?php if(!isset($_GET['end_date'])){ echo '-default';}?>" value="<?php if(isset($_GET['end_date'])){ echo strftime("%Y-%m-%d", strtotime($_GET['end_date']));}?>" tabindex="-1" />
				<button type="submit" name="search_date" class="btn btn-success screen btn-flat screen"><i class="fa fa-search"></i></button>
			</div>
			</div><div class="clear"></div>
		</form>
	</div>
	<link rel="stylesheet" type="text/css" href="templates/default/bower_components/datatables.net-buttons-dt/css/buttons.dataTables.min.css" media="all" />
	<table id="data-table" class="table salesReportItems">
		<thead>
			<tr>
				<th>Sr#</th><th>Items</th><th>Title</th><th>Cost Price</th><th>Sales Price</th><th>Discount</th>
				<th>Qty</th><th>Total</th><th>Saving</th><th>%</th>
			</tr>
		</thead>
		<tbody id="tblContentBody" class="report-list"></tbody>
		<tfoot>
			<tr>
				<th colspan="4" style="text-align:right">Total:</th>
				<th colspan="1"></th>
				<th colspan="1"></th>
				<th colspan="1"></th>
				<th colspan="1"></th>
				<th colspan="1"></th>
			</tr>
		</tfoot>
	</table>
</div><script>
	var json_data = <?php
		echo json_encode($this->rows);
	?>;
		//console.log(json_data);
		//var subTotal=0;
		//var subTotalMargin=0;
		var vRow = 1;
		$.each(json_data, function(i, v) {
			if(v.data_articles){
			var json_arts = JSON.parse(v.data_articles);
			$.each(json_arts, function(j, vt) {
			if(vt){
			//console.log(vt.qty);
				var tableRow = $("#tblContentBody .article_code").filter(function() {
					return $(this).text() == vt.article_code;
				}).closest("tr");
				var discount=0;
				if(!isNaN(vt.discount)){
					//discount=typeof(vt.discount);
					discount=vt.discount;
					if(vt.discount==''){
						discount=0;
					}
				}
				var tp_price=0;
				if(!isNaN(vt.tp_price)){
					//tp_price=typeof(vt.tp_price);
					tp_price=vt.tp_price;
					if(vt.tp_price==''){
						tp_price=0;
					}
				}
				if(tableRow.html()){
					var new_qty = eval(tableRow.find('.qty').text())+eval(vt.qty);
					tableRow.find('.qty').text(eval(new_qty).toFixed(2));
					var total_cost = eval(vt.qty) * eval(vt.cost_price);
					var new_qty = $(tableRow).find('.qty').text();
					var old_total = $(tableRow).find('.total').text();
					var new_total = eval(vt.qty)*eval(tp_price-vt.discount);
					var old_saving = $(tableRow).find('.saving').text();
					var new_saving = new_total-total_cost;

					$(tableRow).find('.total').text(eval(eval(old_total) + new_total).toFixed(2));
					$(tableRow).find('.saving').text(eval(eval(old_saving) + new_saving).toFixed(2));
					$(tableRow).find('.save_percent').text(((eval(old_saving) + new_saving)/(eval(old_total) + new_total)*100).toFixed(2) + ' %');
				}else{
					var html = '<tr>';
					html = html + '<td class="sr_no">'+vRow+ '</td>';
					//html = html + '<td class="sr_no">'+v.id+ '</td>';
					html = html + '<td class="article_code">'+vt.article_code+ '</td>';
					html = html + '<td class="title">'+vt.title+'</td>';
					html = html + '<td class="cost_price">'+eval(vt.cost_price).toFixed(2)+'</td>';
					html = html + '<td class="price">'+eval(tp_price).toFixed(2)+'</td>';
					//html = html + '<td class="discount">'+eval(vt.discount).toFixed(2)+'</td>';
					//html = html + '<td class="discount">'+discount+'</td>';
					html = html + '<td class="discount">'+discount+'</td>';
					html = html + '<td class="qty">'+eval(vt.qty).toFixed(2)+'</td>';
					var total_cost = eval(vt.qty) * eval(vt.cost_price);
					var total = eval(vt.qty) * (eval(tp_price)-eval(discount));
					var saving = total-total_cost;
					html = html + '<td class="total">'+(total).toFixed(2)+'</td>';
					html = html + '<td class="saving">'+eval(saving).toFixed(2)+'</td>';
					html = html + '<td class="save_percent">'+eval(saving/total *100).toFixed(2)+' %</td>';
					html = html + '</tr">';
					vRow++;
					//console.log(html);
					//$("#invArticles").append(html);
					$("#tblContentBody").append(html);
				
				}
				}
			});
			}
		});
		</script>
<script>
$(document).ready(function(){
	
	$('#data-table').DataTable({
		dom: 'lfBrtip',buttons:['excel', 'pdf'],
		"footerCallback": function(row, data, start, end, display ) {
		var api = this.api(), data;

		// Remove the formatting to get integer data for summation
		var intVal = function (i) {
			return typeof i === 'string' ?
			i.replace(/[\$,]/g, '')*1 :
			typeof i === 'number' ?
			i : 0;
		};

		// Total over all pages
		total1 = api
		.column(7)
		.data()
		.reduce( function (a, b) {
			return intVal(a) + intVal(b);
		},0);

		total2 = api
		.column(8)
		.data()
		.reduce( function (a, b) {
			return intVal(a) + intVal(b);
		},0);

		// Update footer
		$( api.column(7).footer()).html(eval(total1).toFixed(2));
		$( api.column(8).footer()).html(eval(total2).toFixed(2));
		
		},paging:false
	} );

	
	
})
</script>