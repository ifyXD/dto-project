<div class="fixed-plugin {{ $isOpen ? 'show' : '' }}">
    <a class="fixed-plugin-button text-dark position-fixed px-3 py-2">
        <i class="fa fa-cog py-2"> </i>
    </a>
    <div class="card shadow-lg" style="height: 100vh; overflow-y: auto;">
        <div class="card-header pb-0 pt-3">
            <div class="float-start">
                <h2 class="text-2xl font-bold mb-4">{{ $productId ? 'Edit Product' : 'Create New Product' }}</h2>
            </div>
            <div class="float-end mt-4">
                <button class="btn btn-link text-dark p-0 fixed-plugin-close-button" wire:click.prevent="closeModal">
                    <i class="fa fa-close"></i>
                </button>
            </div>
        </div>
        <hr class="horizontal dark my-1">
        <div style="overflow-y: auto;">
            <form wire:submit.prevent="{{ $productId ? 'update' : 'store' }}" role="form text-left">
                <div class="card-body pt-sm-3 pt-0">
                    <div class="row">
                        <div class="col-md-12">

                            <div class="form-group">
                                <label for="store-name" class="form-control-label">{{ __('Select Category') }}</label>
                                <div class="@error('store_cat_id') border border-danger rounded-3 @enderror">
                                    <select wire:model="store_cat_id" name="" id=""
                                        class="form-control @error('store_cat_id') border border-danger rounded-3 @enderror">
                                        <option {{ $selectCategory == '' ? 'selected' : '' }} value="">Select
                                            Category</option>
                                        @foreach ($categories as $key => $category)
                                            <option {{ $selectCategory == $category->id ? 'selected' : '' }}
                                                value="{{ $category->id }}">{{ $category->category_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('store_cat_id')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="store-name" class="form-control-label">{{ __('Product Name') }}</label>
                                <div class="@error('product_name') border border-danger rounded-3 @enderror">
                                    <input wire:model="product_name" class="form-control" type="text"
                                        placeholder="Product Name" id="product-name">
                                </div>
                                @error('product_name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="lg:col-span-12">
                            <div class="form-group">
                                <label for="description" class="form-control-label">{{ __('Description') }}</label>
                                <div>
                                    <textarea wire:model="description" class="form-control" style="height: 15vh; " placeholder="Description"
                                        id="description"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="store-name" class="form-control-label">{{ __('Product Price') }}</label>
                                <div class="@error('product_price') border border-danger rounded-3 @enderror">
                                    <input wire:model="product_price" class="form-control" type="text"
                                        placeholder="Product Price" id="product-price">
                                </div>
                                @error('product_price')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="product-unit" class="form-control-label">{{ __('Product Unit') }}</label>
                                <div class="@error('product_unit') border border-danger rounded-3 @enderror">
                                    <select wire:model="product_unit" class="form-control">
                                        <option value="">Select Unit</option>
                                        @foreach ($units as $unit)
                                            <option value="{{ $unit->unit_name }}">{{ $unit->unit_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('product_unit')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror

                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="product-stock" class="form-control-label">{{ __('Product Stock') }}</label>
                                <div class="">
                                    <input wire:model="product_stock" class="form-control" type="number" min="0"
                                        placeholder="Product Stock" id="product-stock">
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="image" class="form-control-label">{{ __('Image') }}</label>
                                <div class="">
                                    <input wire:model="image" wire:key="file-input-{{ $iteration }}"
                                        class="form-control" type="file">
                                </div>
                                @error('image')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <div wire:loading wire:target="image" wire:key="image">
                                    <span>Please wait...</span>
                                </div>
                                @if ($image)
                                    @if ($productId)
                                        @if (is_string($image))
                                            <img src="{{ $image != 'default.png' ? asset('storage/' . $image) : asset('storage/images/stores/default/default.png') }}"
                                                class="img-fluid" alt="{{ $product_name }}">
                                        @else
                                            <img src="{{ $image->temporaryUrl() }}" class="img-fluid" alt="">
                                        @endif
                                    @else
                                        <img src="{{ $image->temporaryUrl() }}" class="img-fluid" alt="">
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="d-flex py-4">
                        <button class="btn bg-gradient-primary w-100 px-3 mb-2 active"
                            wire:click.prevent="closeModal">
                            Close
                        </button>
                        <button type="submit" class="btn bg-gradient-secondary w-100 px-3 mb-2 ms-2 active">
                            {{ $productId ? 'Update' : 'Create' }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


{{-- for delete --}}
<div class="fixed-plugin {{ $isDeleteOpen ? 'show' : '' }}">
    <a class="fixed-plugin-button text-dark position-fixed px-3 py-2">
        <i class="fa fa-cog py-2"> </i>
    </a>
    <div class="card shadow-lg max-h-screen overflow-y-auto">
        <div class="card-header pb-0 pt-3 ">
            <div class="float-start">
                <h2 class="text-2xl font-bold mb-4">Delete</h2>
            </div>
            <div class="float-end mt-4">
                <button class="btn btn-link text-dark p-0 fixed-plugin-close-button" wire:click.prevent="closeModal">
                    <i class="fa fa-close"></i>
                </button>
            </div>
        </div>
        <hr class="horizontal dark my-1">
        <div class="mt-3 pt-sm-3 pt-0 text-center">
            <p class="text-sm">Are you sure you want to delete this record?</p>
            {{-- <p class="text-sm">{{$productId}}</p> --}}
        </div>
        <div class="d-flex py-4">
            <button class="btn bg-gradient-primary w-100 px-3 mb-2" wire:click.prevent="closeModal">Close</button>
            <button type="button" wire:click="confirmDelete({{ $productId }})"
                class="btn bg-gradient-danger w-100 px-3 mb-2 ms-2 active">Delete</button>
        </div>
    </div>
</div>
