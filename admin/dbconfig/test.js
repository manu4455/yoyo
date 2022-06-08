SOURCE.page_level_08 = new function () { };
SOURCE.page_level_07 = new function () { };
SOURCE.page_level_06 = new function () {

	var ret_function = null; //
	var mnus = null; // this will store all menu details
	var action = "ADD_ENTRY";
	var action_id = 1; // default add_entry
	var trans_id = 0;//bibhu
	var container = null;
	var frmID = 0;
	var m_store = [];
	var check_spec=[];
	this.initPage = function initPage(arg, _container, return_fn) {

		$('#transdate').val((new Date()).toISOString().substr(0, 10));
		frmID = "#frm_" + arg["r_data"]["mnu_opt"]["m_id"] + " ";
		container = _container;
		$(frmID + 'input').attr('autocomplete', 'off');
		ret_function = return_fn;
		mnus = arg["r_data"]["mnu_opt"];
		trans_id = arg["r_data"]["load_data"]["trans_id"]// bibhu...changed pravin
		action = "ADD_ENTRY";
		action_id = 1;
		// initialize event specific data
		if (arg["eventID"] == "REQ_MODIFY") {
			action = "MODIFY_ENTRY";
			action_id = 2;
			$(frmID + '#divHeading').text("Modify Subscription Details");
			$(frmID + "#btnDone").html("UPDATE");
		}
		else if (arg["eventID"] == "REQ_DELETE") {
			action = "DELETE_ENTRY";
			action_id = 3;
			$(frmID + '#divHeading').text("Delete Subscription Details");
			$(frmID + ".divFrmContainer *").prop('disabled', true);
			$(frmID + "#btnDone").html("DELETE").prop('disabled', false);
			$(frmID + '#btnClose').prop('disabled', false);
		}
		else if (arg["eventID"] == "REQ_VIEW") {
			action = "VIEW_ENTRY";
			action_id = 4;
			$(frmID + '#divHeading').text("Subscription Received Details");
			$(frmID + ".divFrmContainer *").prop('disabled', true);
			$(frmID + '#btnDone').hide();
			$(frmID + "#btnClose").html("CLOSE").prop('disabled', false);

		}
		else if (arg["eventID"] == "REQ_VERIFY") {
			action = "VERIFY_ENTRY";
			action_id = 5;
			$(frmID + '#divHeading').text("Verify Subscription Details");
			$(frmID + ".divFrmContainer *").prop('disabled', true);
			$(frmID + '.btnContainer').hide();
		}

		$('#div_com_date').on('change',function(e){
			var com_date = $('#div_com_date').val();
			$('#div_ext_date').val(com_date);
		});

		$(frmID + "#btnDone").on("click", function (e) { // done button clisked
			
			
			var ret = SOURCE.cf.validateAndCompileForm(frmID);
			if (ret["r_code"] == true) // if validation was successful
				saveDetails(ret["r_data"]); // send compiled values to saveDetails

			//$("#itemcat,#itemname,#qty").addClass("isRequired");
		});

		$(frmID + "#btnClose").on("click", function (e) { // close button clicked
			$(container).hide();
			ret_function({ "return": "Close", "level": "06" });// second parameter is a 0 
		});

		
		$('#item_cat').on('change',function(e){
			SOURCE.cf.hideCmbItem("#item_sub_cat","option");
			SOURCE.cf.showCmbItem("#item_sub_cat", "." + this.selectedOptions[0].className);
		});
		//display specification Box
		$('#btn_add_spec').on('click',function(e){
			debugger;
			$('#spec-box').show(500);			
			$('#add_spec').show();
			$('#spec-new').show();
			
			var spec = $(this).attr('data-id');			
			var json = $.parseJSON('[' + spec + ']');
			var sp = json[0];
			var htmls = "";
			if(json.length > 0){
				for (var j=0; j < sp.length;j++)
				{
					var specs = sp[j].spec;
					var sub_spec = sp[j].sub_spec;					
					var id = parseInt(j) + 1;
					htmls +="<table class='getSpecification grid' style='margin-bottom:10px;width:100%;'>";
					htmls +="<thead>";
					htmls +="<tr>";
					htmls +="<th style='width: 30%;text-align: left;'>Specification</th>";
					htmls +="<th style='width: 45%;'><input class='specification' placeholder='Specification' style='width: 100%; padding:5px 0px 5px 2px;'  type='text' value='"+specs+"' /></th>";
					htmls +="<th  style='width: 15%;text-align: right;'><button style='border:1px solid #000;' data-count='"+id+"' class='addSubSpecBtn' >+ Sub Spec</button> </th>";
					htmls +="<th  style='width: 10%;text-align: right;'><button style='border:1px solid #000;' data-count='"+id+"' class='spec-remove' > X </button> </th>";

					htmls +="</tr>";
					htmls +="</thead>";
					htmls +="<tbody id='SubSpecificationbody_"+id+"' class='SubSpecificationbody'>";
					for (var k=0; k < sub_spec.length; k++){
						
						htmls +="<tr><td style='width: 30%;'><input type='text' placeholder='Sub Specification' value='"+sub_spec[k]['sub_spec_name']+"' style='width:95%;padding:5px 0px 5px 2px;' /></td><td colspan='2' style='width: 60%; ' ><input type='text' placeholder='Value' value='"+sub_spec[k]['sub_spec_value']+"' style='width:100%;padding:5px 0px 5px 2px;' /></td><td style='width: 15%;text-align: right;'><button class='remove_subSpec'>X</button></td></tr>";
					}
					htmls +="</tbody>";
					htmls +="</table>";
				}
			}
			
			$('#spec-details').append(htmls);
			
		});

		//display specification Box
		$('#btn_add_delivery_to').on('click',function(e){
			debugger;						
			var total_qty = $('#qty').val();
			if(total_qty.length > 0){
				$('#delto-box').show(500);				
				$('#add_delto').show();
				var tr ="";	
				var delto = $(this).attr('data-id');			
				var json = $.parseJSON('[' + delto + ']');
				var data_store = json[0]; 
				if(json.length > 0){
					for(var i = 0;i< m_store.length ; i++){
						debugger;
						var store_data = data_store[i];
						var store = m_store[i];
						if(store[0] == store_data["store_id"]){
							tr +='<tr><td style="width:15px;" hidden>'+store_data["store_id"]+'</td> <td style="text-align:left; font-weight:bold;">'+store_data["store_name"]+'</td><td style="width:40%;"><input type="number" style="padding:10px;" class="isRequired delto_qty" value="'+store_data["store_qty"]+'" autocomplete="off"  placeholder="Quantity" style="width:100%;"></td></tr>';

						}else{
							tr +='<tr><td style="width:15px;" hidden>'+store[0]+'</td> <td style="text-align:left; font-weight:bold;">'+store[1]+'</td><td style="width:40%;"><input type="number" style="padding:10px;" class="isRequired delto_qty" value="0" autocomplete="off"  placeholder="Quantity" style="width:100%;"></td></tr>';

						}
						
					}
				}else{
					for(var i = 0;i< m_store.length ; i++){
						debugger;
						var store = m_store[i];
						tr +='<tr><td style="width:15px;" hidden>'+store[0]+'</td> <td style="text-align:left; font-weight:bold;">'+store[1]+'</td><td style="width:40%;"><input type="number" style="padding:10px;" class="isRequired delto_qty" value="0" autocomplete="off"  placeholder="Quantity" style="width:100%;"></td></tr>';
		
					}
				}

				$('#delto-details').append(tr);

				$('#delto-details td input').change(function(i){
					debugger;
					var arr = [];
					var qty = $('#qty').val();

					$('#delto-details td input').each(function(i){
						arr[i] = $(this).val();
					});
					var sum = 0;
					// Running the for loop
					for (let i = 0; i < arr.length; i++) {
						sum = parseInt(sum) + parseInt(arr[i]);
					}

					if(sum > qty){
						$(this).val('0');					
						alert('Total SO Quantity Is less than Distributed Quantity !');
						$('#add_delto').attr('disabled',true);
					}else if(sum < qty){
						var total_qty = parseInt(qty) - parseInt(sum);
						$('.total_qty').html(total_qty);
						$('#add_delto').attr('disabled',true);
					}else if(sum == qty){
						var total_qty = parseInt(qty) - parseInt(sum);
						$('.total_qty').html(total_qty);
						$('#add_delto').attr('disabled',false);
					}

					
				});

			}else{
				alert('Please Enter Quantiy !');
			}
			
		});
		
		// close specification box
		$('#delto-close').on('click',function(e){		
			
			$('#delto-box').hide(500);
			$('#delto-details').html('');
		});
		$('#spec-close').on('click',function(e){
			$('#spec-box').hide(500);
			$("#spec-details").html(' ');
		});
		
		// new specificatio input details
		$('#spec-new').on('click',function(e){
			var Count ="";
			var htmls = "";
			var specification ="";
			
			Count = $('#spec-details').find('table').length;
			var id = parseInt(Count) + 1;
			htmls +="<table class='getSpecification grid' style='margin-bottom:10px;width:100%;'>";
			htmls +="<thead>";
			htmls +="<tr>";
			htmls +="<th style='width: 30%;text-align: left;'>Specification</th>";
			htmls +="<th style='width: 45%;'><input class='specification' placeholder='Specification' style='width: 100%; padding:5px 0px 5px 2px;'  type='text' /></th>";
			htmls +="<th  style='width: 15%;text-align: right;'><button style='border:1px solid #000;' data-count='"+id+"' class='addSubSpecBtn' >+ Sub Spec</button> </th>";
			htmls +="<th  style='width: 10%;text-align: right;'><button style='border:1px solid #000;' data-count='"+id+"' class='spec-remove' > X </button> </th>";

			htmls +="</tr>";
			htmls +="</thead>";
			htmls +="<tbody id='SubSpecificationbody_"+id+"' class='SubSpecificationbody'>";
			htmls +="</tbody>";
			htmls +="</table>";
			$('#spec-details').append(htmls);
			
			$(".addSubSpecBtn").unbind().click(function(){
				debugger;
				
				var tr ="";
				tr = "<tr><td style='width: 30%;'><input type='text' placeholder='Sub Specification' style='width:95%;padding:5px 0px 5px 2px;' /></td><td colspan='2' style='width: 60%; ' ><input type='text' placeholder='Value' style='width:100%;padding:5px 0px 5px 2px;' /></td><td style='width: 15%;text-align: right;'><button class='remove_subSpec'>X</button></td></tr>"
				$("#SubSpecificationbody_"+$(this).data('count')).append(tr);
				
				
				$(".remove_subSpec").on('click', function(){
					$(this).closest('tr').remove();
				});		
					
			});

			function checkduplicateSpec(spec)
			{
				debugger
				var flag=false;
				for(var i=0; i< check_spec.length; i++){
					debugger;
					var name = check_spec[i];
					if(name == spec){
						debugger;						
						flag=true;
						break;
					} 
				}
				return flag;
			}
			
			$('.specification').unbind().change(function(i){
				debugger;
				var spec = $(this).val();
				debugger
				if (checkduplicateSpec(spec))
				{
					$(this).val('').focus();
					alert('Specification Cannot Be Same');

				}
				else{
					check_spec.push(spec);
				}
			});

			$('#add_spec').on('click',function(e){
				var spec=[];		
				
				$('.getSpecification').unbind().each(function(i){			
					debugger;
					spec[i]={"spec":$(this).find("th:eq(1) input").val(), "sub_spec":[]};					
				
					$($(this).find("tbody tr")).each(function(j){
						debugger;
						var sub_spec ={};
						var sub_spec_name = $(this).find("td:eq(0) input").val();
						var sub_spec_value = $(this).find("td:eq(1) input").val();
						var conformity = 0;
						var remarks = '';

						sub_spec.sub_spec_name = sub_spec_name;
						sub_spec.sub_spec_value = sub_spec_value;
						sub_spec.conformity = conformity;
						sub_spec.remarks = remarks;

						spec[i]["sub_spec"][j]=sub_spec; 
						
					});				
					
				});
				
				specification = JSON.stringify(spec);
				debugger;
				$('#btn_add_spec').attr('data-id',specification);
				$('#spec-details').html('');				
				$('#spec-box').hide(500);
			});	

			// remove specification 
			$(".spec-remove").unbind().click( function () {
				$(this).closest('table').remove();
			});
		});

		

		//add specification details to json data
		
		
		$('#add_delto').on('click',function(e){
			$("#btn_add_delivery_to").attr('data-id','');			
			debugger;
			var delto = [];

			$('#delto-details tr').each(function(i){
				debugger;
				var delto_Details = {};

				var store_id = $(this).find("td:eq(0)").text();
				var store_name = $(this).find("td:eq(1)").text();
				var store_qty = $(this).find("td:eq(2) input").val();		

				delto_Details.store_id = store_id;
				delto_Details.store_name = store_name;
				delto_Details.store_qty = store_qty;

				delto.push(delto_Details);
			});
			var details = JSON.stringify(delto);
			$("#btn_add_delivery_to").attr('data-id',details);		
			
			$("#delto-details").html(' ');
			$('#delto-box').hide(500);
		});

		
		$("#qty").on('change',function() {
			var inputqty = $("#qty").val();
			if($.isNumeric(inputqty)){

			}else{
				alert('Please enter Correct Quantity');
				$("#qty").val('0');
			}
		});
		$("#per_qty_cost").on('change',function() {
			var qty = $("#qty").val();
			var per_qty = $("#per_qty_cost").val();
			var total_qty_cost = 0;
			if($.isNumeric(per_qty)){
				total_qty_cost = parseInt(per_qty) * parseInt(qty);
				$("#total_qty_cost").val(total_qty_cost);

			}else{
				alert('Please enter Correct Quantity');
				$("#qty").val('0');
			}
		});

		// add list of item to table grid
		$('#btn_add_item').on('click',function(e){
			debugger;
			var item_id = $('#item_id').val();
			var item_cat = $('#item_cat :selected').val();
			var item_cat_name = $('#item_cat :selected').text();
			var item_sub_cat = $('#item_sub_cat :selected').val();			
			var item_sub_cat_name = $('#item_sub_cat :selected').text();
			var make = $('#make').val();
			var model = $('#model').val();
			var description = $('#description').val();
			var au_id = $('#au :selected').val();
			var au_name = $('#au :selected').text();
			var qty = $('#qty').val();
			var spec = $('#btn_add_spec').attr('data-id');
			var distribution = $('#btn_add_delivery_to').attr('data-id');
			var per_qty_cost = $('#per_qty_cost').val();
			var total_qty_cost = $('#total_qty_cost').val();
			var act = $('#btn_add_item').attr('data-id');
			if ((item_cat.length <= 0) || (item_sub_cat == undefined) ||(au_id == undefined) || (make.length <= 0) || (model.length <= 0) || (description.length <= 0) || (distribution.length <= 0)) {
				alert('Please Fill All Item Details !');				
				return;
			}else{
				$('#make').val('');
				$('#item_id').val('0');
				$('#model').val('');
				$('#description').val('');
				$('#btn_add_spec').attr('data-id','');
				$('#btn_add_item').attr('data-id','ADD');
				$('#qty').val('0');
				$('#item_id').val('0');
				$('#btn_add_delivery_to').attr('data-id','');
				$('#per_qty_cost').val('0');
				$('#total_qty_cost').val('0');				

				So_items(item_cat,item_sub_cat,make,model,description,spec,item_cat_name,item_sub_cat_name,qty,act,item_id,distribution,per_qty_cost,total_qty_cost,au_id,au_name);
			}			
		});
		
		
		

		$(frmID + "#transNumber").val('AUTO');
		LoadMasters(arg["r_data"]["load_data"]["mast"]);
		
		LoadExistingDetails(arg["r_data"]["load_data"]["data"]);

	}
	
	function So_items(item_cat,item_sub_cat,make,model,description,spec,item_cat_name,item_sub_cat_name,qty,act,item_id,distribution,per_qty_cost,total_qty_cost,au_id,au_name){

		var tr ="";
		tr ="<tr><td>"+item_cat_name+"</td><td>"+item_sub_cat_name+"</td><td hidden>"+item_cat+"</td><td hidden>"+item_sub_cat+"</td><td>"+make+"</td><td>"+model+"</td><td>"+description+"</td><td hidden>"+au_id+"</td><td>"+au_name+"</td><td>"+qty+"</td><td >"+per_qty_cost+"</td><td >"+total_qty_cost+"</td><td hidden>"+distribution+"</td><td hidden>"+spec+"</td><td hidden>"+act+"</td><td hidden>"+item_id+"</td><td style='text-align:center;'><img  class='view-delto' src='resources/res_internal/img/btn/view.png' height='25'></td><td style='text-align:center;'><img  class='view-spec' src='resources/res_internal/img/btn/view.png' height='25'></td><td style='text-align:center'><img class='item-edit' src='resources/res_internal/img/btn/edit.png' height='25'></td><td style='text-align:center'><img class='item-remove' src='resources/res_internal/img/btn/cancel.png' height='25'></td></tr>";
		
		$('#items_details').append(tr);

		var so_cost = $("#So_cost").val();
		var total_so_cost = parseInt(total_qty_cost) + parseInt(so_cost);
		$("#So_cost").val(total_so_cost);

		//remove items details
		$(".item-remove").on('click', function () {
			$(this).closest('tr').remove();
		});

		$(".item-edit").unbind().bind().on('click', function () {
			var soitems = [];
			$(this).closest('tr').each(function(i, v){
				debugger;
				$(this).children('td').each(function(ii, vv){
					debugger
					soitems.push($(this).text());
				}); 
			});
			$(this).closest('tr').remove();
			loadsoitems(soitems);
		});
		// view specification details
		$(".view-spec").unbind().bind().on('click', function () {
			debugger;
			var specs = "";
			var sp ="";
			$('#spec-box').show(500);
			$('#add_spec').hide();
			$('#spec-new').hide();
			var closetr = $(this).closest('tr');

			var str = closetr.find("td:eq(13)").text();
			var json = $.parseJSON('[' + str + ']');
			var sp = json[0];
			var htmls = "";
			if(json.length > 0){
				for (var j=0; j < sp.length;j++)
				{
					var specs = sp[j].spec;
					var sub_spec = sp[j].sub_spec;					
					var id = parseInt(j) + 1;

					htmls +="<table class='getSpecification grid' style='margin-bottom:10px;width:100%;'>";
					htmls +="<thead>";
					htmls +="<tr>";
					htmls +="<th style='width: 30%;text-align: left;'>Specification</th>";
					htmls +="<th style='width: 45%;'><input class='specification' placeholder='Specification' style='width: 100%; padding:5px 0px 5px 2px;'  type='text' value='"+specs+"' /></th>";
					htmls +="<th  style='width: 15%;text-align: right;'><button style='border:1px solid #000;' data-count='"+id+"' class='addSubSpecBtn' >+ Sub Spec</button> </th>";
					htmls +="<th  style='width: 10%;text-align: right;'><button style='border:1px solid #000;' data-count='"+id+"' class='spec-remove' > X </button> </th>";

					htmls +="</tr>";
					htmls +="</thead>";
					htmls +="<tbody id='SubSpecificationbody_"+id+"' class='SubSpecificationbody'>";
					for (var k=0; k < sub_spec.length; k++){
						
						htmls +="<tr><td style='width: 30%;'><input type='text' placeholder='Sub Specification' value='"+sub_spec[k]['sub_spec_name']+"' style='width:95%;padding:5px 0px 5px 2px;' /></td><td colspan='2' style='width: 60%; ' ><input type='text' placeholder='Value' value='"+sub_spec[k]['sub_spec_value']+"' style='width:100%;padding:5px 0px 5px 2px;' /></td><td style='width: 15%;text-align: right;'><button class='remove_subSpec'>X</button></td></tr>";
					}
					htmls +="</tbody>";
					htmls +="</table>";
				}
			}
			
			$('#spec-details').append(htmls);
		});

		$(".view-delto").unbind().bind().on('click',  function () {
			debugger;
			$('#delto-box').show(500);
			$('#add_delto').hide();			
			var stores ="";
			var tr ="";
			var closetr = $(this).closest('tr');
			
			var delto = closetr.find("td:eq(12)").text();
			
			stores = $.parseJSON(delto); 
			$.each(stores,function(key,value){
				debugger;
				var store = stores[key];
				tr +='<tr><td style="width:15px;" hidden>'+store["store_id"]+'</td> <td style="text-align:left; font-weight:bold;">'+store["store_name"]+'</td><td style="width:40%;"><input type="number" style="padding:10px;" class="isRequired delto_qty" value="'+store["store_qty"]+'" autocomplete="off"  placeholder="Quantity" style="width:100%;"></td></tr>';
				
			});
			$('#delto-details').append(tr);
		});
		function loadsoitems(soitems){
			debugger;
		
			SOURCE.cf.showCmbItem(frmID +"#item_cat",'options');			
			SOURCE.cf.showCmbItem(frmID +"#item_sub_cat",'options');
			SOURCE.cf.showCmbItem(frmID +"#au",'options');
			$(frmID +"#item_cat").val(soitems[2]).select2();
			$(frmID +"#item_sub_cat").val(soitems[3]).select2();
			$(frmID +"#make").val(soitems[4]);
			$(frmID +"#model").val(soitems[5]);
			$(frmID +"#description").val(soitems[6]);
			$(frmID +"#au").val(soitems[7]).select2();
			$(frmID +"#qty").val(soitems[9]);
			$(frmID +"#per_qty_cost").val(soitems[10]);
			$(frmID +"#total_qty_cost").val(soitems[11]);
			$(frmID +"#btn_add_delivery_to").attr('data-id',soitems[12]);
			$(frmID +"#btn_add_spec").attr('data-id',soitems[13]);
			$(frmID +"#btn_add_item").attr('data-id',soitems[14]);
			$(frmID +"#item_id").val(soitems[15]);

			var so_cost = $("#So_cost").val();
			var total_so_cost = parseInt(so_cost) - parseInt(soitems[11]) ;
			$("#So_cost").val(total_so_cost);
			
		}
	}
	
	function CompileItems(){
		
		var arr=[];
		
		$("#items_details tr").each(function(i){
			debugger;
			var items={};
			
			items.category = $(this).find("td:eq(2)").text();
			items.sub_category = $(this).find("td:eq(3)").text();
			items.make = $(this).find("td:eq(4)").text();
			items.modal = $(this).find("td:eq(5)").text();
			items.name = $(this).find("td:eq(6)").text();
			items.au_id = $(this).find("td:eq(7)").text();
			items.qty = $(this).find("td:eq(9)").text();
			items.per_cost = $(this).find("td:eq(10)").text();
			items.total_cost = $(this).find("td:eq(11)").text();
			items.distribution = $(this).find("td:eq(12)").text();
			items.specification = $(this).find("td:eq(13)").text();
			items.act = $(this).find("td:eq(14)").text();
			items.item_id = $(this).find("td:eq(15)").text();		

			arr.push(items);
			
		});
		return arr;
	}

	function LoadMasters(mast) // this function will load all masters in the respective controls
	{
		debugger;
		SOURCE.cf.setComboItems($(frmID).find("#item_cat"), mast["item_cat"], false);
		SOURCE.cf.setComboItems($(frmID).find("#vendor"), mast["vendor"], false);
		SOURCE.cf.setComboItems($(frmID).find("#item_sub_cat"), mast["sub_item"], false);
		SOURCE.cf.setComboItems($(frmID).find("#au"), mast["au"], false);
		m_store = mast["store"];		
	}

	function LoadExistingDetails(dets) // load Existing Details in case of Modify, Delete, View , Verify (hides the buttons div)
	{

		debugger
		// THIS FUNCTION WILL ONLY UPDATE EXISTING DETAILS NOT INITIALIZE FORMS
		if (action != "ADD_ENTRY") {
			var details = dets[0];
			var items = dets[1];
			
			$('#transNumber').val(details[0][1]);
			$('#soNumber').val(details[0][2]);
			$('#so_date').val(details[0][3]);		
			//$('#So_cost').val(details[0][4]);
			$('#div_start_date').val(details[0][5]);
			$('#div_com_date').val(details[0][6]);
			$('#div_ext_date').val(details[0][7]);

			SOURCE.cf.showCmbItem(frmID +"#vendor",'options');

			$('#vendor').val(details[0][8]).select2();
			for(var i=0; i<items.length; i++){				
				So_items(items[i][1],items[i][2],items[i][3],items[i][4],items[i][5],items[i][10],items[i][12],items[i][13],items[i][6],items[i][11],items[i][0],items[i][9],items[i][7],items[i][8],items[i][14],items[i][15],);
			}
			
			
		}
	}
	
	function saveDetails(details) // call to server only to be made here
	{
		
		var items_details = CompileItems();

		if (items_details.length > 0) {
			if (confirm('Are you sure to save?')) {
				var frmData = details;				
				var audit = {
					"action_type_id": action_id,// 1=add,2=modify,3=delete,4=view,5=verify
					"audit_type_id": 0, // 0=na,1=observation,2=delete/reject,3=approved
					"audit_remarks": action,
					"verify_data": "",
					"encr_hash": "",
					"seq_no": 0
				};
				var _addInfo = {
					"mnuid": mnus["m_id"],
					"sub_mnuid": "0", // this value will change depending on a form mostly it will be 0
					"trans_id": trans_id,
					"frmData": frmData,
					"items": items_details,
					"audit": audit
				};

				debugger;
				SOURCE.srv.fn_CS({ srvcID: "F100", eventID: action, addInfo: _addInfo }, page_OS, $("#progressBarFooter")[0]);
			}
		}
		else {
			SOURCE.cf.showNotification("Please Add Item List", 3000, null);
		}
	}

	function page_OS(arg) {

		if (arg.r_code == "0") {
			var msg = "Data Inserted";
			if (arg.eventID == "MODIFY_ENTRY")
				msg = "Data Modified";
			else if (arg.eventID == "DELETE_ENTRY")
				msg = "Entry Deleted";
				
			SOURCE.cf.showNotification(msg, 3000, null);			
			$(container).hide();				
			ret_function({ "return": "Success", "message": msg, "level": "06" });// second parameter is a 0 
		}
		else {
		
			// $(frmID + "#sql").html(arg.r_data);
			alert(arg.r_data);
		}
	}
}