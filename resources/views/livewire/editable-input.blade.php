<div>
    <input 
        type="text" 
        wire:model.lazy="value" 
        wire:blur="updateTask({{ $id }}, '{{ $field }}', $event.target.value)"
        value="{{ $value }}" 
        class="border p-1 w-full"
    />
</div>
