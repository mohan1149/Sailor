<?php
    include(app_path().'/translations/strings.php');
    session_start();
    $lang = 'en';
    if(isset($_GET['lan'])){
        $lang             = $_GET['lan'];
        $_SESSION['lang'] = $lang;
    }else{
        $lang             = 'English';
        $_SESSION['lang'] = $lang;
    }
    $strings = $_SESSION['lang'];
?>
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Login to Sailor</title>
        <!-- Scripts -->
        <script type="text/javascript" src="<?php echo asset('jquery.min.js')?>"></script>
        <script type="text/javascript" src="<?php echo asset('master.js')?>"></script>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="<?php echo asset('w3.css')?>">
        <!-- Styles -->
        <style>
            html, body {
                /* color: #636b6f; */
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }
            .left{
                background-color: rgb(61, 94, 161);
                height:100vh;
            }
            .right{
                height:100vh;
            }
            .left-container{
                margin-top:20vh;
            }
            .logo-text{
                margin-top:10px;
            }
            .right-container{
                margin-top:20vh;
            }
            .title{
                font-family: 'Nunito', sans-serif;
                font-weight:200;
                text-align:center;
            }
            .intro{
                font-family: 'Nunito', sans-serif;
                font-weight:200;
                margin-left:50px;
                margin-right:50px;
            }
            .form-input{
                width:80%;
                margin-bottom:10px;
                border-width:0px;
                border-radius:30px;
                padding:4px;
                padding-left:10px;
                margin-left:2px;
                height:40px;

            }
            .form-submit{
                width:50%;
                border-radius:30px;
                background-color: rgb(61, 94, 161);
            }
        </style>
    </head>
    <body>
        <div class="w3-row">
            <div class="w3-half left w3-center">
                <div class="left-container">
                    <svg width="300" viewBox="0 0 268.2120056152344 267.4739990234375">
                        <g>
                            <svg viewBox="0 0 268.212 267.474" fill="#dee58d">
                                <path d="M268.212,227.412c-9.872,12.646-22.085,27.813-31.956,40.062c-1.081,0-192.286-0.576-199.788-0.576  c-0.18,0-1.909-1.188-5.197-3.566c-6.413-3.999-12.799-9.583-19.194-16.717C4.197,238.185,0.18,231.447,0,226.331L268.212,227.412z   M86.672,207.057H20.581L86.672,0.541V207.057z M253.946,207.057H110.522V0L253.946,207.057z">
                                </path>
                            </svg>
                        </g>
                    </svg>
                </div>
                <div class="logo-text">
                    <div>
                        <svg width="136.75" viewBox="3.2200000286102295 13.819999694824219 136.75 31.110000610351562" overflow="visible" style="overflow: visible;">
                            <path stroke="none" fill="#ffffff" d="M6.62 20.16L6.62 20.16Q6.62 22.08 7.54 23.47L7.54 23.47L7.54 23.47Q8.45 24.86 9.77 25.80L9.77 25.80L9.77 25.80Q11.09 26.74 13.44 28.13L13.44 28.13L13.44 28.13Q15.94 29.62 17.30 30.60L17.30 30.60L17.30 30.60Q18.67 31.58 19.66 33.12L19.66 33.12L19.66 33.12Q20.64 34.66 20.64 36.82L20.64 36.82L20.64 36.82Q20.64 39.07 19.54 40.92L19.54 40.92L19.54 40.92Q18.43 42.77 16.25 43.85L16.25 43.85L16.25 43.85Q14.06 44.93 10.90 44.93L10.90 44.93L10.90 44.93Q9.22 44.93 7.70 44.57L7.70 44.57L7.70 44.57Q6.19 44.21 4.37 43.30L4.37 43.30L4.37 43.30Q4.13 43.15 4.06 42.96L4.06 42.96L4.06 42.96Q3.98 42.77 3.94 42.38L3.94 42.38L3.22 36.14L3.22 36.10L3.22 36.10Q3.22 35.90 3.46 35.88L3.46 35.88L3.46 35.88Q3.70 35.86 3.74 36.05L3.74 36.05L3.74 36.05Q4.22 39.36 6.29 41.81L6.29 41.81L6.29 41.81Q8.35 44.26 11.95 44.26L11.95 44.26L11.95 44.26Q14.50 44.26 16.25 42.86L16.25 42.86L16.25 42.86Q18 41.47 18 38.50L18 38.50L18 38.50Q18 36.34 17.04 34.78L17.04 34.78L17.04 34.78Q16.08 33.22 14.71 32.18L14.71 32.18L14.71 32.18Q13.34 31.15 10.99 29.76L10.99 29.76L10.99 29.76Q8.69 28.42 7.37 27.41L7.37 27.41L7.37 27.41Q6.05 26.40 5.11 24.89L5.11 24.89L5.11 24.89Q4.18 23.38 4.18 21.26L4.18 21.26L4.18 21.26Q4.18 18.86 5.40 17.18L5.40 17.18L5.40 17.18Q6.62 15.50 8.59 14.66L8.59 14.66L8.59 14.66Q10.56 13.82 12.82 13.82L12.82 13.82L12.82 13.82Q15.46 13.82 18.29 14.98L18.29 14.98L18.29 14.98Q19.01 15.26 19.01 15.79L19.01 15.79L19.44 20.88L19.44 20.88Q19.44 21.07 19.18 21.07L19.18 21.07L19.18 21.07Q18.91 21.07 18.86 20.88L18.86 20.88L18.86 20.88Q18.67 18.38 16.99 16.42L16.99 16.42L16.99 16.42Q15.31 14.45 12.19 14.45L12.19 14.45L12.19 14.45Q9.31 14.45 7.97 16.13L7.97 16.13L7.97 16.13Q6.62 17.81 6.62 20.16L6.62 20.16ZM49.97 43.78L49.97 43.78Q50.16 43.78 50.16 44.06L50.16 44.06L50.16 44.06Q50.16 44.35 49.97 44.35L49.97 44.35L49.97 44.35Q49.10 44.35 47.18 44.26L47.18 44.26L47.18 44.26Q45.36 44.16 44.50 44.16L44.50 44.16L44.50 44.16Q43.82 44.16 42.58 44.26L42.58 44.26L42.58 44.26Q41.42 44.35 40.80 44.35L40.80 44.35L40.80 44.35Q40.61 44.35 40.61 44.06L40.61 44.06L40.61 44.06Q40.61 43.78 40.80 43.78L40.80 43.78L40.80 43.78Q42.10 43.78 42.74 43.44L42.74 43.44L42.74 43.44Q43.39 43.10 43.39 42.29L43.39 42.29L43.39 42.29Q43.39 41.52 42.82 40.32L42.82 40.32L39.50 33.12L32.45 33.12L30.34 38.45L30.34 38.45Q29.57 40.46 29.57 41.42L29.57 41.42L29.57 41.42Q29.57 42.67 30.46 43.22L30.46 43.22L30.46 43.22Q31.34 43.78 33.12 43.78L33.12 43.78L33.12 43.78Q33.36 43.78 33.36 44.06L33.36 44.06L33.36 44.06Q33.36 44.35 33.12 44.35L33.12 44.35L33.12 44.35Q32.40 44.35 31.15 44.26L31.15 44.26L31.15 44.26Q29.81 44.16 28.66 44.16L28.66 44.16L28.66 44.16Q27.46 44.16 25.82 44.26L25.82 44.26L25.82 44.26Q24.38 44.35 23.52 44.35L23.52 44.35L23.52 44.35Q23.33 44.35 23.33 44.06L23.33 44.06L23.33 44.06Q23.33 43.78 23.52 43.78L23.52 43.78L23.52 43.78Q25.01 43.78 25.87 43.37L25.87 43.37L25.87 43.37Q26.74 42.96 27.46 41.76L27.46 41.76L27.46 41.76Q28.18 40.56 29.23 38.02L29.23 38.02L36.10 21.17L36.10 21.17Q36.19 20.98 36.38 20.98L36.38 20.98L36.38 20.98Q36.58 20.98 36.62 21.17L36.62 21.17L44.35 37.78L44.35 37.78Q45.60 40.46 46.34 41.66L46.34 41.66L46.34 41.66Q47.09 42.86 47.88 43.32L47.88 43.32L47.88 43.32Q48.67 43.78 49.97 43.78L49.97 43.78ZM35.71 24.96L32.78 32.35L39.12 32.35L35.71 24.96ZM58.42 40.46L58.42 40.46Q58.42 41.95 58.68 42.62L58.68 42.62L58.68 42.62Q58.94 43.30 59.69 43.54L59.69 43.54L59.69 43.54Q60.43 43.78 62.11 43.78L62.11 43.78L62.11 43.78Q62.26 43.78 62.26 44.06L62.26 44.06L62.26 44.06Q62.26 44.35 62.11 44.35L62.11 44.35L62.11 44.35Q60.82 44.35 60.10 44.30L60.10 44.30L57.12 44.26L54.29 44.30L54.29 44.30Q53.52 44.35 52.18 44.35L52.18 44.35L52.18 44.35Q52.08 44.35 52.08 44.06L52.08 44.06L52.08 44.06Q52.08 43.78 52.18 43.78L52.18 43.78L52.18 43.78Q53.86 43.78 54.62 43.54L54.62 43.54L54.62 43.54Q55.39 43.30 55.66 42.60L55.66 42.60L55.66 42.60Q55.92 41.90 55.92 40.46L55.92 40.46L55.92 25.78L55.92 25.78Q55.92 24.34 55.66 23.66L55.66 23.66L55.66 23.66Q55.39 22.99 54.60 22.73L54.60 22.73L54.60 22.73Q53.81 22.46 52.18 22.46L52.18 22.46L52.18 22.46Q52.08 22.46 52.08 22.18L52.08 22.18L52.08 22.18Q52.08 21.89 52.18 21.89L52.18 21.89L54.29 21.94L54.29 21.94Q56.11 22.03 57.12 22.03L57.12 22.03L57.12 22.03Q58.32 22.03 60.14 21.94L60.14 21.94L62.11 21.89L62.11 21.89Q62.26 21.89 62.26 22.18L62.26 22.18L62.26 22.18Q62.26 22.46 62.11 22.46L62.11 22.46L62.11 22.46Q60.53 22.46 59.76 22.75L59.76 22.75L59.76 22.75Q58.99 23.04 58.70 23.74L58.70 23.74L58.70 23.74Q58.42 24.43 58.42 25.87L58.42 25.87L58.42 40.46ZM72.05 25.82L72.05 40.27L72.05 40.27Q72.05 41.66 72.31 42.36L72.31 42.36L72.31 42.36Q72.58 43.06 73.34 43.34L73.34 43.34L73.34 43.34Q74.11 43.63 75.65 43.63L75.65 43.63L79.49 43.63L79.49 43.63Q84.19 43.63 85.01 37.87L85.01 37.87L85.01 37.87Q85.01 37.78 85.20 37.78L85.20 37.78L85.20 37.78Q85.34 37.78 85.46 37.82L85.46 37.82L85.46 37.82Q85.58 37.87 85.58 37.97L85.58 37.97L85.58 37.97Q85.25 40.03 85.25 43.63L85.25 43.63L85.25 43.63Q85.25 44.02 85.08 44.18L85.08 44.18L85.08 44.18Q84.91 44.35 84.53 44.35L84.53 44.35L65.86 44.35L65.86 44.35Q65.76 44.35 65.76 44.06L65.76 44.06L65.76 44.06Q65.76 43.78 65.86 43.78L65.86 43.78L65.86 43.78Q67.49 43.78 68.26 43.54L68.26 43.54L68.26 43.54Q69.02 43.30 69.29 42.60L69.29 42.60L69.29 42.60Q69.55 41.90 69.55 40.46L69.55 40.46L69.55 25.78L69.55 25.78Q69.55 24.34 69.29 23.66L69.29 23.66L69.29 23.66Q69.02 22.99 68.26 22.73L68.26 22.73L68.26 22.73Q67.49 22.46 65.86 22.46L65.86 22.46L65.86 22.46Q65.76 22.46 65.76 22.18L65.76 22.18L65.76 22.18Q65.76 21.89 65.86 21.89L65.86 21.89L67.97 21.94L67.97 21.94Q69.70 22.03 70.75 22.03L70.75 22.03L70.75 22.03Q71.95 22.03 73.68 21.94L73.68 21.94L75.70 21.89L75.70 21.89Q75.79 21.89 75.79 22.18L75.79 22.18L75.79 22.18Q75.79 22.46 75.70 22.46L75.70 22.46L75.70 22.46Q74.06 22.46 73.32 22.73L73.32 22.73L73.32 22.73Q72.58 22.99 72.31 23.69L72.31 23.69L72.31 23.69Q72.05 24.38 72.05 25.82L72.05 25.82ZM99.50 44.93L99.50 44.93Q96.14 44.93 93.53 43.34L93.53 43.34L93.53 43.34Q90.91 41.76 89.50 39.10L89.50 39.10L89.50 39.10Q88.08 36.43 88.08 33.31L88.08 33.31L88.08 33.31Q88.08 29.57 90.05 26.83L90.05 26.83L90.05 26.83Q92.02 24.10 95.02 22.70L95.02 22.70L95.02 22.70Q98.02 21.31 101.14 21.31L101.14 21.31L101.14 21.31Q104.50 21.31 107.04 22.94L107.04 22.94L107.04 22.94Q109.58 24.58 110.95 27.22L110.95 27.22L110.95 27.22Q112.32 29.86 112.32 32.74L112.32 32.74L112.32 32.74Q112.32 36 110.59 38.81L110.59 38.81L110.59 38.81Q108.86 41.62 105.91 43.27L105.91 43.27L105.91 43.27Q102.96 44.93 99.50 44.93L99.50 44.93ZM100.80 43.97L100.80 43.97Q104.78 43.97 107.16 41.33L107.16 41.33L107.16 41.33Q109.54 38.69 109.54 33.98L109.54 33.98L109.54 33.98Q109.54 30.77 108.38 28.10L108.38 28.10L108.38 28.10Q107.23 25.44 104.98 23.86L104.98 23.86L104.98 23.86Q102.72 22.27 99.55 22.27L99.55 22.27L99.55 22.27Q95.42 22.27 93.14 24.91L93.14 24.91L93.14 24.91Q90.86 27.55 90.86 32.16L90.86 32.16L90.86 32.16Q90.86 35.42 92.04 38.11L92.04 38.11L92.04 38.11Q93.22 40.80 95.47 42.38L95.47 42.38L95.47 42.38Q97.73 43.97 100.80 43.97L100.80 43.97ZM139.87 43.78L139.87 43.78Q139.97 43.78 139.97 44.06L139.97 44.06L139.97 44.06Q139.97 44.35 139.87 44.35L139.87 44.35L134.83 44.35L134.83 44.35Q133.97 44.35 131.66 41.47L131.66 41.47L131.66 41.47Q129.36 38.59 126.14 33.50L126.14 33.50L126.14 33.50Q124.90 33.70 124.13 33.70L124.13 33.70L124.13 33.70Q123.46 33.70 122.02 33.60L122.02 33.60L122.02 40.46L122.02 40.46Q122.02 41.95 122.28 42.62L122.28 42.62L122.28 42.62Q122.54 43.30 123.29 43.54L123.29 43.54L123.29 43.54Q124.03 43.78 125.71 43.78L125.71 43.78L125.71 43.78Q125.86 43.78 125.86 44.06L125.86 44.06L125.86 44.06Q125.86 44.35 125.71 44.35L125.71 44.35L125.71 44.35Q124.42 44.35 123.70 44.30L123.70 44.30L120.77 44.26L117.98 44.30L117.98 44.30Q117.22 44.35 115.82 44.35L115.82 44.35L115.82 44.35Q115.73 44.35 115.73 44.06L115.73 44.06L115.73 44.06Q115.73 43.78 115.82 43.78L115.82 43.78L115.82 43.78Q117.50 43.78 118.27 43.54L118.27 43.54L118.27 43.54Q119.04 43.30 119.33 42.60L119.33 42.60L119.33 42.60Q119.62 41.90 119.62 40.46L119.62 40.46L119.62 25.78L119.62 25.78Q119.62 24.34 119.33 23.66L119.33 23.66L119.33 23.66Q119.04 22.99 118.27 22.73L118.27 22.73L118.27 22.73Q117.50 22.46 115.87 22.46L115.87 22.46L115.87 22.46Q115.78 22.46 115.78 22.18L115.78 22.18L115.78 22.18Q115.78 21.89 115.87 21.89L115.87 21.89L118.03 21.94L118.03 21.94Q119.76 22.03 120.77 22.03L120.77 22.03L120.77 22.03Q121.68 22.03 122.40 21.98L122.40 21.98L122.40 21.98Q123.12 21.94 123.60 21.89L123.60 21.89L123.60 21.89Q125.09 21.74 126.38 21.74L126.38 21.74L126.38 21.74Q129.31 21.74 130.87 22.94L130.87 22.94L130.87 22.94Q132.43 24.14 132.43 26.40L132.43 26.40L132.43 26.40Q132.43 28.37 131.35 30.00L131.35 30.00L131.35 30.00Q130.27 31.63 128.45 32.64L128.45 32.64L128.45 32.64Q131.18 37.06 133.03 39.41L133.03 39.41L133.03 39.41Q134.88 41.76 136.46 42.77L136.46 42.77L136.46 42.77Q138.05 43.78 139.87 43.78L139.87 43.78ZM122.02 32.69L122.02 32.69Q122.93 32.88 124.46 32.88L124.46 32.88L124.46 32.88Q127.49 32.88 128.69 31.56L128.69 31.56L128.69 31.56Q129.89 30.24 129.89 27.70L129.89 27.70L129.89 27.70Q129.89 22.37 125.09 22.37L125.09 22.37L125.09 22.37Q123.17 22.37 122.59 23.18L122.59 23.18L122.59 23.18Q122.02 24.00 122.02 25.87L122.02 25.87L122.02 32.69Z" transform="rotate(0 71.59500002861023 29.375)">
                            </path>
                        </svg>
                    </div>
                </div>
            </div>
            <div class="w3-half right w3-dark-grey">
                <select class="w3-right language" style="margin:5px;">
                    <?php
                        $languages = ['English','Arabic','Hindi'];
                        foreach($languages as $lan){
                            if($lan === $lang){
                                ?>
                                    <option selected value="<?php echo $lan?>"><?php echo $lan?></option>
                                <?php
                            }else{
                                ?>
                                    <option value="<?php echo $lan?>"><?php echo $lan?></option>
                                <?php
                            }
                        }
                    ?>
                </select>
                <div class="right-container">
                    <div class="content">
                        <div class='signup-form'>
                            <h2 class="title"><?php echo $$strings['title'];?></h2>
                            <h5 class="intro">
                                <?php echo $$strings['intro']?>
                            </h5>
                            <form action='/login' method="POST" class="w3-center">
                                @csrf
                                <div class='form-group'>
                                    <span><i class='fa fa-envelope login-icons'></i></span>
                                    <input class="form-input"type='email' placeholder="<?php echo $$strings['email'];?>" name='email'>
                                </div>
                                <div class='form-group'>
                                    <span><i style="font-size:21px;"class='fa fa-lock login-icons'></i></span>
                                    <input class="form-input" type='password' placeholder=<?php echo $$strings['password']?> name='password'>
                                </div>

                                <div class='form-group' style='text-align:center'>
                                    <input class="form-submit w3-button" type='submit' value="<?php echo $$strings['login']?>">
                                </div>
                            </form>
                            <a class="w3-right" href="/forgot/password" style="margin-right:20px;"><?php echo $$strings['forgotpwd']?></a>
                            <a class="w3-left" href="/staff/login" style="margin-left:20px;"><?php echo 'Staff Login'?></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
