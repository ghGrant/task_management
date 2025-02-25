<div>
    <select 
        wire:model.lazy="value"
        wire:change="updateTask({{ $id }}, '{{ $field }}', $event.target.value)"
        class="border p-1 w-full"
    >
        @foreach($options as $option)
            <option value="{{ $option->id }}" {{ $option->id == $value ? 'selected' : '' }}>
                {{ $option->{$optionLabel} }}
            </option>
        @endforeach
    </select>
</div>
