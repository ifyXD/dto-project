<div class="col-12 {{ $isLogOpen ? '' : 'd-none' }}">
    <div class="card mb-4 mx-4 ">
        <div class="card-header pb-0 ">
            <div class="d-flex flex-row justify-content-between">
                <div>
                    <h5 wire:click="logs('{{ $debt_id }}', 'back')" class="mb-0"><i class="fas fa-arrow-left"></i>
                    </h5>
                </div>
                @if ($log_status === 'pending')
                    <a href="#" wire:click="createlog" class="btn bg-gradient-secondary btn-sm mb-0"
                        type="button">+&nbsp; Create</a>
                @endif
            </div>
            <div class="ms-md-3 pe-md-3 d-flex align-items-center mt-2 mb-2 float-right">
                <div class="input-group">
                    <span class="input-group-text text-body"><i class="fas fa-search" aria-hidden="true"></i></span>
                    <input type="text" class="form-control" wire:model="search" placeholder="Search here...">
                </div>
            </div>
        </div>
        <div class="card-body px-0 pt-0 pb-2">
            @if ($logfirst)
                <div class="card border-rounded">
                    <div class="card-body">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Name
                                        </th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Date Issued
                                        </th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Due Date
                                        </th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Amount
                                        </th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Status
                                        </th>
                                    </tr>
                                <tbody>
                                    <tr>
                                        <td class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">{{ $logfirst->debtor_name }}</p>
                                        </td>
                                        <td class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">
                                                {{ $logfirst->issue_date }}
                                            </p>
                                        </td>
                                        <td class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">
                                                {{ $logfirst->due_date }}
                                            </p>
                                        </td>
                                        <td class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">
                                                {{ $logfirst->debt_amount }}
                                            </p>
                                        </td>
                                        <td class="text-center">
                                            <p class="text-xs font-weight-bold mb-0 
                                                @if($logfirst->status === 'pending') text-danger @endif">
                                                {{ $logfirst->status }}
                                            </p>
                                        </td>
                                        
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="table-responsive p-0 mt-5">
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    Sr.
                                </th>
                                <th
                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    Name
                                </th>
                                <th
                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    Date Paid
                                </th>
                                <th
                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    Amount
                                </th>
                                <th
                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    Status
                                </th>
                                @if ($log_status === 'pending')
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Action
                                    </th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @if ($logs_arr->isNotEmpty())
                                @foreach ($logs_arr as $key => $debt)
                                    <tr>
                                        <td class="ps-4">
                                            <p class="text-xs font-weight-bold mb-0">{{ $key + 1 }}</p>
                                        </td>
                                        <td class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">{{ $debt->name }}</p>
                                        </td>
                                        <td class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">
                                                {{ $debt->date }}
                                            </p>
                                        </td>
                                        <td class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">
                                                {{ $debt->amount }}
                                            </p>
                                        </td>
                                        <td class="text-center">
                                            <p class="text-xs font-weight-bold mb-0 @if($debt->log_status === 'pending') text-danger @endif">
                                                {{ $debt->log_status }}
                                            </p>
                                        </td>

                                        <td class="text-center">
                                            <a href="#" wire:click="editLogs({{ $debt->id }})" class="mx-3"
                                                data-bs-toggle="tooltip" data-bs-original-title="Edit user">
                                                <i class="fas fa-user-edit text-secondary"></i>
                                            </a>
                                            <span wire:click="deleteLogs({{ $debt->id }})" data-bs-toggle="tooltip"
                                                data-bs-original-title="Delete">
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
            @endif
        </div>
        <div class="card-footer px-0 pt-0 pb-2">
            <div class="card border-rounded">
                <div class="card-body">
                    <div class="row">  
                        <div class="col-md-12">
                            <label>Total Debts:</label>
                            {{ $totaldebts }}
                        </div>
                        <div class="col-md-12">
                            <label>Total Debt Log Amount:</label>
                            @if ($totaldebtamount)
                                {{ $totaldebtamount }}
                            @else
                                0.
                            @endif
                        </div>
                        <div class="col-md-12">
                            <label>Remaining Debt Balance:</label>
                            {{ $remainingdebtamount }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        
    </div>
</div>
