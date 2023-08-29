<?php 
require './helper/database/conn.php';

if(isset($_GET['sheet_number'])) {
    $sheet_number = intval($_GET['sheet_number']);
} else {
    header("Location: index.php"); // Melakukan redirect ke index.php
    exit(); // Menghentikan eksekusi script setelah melakukan redirect
}

$items_per_iteration = 500;
$start = ($sheet_number - 1) * $items_per_iteration;
$end = $sheet_number * $items_per_iteration - 1;

if (isset($_GET['id_data'])) {
    $id_data = $_GET['id_data'];
    $query = "SELECT * FROM data WHERE id = ?";
    
    // Membuat pernyataan SQL dengan prepared statement
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id_data);
    
} else {
    $query = "SELECT * FROM data WHERE id BETWEEN ? AND ? AND labeled IS NULL ORDER BY id LIMIT 1";
    
    // Membuat pernyataan SQL dengan prepared statement
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $start, $end);
}


// Menjalankan pernyataan SQL
$stmt->execute();

// Mengambil hasil query
$result = $stmt->get_result();

$data = mysqli_fetch_assoc($result);

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
    <link href="./public/css/style.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@300;400;600;700;900&display=swap"
        rel="stylesheet">
    <title>OsLab-Sentiment Analysis</title>
</head>

<body class="bg-slate-900 h-full relative pb-8">
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

    <main class="md:mt-8 mt-6 h-[80vh] w-full px-40 smx:px-5">

        <!-- info metadata -->
        <div class="w-full flex justify-between items-center gap-3 mb-4">

            <!-- id text -->
            <input type="hidden" id="id_text" value="<?= $data['id'] ?>">
            <!-- id text -->
        
            <!-- btn back -->
            <a href="index.php" id="back-page" class="flex items-center font-semibold text-white text-sm md:text-base">
                <svg width="35px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                    <g id="SVGRepo_iconCarrier">
                        <path d="M15 7L10 12L15 17" stroke="#e3e3e3" stroke-width="1.5" stroke-linecap="round"
                            stroke-linejoin="round"></path>
                    </g>
                </svg>

                <span class="">Back</span>
            </a>
            <!-- btn back -->

            <div class="flex gap-2">
                <select id="id_data" onchange="" class="bg-slate-500 w-10 md:w-fit font-semibold bg-opacity-20 border rounded p-1 text-sm md:text-base md:p-2 md:px-3 text-slate-50" name="id" id="id">
                    <option value="" disabled>Chose Item</option>
                    <?php for ($i=$start; $i <= $end; $i++):?>
                        <option class="text-slate-900" <?= $data['id'] == $i ? 'selected' : '' ;?> value="<?= $i ?>"><?= $i ?></option>
                    <?php endfor;?>
                </select>
                <span class="bg-slate-500 font-semibold bg-opacity-20 border rounded p-1 text-sm md:text-base md:p-2 md:px-3 text-slate-50">
                    Sheet : <?= $sheet_number ?>
                </span>
                <span class="bg-slate-500 font-semibold bg-opacity-20 border rounded p-1 text-sm md:text-base md:p-2 md:px-3 text-green-500">
                    Data : <span class="total_data">?</span> / <span class="labeled">?</span>
                </span>
            </div>
        </div>
        <!-- info metadata -->

        <!-- data text -->
        <div
            class="w-full h-[70%] border rounded-md bg-slate-300 text-gray-50 font-semibold bg-opacity-20 p-4 overflow-y-auto text-lg text-justify">
            <?= $data['text'] ?>
        </div>
        <!-- data text -->

        <!-- container button -->
        <div class="grid w-full justify-center">
            <div class="flex gap-10 justify-center my-6">
                <!-- btn previous -->
                <button onclick="goto(1, 'dec')" <?= $data['id'] == $start ? 'disabled' : '';?> id="back-prev" class="flex items-center font-semibold text-white <?= $data['id'] == $start ? 'opacity-20 cursor-not-allowed' : '';?>">
                    <svg width="35px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                        <g id="SVGRepo_iconCarrier">
                            <path d="M15 7L10 12L15 17" stroke="#e3e3e3" stroke-width="1.5" stroke-linecap="round"
                                stroke-linejoin="round"></path>
                        </g>
                    </svg>

                    <span>Prev</span>
                </button>
                <!-- btn previous -->
                <!-- btn previous -->
                <button onclick="goto(1, 'inc')" <?= $data['id'] == $end ? 'disabled' : '';?> id="back-prev" class="flex items-center font-semibold text-white <?= $data['id'] == $end ? 'opacity-20 cursor-not-allowed' : '';?>">

                    <span>Next</span>

                    <svg class="transform rotate-180" width="35px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                        <g id="SVGRepo_iconCarrier">
                            <path d="M15 7L10 12L15 17" stroke="#e3e3e3" stroke-width="1.5" stroke-linecap="round"
                                stroke-linejoin="round"></path>
                        </g>
                    </svg>

                </button>
                <!-- btn previous -->
            </div>

            <!-- button -->
            <div class="grid grid-cols-3 gap-3">

                <button
                    type="button"
                    onclick="do_labeling(1)"
                    class="btn-labeling flex flex-col items-center justify-center w-full transition-all duration-300 p-5 bg-slate-50 <?= $data['label'] == '1' ? 'bg-opacity-90': 'bg-opacity-20'; ?> border rounded-lg hover:opacity-40 cursor-pointer">

                    <svg xmlns="http://www.w3.org/2000/svg" class="text-green-600 fill-current" width="60"
                        viewBox="0 0 24 24">
                        <path
                            d="M12 2c5.514 0 10 4.486 10 10s-4.486 10-10 10-10-4.486-10-10 4.486-10 10-10zm0-2c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm5.508 13.941c-1.513 1.195-3.174 1.931-5.507 1.931-2.335 0-3.996-.736-5.509-1.931l-.492.493c1.127 1.72 3.2 3.566 6.001 3.566 2.8 0 4.872-1.846 5.999-3.566l-.492-.493zm.492-3.939l-.755.506s-.503-.948-1.746-.948c-1.207 0-1.745.948-1.745.948l-.754-.506c.281-.748 1.205-2.002 2.499-2.002 1.295 0 2.218 1.254 2.501 2.002zm-7 0l-.755.506s-.503-.948-1.746-.948c-1.207 0-1.745.948-1.745.948l-.754-.506c.281-.748 1.205-2.002 2.499-2.002 1.295 0 2.218 1.254 2.501 2.002z" />
                    </svg>

                </button>

                <button
                    onclick="do_labeling(0)"
                    class="btn-labeling flex flex-col items-center w-full transition-all duration-300 justify-center p-5 bg-slate-50 <?= $data['label'] == '0' ? 'bg-opacity-90': 'bg-opacity-20'; ?> border rounded-lg hover:opacity-40 cursor-pointer">
                    
                    <svg xmlns="http://www.w3.org/2000/svg" class="text-yellow-300 fill-current" width="60"
                        viewBox="0 0 24 24">
                        <path
                            d="M12 2c5.514 0 10 4.486 10 10s-4.486 10-10 10-10-4.486-10-10 4.486-10 10-10zm0-2c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm4 17h-8v-2h8v2zm-7.5-9c-.828 0-1.5.671-1.5 1.5s.672 1.5 1.5 1.5 1.5-.671 1.5-1.5-.672-1.5-1.5-1.5zm7 0c-.828 0-1.5.671-1.5 1.5s.672 1.5 1.5 1.5 1.5-.671 1.5-1.5-.672-1.5-1.5-1.5z" />
                    </svg>

                </button>

                <button
                    onclick="do_labeling(-1)"
                    class="btn-labeling flex flex-col items-center w-full transition-all duration-300 justify-center p-5 bg-slate-50 <?= $data['label'] == '-1' ? 'bg-opacity-90': 'bg-opacity-20'; ?> border rounded-lg hover:opacity-40 cursor-pointer">

                    <svg xmlns="http://www.w3.org/2000/svg" class="text-red-600 fill-current" width="60"
                        viewBox="0 0 24 24">
                        <path
                            d="M12 2c5.514 0 10 4.486 10 10s-4.486 10-10 10-10-4.486-10-10 4.486-10 10-10zm0-2c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm-3.5 8c-.828 0-1.5.671-1.5 1.5s.672 1.5 1.5 1.5 1.5-.671 1.5-1.5-.672-1.5-1.5-1.5zm7 0c-.828 0-1.5.671-1.5 1.5s.672 1.5 1.5 1.5 1.5-.671 1.5-1.5-.672-1.5-1.5-1.5zm-.941 9.94c-.903-.19-1.741-.282-2.562-.282-.819 0-1.658.092-2.562.282-1.11.233-1.944-.24-2.255-1.015-.854-2.131 1.426-3.967 4.816-3.967 3.537 0 5.666 1.853 4.817 3.968-.308.769-1.136 1.249-2.254 1.014zm-2.563-1.966c1.614 0 3.056.67 3.206.279.803-2.079-7.202-2.165-6.411 0 .138.377 1.614-.279 3.205-.279z" />
                    </svg>

                </button>
            </div>
            <!-- button -->
        </div>
    </main>
</body>
<script src="./public/js/jquery.js"></script>
<script>
    let id_text = $("#id_text").val()
    
    // Mengambil nilai 'sheet_number' dari query string URL
    let urlParams = new URLSearchParams(window.location.search);
    let sheet_number = urlParams.get('sheet_number');
    
    
    const getMetaData = function () {
        // Mengirim permintaan AJAX
        $.ajax({
            url: './helper/getMetaData.php', // Ganti dengan lokasi file PHP kamu
            type: 'GET', // Atau 'POST' tergantung kebutuhan kamu
            data: { sheet_number }, // Mengirim sheet_number sebagai parameter GET atau POST
            dataType: 'json', // Mengharapkan respons dalam bentuk JSON
            success: function(data) {
                // Data adalah respons JSON dari PHP
                let total_data = parseInt(data.total_data_in_group)
                let labeled = total_data - parseInt(data.unlabeled_data_count)
                $(".total_data").text(total_data)
                $(".labeled").text(labeled)
            },
            error: function(xhr, status, error) {
                console.error(status + ': ' + error);
            }
        });
    }

    getMetaData()

    $('#id_data').change(function() {
        // Mendapatkan nilai terpilih dari elemen select
        let selectedValue = $(this).val();

        // Mendapatkan URL saat ini
        let currentUrl = window.location.href;

        // Memeriksa apakah query parameter "id_data" sudah ada dalam URL
        if (currentUrl.indexOf('id_data=') !== -1) {
            // Jika sudah ada, maka kita perlu menggantinya dengan nilai yang baru
            // Kami akan menggunakan ekspresi reguler untuk mencari dan mengganti nilai lama
            let regex = /id_data=\d+/;
            currentUrl = currentUrl.replace(regex, 'id_data=' + selectedValue);
        } else {
            // Jika belum ada, tambahkan query parameter "id_data" ke URL
            currentUrl += '&id_data=' + selectedValue;
        }

        // Melakukan refresh halaman dengan URL baru
        window.location.href = currentUrl;
    });

    const goto = function (id, type_) {
        // Mendapatkan nilai terpilih dari elemen select
        let currentId = id_text;
        if (type_ == 'inc') {
            currentId = parseInt(id_text) + parseInt(id);
        } else {
            currentId = parseInt(id_text) - parseInt(id);
        }
        console.log(currentId);

        // Mendapatkan URL saat ini
        let currentUrl = window.location.href;

        // Memeriksa apakah query parameter "id_data" sudah ada dalam URL
        if (currentUrl.indexOf('id_data=') !== -1) {
            // Jika sudah ada, maka kita perlu menggantinya dengan nilai yang baru
            // Kami akan menggunakan ekspresi reguler untuk mencari dan mengganti nilai lama
            let regex = /id_data=\d+/;
            currentUrl = currentUrl.replace(regex, 'id_data=' + currentId);
        } else {
            // Jika belum ada, tambahkan query parameter "id_data" ke URL
            currentUrl += '&id_data=' + currentId;
        }

        // Melakukan refresh halaman dengan URL baru
        window.location.href = currentUrl;
    }

    function do_labeling(label) {
            // Melakukan permintaan AJAX
            // Menyimpan nilai href tautan asli dalam variabel originalHref
            let originalHref = $("#back-page").prop('href');
            
            $.ajax({
                url: './helper/labeling.php', // Ganti dengan lokasi file PHP kamu
                type: 'POST', // Menggunakan metode POST
                data: { id: id_text, label }, // Mengirim id dan label sebagai data POST
                dataType: 'json',
                beforeSend: function() {
                    // Callback sebelum permintaan dikirim
                    // Kamu dapat menambahkan logika tambahan di sini jika diperlukan
                    $(".btn-labeling").prop("disabled", true).addClass("opacity-40 cursor-progress");
                    $("#back-page").prop('href', 'javascript:void(0)').addClass("opacity-40 cursor-progress");
                },
                success: function(data) {
                    // Data adalah respons JSON dari PHP
                    console.log(data); // Lakukan sesuatu dengan data JSON
                },
                error: function(xhr, status, error) {
                    // console.error(status + ': ' + error);
                },
                complete: function() {
                    // Callback setelah permintaan selesai (baik berhasil maupun gagal)
                    // Mengaktifkan kembali tombol dan menghapus kelas "progress"
                    location.reload();
                }
            });
        }

</script>

</html>