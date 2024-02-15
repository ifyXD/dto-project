 <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
     <div class="container-fluid py-4">
         <div class="row">
             <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                 <div class="card">
                     <div class="card-body p-3">
                         <div class="row">
                             <div class="col-8">
                                 <div class="numbers">
                                     <p class="text-sm mb-0 text-capitalize font-weight-bold">Today's Money</p>
                                     <h5
                                         class="font-weight-bolder mb-0 {{ $todaySalesTotal == 0 ? 'text-danger' : '' }}">
                                         ₱ {{ $todaySalesTotal }}
                                         {{-- <span class="text-success text-sm font-weight-bolder">+55%</span> --}}
                                     </h5>
                                 </div>
                             </div>
                             <div class="col-4 text-end">
                                 <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                                     <i class="ni ni-money-coins text-lg opacity-10" aria-hidden="true"></i>
                                 </div>
                             </div>
                         </div>
                     </div>
                 </div>
             </div>
             <div class="col-xl-3 col-sm-6">
                 <div class="card">
                     <div class="card-body p-3">
                         <div class="row">
                             <div class="col-8">
                                 <div class="numbers">
                                     <p class="text-sm mb-0 text-capitalize font-weight-bold"><b>{{ $currentYear }}</b>
                                         Total
                                         Sales</p>
                                     <h5 class="font-weight-bolder mb-0 {{ $totalSales == 0 ? 'text-danger' : '' }}">
                                         ₱ {{ $totalSales }}
                                     </h5>
                                 </div>
                             </div>
                             <div class="col-4 text-end">
                                 <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                                     <i class="ni ni-cart text-lg opacity-10" aria-hidden="true"></i>
                                 </div>
                             </div>
                         </div>
                     </div>
                 </div>
             </div>
             <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                 <div class="card">
                     <div class="card-body p-3">
                         <div class="row">
                             <div class="col-8">
                                 <div class="numbers">
                                     <p class="text-sm mb-0 text-capitalize font-weight-bold">Total Categories</p>
                                     <h5 class="font-weight-bolder mb-0">

                                         {{ $categoryCount }}
                                         {{-- <span class="text-success text-sm font-weight-bolder">+3%</span> --}}
                                     </h5>
                                 </div>
                             </div>
                             <div class="col-4 text-end">
                                 <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                                     <i class="ni ni-world text-lg opacity-10" aria-hidden="true"></i>
                                 </div>
                             </div>
                         </div>
                     </div>
                 </div>
             </div>
             <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                 <div class="card">
                     <div class="card-body p-3">
                         <div class="row">
                             <div class="col-8">
                                 <div class="numbers">
                                     <p class="text-sm mb-0 text-capitalize font-weight-bold">Total Products</p>
                                     <h5 class="font-weight-bolder mb-0">
                                         {{ $productCount }}
                                         {{-- <span class="text-danger text-sm font-weight-bolder">-2%</span> --}}
                                     </h5>
                                 </div>
                             </div>
                             <div class="col-4 text-end">
                                 <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                                     <i class="ni ni-paper-diploma text-lg opacity-10" aria-hidden="true"></i>
                                 </div>
                             </div>
                         </div>
                     </div>
                 </div>
             </div>
             {{-- <div class="col-12 mt-4 mb-4">
                 <div class="card">
                     <div class="card-body p-3">
                         <div class="row">
                             <div class="col-8"> 
                                 <canvas id="salesChart"></canvas>
                             </div>

                         </div>
                     </div>
                 </div>
             </div> --}}

         </div>
     </div>
 </main>

 <!--   Core JS Files   -->
 <script src="/assets/js/plugins/chartjs.min.js"></script>
 <script src="/assets/js/plugins/Chart.extension.js"></script> 


