<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight mb-3">
                    {{ __('table.title_list') }}
                </h2>
                <p class="text-sm dark:text-gray-200">
                    {{ __('table.description_list') }}
                </p>
            </div>
            <div class="flex items-center gap-2">
                <x-primary-button-link href="{{route('discounts.create')}}">{{ __('table.title_form_create') }}
                </x-primary-button-link>
                <x-secondary-button onclick="exportData(`{{route('discounts.export')}}`)">{{ __('table.export') }}</x-secondary-button>
            </div>
        </div>
    </x-slot>

    <div class="pt-12">
        <div class="w-full sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="{{route('discounts.index')}}" method="GET" class="flex items-end justify-between"
                        autocomplete="off">
                        @csrf
                        <div class="flex items-center justify-between gap-2 w-5/6">
                            <div class="w-1/4">
                                <x-input-label>{{__('table.brand')}}</x-input-label>
                                <x-select-input name='brand' id="brand" class="mt-2">
                                    <option value="">--Seleccionar--</option>
                                    @foreach ($brands as $brand)
                                    <option value="{{$brand->id}}" {{(isset($_GET['brand']) && $_GET['brand'] == $brand->id) ? 'selected' : '' }}>{{$brand->name}}</option>
                                    @endforeach
                                </x-select-input>
                            </div>
                            <div class="w-1/4">
                                <x-input-label>{{__('table.region')}}</x-input-label>
                                <x-select-input name='region' id="region" class="mt-2">
                                    <option value="">--Seleccionar--</option>
                                    @foreach ($regions as $region)
                                    <option value="{{$region->id}}" {{(isset($_GET['region']) && $_GET['region'] == $region->id) ? 'selected' : '' }}>{{$region->name}}</option>
                                    @endforeach
                                </x-select-input>
                            </div>
                            <div class="w-1/4">
                                <x-input-label>{{__('table.name')}}</x-input-label>
                                <x-text-input name='discount_name' id="discount_name" placeholder="Ingresar..." type="text" class="mt-2 w-full" value="{{isset($_GET['discount_name']) ? $_GET['discount_name'] : ''}}">
                                </x-text-input>
                            </div>
                            <div class="w-1/4">
                                <x-input-label>{{__('table.code_discount')}}</x-input-label>
                                <x-text-input name='discount_code' id="discount_code" placeholder="Missing..." type="text" class="mt-2" value="{{isset($_GET['discount_code']) ? $_GET['discount_code'] : ''}}">
                                </x-text-input>
                            </div>
                        </div>
                        <div class="flex items-center gap-2 w-1/6">
                            <x-primary-button class="py-3">{{ __('table.search')}}</x-primary-button>
                            <x-secondary-button-link class="py-3" href="{{route('discounts.index')}}">{{ __('table.clear') }}
                            </x-secondary-button-link>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="pt-6">
        <div class="mx-full sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <table class="w-full">
                        <thead>
                            <tr>
                                <th class="px-4 py-2">{{ __('table.brand') }}</th>
                                <th class="px-4 py-2">{{ __('table.region') }}</th>
                                <th class="px-4 py-2">{{ __('table.name') }}</th>
                                <th class="px-4 py-2">{{ __('table.access_type') }}</th>
                                <th class="px-4 py-2">{{ __('table.status') }}</th>
                                <th class="px-4 py-2">{{ __('table.period') }}</th>
                                <th class="px-4 py-2">{{ __('table.code_discount') }}</th>
                                <th class="px-4 py-2">{{ __('table.discount_percentage')}}</th>
                                <th class="px-4 py-2">{{ __('table.range_date')}}</th>
                                <th class="px-4 py-2">{{ __('table.priority')}}</th>
                                <th class="px-4 py-2">{{ __('table.actions')}}</th>
                            </tr>
                        </thead>
                        <tbody class="border-t-2">
                            @foreach ($discounts as $discount)
                            @php
                            $start_date = date('d M Y',strtotime($discount->start_date));
                            $end_date = date('d M Y',strtotime($discount->end_date));
                            @endphp
                            <tr class="hover:bg-gray-700">
                                <td class="px-4 py-2">{{$discount->brand->name}}</td>
                                <td class="px-4 py-2">{{$discount->region->code}}</td>
                                <td class="px-4 py-2">{{$discount->name}}</td>
                                <td class="px-4 py-2">{{$discount->access_type->name}}</td>
                                <td class="px-4 py-2">
                                    @if($discount->active == 1)
                                    <span
                                        class="bg-green-300 rounded text-white text-sm font-bold px-2 py-1 uppercase">Activo</span>
                                    @else
                                    <span
                                        class="bg-red-400 rounded text-white text-sm font-bold px-2 py-1 uppercase">Inactivo</span>
                                    @endif
                                </td>
                                <td align="center" class="px-4 py-2">
                                    @foreach ($discount->discount_ranges as $range)
                                    <p>{{$range->from_days . ' - ' . $range->to_days}}</p>
                                    @endforeach
                                </td>
                                <td align="center" class="px-4 py-2">
                                    @foreach ($discount->discount_ranges as $range)
                                    <p>{{($range->code) ? $range->code : '--'}}</p>
                                    @endforeach
                                </td>
                                <td align="center" class="px-4 py-2">
                                    @foreach ($discount->discount_ranges as $range)
                                    <p>{{($range->discount) ? $range->discount . " %" : '--'}}</p>
                                    @endforeach
                                </td>
                                <td class="px-4 py-2 text-sm">{{$start_date . " / " . $end_date}}</td>
                                <td align="center" class="px-4 py-2">{{$discount->priority}}</td>
                                <td class="px-4 py-2 flex flex-wrap gap-2">
                                    <a href="{{route('discounts.edit', $discount)}}"
                                        class="w-full bottom bg-green-400 text-center text-white px-2 py-1 rounded">{{__('table.edit')}}</a>
                                    <form class="w-full" action="{{route('discounts.destroy', $discount)}}" id="deleteForm{{ $discount->id }}"
                                        method="POST">
                                        @method('DELETE')
                                        @csrf
                                        <button type="button" onclick="confirmDelete({{ $discount->id }})"
                                            class="w-full bottom bg-red-600 text-center text-white px-2 py-1 rounded">{{__('table.delete')}}</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="mt-4">
                        {{ $discounts->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function confirmDelete(discountId) {
            if (confirm('¿Estás seguro de que deseas eliminar este descuento?')) {
                console.log(document.querySelector(`#deleteForm${discountId}`))
                document.querySelector(`#deleteForm${discountId}`).submit();
            } else {
                return false;
            }
        }

        function exportData(url){
            const brand = document.querySelector('#brand');
            const region = document.querySelector('#region');
            const discount_name = document.querySelector('#discount_name');
            const discount_code = document.querySelector('#discount_code');

            location.href = url + "?brand=" + brand.value + "&region=" + region.value + "&discount_name=" + discount_name.value + "&discount_code=" + discount_code.value;
        }
    </script>
    @endpush
</x-app-layout>