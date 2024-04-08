<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('table.title_form_create') }}
                </h2>
                <p class="text-sm dark:text-gray-200">
                    {{ __('table.description_form_create') }}
                </p>
            </div>
            <div class="flex items-center gap-2">
                <x-primary-button-link href="{{route('discounts.index')}}">{{ __('table.back') }}</x-primary-button-link>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="mx-full sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <p class="text-left -mt-3 mb-3">{{__('table.description_form_create')}}</p>

                    <div class="w-full mb-6 py-5">
                        <form action="{{route('discounts.store')}}" method="POST" autocomplete="off">
                            @csrf
                            <div class="md:flex md:items-center md:justify-between w-full shadow shadow-gray-900 rounded px-3 py-4 mb-4">
                                <div class="md:flex md:items-center px-3 md:justify-start md:w-3/4 gap-2">
                                    <div>
                                        <x-input-label for="inline-full-name" :value="__('table.form_name')" />
                                    </div>
                                    <div class="w-6/12">
                                        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"
                                            :value="old('name')" />
                                        @error('name')
                                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                        @enderror
                                    </div>
                                    <div>
                                        <p class="text-xs py-2 px-1 rounded bg-gray-700">
                                            {{__('table.form_name_message')}}</p>
                                    </div>
                                </div>

                                <div class="md:flex md:items-center px-3 md:justify-end gap-1">
                                    <input class="" id="inline-full-checkbox" type="checkbox" name="active"
                                        {{(old('active')) ? 'checked' : '' }}>
                                    <x-input-label for="inline-full-checkbox" :value="__('table.form_status')" />
                                </div>
                            </div>

                            <div class="md:flex md:flex-wrap md:justify-between shadow shadow-gray-900 rounded my-4 px-3 py-4">
                                <div class="w-full md:w-1/4 px-3 mb-6 md:mb-0">
                                    <x-input-label :value="__('table.brand')" />
                                    
                                    <x-select-input name="brand_id" class="mt-1">
                                        <option value="">--Seleccionar--</option>
                                        @foreach ($brands as $brand)
                                        <option value="{{$brand->id}}" {{(old('brand_id') == $brand->id) ? 'selected' : ''}}>{{$brand->name}}</option>
                                        @endforeach
                                    </x-select-input>
                                </div>

                                <div class="w-full md:w-1/4 px-3">
                                    <x-input-label :value="__('table.access_type')" />

                                    <x-select-input name="access_type_code" class="mt-1">
                                        <option value="">--Seleccionar--</option>
                                        @foreach ($access_types as $access_type)
                                        <option value="{{$access_type->code}}" {{(old('access_type_code') == $access_type->code) ? 'selected' : ''}}>{{$access_type->name}}</option>
                                        @endforeach
                                    </x-select-input>
                                </div>

                                <div class="w-full md:w-1/4 px-3 mb-6 md:mb-0">
                                    <x-input-label :value="__('table.priority')" />

                                    <x-text-input class="block mt-1 w-full" id="grid-first-name" type="number"
                                        name="priority" :value="old('priority')" min="1" />
                                    
                                    @error('priority')
                                    <x-input-error :messages="$errors->get('priority')" class="mt-2" />
                                    @enderror
                                </div>

                                <div class="w-full md:w-1/4 px-3">
                                    <x-input-label :value="__('table.region')" />

                                    <x-select-input name="region_id" class="mt-1">
                                        <option value="">--Seleccionar--</option>
                                        @foreach ($regions as $region)
                                        <option value="{{$region->id}}" {{(old('region_id') == $region->id) ? 'selected' : ''}}>{{$region->name}}</option>
                                        @endforeach
                                    </x-select-input>
                                </div>
                            </div>

                            <div class="md:flex md:flex-wrap md:justify-between shadow shadow-gray-900 rounded my-4 px-3 py-4 text-xs rounded bg-gray-700">
                                Desde esta sección podrá cargar descuentos promocionales AWD / BCD, o un descuento GSA (cediendo comisión). Podrá agregar uno o ambos descuentos al mismo tiempo para que se apliquen al mismo tiempo. Tenga en cuenta que si una tarifa tiene diferentes precios por vigencia, debera definir descuentos diferente para cada uno de ellos
                            </div>

                            <div class="md:flex md:items-center md:justify-between my-4 py-4 gap-4">
                                <x-discount-form-period :index="0"/>
                                <x-discount-form-period :index="1"/>
                                <x-discount-form-period :index="2"/>
                            </div>

                            <div class="md:flex md:items-center md:justify-between shadow shadow-gray-900 rounded my-4 px-3 py-4 gap-2">
                                <div class="w-full md:w-2/4 px-3 mb-6 md:mb-0">
                                    <label class="block uppercase tracking-wide  text-xs font-bold mb-2"
                                        for="start_date">
                                        {{__('table.form_aplication_period')}}
                                    </label>
                                    <x-text-input class="block mt-1 w-full" type="date" name="start_date"
                                        :value="old('start_date')" />
                                    @error('start_date')
                                    <x-input-error :messages="$errors->get('start_date')" class="mt-2" />
                                    @enderror
                                    <x-text-input class="block mt-1 w-full" type="date" name="end_date"
                                        :value="old('end_date')" />
                                    @error('end_date')
                                    <x-input-error :messages="$errors->get('end_date')" class="mt-2" />
                                    @enderror
                                </div>
                                <div class="md:w-2/4">
                                    <p class="text-xs py-2 px-1 rounded bg-gray-700">
                                        {{__('table.form_aplication_period_message')}}</p>
                                </div>
                            </div>

                            <div class="flex items-center justify-end gap-2">
                                <x-primary-button class="ms-3" type="submit">
                                    {{ __('table.form_save') }}
                                </x-primary-button>
                                <a class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-500 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-25 transition ease-in-out duration-150"
                                    href="{{route('discounts.index')}}">
                                    {{__('table.form_cancel')}}
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        @push('scripts')
            <script>
                document.querySelectorAll('.input-period').forEach(element => {
                    number = element.getAttribute('data-index');
                    if(number > 0){
                        element.setAttribute('readonly','true');
                    }

                    if(element.addEventListener('input', function(){
                        if(element.getAttribute('data-index') == 0){
                            document.querySelectorAll('input[data-index="1"]').forEach(value => {
                                value.removeAttribute('readonly');
                            })
                        }

                        if(element.getAttribute('data-index') == 0){
                            document.querySelectorAll('input[data-index="2"]').forEach(value => {
                                value.removeAttribute('readonly');
                            })
                        }
                    }));
                });
            </script>
        @endpush
</x-app-layout>