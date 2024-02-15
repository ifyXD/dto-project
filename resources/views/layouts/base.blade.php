<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Metas -->
    @if (env('IS_DEMO'))
        <x-demo-metas></x-demo-metas>
    @endif
    <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="../assets/img/favicon.png">
    <title>
        Joseph
    </title>
    <!-- Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <!-- Nucleo Icons -->
    <link href="../assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
    <!-- CSS Files -->
    <link id="pagestyle" href="../assets/css/soft-ui-dashboard.css?v=1" rel="stylesheet" />
    <!-- Alpine -->
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">

    <style>
        .notebook-container {
            background-color: #f9f9f9;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-top: 20px;
            font-family: 'Courier New', Courier, monospace;
        }

        .notebook-list {
            list-style-type: square;
            padding-left: 20px;
        }

        .dropdown {
            position: relative;
        }

        .dropdown .dropdown-btn {
            cursor: pointer;
        }

        .dropdown .dropdown-content {
            display: none;
            position: absolute;
            right: 55%;
            top: -250%;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 4px;
        }

        .dropdown:hover .dropdown-content {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            /* Align items to the start (left) */
        }

        .dropdown-content a {
            padding: 9px 13px;
            text-decoration: none;
            color: #333;
            transition: background-color 0.3s;
            width: 100%;
            /* Make the links take up the full width */
            box-sizing: border-box;
            /* Include padding and border in width calculation */
        }

        .dropdown-content a:hover {
            background-color: #f0f0f0;
        }
    </style>
    @livewireStyles

</head>

<body class="g-sidenav-show bg-gray-100">

    {{ $slot }}

    <!--   Core JS Files   -->
    <script src="assets/js/core/popper.min.js"></script>
    <script src="assets/js/core/bootstrap.min.js"></script>
    <script src="assets/js/plugins/smooth-scrollbar.min.js"></script>
    <script>
        var win = navigator.platform.indexOf('Win') > -1;
        if (win && document.querySelector('#sidenav-scrollbar')) {
            var options = {
                damping: '0.5'
            }
            Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
        }
    </script>
    <!-- Github buttons -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="assets/js/soft-ui-dashboard.js"></script>
    
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script> 

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @livewireScripts
</body>

</html>
