$(document).ready(function(){

	
	$(document).scroll(function(){
		const menuTop = $(document).scrollTop();
		if(menuTop > 80){
			$("header").css({position: "fixed",top: "0px"});
		}else{
			$("header").css({position: "relative",top: "0px"});
		}	
	});
	
	
	
})