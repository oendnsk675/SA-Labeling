<?php 

require 'helper/database/conn.php';


$query = "SELECT
            sheet_number,
            COUNT(*) AS total_data_in_group,
            SUM(CASE WHEN labeled IS NULL THEN 1 ELSE 0 END) AS unlabeled_data_count
            FROM
            (
                SELECT
                    FLOOR((id - 500) / 500) + 2 AS sheet_number,
                    labeled
                FROM
                    data
            ) subquery
            GROUP BY
            sheet_number;";

$result = $conn->query($query);

?>

<!doctype html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Sayidina ahmadal qososyi" />
    <meta name="keywords" content="Sentiment analysis, web, html">
    <meta name="description" content="Look for something in this world, and see how people react to that thing😎" />
    <meta name="og:image" content="./public/img/og.png" />
    <link rel="shortcut icon" href="./public/img/logo.png" type="image/x-icon">
    <link href="./public/css/loader.css" rel="stylesheet">
    <link href="./public/css/style.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@300;400;600;700;900&display=swap"
        rel="stylesheet">
    <title>OsLab-Sentiment Analysis</title>
</head>

<body class="bg-slate-900 overflow-auto relative pb-24">
    <header>
        <nav class="w-full flexbg-secondary2 bg-opacity-30 items-center px-64 smx:px-4 p-4">
            <!-- logo -->
            <a href="" class="flex items-end gap-3">
                <div class="bg-stone-100 p-1 rounded-md">
                    <svg id="logo_os" data-name="logo os" xmlns="http://www.w3.org/2000/svg"
                        xmlns:xlink="http://www.w3.org/1999/xlink" width="30" height="30" viewBox="0 0 35.037 30.041">
                        <defs>
                            <linearGradient id="linear-gradient" x1="-0.136" y1="0.45" x2="1" y2="0.5"
                                gradientUnits="objectBoundingBox">
                                <stop offset="0" stop-color="#9374ec" stop-opacity="0.302" />
                                <stop offset="1" stop-color="#3106ab" />
                            </linearGradient>
                        </defs>
                        <path id="Path_5" data-name="Path 5" d="M59.96,0H43V5.653H59.96v5.653h5.653V0Z"
                            transform="translate(-37.347)" fill="url(#linear-gradient)" />
                        <path id="Path_6" data-name="Path 6" d="M0,48.653v16.96H16.96V59.96H5.653V43H0Z"
                            transform="translate(0 -37.347)" fill="url(#linear-gradient)" />
                        <path id="Path_7" data-name="Path 7"
                            d="M155.328,105.719v-5.653h-5.588V100h-5.653v11.241H138.5v5.653h11.307v-5.653h-.066v-5.522Z"
                            transform="translate(-120.291 -86.853)" fill="#151513" />
                    </svg>
                </div>
                <span class="font-sans-pro font-semibold text-2xl text-stone-50">OsLab</span>
            </a>
            <!-- /logo -->
        </nav>

    </header>
    <hr class="opacity-50">

    <main class="mt-8 smx:mt-14 w-full px-40 smx:px-5">

        <!-- card sheet -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <?php while($data = mysqli_fetch_assoc($result)):?>
                <a href="labeling.php?sheet_number=<?= $data['sheet_number'] ?>"
                    class="flex flex-col items-center h-64 transition-all duration-300 md:h-56 justify-center gap-5 p-2 bg-slate-50 bg-opacity-20 border rounded-lg hover:opacity-40 cursor-pointer">
                    <h2 class="text-5xl font-semibold text-gray-200">Sheet <?= $data['sheet_number'] ?></h2>
                    <div class="text-white">
                        <span class="text-lg font-semibold">Data : </span>
                        <span class="text-lg font-semibold"><span class="text-red-600"><?= $data['total_data_in_group'] ?></span> / <span
                                class="text-green-600"><?= $data['total_data_in_group'] - $data['unlabeled_data_count'] ?></span></span>
                    </div>
                </a>
            <?php endwhile;?>
        </div>
        <!-- card sheet -->
    </main>
</body>

</html>