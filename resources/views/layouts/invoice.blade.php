<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="style.css">
    <title>Receipt example</title>
    <style>
      @page {
          size: 3.125in 230in;  /* Set the page size to match "3 1/8" x 230'  but the match is this  size: 2.5in 200in;*/ 
          margin: 0; /* Remove default margins */
      }

      body {
          margin: 0; /* Remove default body margin */
          box-sizing: border-box; /* Include padding in the total width */
      }

      * {
          font-size: 12px;
          font-family: 'Times New Roman';
      }

      td,
      th,
      tr,
      table {
          border-top: 1px solid black;
          border-collapse: collapse;
      }

      td.description,
      th.description {
          width: 100px;
          max-width: 100px;
      }

      td.quantity,
      th.quantity {
          width: 50px;
          max-width: 50px;
          word-break: break-all;
      }

      td.price,
      th.price {
          width: 50px;
          max-width: 50px;
          word-break: break-all;
      }

      .centered {
          text-align: center;
          align-content: center;
      }

      .ticket {
          width: 200px;
          max-width: 200px;
          margin: 0 auto; /* Center the ticket container */
      }

      img {
          max-width: inherit;
          width: inherit;
      }

      @media print {
          .hidden-print,
          .hidden-print * {
              display: none !important;
          }
      }
  </style>
</head>

<body>
    @yield('content')
</body>

</html>
