
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- link rel="shortcut icon" href="assets/ico/favicon.ico" -->

    <title>Starter Template for Bootstrap</title>

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
            var swRus = $('#sw-rus');
            var swEng = $('#sw-eng');
            var logo = $('.logo');
            var prevSw = false;
            swRus.click( function()
            {
                if (prevSw)
                    prevSw.toggleClass('active');
                prevSw = swRus;
                prevSw.toggleClass('active');
                $('.info .eng').hide();
                $('.info .rus').show();
                logo.removeClass('eng').addClass('rus');
            });
            swEng.click( function()
            {
                if (prevSw)
                    prevSw.toggleClass('active');
                prevSw = swEng;
                prevSw.toggleClass('active');
                $('.info .rus').hide();
                $('.info .eng').show();
                logo.removeClass('rus').addClass('eng');
            });
            swRus.trigger('click');
        });
    </script>
</head>

<body>
    <div class='container outer-cont'>
        <div class='inner-cont content'>
            <div class='logo'></div>
            <div class='switcher'>
                <div id='sw-rus'>RUS</div>
                <div id='sw-eng'>ENG</div>
            </div>
            <div class='info'>
                <div class='rus' style='display:none;'>
                    <p>
                        Спасибо, что заглянули к нам в мастерскую!<br>
                        <i>Сейчас наш сайт находится в разработке!</i><br>
                        Следите за нами на <a href="http://www.facebook.com/bakermakermoscow" target="_blank">Facebook</a> и <a href="http://instagram.com/baker_maker/" target="_blank">Instagram</a>
                    </p>
                    <p>
                        Звоните и заказывайте наши сладости по тел.: <b>+7 926 625 75 90</b><br>
                        Пишите нам письма на <a href="mailto:info@baker-maker.ru">info@baker-maker.ru</a>
                    </p>
                    <p>
                        Портфолио с нашими работами вы можете посмотреть <a href="http://www.facebook.com/bakermakermoscow/photos_stream" target="_blank">тут</a>
                    </p>
                </div>
                <div class='eng' style='display:none;'>
                    <p>
                        Thank you for your visit!<br>
                        <i>Our page is under construction and it's coming soon!</i><br>
                        Follow us on <a href="http://www.facebook.com/bakermakermoscow" target="_blank">Facebook</a> and <a href="http://instagram.com/baker_maker/" target="_blank">Instagram</a>
                    </p>
                    <p>
                        Fancy to try our cakes, call us <b>+7 926 625 75 90</b><br>
                        or e-mail us <a href="mailto:info@baker-maker.ru">info@baker-maker.ru</a>
                    </p>
                    <p>
                        Want to see them first - <a href="http://www.facebook.com/bakermakermoscow/photos_stream" target="_blank">click here</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
