<div><br>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label>Task Category No.</label>
                <input type="text" class="form-control" value="TC-{{ $taskCategoryNo }}"
                    disabled>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>Category Description</label>
                <input type="text" class="form-control" wire:model="taskCategory">
            </div>
        </div>
    </div>

    <div class="text-end">
        <button type="button" class="btn btn-primary bg-gradient-info"
            wire:click.prevent="addTaskCategory" wire:loading.attr="disabled">Submit</button>
    </div>
</div>