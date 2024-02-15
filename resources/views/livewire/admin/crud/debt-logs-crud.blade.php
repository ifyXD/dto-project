<div class="fixed-plugin {{ $isOpenLog ? 'show' : '' }}">
    <a class="fixed-plugin-button text-dark position-fixed px-3 py-2">
        <i class="fa fa-cog py-2"> </i>
    </a>
    <div class="card shadow-lg" style="height: 100vh; overflow-y: auto;">
        <div class="card-header pb-0 pt-3">
            <div class="float-start">
                <h2 class="text-2xl font-bold mb-4">{{ $debt_log_id ? 'Edit Log' : 'Create Log' }}</h2>
            </div>
            <div class="float-end mt-4">
                <button class="btn btn-link text-dark p-0 fixed-plugin-close-button" wire:click.prevent="closeModalLog">
                    <i class="fa fa-close"></i>
                </button>
            </div>
        </div>
        <hr class="horizontal dark my-1">
        <div style="overflow-y: auto;">
            <form wire:submit.prevent="{{ $debt_log_id ? 'updateLog' : 'storeLog' }}" role="form text-left">
                <div class="card-body pt-sm-3 pt-0">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="rep-name" class="form-control-label">{{ __('Representative Name') }}</label>
                                <div class="@error('rep_name') border border-danger rounded-3 @enderror">
                                    <input wire:model="rep_name" class="form-control" type="text"
                                        placeholder="Representative Name" id="rep-name">
                                </div>
                                @error('rep_name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="store-name" class="form-control-label">{{ __('Amount') }}</label>
                                <div class="@error('debt_log_amount') border border-danger rounded-3 @enderror">
                                    <input wire:model="debt_log_amount" min="1" class="form-control" type="number"
                                        placeholder="Debt Amount" id="debt-amount">
                                </div>
                                @error('debt_log_amount')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>



                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="issue-date" class="form-control-label">{{ __('Date') }}</label>
                                <div class="@error('debt_log_date') border border-danger rounded-3 @enderror">
                                    <input wire:model="debt_log_date" class="form-control" type="date"
                                        id="issue-date">
                                </div>

                            </div>
                        </div>  

                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-control-label">{{ __('Status') }}</label>
                                <div class="@error('debt_log_status') border border-danger rounded-3 @enderror">
                                    <div class="form-check form-check-inline">
                                        <input wire:model="debt_log_status" class="form-check-input" type="radio" id="pending" value="pending">
                                        <label class="form-check-label" for="pending">Pending</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input wire:model="debt_log_status" class="form-check-input" type="radio" id="paid" value="paid">
                                        <label class="form-check-label" for="paid">Paid</label>
                                    </div>
                                </div>
                                @error('debt_log_status')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="d-flex py-4">
                        <button class="btn bg-gradient-primary w-100 px-3 mb-2 active"
                            wire:click.prevent="closeModalLog">
                            Close
                        </button>
                        <button type="submit" class="btn bg-gradient-secondary w-100 px-3 mb-2 ms-2 active">
                            {{ $debt_log_id ? 'Update' : 'Create' }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


{{-- for delete --}}
<div class="fixed-plugin {{ $isDeleteOpenLog ? 'show' : '' }}">
    <a class="fixed-plugin-button text-dark position-fixed px-3 py-2">
        <i class="fa fa-cog py-2"> </i>
    </a>
    <div class="card shadow-lg max-h-screen overflow-y-auto">
        <div class="card-header pb-0 pt-3 ">
            <div class="float-start">
                <h2 class="text-2xl font-bold mb-4">Delete</h2>
            </div>
            <div class="float-end mt-4">
                <button class="btn btn-link text-dark p-0 fixed-plugin-close-button" wire:click.prevent="closeModalLog">
                    <i class="fa fa-close"></i>
                </button>
            </div>
        </div>
        <hr class="horizontal dark my-1">
        <div class="mt-3 pt-sm-3 pt-0 text-center">
            <p class="text-sm">Are you sure you want to delete this record?</p>
        </div>
        <div class="d-flex py-4">
            <button class="btn bg-gradient-primary w-100 px-3 mb-2" wire:click.prevent="closeModalLog">Close</button>
            <button type="button" wire:click="confirmDeleteLog({{ $debt_log_id }})"
                class="btn bg-gradient-danger w-100 px-3 mb-2 ms-2 active">Delete</button>
        </div>
    </div>
</div>
