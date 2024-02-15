<div>
    @include('livewire.admin.crud.product-crud')
    {{-- <div class="container-fluid">
        <div class="page-header min-height-300 border-radius-xl mt-4"
            style="background-image: url({{ $categoryBy != '' ? asset('storage/' . $categoryBy->image) : asset('storage/images/default/default.png') }}); background-position-y: 50%;">
            <span class="mask bg-gradient-primary opacity-6"></span>
        </div>
        <div class="card card-body blur shadow-blur mx-4 mt-n6">
            <div class="row gx-4">
                <div class="col-auto">
                    <div class="avatar avatar-xl position-relative">
                        <img src="{{ $categoryBy != '' ? asset('storage/' . $categoryBy->image) : asset('storage/images/default/default.png') }}"
                            alt="..." class="w-100 border-radius-lg shadow-sm">
                    </div>
                </div>
                <div class="col-auto my-auto">
                    <div class="h-100">
                        <h5 class="mb-1">
                            {{ $categoryBy != '' ? $categoryBy->category_name : 'All' }}
                        </h5>
                        <p class="mb-0 font-weight-bold text-sm" data-bs-toggle="tooltip"
                            data-bs-original-title="{{ $categoryBy != '' ? $categoryBy->description : 'All' }}">
                            {{ $categoryBy != '' ? Str::limit($categoryBy->description, 10, '...') : '' }}
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </div> --}}

    <div class="container-fluid py-4">
        <div class="card">
            <div class="card-header pb-0">
                <div class="d-flex flex-row justify-content-between">
                    <div class="mb-0">
                        <select wire:model="selectCategory" class="form-control w-100" style="border: none">
                            <option value="">All</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ ucfirst($category->category_name) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <a href="#" wire:click="create" class="btn bg-gradient-secondary btn-sm mb-0"
                        type="button">+&nbsp; Create</a>
                </div>
                <div class="ms-md-3 pe-md-3 d-flex align-items-center mt-2 mb-2 float-right">
                    <div class="input-group">
                        <span class="input-group-text text-body"><i class="fas fa-search" aria-hidden="true"></i></span>
                        <input type="text" class="form-control" wire:model="search" placeholder="Search here...">
                    </div>
                </div>
            </div>
            <div class="card-body pt-4 p-3">
                <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    Sr.
                                </th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                    Photo
                                </th>
                                <th
                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    Name
                                </th>
                                <th
                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    Description
                                </th>
                                <th
                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    Price
                                </th>
                                <th
                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    Stock
                                </th>
                                <th
                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $key=>$product)
                                <tr>
                                    <td class="text-center">{{$key+1}}</p>
                                    </td>
                                    <td>
                                        <div>
                                            <img src="{{asset('storage/' . $product->image)}}"
                                                class="avatar avatar-sm me-3" alt="{{ $product->store_name }}">

                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <p class="text-xs font-weight-bold mb-0">{{$product->product_name}}</p>
                                    </td>
                                    <td class="text-center">
                                        <p class="text-xs font-weight-bold mb-0">
                                    {{ Str::limit($product->product_description, 10, '...') }}</p>
                                    </td>
                                    <td class="text-center">
                                        <p class="text-xs font-weight-bold mb-0 text-danger">{{$product->price.$product->unit}}</p>
                                    </td>
                                    <td class="text-center">
                                        <p class="text-xs font-weight-bold mb-0">{{$product->stock}}</p>
                                    </td>
                                    <td class="text-center">
                                        <a href="#" wire:click="edit({{$product->id}})" class="mx-3" data-bs-toggle="tooltip"
                                            data-bs-original-title="Edit user">
                                            <i class="fas fa-user-edit text-secondary"></i>
                                        </a>  
                                        <span wire:click="delete({{$product->id}})">
                                            <i class="cursor-pointer fas fa-trash text-danger"></i>
                                        </span>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-start mt-3">
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </div>
    @if (session()->has('messageflash'))
        @php
            $toastrType = session('messageflash');
            $toastrSettings = "{ positionClass: 'toast-bottom-right' }";
        @endphp

        <script>
            @if ($toastrType === 'saved')
                toastr.success('Created Successfully', '', {!! $toastrSettings !!});
            @elseif ($toastrType === 'updated')
                toastr.info('Updated Successfully', '', {!! $toastrSettings !!});
            @elseif ($toastrType === 'deleted')
                toastr.error('Deleted Successfully', '', {!! $toastrSettings !!});
            @endif
        </script>
    @endif
</div>
