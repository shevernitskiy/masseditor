$(document).ready(function () {
    $('#metakey_menu').click(function(){
	var products = $.product_list.getSelectedProducts(true);
        if (!products.count) {
            alert('Выберите хотя бы один товар');
            return false;
        }
        $.post('?plugin=editor&action=metakey', function(mydialog) {
            $(mydialog).waDialog({
		'onClose' : function(f) {
		    $(this).remove;
		},
		'esc' : false,
		'onSubmit': function (d) {
		    var form = d.find('form');
			form.find('.dialog-buttons i.loading').show();
		    $.post(form.attr('action'), form.serializeArray().concat(products.serialized), function (r) {
			if(r.status=='ok'){
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