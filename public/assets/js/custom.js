$(function() {
	// cài đặt open menu khi chuyển trang
	var menu = $('.menu-data').val().split(" | ")
	$(`.${menu[0]}`).addClass('open')
	$(`.${menu[1]}`).addClass('active')
});