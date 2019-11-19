$(document).ready(function() {
	$('.element-group .element').click(function(){
		$this = $(this).parent('.element-group').find('.actions');
		$nothis = $(this).parent('.element-group').siblings().find('.actions');
		$this.slideToggle();
		$nothis.slideUp();
	});
	
});