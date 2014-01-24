$(function () {
	if (typeof window.addEventListener == "undefined" && typeof document.documentElement.style.maxHeight == "undefined") {
		$('body').prepend('<div class="ie6_error">現在、旧式ブラウザをご利用中です。このウェブサイトは、現在ご利用中のブラウザには対応しておりません。バージョンを確認し、アップグレードを行ってください。</div>');
	}
});