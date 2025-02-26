<div>
    <div class="container-fluid py-4">
        <div class="row row-sm">
            <div class="col-lg-12">
                <div class="card custom-card">
                    <div class="card-body">
                        <div class="breadcrumb-header d-flex justify-content-between align-items-center">
                            <div class="left-content">
                                <span class="main-content-title mg-b-1 mg-b-lg-1 fs-4">Create New Task Category</span>
                            </div>
                        </div>
                        <livewire:create-task-category />
                    </div>
                </div><br>

                <div class="card custom-card">
                    <div class="card-body">
                        <div class="left-content">
                            <span class="main-content-title mg-b-1 mg-b-lg-1 fs-4">List of Task Categories</span>
                        </div>
                        <livewire:TaskCategoryTable />
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>