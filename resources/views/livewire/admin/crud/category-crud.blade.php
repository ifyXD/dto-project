{{-- create and update --}}
<div class="fixed-plugin {{ $isOpen ? 'show' : '' }}">
    <a class="fixed-plugin-button text-dark position-fixed px-3 py-2">
        <i class="fa fa-cog py-2"> </i>
    </a>
    <div class="card shadow-lg" style="height: 100vh; overflow-y: auto;">
        <div class="card-header pb-0 pt-3 ">
            <div class="float-start">

                <h2 class="text-2xl font-bold mb-4">{{ $categoryId ? 'Edit Reseller' : 'Create New Reseller' }}</h2>
            </div>
            <div class="float-end mt-4">
                <button class="btn btn-link text-dark p-0 fixed-plugin-close-button" wire:click.prevent="closeModal">
                    <i class="fa fa-close"></i>
                </button>
            </div>
        </div>
        <hr class="horizontal dark my-1">
        <div style="overflow-y: auto;">
            <form wire:submit.prevent="{{ $categoryId ? 'update' : 'store' }}" role="form text-left">
                <div class="card-body pt-sm-3 pt-0">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="store-name" class="form-control-label">{{ __('Category Name') }}</label>
                                <div class="@error('category_name') border border-danger rounded-3 @enderror">
                                    <input wire:model="category_name" class="form-control" type="text"
                                        placeholder="category Name" id="category-name">
                                </div>
                                @error('category_name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="lg:col-span-12">
                            <div class="form-group">
                                <label for="description" class="form-control-label">{{ __('Description') }}</label>
                                <div>
                                    <textarea wire:model="description" class="form-control" style="height: 25vh; " placeholder="Description"
                                        id="description"></textarea>
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
                                    @if ($categoryId)
                                        @if (is_string($image))
                                            <img src="{{ $image != 'default.png' ? asset('storage/' . $image) : asset('storage/images/stores/default/default.png') }}"
                                                class="img-fluid" alt="{{ $category_name }}">
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
                            wire:click.prevent="closeModal">Close</button>
                        <button type="submit"
                            class="btn bg-gradient-secondary w-100 px-3 mb-2 ms-2 active">{{ $categoryId ? 'Update' : 'Create' }}</button>
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
            {{-- <p class="text-sm">{{$categoryId}}</p> --}}
        </div>
        <div class="d-flex py-4">
            <button class="btn bg-gradient-primary w-100 px-3 mb-2" wire:click.prevent="closeModal">Close</button>
            <button type="button" wire:click="confirmDelete({{ $categoryId }})"
                class="btn bg-gradient-danger w-100 px-3 mb-2 ms-2 active">Delete</button>
        </div>
    </div>
</div>
