$(function( ) {
 $("#thumb1").on("load",function(){
 var iw, ih;
 var cw = 300; /*トリミング後の横幅*/
 var ch = 300; /*トリミング後の縦幅*/
 iw = ($(this).width() - cw) / 2;
 ih = ($(this).height() - ch) / 2;
 $(this).css("top", "-"+ih+"px");
 $(this).css("left", "-"+iw+"px");
 });
 });