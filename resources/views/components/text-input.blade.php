{{--
|--------------------------------------------------------------------------
| File: resources/views/components/text-input.blade.php
|--------------------------------------------------------------------------
|
| Komponen input teks yang bisa digunakan kembali.
|
--}}
@props([
    'type' => 'text',
    'name' => '',
    'id' => '',
    'label' => '',
    'placeholder' => '',
    'required' => false,
    'value' => '',
])

<div class="space-y-1">
    {{-- Label --}}
    @if($label)
        <label for="{{ $id }}" class="block text-sm font-medium text-gray-700">
            {{ $label }}
            @if($required)
                <span class="text-red-500">*</span>
            @endif
        </label>
    @endif

    {{-- Input Field --}}
    <input 
        type="{{ $type }}"
        name="{{ $name }}"
        id="{{ $id }}"
        placeholder="{{ $placeholder }}"
        value="{{ old($name, $value) }}"
        @if($required) required @endif
        {{ $attributes->merge([
            'class' => 'w-full px-3 py-2 border border-gray-300 rounded-lg text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-berkah-secondary focus:border-berkah-secondary transition-colors duration-200 text-sm'
        ]) }}
    >

    {{-- Error Message --}}
    @error($name)
        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
    @enderror
</div>
