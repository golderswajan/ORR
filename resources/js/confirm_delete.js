function delete_btn_click(id,url){
    url = url+"?submit_delete="+id; // Formation of get request .. silly .. not using post request :-(
	$('#dialog').attr('title','Confirmation').text("Are you sure to delete this?").dialog({
		buttons:{'Delete':function(){
			$(this).dialog('close');
			reload_page();
            window.location.href = url;
			// $.post(url, {submit_delete:id });
		},
		  // Other buttons
		},
		closeOnEsc:true,
		draggable:true,
		resizable:false,
		show:'drop',
		modal:true,
	});
}

function reload_page()
{
	setTimeout(function () {
        location.reload()
    	}, 300);
}