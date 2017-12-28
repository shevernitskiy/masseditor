$(document).ready(function () {
    $('#metadesc_menu').click(function(){
	var products = $.product_list.getSelectedProducts(true);
        if (!products.count) {
            alert('Выберите хотя бы один товар');
            return false;
        }
        $.post('?plugin=editor&action=metadesc', function(mydialog) {
            $(mydialog).waDialog({
		'onClose' : function(f) {
		    $(this).remove;
		},
		'esc' : false,
		'onSubmit': function (d) {
		    var form = d.find('form');
			form.find('.dialog-buttons i.loading').show();
			console.log(form.attr('action'));
		    $.post(form.attr('action'), form.serializeArray().concat(products.serialized), function (r) {
				console.log(r);
			if(r.status=='ok'){
				console.log('inside');
			    location.reload();
			}else{
			    form.find('.dialog-buttons i.loading').hide();
			    $.post('?plugin=editor&action=setError',{'errors':r.errors},function(error_dlg){
				$(error_dlg).waDialog({
				    'width' :'450px',
				    'height':'150px'
			        });
			    });
			}
		    });
		    return false;
		},
            });
	});
        return false;
	});
});