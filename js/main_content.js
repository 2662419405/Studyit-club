var num = 0;
var arr = ['#include "stdio.h"', 'int main(){', '    printf("Welcome To IT Club");', "    printf('We are family!');", "    printf('Hello World');", "}"];
var aaa = 3500;

var timer = setInterval(function() {

	if(num == arr.length - 1) {
		clearInterval(timer);
	}
	var str = 'content_main_' + num;
	$('#zhuijiaContent').append("<div id=" + str + " class='ace_line' style='height:20px'></div>")
	var num2 = 0;
	var brr = arr[num].split('');
	var str1 = '';

	var Timer2 = setInterval(function() {
		if(num2 == brr.length - 1) {
			clearInterval(Timer2)
		}
		if(brr[num2] == " ") {
			str1 += '&nbsp';
		} else {
			str1 += brr[num2];
		}
		var span_id = 'span_main_content' + num;
		$('#content_main_' + (num - 1)).html(str1 + "<span style='opacity:0.5' id=" + span_id + ">|</span>");
		num2++;
	}, 80);

	$('#span_main_content' + num).hide();

	num = num + 1;
}, aaa);

timee = arr.length * aaa + 1000;

setTimeout(function() {
	$('#cang_content').fadeIn(400);
}, timee)