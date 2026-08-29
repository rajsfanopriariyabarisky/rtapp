@props([
    'name',
    'label' => null,
    'value' => null,
    'required' => false,
    'class' => '',
    'id' => null
])

<div>
    @if($label)
        <label for="{{ $id ?? $name }}" class="block text-gray-700 dark:text-gray-200 mb-1">{{ $label }}</label>
    @endif
    <div class="relative">
        <input 
            type="date" 
            name="{{ $name }}" 
            id="{{ $id ?? $name }}"
            value="{{ $value }}"
            @if($required) required @endif
            class="w-full px-3 py-2 pr-10 border rounded dark:bg-gray-800 dark:text-white @error($name) border-red-500 @enderror {{ $class }}"
            {{ $attributes }}
        >
        <button type="button" onclick="this.previousElementSibling.showPicker()" 
                class="absolute right-2 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 cursor-pointer">
            📅
        </button>
    </div>
    @error($name) <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
</div> 