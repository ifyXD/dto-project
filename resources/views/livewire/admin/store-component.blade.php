<div class="main-content h-full">
    {{-- create  --}}
    @include('livewire.admin.crud.store-crud')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0">
                    <div class="d-flex flex-row justify-content-between">
                        <div>
                            <h5 class="mb-0">All Stores</h5>
                        </div>
                        <a href="#" wire:click="create" class="btn bg-gradient-secondary btn-sm mb-0"
                            type="button">+&nbsp; Create</a>
                    </div>
                    <div class="ms-md-3 pe-md-3 d-flex align-items-center mt-2 mb-2 float-right">
                        <div class="input-group">
                            <span class="input-group-text text-body"><i class="fas fa-search"
                                    aria-hidden="true"></i></span>
                            <input type="text" class="form-control" wire:model="search" placeholder="Search here...">
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
                                        Photo
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Name
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Location
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Creation Date
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($stores) > 0)
                                    @foreach ($stores as $key => $store)
                                        <tr>
                                            <td class="ps-4">
                                                <p class="text-xs font-weight-bold mb-0">{{ $key + 1 }}</p>
                                            </td>
                                            <td>
                                                <div>
                                                    <img src="{{ asset('storage/' . $store->image) }}"
                                                        class="avatar avatar-sm me-3" alt="{{ $store->store_name }}">

                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <p class="text-xs font-weight-bold mb-0">{{ $store->store_name }}</p>
                                            </td>
                                            <td class="text-center">
                                                <p class="text-xs font-weight-bold mb-0">
                                                    {{ Str::limit($store->location, 20, '...') }}</p>
                                            </td>
                                            <td class="text-center">
                                                <span
                                                    class="text-secondary text-xs font-weight-bold">{{ date('F j, Y - g:i a', strtotime($store->created_at)) }}</span>
                                            </td>
                                            <td class="text-center">
                                                <a href="#" wire:click="edit({{ $store->id }})" class="mx-3"
                                                    data-bs-toggle="tooltip" data-bs-original-title="Edit user">
                                                    <i class="fas fa-user-edit text-secondary"></i>
                                                </a>  
                                                <span wire:click="delete({{ $store->id }})">
                                                    <i class="cursor-pointer fas fa-trash text-danger"></i>
                                                </span>
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
                    <div class="d-flex justify-content-center mt-3">
                        {{ $stores->links() }}
                    </div>
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
