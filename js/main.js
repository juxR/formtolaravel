;(function( $ ){

	$(function(){
		$('.send').on('click',getHTML);
	});
	var getHTML = function(){
		sHtml = $('#form').val().replace('\n',"").replace(' ','');
		
		//$form = $html.find('<form>');
		console.log(sHtml.split('<form>'));
	}


}).call(this,jQuery);