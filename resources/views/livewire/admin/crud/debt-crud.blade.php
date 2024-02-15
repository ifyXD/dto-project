<div class="fixed-plugin {{ $isOpen ? 'show' : '' }}">
    <a class="fixed-plugin-button text-dark position-fixed px-3 py-2">
        <i class="fa fa-cog py-2"> </i>
    </a>
    <div class="card shadow-lg" style="height: 100vh; overflow-y: auto;">
        <div class="card-header pb-0 pt-3">
            <div class="float-start">
                <h2 class="text-2xl font-bold mb-4">{{ $debt_id ? 'Edit Debt' : 'Create Debt' }}</h2>
            </div>
            <div class="float-end mt-4">
                <button class="btn btn-link text-dark p-0 fixed-plugin-close-button" wire:click.prevent="closeModal">
                    <i class="fa fa-close"></i>
                </button>
            </div>
        </div>
        <hr class="horizontal dark my-1">
        <div style="overflow-y: auto;">
            <form wire:submit.prevent="{{ $debt_id ? 'update' : 'store' }}" role="form text-left">
                <div class="card-body pt-sm-3 pt-0">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="store-name" class="form-control-label">{{ __('Debtor Name') }}</label>
                                <div class="@error('debtor_name') border border-danger rounded-3 @enderror">
                                    <input wire:model="debtor_name" class="form-control" type="text"
                                        placeholder="Debtor Name" id="product-name">
                                </div>
                                @error('debtor_name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="store-name" class="form-control-label">{{ __('Contact Number') }}</label>
                                <div class="@error('debtor_number') border border-danger rounded-3 @enderror">
                                    <input wire:model="debtor_number" class="form-control" type="text"
                                        placeholder="Contact Number" id="product-name">
                                </div>
                                @error('debtor_number')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="store-name" class="form-control-label">{{ __('Location') }}</label>
                                <div class="@error('debtor_location') border border-danger rounded-3 @enderror">
                                    <input wire:model="debtor_location" class="form-control" type="text"
                                        placeholder="Location" id="product-name">
                                </div>
                                @error('debtor_location')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <hr>
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

                        {{-- <div class="col-md-12">
                            <div class="text-center mx-auto">
                                <small>{{ __('Optional') }}</small>
                            </div>
                            <div class="form-group">
                                <label for="store-name" class="form-control-label">{{ __('Search') }}</label>
                                <div class="">
                                    <input wire:model="productsearch" class="form-control" type="text"
                                        placeholder="Search..." id="product-name">
                                </div>
                            </div>

                            <div class="notebook-container">
                                @foreach ($products as $product)
                                    <div class="form-group" wire:key="product-{{ $product->id }}">
                                        <div class="d-flex align-items-center">
                                            <input type="checkbox" wire:model="productchecked"
                                                value="{{ $product->id }}">
                                            <label for="store-name"
                                                class="form-control-label ml-2">{{ $product->product_name }}</label>

                                            @if (in_array($product->id, $productchecked))
                                                <div wire:ignore>
                                                    <button wire:click="decrementQuantity('{{ $product->id }}')"
                                                        wire:keydown.debounce.500ms="decrementQuantity('{{ $product->id }}')">-</button>
                                                    <span>{{ $productQuantities[$product->id] ?? 1 }}</span>
                                                    <button wire:click="incrementQuantity('{{ $product->id }}')"
                                                        wire:keydown.debounce.500ms="incrementQuantity('{{ $product->id }}')">+</button>
                                                </div>
                                            @endif

                                        </div>
                                    </div>
                                @endforeach
                                <div>{{ $products->links() }}</div>

                                <div class="col-md-12 notebook-container">
                                    <ul class="notebook-list">
                                        @foreach ($this->checkedProducts as $p)
                                            <li>
                                                {{ $p['product_name'] }} ({{ $productQuantities[$p['id']] ?? 1 }})
                                                {{ $p['price'] * $productQuantities[$p['id']] ?? 1 }}
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>

                            </div>
                        </div> --}}


                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="store-name" class="form-control-label">{{ __('Debt Amount') }}</label>
                                <div class="@error('debt_amount') border border-danger rounded-3 @enderror">
                                    <input wire:model="debt_amount" min="0" class="form-control" type="number"
                                        placeholder="Debt Amount" id="debt-amount">
                                </div>
                                @error('debt_amount')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>



                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="issue-date" class="form-control-label">{{ __('Issue Date') }}</label>
                                <div class="@error('issue_date') border border-danger rounded-3 @enderror">
                                    <input wire:model="issue_date" class="form-control" type="date" id="issue-date">
                                </div>

                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="due-date" class="form-control-label">{{ __('Due Date') }}</label>
                                <div class="@error('due_date') border border-danger rounded-3 @enderror">
                                    <input wire:model="due_date" class="form-control" type="date" id="due-date">
                                </div>

                                @error('due_date')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror

                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group @error('debt_status') border border-danger rounded-3 @enderror">
                                <label for="debt_status">Debt Status</label>
                                <select name="debt_status" id="debt_status" wire:model="debt_status"
                                    class="form-control">
                                    <option value="pending" {{ $debt_status == 'pending' ? 'selected' : '' }}>Pending
                                    </option>
                                    <option value="paid" {{ $debt_status == 'paid' ? 'selected' : '' }}>Paid</option>
                                </select>
                                @error('debt_status')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>
                    </div>
                    <div class="d-flex py-4">
                        <button class="btn bg-gradient-primary w-100 px-3 mb-2 active"
                            wire:click.prevent="closeModal">
                            Close
                        </button>
                        <button type="submit" class="btn bg-gradient-secondary w-100 px-3 mb-2 ms-2 active">
                            {{ $debt_id ? 'Update' : 'Create' }}
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
            <button type="button" wire:click="confirmDelete({{ $debt_id }})"
                class="btn bg-gradient-danger w-100 px-3 mb-2 ms-2 active">Delete</button>
        </div>
    </div>
</div>
