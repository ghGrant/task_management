<div>
    <select
        wire:model.lazy="value"
        wire:change="updateTask({{ $id }}, '{{ $field }}', $event.target.value)"
        class="border p-1 w-full">
        @foreach($options as $option)
        @if(is_array($options))
        <!-- FOR TASK CATEGORIES -->
        <option value="{{ $option }}" {{ $option == $value ? 'selected' : '' }}>
            {{ $option }}
        </option>
        @else
        <!-- FOR TASK TABLE -->
        <option value="{{ $option->id }}" {{ $option->id == $value ? 'selected' : '' }}>
            {{ $option->{$optionLabel} }}
        </option>
        @endif
        @endforeach
    </select>
</div>