{{--
|--------------------------------------------------------------------------
| File: resources/views/components/text-input.blade.php
|--------------------------------------------------------------------------
|
| Komponen input teks yang bisa digunakan kembali.
|
--}}
@props(['disabled' => false, 'type' => 'text', 'name', 'id', 'value' => '', 'label'])

<div class="mb-4">
    <label for="{{ $id }}" class="block font-medium text-sm text-gray-700">{{ $label }}</label>
    <input type="{{ $type }}"
           id="{{ $id }}"
           name="{{ $name }}"
           value="{{ old($name, $value) }}"
           {{ $disabled ? 'disabled' : '' }}
           {!! $attributes->merge(['class' => 'block mt-1 w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-berkah-teal-gelap focus:border-berkah-teal-gelap sm:text-sm']) !!}>
    @error($name)
        <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
    @enderror
</div>
