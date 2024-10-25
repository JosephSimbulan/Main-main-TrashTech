<?php
// loading_animation.php
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loading Animation</title>
    <style>
        body {
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: #f0f0f0; /* Light background for better visibility */
        }

        .wrapper {
            width: 200px;
            height: 200px;
            position: relative;
            overflow: hidden;
        }

        .box-wrap {
            width: 100%;
            height: 100%;
            position: absolute;
            display: flex;
            flex-wrap: wrap;
            align-content: space-between;
        }

        .box {
            width: 30%;
            height: 30%;
            border-radius: 5%;
            position: relative;
            animation: boxMove 1.4s infinite;
        }

        .box.one {
            background: #f44336; /* Red */
            animation-delay: 0s;
        }

        .box.two {
            background: #2196F3; /* Blue */
            animation-delay: 0.2s;
        }

        .box.three {
            background: #4CAF50; /* Green */
            animation-delay: 0.4s;
        }

        .box.four {
            background: #FFEB3B; /* Yellow */
            animation-delay: 0.6s;
        }

        .box.five {
            background: #FF5722; /* Orange */
            animation-delay: 0.8s;
        }

        .box.six {
            background: #9C27B0; /* Purple */
            animation-delay: 1.0s;
        }

        @keyframes boxMove {
            0% {
                visibility: visible;
                clip-path: inset(0% 0% 0% 70% round 5%);
                animation-timing-function: cubic-bezier(0.86, 0, 0.07, 1);
            }

            14.2857% {
                clip-path: inset(0% 0% 0% 70% round 5%);
                animation-timing-function: cubic-bezier(0.86, 0, 0.07, 1);
            }

            28.5714% {
                clip-path: inset(35% round 5%);
                animation-timing-function: cubic-bezier(0.86, 0, 0.07, 1);
            }

            42.8571% {
                clip-path: inset(35% 0% 35% 70% round 5%);
                animation-timing-function: cubic-bezier(0.86, 0, 0.07, 1);
            }

            57.1428% {
                clip-path: inset(0% 0% 0% 70% round 5%);
                animation-timing-function: cubic-bezier(0.86, 0, 0.07, 1);
            }

            71.4285% {
                clip-path: inset(0% 0% 0% 70% round 5%);
                animation-timing-function: cubic-bezier(0.86, 0, 0.07, 1);
            }

            85.7142% {
                clip-path: inset(0% 0% 0% 70% round 5%);
                animation-timing-function: cubic-bezier(0.86, 0, 0.07, 1);
            }

            100% {
                clip-path: inset(35% round 5%);
                animation-timing-function: cubic-bezier(0.86, 0, 0.07, 1);
            }
        }

        @media (max-width: 400px) {
            .wrapper {
                width: 150px;
                height: 150px;
            }
        }

        @media (max-width: 250px) {
            .wrapper {
                width: 100px;
                height: 100px;
            }
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="box-wrap">
            <div class="box one"></div>
            <div class="box two"></div>
            <div class="box three"></div>
            <div class="box four"></div>
            <div class="box five"></div>
            <div class="box six"></div>
        </div>
    </div>
</body>
</html>

