<html>
<head>
<meta content="text/html; charset=windows-1251" http-equiv="Content-Type">
	<script type="text/javascript"  src="jquery-1.6.2.min.js">
	</script>
	<style type="text/css">
		* {
			font-family: Verdana, Arial;
		}
		body, html {
			width: 100%;
			height: 100%;
			padding: 0px;
			margin: 0px;
			overflow-x: hidden;
			overflow-y: auto;
		}
		body {
			background:url(bg.jpg) center -100px no-repeat #ffe8cd;
		}
		.cont1 {
			position; absolute;
			width: 100%;
			height: 100%;
		}
		.cont2 {
			position: absolute;
			left: 50%;
			top: 0px;
			margin-left: -132px;
			margin-top: 120px;
			width: 263px;
			height: 246px;
			background: url(logo.png);
		}
		.cont3 {
			position: absolute;
			top: 50%;
			width: 100%;
			height: 50%;
		}
		.cont4 {
			position: absolute;
			left: 50%;
			top: 546px;
			margin-left: -335px;
			margin-top: -110px;
			height: 221px;
			width: 669px;
			background: url(layer.png);
		}
		.text1 {
			font-size: 20px;
			color: #512223;
			text-align: center;
			padding-top: 35px;
		}
		.text2 {
			font-size: 14px;
			color: #512223;
			text-align: center;
			padding: 20px;
		}
		a {
			color: #512223;
		}
	</style>
</head>
<body>
	<script type="text/javascript">
		var _gaq = _gaq || [];
		_gaq.push(['_setAccount', 'UA-37169710-1']);
		_gaq.push(['_trackPageview']);

		(function() {
			var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
			ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
			var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
		})();
	</script>


	<script type="text/javascript">
		$(document).ready( function()
		{
			resizeLayer();
			$(window).resize( function()
			{
				resizeLayer();
			});
		});

		function resizeLayer()
		{
/*            var hh = $('.cont3').height();
            if( hh < 340 )
            {
                $('.cont4').css({'top':'506px'});
                $('.cont1').append($('.cont4'));
            }
            else
            {
                $('.cont4').css({'top':'50%'});
                $('.cont3').append($('.cont4'));
            }*/
		}
	</script>
	<div class="cont1">
		<div class="cont2">
		</div>
        <div class="cont4">
            <div class="text1">
                �������, ��� ��������� � ��� � ����������!
            </div>
            <div class="text2">
                ������ ��� ���� ��������� � ����������.<br/>
                ������� �� ���� �� <a href="http://www.facebook.com/bakermakermoscow" target="_blank">Facebook</a> � <a href="http://instagram.com/baker_maker/" target="_blank">Instagram</a><br/>
                ������� � ����������� ���� �������� �� ���.: +7 926 625 75 90<br/>
                ������ ��� ������ �� <a href="mailto:info@baker-maker.ru">info@baker-maker.ru</a><br/><br/>
��������� � ������ �������� �� ������ ���������� <a href="http://www.facebook.com/bakermakermoscow/photos_stream" target="_blank">���</a><br/>
            </div>
        </div>
		<div class="-cont3">
		</div>
	</div>
</body>
</html>