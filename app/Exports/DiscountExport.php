<?php

namespace App\Exports;

use App\Models\Discount;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\FromCollection;

// class DiscountExport implements FromCollection
class DiscountExport implements FromView
{
    public $name;
    public $code;
    public $brand_id;
    public $region_id;

    public function __construct($array_data)
    {
        $this->name = $array_data['name'];
        $this->code = $array_data['code'];
        $this->brand_id = $array_data['brand_id'];
        $this->region_id = $array_data['region_id'];
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    // public function collection()
    public function view(): View
    {
        $name = $this->name ?? '';
        $code = $this->code ?? '';
        $region_id = $this->region_id ?? '';
        $brand_id = $this->brand_id ?? '';

        //Listado de descuentos
        $discounts = Discount::with('discount_ranges')
                    ->where('name', 'LIKE', "%$name%")
                    ->whereHas('discount_ranges', function($query) use ($code){
                        if($code != ''){
                            $query->where('code', $code);
                        }
                    })
                    ->whereHas('region', function($query) use ($region_id){
                        if($region_id != ''){
                            $query->where('region_id', $region_id);
                        }
                    })
                    ->whereHas('brand', function($query) use ($brand_id){
                        $query->where('active',1);
                        if($brand_id != ''){
                            $query->where('brand_id', $brand_id);
                        }
                    })
                    ->orderBy('name')
                    ->get();
        // dd($discounts);
        return view('discounts.export', [
            'discounts' => $discounts
        ]);
    }
}
