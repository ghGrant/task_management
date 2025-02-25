<div><br>
    <div class="row">
        <div class="col-md-2">
            <div class="form-group">
                <label>Task Category No.</label>
                <input type="text" class="form-control" value="TC-{{ $taskNo }}"
                    disabled>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label>Assign Task to:</label>
                <select class="form-control" wire:model="taskName">
                    <option hidden value="">Select User</option>
                    @foreach($userName as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label>Task Description</label>
                <input type="text" class="form-control" wire:model="task">
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <label>Task Category</label>
                <select class="form-control" wire:model="taskCategory">
                    <option hidden value="">Select User</option>
                    @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->category }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <label>Remarks:</label>
                <input type="text" class="form-control" wire:model="remarks">
            </div>
        </div>
    </div>

    <div class="text-end">
        <button type="button" class="btn btn-primary bg-gradient-info"
            wire:click.prevent="addTask" wire:loading.attr="disabled">Submit</button>
    </div>
</div>