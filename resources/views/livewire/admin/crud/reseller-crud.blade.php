{{-- create and update --}}
<div class="fixed-plugin {{ $isOpen ? 'show' : '' }}">
    <a class="fixed-plugin-button text-dark position-fixed px-3 py-2">
        <i class="fa fa-cog py-2"> </i>
    </a>
    <div class="card shadow-lg ">
        <div class="card-header pb-0 pt-3 ">
            <div class="float-start">

                <h2 class="text-2xl font-bold mb-4">{{ $resellerId ? 'Edit Reseller' : 'Create New Reseller' }}</h2>
            </div>
            <div class="float-end mt-4">
                <button class="btn btn-link text-dark p-0 fixed-plugin-close-button" wire:click.prevent="closeModal">
                    <i class="fa fa-close"></i>
                </button>
            </div>
        </div>
        <hr class="horizontal dark my-1">
        <form wire:submit.prevent="{{ $resellerId ? 'update' : 'store' }}" role="form text-left">
            <div class="card-body pt-sm-3 pt-0">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="store-name" class="form-control-label">{{ __('Reseller Name') }}</label>
                            <div class="@error('reseller_name') border border-danger rounded-3 @enderror">
                                <input wire:model="reseller_name" class="form-control" type="text"
                                    placeholder="Reseller Name" id="reseller-name">
                            </div>
                            @error('reseller_name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="contact-number" class="form-control-label">{{ __('Contact Number') }}</label>
                            <div>
                                <input wire:model="contact_number" class="form-control" type="text"
                                    placeholder="Contact Number" id="contact-number">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="location" class="form-control-label">{{ __('Location') }}</label>
                            <div class="">
                                <input wire:model="location" class="form-control" type="text">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="image" class="form-control-label">{{ __('Image') }}</label>
                            <div class="">
                                <input wire:model="image" wire:key="file-input-{{ $iteration }}" class="form-control" type="file">
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
                                @if ($resellerId)
                                    @if (is_string($image))
                                        <img src="{{ $image != 'default.png' ? asset('storage/' . $image) : asset('storage/images/stores/default/default.png') }}"
                                            class="img-fluid" alt="{{ $store_name }}">
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
                        class="btn bg-gradient-secondary w-100 px-3 mb-2 ms-2 active">{{ $resellerId ? 'Update' : 'Create' }}</button>
                </div>

            </div>
        </form>
    </div>
</div>

{{-- for delete --}}
<div class="fixed-plugin {{ $isDeleteOpen ? 'show' : '' }}">
    <a class="fixed-plugin-button text-dark position-fixed px-3 py-2">
        <i class="fa fa-cog py-2"> </i>
    </a>
    <div class="card shadow-lg ">
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
            {{-- <p class="text-sm">{{$resellerId}}</p> --}}
        </div>
        <div class="d-flex py-4">
            <button class="btn bg-gradient-primary w-100 px-3 mb-2" wire:click.prevent="closeModal">Close</button>
            <button type="button" wire:click="confirmDelete({{ $resellerId }})"
                class="btn bg-gradient-danger w-100 px-3 mb-2 ms-2 active">Delete</button>
        </div>
    </div>
</div>
