
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- link rel="shortcut icon" href="assets/ico/favicon.ico" -->

    <meta http-equiv="last-modified" content="2014-11-27@23:45:00" />
    <!--meta http-equiv="cache-control" content="no-cache" /-->

    <meta property="og:title" content="Baker-Maker. Мастерская сладких идей."/>
    <meta property="og:url" content="http://baker-maker.ru" />
    <meta property="og:image" content="http://baker-maker.ru/img/bg_01.jpg" />

    <meta name="viewport" content="width=1280">

    <title>Baker-Maker.ru</title>

    <!-- Bootstrap core CSS -->
    <link href="bootstrap-3.1.1/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/styles.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <script src="js/jquery-2.1.0.min.js"></script>
    <script src="bootstrap-3.1.1/js/bootstrap.min.js"></script>

    <script type="text/javascript">
        $(document).ready( function()
        {
            $(document).scroll(function() {
                var scrTop = $(document).scrollTop();
                var nav = $('#js-navigation');
                var sections = $('[id^="js-sect"]');
                var currIndex = 0;
                sections.each( function(index) {
                    if ($(this).offset().top - scrTop > 32)
                        return false;
                    currIndex = index;
                });
                // Start at 1
                currIndex++;

                nav.find('ul li').removeClass('active');
                nav.find('ul li[data-sect='+currIndex+']').addClass('active');
            });
            $(document).trigger('scroll');
        });
    </script>
</head>

<body>
    <div class='main-container  cont'>
<!--
        <div class='b'>
            <img src='img/bg_01.jpg'>
            <p>This is test text</p>
        </div>
        <div class='b'>
            <img src='img/bg_02.jpg'>
        </div>

-->

        <div class='navigation' id='js-navigation'>
            <ul class='navigation'>
                <li data-sect='1'></li>
                <li data-sect='2'></li>
                <li data-sect='3'></li>
                <li data-sect='4'></li>
                <li data-sect='5'></li>
                <li data-sect='6'></li>
                <li data-sect='7'></li>
                <li data-sect='8'></li>
                <li data-sect='9'></li>
            </ul>
        </div>

        <div class='row  block1' id='js-sect1'>
            <ul class='menu'>
                <li><a href='#contacts'>Контакты</a></li>
            </ul>
        </div>
        <div class='row  block2'></div>
        <div class='row  block3'></div>

        <div class='row  block4' id='js-sect2'></div>
        <div class='row  block5' id='js-sect3'></div>
        <div class='row  block6' id='js-sect4'></div>
        <div class='row  block7'></div>
        <div class='row  block8' id='js-sect5'></div>
        <div class='row  block9' id='js-sect6'></div>
        <div class='row  block10' id='js-sect7'></div>
        <div class='row  block11' id='js-sect8'></div>
        <div class='row  block12'></div>
        <div class='row  block13 cont' id='js-sect9'>
            <a name='contacts' class='anchor'></a>
            <div class='contacts'>
                +8 926 625 75 90
                <br/>
                <a href="mailto:info@baker-maker.ru">info@baker-maker.ru</a>
                <br/>
                <a href="http://www.facebook.com/bakermakermoscow" target="_blank">Facebook</a> и <a href="http://instagram.com/baker_maker/" target="_blank">Instagram</a>
            </div>
        </div>
    </div>
</body>
</html>
