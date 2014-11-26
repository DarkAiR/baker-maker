
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
    <div class='container-fluid'>
            <div class='row  block1'>
                <ul class='menu'>
                    <li><a href='#contacts'>Контакты</a></li>
                </ul>
            </div>
            <div class='row  block2'></div>
            <div class='row  block3'></div>
            <div class='row  block4'></div>
            <div class='row  block5'></div>
            <div class='row  block6'></div>
            <div class='row  block7'></div>
            <div class='row  block8'></div>
            <div class='row  block9'></div>
            <div class='row  block10'></div>
            <div class='row  block11'></div>
            <div class='row  block12'></div>

            <a name='contacts'></a>
            <div class='row  block13 cont'>
                <div class='contacts'>
                    +8 926 625 75 90
                    <br/>
                    <a href="mailto:info@baker-maker.ru">info@baker-maker.ru</a>
                    <br/>
                    <a href="http://www.facebook.com/bakermakermoscow" target="_blank">Facebook</a> и <a href="http://instagram.com/baker_maker/" target="_blank">Instagram</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
