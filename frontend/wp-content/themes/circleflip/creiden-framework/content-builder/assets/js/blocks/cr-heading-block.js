jQuery(document).ready(function($){
	function headingicon(){
		$('.headingSelect select').each(function(){
			if($(this).val() == 2 ){
				$(this).closest('.headingSelect').parent().find('.ButtonIcon').addClass('show');
				$(this).closest('.headingSelect').parent().find('.ButtonIcon').removeClass('hide');
			}else{
				$(this).closest('.headingSelect').parent().find('.ButtonIcon').addClass('hide');
				$(this).closest('.headingSelect').parent().find('.ButtonIcon').removeClass('show');
			}
		});
		$('.headingSelect select').change(function(){
			if($(this).val() == 2 ){
				$(this).closest('.headingSelect').parent().find('.ButtonIcon').addClass('show');
				$(this).closest('.headingSelect').parent().find('.ButtonIcon').removeClass('hide');
			}else{
				$(this).closest('.headingSelect').parent().find('.ButtonIcon').addClass('hide');
				$(this).closest('.headingSelect').parent().find('.ButtonIcon').removeClass('show');
			}
		});
	}
});
