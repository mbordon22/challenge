<table>
    <thead>
        <tr>
            <th>{{ __('table.brand') }}</th>
            <th>{{ __('table.region') }}</th>
            <th>{{ __('table.name') }}</th>
            <th>{{ __('table.access_type') }}</th>
            <th>{{ __('table.status') }}</th>
            <th>{{ __('table.period') }}</th>
            <th>{{ __('table.code_discount') }}</th>
            <th>{{ __('table.discount_percentage')}}</th>
            <th>{{ __('table.range_date')}}</th>
            <th>{{ __('table.priority')}}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($discounts as $discount)
        @php
        $start_date = date('d M Y',strtotime($discount->start_date));
        $end_date = date('d M Y',strtotime($discount->end_date));
        @endphp
        <tr>
            <td>{{$discount->brand->name}}</td>
            <td>{{$discount->region->code}}</td>
            <td>{{$discount->name}}</td>
            <td>{{$discount->access_type->name}}</td>
            <td>
                @if($discount->active == 1)
                <span>Activo</span>
                @else
                <span>Inactivo</span>
                @endif
            </td>
            <td align="center">
                @foreach ($discount->discount_ranges as $range)
                <p>{{$range->from_days . ' - ' . $range->to_days}}</p>
                @endforeach
            </td>
            <td align="center">
                @foreach ($discount->discount_ranges as $range)
                <p>{{($range->code) ? $range->code : '--'}}</p>
                @endforeach
            </td>
            <td align="center">
                @foreach ($discount->discount_ranges as $range)
                <p>{{($range->discount) ? $range->discount . " %" : '--'}}</p>
                @endforeach
            </td>
            <td>{{$start_date . " / " . $end_date}}</td>
            <td align="center">{{$discount->priority}}</td>
        </tr>
        @endforeach
    </tbody>
</table>