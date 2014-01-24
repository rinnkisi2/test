$(function(){
		//st--スクロール
    $('a.scr[href^="#"]').click(function(event) {
        var id = $(this).attr("href");
        var offset = 60;
        var target = $(id).offset().top - offset;
        $('html, body').animate({scrollTop:target}, 500);
        event.preventDefault();
        return false;
    });
		//アコーディオン
		$("#btnTrg").click(function(fast){
			$("#searchBox").slideDown();
			$(".close a").click(function(fast){
				$("#searchBox").slideUp();				
				});
		});
		//ページトップボタン
		var topBtn = $('#btn_pt');	
		topBtn.hide();
		$(window).scroll(function () {
			if ($(this).scrollTop() > 100) {
				topBtn.fadeIn();
			} else {
				topBtn.fadeOut();
			}
		});
		topBtn.click(function () {
		$('body,html').animate({
			scrollTop: 0
		}, 500);
		return false;
		});
});