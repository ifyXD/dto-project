<div id="wrapper">

    <ul class="sidebar navbar-nav toggled">
        <li class="nav-item active">
            <a type="button" class="nav-link" wire:click="byCategory({{ $id = 0 }})">
                <i class="fa fa-fw fa-home"></i>
                <span>All</span>
            </a>
        </li>
        @foreach ($categories as $category)
            <li class="nav-item">
                <a class="nav-link" type="button" wire:click="byCategory({{ $category->id }})">
                    <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                    <span>&nbsp;{{ ucfirst($category->category_name) }}</span>
                </a>
            </li>
        @endforeach
    </ul>
    {{-- end sidebar --}}
    <div id="content-wrapper">
        <div class="container-fluid">
            <!-- Breadcrumbs-->
            <div class="row">
                <div class="col-9 col-md-10">
                    <div class="form-group">
                        <div class="input-group">
                            <input type="text" class="form-control" wire:model="search" placeholder="Search...">

                        </div>
                    </div>
                </div>
                <!-- Livewire view (Blade file) -->

                <div class="col-3 col-md-2">
                    <div class="form-group ">
                        <span class="d-flex justify-content-end p-1 " style="font-size: 30px; ">
                            <i class="fa fa-shopping-basket text-success {{ $itemCountChanged ? 'shake-animate' : '' }}"
                                wire:click="bastketItem" aria-hidden="true" id="cartIcon"></i>
                            <sup class="text-danger"
                                style="font-size: 50%; line-height: 1.5;">({{ $itemCount }})</sup>
                        </span>
                    </div>
                </div>




            </div>


            {{-- Products --}}

            <div class="row {{ $showItem ? 'd-none' : '' }}">
                @if (count($products) > 0)
                    @foreach ($products as $pro)
                        <div class="col-12 col-md-4 col-sm-6 col-xs-6 mb-3">
                            <div class="card text-white bg-info o-hidden h-100">
                                <div class="card-header">
                                    <h4>{{ $pro->product_name }}</h4>
                                </div>
                                <div class="card-img-top"
                                    style="height: 200px; background-image: url('{{ asset('storage/' . $pro->image) }}');
                                                          background-repeat: no-repeat;
                                                          background-size: cover;">
                                </div>
                                <div class="card-body">
                                    <div class="card-body-icon">
                                        <i class="fa fa-cart-plus" aria-hidden="true"></i>
                                    </div>
                                    <div class="card-text">
                                        <span class="float-left {{ $pro->stock == 0? 'text-danger' : '' }}"><strong>Stock: ({{ $pro->stock }})</strong></span>
                                        <span
                                            class="d-flex justify-content-end"><strong>P{{ $pro->price . $pro->unit }}</strong></span>
                                    </div>
                                </div>
                                <a class="card-footer text-white clearfix small z-1 bg-secondary bg-gradient"
                                    type="button">
                                    <div class="row align-items-center">
                                        <div class="col-4 text-center">
                                            <span wire:click="decrement({{ $pro->id }})"
                                                style="font-size: 40px; font-weight: bold; cursor: {{ $pro->stock > 0 ? 'pointer' : 'not-allowed' }}">-</span>
                                        </div>
                                        <div class="col-4 text-center">
                                            <span
                                                style="font-size: 40px; font-weight: bold">{{ $currentQtyById[$pro->id] ?? 0 }}</span>
                                        </div>
                                        <div class="col-4 text-center">
                                            <span
                                                wire:click="{{ $pro->stock > 0 ? 'increment(' . $pro->id . ')' : '' }}"
                                                style="font-size: 40px; font-weight: bold; cursor: {{ $pro->stock > 0 ? 'pointer' : 'not-allowed' }}"
                                                @if ($pro->stock == 0) title="Out of Stock" @endif>
                                                +
                                            </span>

                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="m-auto text-danger">
                        <span>No data found</span>
                    </div>
                @endif
            </div>


            {{-- Cart --}}
            <div class="row {{ $showItem ? '' : 'd-none' }}">
                <div class="col-12 mb-3">
                    <div class="card o-hidden h-100"
                        style="border: 2px solid #ccc; border-radius: 10px; overflow: hidden;">
                        <div class="table-responsive">
                            <table class="table table-hover" style="margin: 0;">
                                <thead>
                                    <tr style="background-color: #f8f9fa;">
                                        <th style="font-size: 16px; padding: 10px; border-bottom: 2px solid #ccc;">Sr.
                                        </th>
                                        <th style="font-size: 16px; padding: 10px; border-bottom: 2px solid #ccc;">Item
                                        </th>
                                        <th style="font-size: 16px; padding: 10px; border-bottom: 2px solid #ccc;">Qty
                                        </th>
                                        <th
                                            style="font-size: 16px; padding: 10px; border-bottom: 2px solid #ccc; display: none; display: table-cell;">
                                            Price</th>
                                        <th
                                            style="font-size: 16px; padding: 10px; border-bottom: 2px solid #ccc; display: none; display: table-cell;">
                                            Subtotal</th>
                                        <th
                                            style="font-size: 16px; padding: 10px; border-bottom: 2px solid #ccc; display: none; display: table-cell;">
                                            Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($cartItem as $key => $item)
                                        <tr style="background-color: #fff;">
                                            <td
                                                style="font-size: 14px; padding: 10px; border-bottom: 1px solid #ccc; display: none; display: table-cell;">
                                                {{ $key + 1 }}
                                            </td>
                                            <td style="font-size: 14px; padding: 10px; border-bottom: 1px solid #ccc;">
                                                {{ $item['name'] }}
                                            </td>
                                            <td style="font-size: 14px; padding: 10px; border-bottom: 1px solid #ccc;">
                                                {{ $item['quantity'] }}
                                            </td>
                                            <td
                                                style="font-size: 14px; padding: 10px; border-bottom: 1px solid #ccc; display: none; display: table-cell;">
                                                {{ $item['price'] }}
                                            </td>
                                            <td id="SubTotal"
                                                style="font-size: 14px; padding: 10px; border-bottom: 1px solid #ccc; display: none; display: table-cell;">
                                                {{ $item['price'] * $item['quantity'] }}
                                            </td>
                                            <td
                                                style="font-size: 14px; padding: 10px; border-bottom: 1px solid #ccc; display: none; display: table-cell;">
                                                <div class="d-flex justify-content-center align-items-center">
                                                    <button class="btn btn-sm btn-outline-secondary"
                                                        wire:click="decrement({{ $item['id'] }})">-</button>
                                                    <span class="mx-2">{{ $item['quantity'] }}</span>
                                                    <button class="btn btn-sm btn-outline-secondary"
                                                        wire:click="increment({{ $item['id'] }})"
                                                        @if ($item['quantity'] >= $item['stock']) disabled @endif>
                                                        +
                                                    </button>
                                                </div>
                                            </td>

                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                @if (count($cartItem) > 0)
                    <div class="col-12 mb-3">
                        <hr>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title mb-4">Payment Details</h5>
                                        <div class="form-group row">
                                            <label for="cashInput"
                                                class="col-4 col-form-label"><strong>Cash:</strong></label>
                                            <div class="col-8">
                                                <div class="input-group">
                                                    <span class="input-group-text">₱</span>
                                                    <input type="text" class="form-control" wire:model="cashInput" {{ $isPaid ? 'disabled' : '' }}>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-4 col-form-label"><strong>Total:</strong></label>
                                            <div class="col-8">
                                                <p class="mb-0 mt-2" id="overallTotal">₱ {{ $overallTotal }}</p>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-4 col-form-label"><strong>Balance:</strong></label>
                                            <div class="col-8">
                                                <p class="mb-0 mt-2">₱ {{ $balance < 0 ? '' : $balance }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex justify-content-end align-items-center">
                                    @if ($isPaid)
                                        <button class="btn btn-danger mr-2" wire:click="close">Close
                                        </button>
                                    @endif
                                    <button class="btn {{ $isPaid ? 'btn-info' : 'btn-primary' }}  mr-2"
                                        wire:click="confirmPayment" @if ($cashInput === '' || $cashInput == 0 || $balance < 0 || $isPaid) disabled @endif>
                                        {{ $isPaid ? 'Paid' : 'Pay' }}
                                        @if ($isPaid)
                                            <i class="fa fa-check-square-o" aria-hidden="true"></i>
                                        @endif
                                    </button>

                                    <button class="btn btn-success" wire:click="generatePDF({{$salesReportId}})"
                                        @if ($cashInput === '' || $cashInput == 0 || $balance < 0 || !$isPaid) disabled title="Pay first" @endif>
                                        Print
                                        <i class="fa fa-print" aria-hidden="true"></i>
                                    </button>


                                </div>
                            </div>

                        </div>
                    </div>
                @endif
            </div>
        </div>
        <br><br><br>
    </div>
</div>
@push('scripts')
    <script>
        // Function to remove the "shake" class
        function removeShakeClass() {
            var element = document.getElementById('cartIcon');

            // Check if the element has the "shake-animate" class before removing it
            if (element.classList.contains('shake-animate')) {
                element.classList.remove('shake-animate');
            }
        }

        // Set interval to run the function every 2 seconds
        setInterval(removeShakeClass, 2000);
    </script>
    <script>
        document.addEventListener('livewire:load', function() {
            Livewire.on('openNewTab', function(url) {
                window.open(url, '_blank');
            });
        });
    </script>
    <script>
        document.addEventListener('livewire:load', function() {
            Livewire.on('confirmPayment', function() {
                Swal.fire({
                    title: "Are you sure?",
                    text: "You won't be able to revert this! Please double check!!!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, proceed!",
                }).then((result) => {
                    if (result.isConfirmed) {
                        @this.pay();
                    }
                });
            });
        });
    </script>
@endpush
