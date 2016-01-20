/* scrollTo */
$(function() {
	$('.page-top > a').bind('click',function(){
		$('body,html').animate({ scrollTop: 0 }, 500);
	});
});

/* SLIDESHOW MAIN */
$(function(){

	$('.flexslider').flexslider({
		animation: "slide",
		start: function(slider){
			$('body').removeClass('loading');
		}
	});

});
function addCommas(nStr)
{
      nStr += '';
      x = nStr.split('.');
      x1 = x[0];
      x2 = x.length > 1 ? '.' + x[1] : '';
      var rgx = /(\d+)(\d{3})/;
      while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
      }
      return x1 + x2;
}



