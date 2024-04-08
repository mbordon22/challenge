<div class="md:flex md:items-center md:flex-wrap md:justify-between md:w-1/3 shadow shadow-gray-900 rounded px-3 py-4">
    {{-- Desde y hasta --}}
    <div class="w-full px-3 mb-6 md:mb-2">
        <x-input-label :value="__('table.form_aplication_period') . $number" />

        <div class="flex items-center justify-between gap-2">
            <x-text-input class="block mt-1 w-1/2 input-period" data-index="{{$index}}" type="number" name="from_days[]" value="{{$discount_ranges['from_days']}}" placeholder="Desde..."/>
            
            @error('from_days.' . $index)
            <x-input-error :messages="$errors->get('from_days.' . $index)" class="mt-2" />
            @enderror
    
            <x-text-input class="block mt-1 w-1/2 input-period" data-index="{{$index}}" type="number" name="to_days[]" value="{{$discount_ranges['to_days']}}" placeholder="Hasta..."/>
            
            @error('to_days.' . $index)
            <x-input-error :messages="$errors->get('to_days.' . $index)" class="mt-2" />
            @enderror
        </div>
    </div>

    {{-- Codigo --}}
    <div class="w-full px-3 mb-6 md:mb-2">
        <x-input-label :value="__('table.form_discount_code')" />

        <x-text-input class="block mt-1 w-full input-period" data-index="{{$index}}" type="text" name="code[]" value="{{$discount_ranges['code']}}" placeholder="Código..."/>

        @error('code.' . $index)
        <x-input-error :messages="$errors->get('code.' . $index)" class="mt-2" />
        @enderror
    </div>

    {{-- Porcentaje --}}
    <div class="w-full px-3 mb-6 md:mb-0">
        <x-input-label :value="__('table.form_discount_percentage')" />

        <x-text-input class="block mt-1 w-full input-period" data-index="{{$index}}" type="number" name="discount[]" value="{{$discount_ranges['discount']}}" placeholder="Porcentaje..."/>

        @error('discount.' . $index)
        <x-input-error :messages="$errors->get('discount.' . $index)" class="mt-2" />
        @enderror
    </div>
</div>