<div>
    <div class="container-fluid py-4">
        <div class="row row-sm">
            <div class="col-lg-12">
                <div class="card custom-card">
                    <div class="card-body">
                        <div class="breadcrumb-header d-flex justify-content-between align-items-center">
                            <div class="left-content">
                                <span class="main-content-title mg-b-1 mg-b-lg-1 fs-4">List of Task Categories</span>
                            </div>

                            <div class="d-flex gap-2">
                                <button type="button" class="btn bg-gradient-success" data-bs-toggle="modal"
                                    data-bs-target="#taskStatusModal">
                                    Tasks Status
                                </button>
                                <button type="button" class="btn bg-gradient-primary" data-bs-toggle="modal"
                                    data-bs-target="#newTaskCategoryModal">
                                    Add New Task Category
                                </button>
                            </div>
                        </div>



                        {{-- Filters --}}
                        <div class="col-sm-3">
                            <div class="row row-xs align-items-center mg-b-20">
                                <div class="col-md-4">
                                    <label class="form-label mg-b-10 fs-7">Sort table by</label>
                                </div>
                                <div class="col-md-8 mg-t-5 mg-md-t-0">
                                    <select wire:model.lazy="sortBy" class="form-control form-control-sm form-select"
                                        data-bs-placeholder="Select column" id="sort-table-filter" style="max-width: 200px; padding: 2px 5px;">
                                        <option value="asc">Ascending</option>
                                        <option value="desc">Descending</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="row row-xs align-items-center mg-b-20">
                                <div class="col-md-4">
                                    <label class="form-label mg-b-10 fs-7">Show entries</label>
                                </div>
                                <div class="col-md-8 mg-t-5 mg-md-t-0">
                                    <select wire:model.lazy="showEntries"
                                        class="form-control form-control-sm form-select"
                                        data-bs-placeholder="Select column" id="sort-table-filter" style="max-width: 200px; padding: 2px 5px;">
                                        <option value="10">10</option>
                                        <option value="20">20</option>
                                        <option value="30">30</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row row-xs align-items-center mg-b-20">
                            <div class="col-md-8">
                                <div class="loading" wire:loading>
                                    <div class="spinner-border spinner-border-sm" role="status">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- Filters --}}


                        {{-- TABLE --}}
                        <div class="table-responsive">
                            <table class="table align-items-center mb-0" wire:loading.remove>
                                <thead>
                                    <tr>
                                        <th class="text-center">
                                            TASK CATEGORY NO.</th>
                                        <th class="text-center">
                                            TASK CATEGORY</th>
                                        <th class="text-center">
                                            STATUS</th>
                                        <th class="text-center">
                                            CREATED BY</th>
                                        <th class="text-center">
                                            DATE CREATED</th>
                                        <th class="text-center">
                                            ACTION</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($tasks as $task)
                                    <tr>
                                        <td class="text-center">TC-{{ $task->categoryNo }}</td>
                                        <td class="text-center">{{ $task->category }}</td>
                                        <td class="text-center">
                                            <span class="badge {{ $this->getStatus($task->status) }} form-control-sm"
                                                style="width: 100%">{{ $task->status }}</span>
                                        </td>
                                        <td class="text-center">{{ $task->created_by }}</td>
                                        <td class="text-center">{{ $task->created_at }}</td>
                                        <td class="text-center">
                                            <button type="button" class="btn p-0 border-0"
                                                data-bs-toggle="modal"
                                                data-bs-target="#editTaskCategoryModal"
                                                wire:click="editTask({{ $task->id }})">
                                                <span class="badge badge-pill bg-gradient-warning">Edit</span>
                                            </button>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="8" class="text-center">No results</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div><br>
                        {{-- TABLE --}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- New Task Modal -->
    <div class="modal fade" id="newTaskCategoryModal" tabindex="-1" role="dialog" aria-labelledby="newTaskCategoryModal"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title font-weight-normal" id="exampleModalLabel">Add New Task Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="card card-plain">
                    <div class="card-body">
                        <!-- Livewire form submission -->
                        <form wire:submit.prevent="addTaskCategory">
                            <div class="row my-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Task Category No.</label>
                                        <input type="text" class="form-control" value="TC-{{ $this->taskCategoryNo }}"
                                            disabled>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Task Category</label>
                                        <input type="text" class="form-control" wire:model="taskCategory">
                                        <div>@error('task') {{ $message }} @enderror</div>
                                    </div>
                                </div>
                            </div>

                            <div class="text-end">
                                <button type="button" class="btn btn-primary bg-gradient-info"
                                    wire:click.prevent="addTaskCategory" wire:loading.attr="disabled">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Complete Task Modal -->
    <div class="modal fade" id="taskStatusModal" tabindex="-1" role="dialog" aria-labelledby="taskStatusModal"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title font-weight-normal">Change Categories Statuses</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="card card-plain">
                    <div class="card-body">
                        <form wire:submit.prevent="taskStatus">
                            <div class="table-responsive">
                                <table class="table align-items-center mb-0" wire:loading.remove>
                                    <thead>
                                        <tr>
                                            <th class="text-center">ACTION</th>
                                            <th class="text-center">CATEGORY NO.</th>
                                            <th class="text-center">CATEGORY</th>
                                            <th class="text-center">STATUS</th>
                                            <th class="text-center">CREATED BY</th>
                                            <th class="text-center">DATE CREATED</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($allCategories as $cTask)
                                        <tr>
                                            <td class="text-center">
                                                <div class="d-flex justify-content-center align-items-center">
                                                    <input type="checkbox" class="form-check-input border border-black"
                                                        wire:model="selectedCategory" value="{{ $cTask->id }}">
                                                </div>
                                            </td>
                                            <td class="text-center">TC-{{ $cTask->categoryNo }}</td>
                                            <td class="text-center">{{ $cTask->category }}</td>
                                            <td class="text-center">
                                                <span
                                                    class="badge {{ $this->getStatus($cTask->status) }} form-control-sm"
                                                    style="width: 100%">{{ $cTask->status }}</span>
                                            </td>
                                            <td class="text-center">{{ $cTask->created_by }}</td>
                                            <td class="text-center">{{ $cTask->created_at }}</td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="8" class="text-center">No results</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div><br>
                            <div class="text-center">
                                <button type="submit" class="btn btn-success bg-gradient-secondary"
                                    wire:loading.attr="disabled">
                                    Change Category Status
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--  -->

</div>