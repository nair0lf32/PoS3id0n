<!DOCTYPE html>
<html lang="en">

<head>
    <title></title>

    <meta charset="utf-8">
    <meta name="description" content="poseidon">
    <meta name="viewport" content="width=device-width, user-scalable=no, maximum-scale=1.0, minimum-scale=1.0">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">

    <link rel="shortcut icon" href="favicon.ico">

    <link rel="stylesheet" href="/css/style.css">
</head>

<body>
    <header>
        <div class=container>
            <h1>PoSeid</h1>
            <div class=eyeball>
                <div class="eyelid"></div>
                <div class="eye-wrap">
                    <div class="inner-eye">
                        <div class="pupil"></div>
                        <div class="light"></div>
                    </div>

                </div>
            </div>
            <h1>n</h1>
        </div>
    </header>


    <section class="content-main">
        <div class="message">
            <?php
            echo "<p> Hello, and welcome. I am poseidon's eye...I can see you! whoever you are, wherever you are. 
            Ok that may not be true, as your privacy would be at risk. 
            But hey you can still test me and see what I see about you. 
            Let me show you...A quick gaze in your data...and BEHOLD!</p>";
            ?>
        </div>

        <div class=gaze-data>
            <?php include 'gaze.php'; ?>
        </div>

    </section>

    <footer>
        <p class="copyright">by florian EDEMESSI (nair0lf32) 2021</p>
    </footer>
    </div>

    <script type="text/javascript" src="/js/script.js"></script>
</body>

</html>