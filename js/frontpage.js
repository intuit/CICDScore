function init() {
	//$('#vertical option[value=""]');
	

$('#vertical option[value=\'none\']').prop('selected',true);
console.log($('select[name="searchfield"]').val());

	$('select[name="searchfield"]').select2({dropdownCssClass: 'show-select-search'});
	$('.button').attr('disabled',true);
	//show_app();
}

function show_app()
{
	vert = $('#vertical').val();

	//console.log($("#app").val(null));
	cont = document.getElementById('app_container');
	cont.innerHTML = '<select data-toggle="select" name="searchfield" class="form-control select select-default mrs mbm" id="app" onchange="enable_next()" style="width:400px;"></select>';
	$('select[name="searchfield"]').select2({dropdownCssClass: 'show-select-search'});
		$.ajax({
			url:'get_file.php?vertical='+vert,
			success: function (data) {
				data = data.split(';');
				option = document.createElement("option");
				option.value = "test";
				option.innerHTML = "Select";
				app.appendChild(option);
				for (var i = 0; i < data.length; i++) 
				{
					option = document.createElement("option");
					option.value = data[i];
					option.innerHTML = data[i];
					app.appendChild(option);

				}
				//$('select[name="searchfield"]').val(null);
				
				$('select[name="searchfield"]').val("");
				//console.log($('#app').val());
			}
		});
	// }

}

function enable_next() 
{
	$('.button').attr('disabled',false);
}

function next() {
	vert = $('#vertical').val();
	app = $('#app').val();
	window.location.assign('score.php?vertical='+vert+'&app='+app);
}
