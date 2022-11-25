<?php
require_once 'vendor/autoload.php';
include_once('fixtures/fixtureCreator.php');
error_reporting(E_ERROR | E_PARSE);


$fc = new FixtureCreator();
$data = $fc->getUsers(60);

$genderChart = array("male" => 0, "female" => 0);
$ageChart = array("to18" => 0, "from18to30" => 0, "from30to50", "from50to80" => 0);
$browsersBar = array("Chrome" => 0, "Firefox" => 0, "Opera" => 0, "InternetExplorer" => 0, "Safari" => 0, "MicrosoftEdge" => 0);

foreach ($data as $row) {
    switch ($row['gender']) {
        case 'male':
            $genderChart['male']++;
            break;
        case 'female':
            $genderChart['female']++;
            break;
    }

    switch (true) {
        case $row['age'] < 18:
            $ageChart['to18']++;
            break;
        case $row['age'] < 30:
            $ageChart['from18to30']++;
            break;
        case $row['age'] < 50:
            $ageChart['from30to50']++;
            break;
        case $row['age'] <= 80:
            $ageChart['from50to80']++;
            break;
    }

    switch ($row['browser']) {
        case 'Chrome':
            $browsersBar['Chrome']++;
            break;
        case 'Firefox':
            $browsersBar['Firefox']++;
            break;
        case 'Opera':
            $browsersBar['Opera']++;
            break;
        case 'Internet Explorer':
            $browsersBar['InternetExplorer']++;
            break;
        case 'Safari':
            $browsersBar['Safari']++;
            break;
        case 'Microsoft Edge':
            $browsersBar['MicrosoftEdge']++;
            break;
    }
}

$state = false;

function addWaterMark($file, $id)
{
    $im = imagecreatefrompng($file);
    $stamp = imagecreatefrompng("fixtures/stamp.png");
    imagealphablending($im, true);
    imagesavealpha($im, true);

    $marge_right = 10;
    $marge_bottom = 10;
    $sx = imagesx($stamp);
    $sy = imagesy($stamp);

    imagecopymerge($im, $stamp, imagesx($im) - $sx - $marge_right, imagesy($im) - $sy - $marge_bottom, 0, 0, imagesx($stamp), imagesy($stamp), 50);

    imagepng($im, $file);

    if ($id == 2) {
        $GLOBALS['state'] = true;
    }
}

if (!empty($_POST['data'])) {
    $canvases = json_decode(stripslashes($_POST['data']));
    $t = 0;
    foreach ($canvases as $canvas) {
        $canvas = str_replace('data:image/png;base64,', '', $canvas);
        $canvas = str_replace(' ', '+', $canvas);
        $fileData = base64_decode($canvas);
        $fileName = "fixtures/photo_{$t}.png";
        file_put_contents($fileName, $fileData);
        addWaterMark($fileName, $t);
        $t++;
    }
}
?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.1/css/bootstrap.min.css" />
    <script src="https://kit.fontawesome.com/c4cafcfd34.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>



    <link rel="icon" type="image/png" href="assets/toy-train.png" />
    <title>Статистика</title>
</head>

<body>
    <h2 class="text-center m-1"> 📈 </h2>

    <div class="container mt-3" style="margin: 0 auto;
    width: 35%;">
        <div class="row align-items-center" style="display: flex;
    flex-direction: column;">
            <div class="col" style="margin-bottom: 5em;">
                <img src="fixtures/photo_0.png" alt="First chart">
            </div>
            <div class="col" style="margin-bottom: 5em;">
                <img src="fixtures/photo_1.png" alt="Second chart">
            </div>
            <div class="col" style="margin-bottom: 5em;">
                <img src="fixtures/photo_2.png" alt="Third chart">
            </div>
        </div>
    </div>
    <div class="container" id="charts">
        <div class="row align-items-center">
            <div class="col"><canvas id="myChart1"></canvas></div>
            <div class="col"><canvas id="myChart2"></canvas></div>
            <div class="col"><canvas id="myChart3"></canvas></div>
        </div>
    </div>
    <script>
        var genderChart = <?php echo json_encode($genderChart); ?>;
        var ageChart = <?php echo json_encode($ageChart); ?>;
        var browsersBar = <?php echo json_encode($browsersBar); ?>;

        console.log(genderChart);
        console.log(ageChart);
        console.log(browsersBar);

        const labels = {
            "first": [
                'Мужчины',
                'Женщины'
            ],
            "second": [
                'До 18 лет',
                'От 18 и до 30 лет',
                'От 30 и до 50 лет',
                'От 50 и до 80 лет'
            ],
            "third": [
                'Chrome',
                'Firefox',
                'Opera',
                'Internet Explorer',
                'Safari',
                'Microsoft Edge'
            ]
        };

        const data = {
            "first": {
                labels: labels["first"],
                datasets: [{
                    label: 'Количество мужчин и женщин',
                    backgroundColor: [
                        'rgb(255, 99, 132)',
                        'rgb(54, 162, 235)',
                        'rgb(255, 205, 86)'
                    ],
                    hoverOffset: 4,
                    data: [genderChart['male'], genderChart['female']],
                }]
            },
            "second": {
                labels: labels["second"],
                datasets: [{
                    label: 'Возраст пользователей',
                    backgroundColor: [
                        'rgb(75, 192, 192)',
                        'rgb(201, 203, 207)',
                        'rgb(255, 205, 86)',
                        'rgb(54, 162, 235)'
                    ],
                    data: [ageChart['to18'], ageChart['from18to30'], ageChart['from30to50'], ageChart['from50to80']],
                }]
            },
            "third": {
                labels: labels["third"],
                datasets: [{
                    label: 'Используемые браузеры',
                    backgroundColor: [
                        'rgba(255, 159, 64, 0.2)',
                        'rgba(255, 205, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(201, 203, 207, 0.2)'
                    ],
                    borderColor: [
                        'rgb(255, 159, 64)',
                        'rgb(255, 205, 86)',
                        'rgb(75, 192, 192)',
                        'rgb(54, 162, 235)',
                        'rgb(153, 102, 255)',
                        'rgb(201, 203, 207)'
                    ],
                    borderWidth: 1,
                    data: [browsersBar['Chrome'], browsersBar['Firefox'], browsersBar['Opera'], browsersBar['InternetExplorer'], browsersBar['Safari'], browsersBar['MicrosoftEdge']],
                }]
            }
        };

        const config = {
            "first": {
                type: 'pie',
                data: data["first"],
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    animation: false
                }
            },
            "second": {
                type: 'polarArea',
                data: data["second"],
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    animation: false
                }
            },
            "third": {
                type: 'bar',
                data: data["third"],
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    },
                    responsive: true,
                    maintainAspectRatio: false,
                    animation: false
                }
            },
        };

        var Chart1 = new Chart(
            document.getElementById('myChart1'),
            config["first"]
        );

        var Chart2 = new Chart(
            document.getElementById('myChart2'),
            config["second"]
        );

        var Chart3 = new Chart(
            document.getElementById('myChart3'),
            config["third"]
        );

        document.getElementById("charts").style.visibility = "hidden";

        var canvases = [Chart1, Chart2, Chart3];
        getUrlCanvases();

        function getUrlCanvases() {
            if (canvases.length == 3) {
                sendCanvases();
            }
        }

        function sendCanvases() {
            var jsonString = JSON.stringify([Chart1.toBase64Image(), Chart2.toBase64Image(), Chart3.toBase64Image()]);

            $.ajax({
                type: "POST",
                url: "statistics.php",
                data: {
                    data: jsonString
                }
            }).done(function(o) {
                console.log(canvases);
            });
        }
    </script>
</body>

</html>