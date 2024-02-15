<div class="main-content h-full">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="d-flex flex-column mb-2 align-items-start">
                                <h5 class="mb-0">All Sales</h5>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex flex-column mb-2 align-items-start">
                                <input type="month" class="form-control" wire:model="monthyear">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="ms-md-3 pe-md-3 mb-2">
                                <div class="input-group">
                                    <span class="input-group-text text-body"><i class="fas fa-search"
                                            aria-hidden="true"></i></span>
                                    <input type="text" class="form-control" wire:model="search"
                                        placeholder="Search here...">
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Sr.
                                    </th>
                                    <th
                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Date
                                    </th>
                                    <th
                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Product Name
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Qty
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Price
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Subtotal
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($sales) > 0)
                                    @foreach ($sales as $key => $sale)
                                        <tr>
                                            <td class="ps-4">
                                                <p class="text-xs font-weight-bold mb-0">{{ $key + 1 }}</p>
                                            </td>
                                            <td class="ps-4">
                                                <p class="text-xs font-weight-bold mb-0">
                                                    {{ date('F j, Y, g:ia', strtotime($sale->created_at)) }}
                                                </p>
                                            </td>

                                            <td class="ps-4">
                                                <p class="text-xs font-weight-bold mb-0">{{ $sale->name }}
                                            </td>
                                            <td class="text-center">
                                                <p class="text-xs font-weight-bold mb-0">{{ $sale->quantity }}</p>
                                            </td>
                                            <td class="text-center">
                                                <p class="text-xs font-weight-bold mb-0">{{ $sale->price }}</p>
                                            </td>
                                            <td class="text-center">
                                                <p class="text-xs font-weight-bold mb-0">{{ $sale->subtotal }}</p>
                                            </td>

                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="6" class="text-center text-danger"><small>No data found</small>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-end mt-3 p-2">
                        {{ $sales->links() }}
                    </div>
                </div>


            </div>
        </div>
        <div>
            <div style="text-align: center; padding: 5%;" wire:ignore>
                <canvas id="monthlySalesChart" style="width: 100%; height: 100%;"></canvas>
            </div>
            
        
            @if ($loading)
                <div class="text-center mt-3">
                    <p>Loading...</p>
                    <div class="spinner-border" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            @endif
        </div>
        
        <script>
            document.addEventListener('livewire:load', function () {
                var ctx = document.getElementById('monthlySalesChart').getContext('2d');
                var monthlySalesData = @json($monthlySalesData ?? []);

                
        
                // Initialize the chart
                var myChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: monthlySalesData.map(data => data.month),
                        datasets: [{
                            label: 'Total Sales per Month',
                            data: monthlySalesData.map(data => data.total_sales),
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
        
                // Watch for Livewire updates and refresh the chart
                Livewire.on('updateChart', data => {
                    if (data && data.length > 0) {
                        myChart.data.labels = data.map(item => item.month);
                        myChart.data.datasets[0].data = data.map(item => item.total_sales);
                        myChart.update();
                    } else {
                        myChart.data.labels = [];
                        myChart.data.datasets[0].data = [];
                        myChart.update();
                    }
                });
            });
        </script>
        
    </div>
</div>
