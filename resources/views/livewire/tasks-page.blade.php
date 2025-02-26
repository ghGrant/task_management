<div>
    <div class="container-fluid py-4">
        <div class="row row-sm">
            <div class="col-lg-12">
                <div class="card custom-card">
                    <div class="card-body">
                        <div class="breadcrumb-header d-flex justify-content-between align-items-center">
                            <div class="left-content">
                                <span class="main-content-title mg-b-1 mg-b-lg-1 fs-4">Create New Task</span>
                            </div>
                        </div>
                        <livewire:CreateTaskList />
                    </div>
                </div><br>

                <div class="card custom-card">
                    <div class="card-body">
                        <div class="breadcrumb-header d-flex justify-content-between align-items-center">
                            <div class="left-content">
                                <span class="main-content-title mg-b-1 mg-b-lg-1 fs-4">List of Tasks</span>
                            </div>
                        </div>
                        <livewire:TasksTable />

                        <div class="d-flex justify-content-end mt-3">
                            <button class="btn btn-primary bg-gradient-danger" wire:click="$dispatch('deleteSelected')">
                                Delete Tasks
                            </button><br>
                            <button class="btn btn-primary bg-gradient-success me-2" wire:click="$dispatch('processSelected')">
                                Complete Tasks
                            </button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>