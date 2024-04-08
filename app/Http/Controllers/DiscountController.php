<?php

namespace App\Http\Controllers;

use App\Exports\DiscountExport;
use App\Models\Brand;
use App\Models\Region;
use App\Models\Discount;
use Illuminate\View\View;
use App\Models\AccessType;
use Illuminate\Http\Request;
use App\Models\DiscountRange;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;

class DiscountController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index( Request $request) : View
    {
        $brands = Brand::where('active','1')->orderBy('display_order')->get();
        $regions = Region::orderBy('display_order')->get();

        $name = $request->get('discount_name');
        $code = $request->get('discount_code');
        $brand_id = $request->get('brand');
        $region_id = $request->get('region');

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
                    ->paginate(4);

        return view('discounts.index',[
            'brands' => $brands,
            'regions' => $regions,
            'discounts' => $discounts
        ]);
    }


    /**
     * Show the form for creating a new discount.
     */
    public function create() : View
    {
        //datos para los selectores
        $brands = Brand::where('active','1')->orderBy('display_order')->get();
        $regions = Region::orderBy('display_order')->get();
        $access_types = AccessType::orderBy('display_order')->get();

        return view('discounts.create', [
                    'brands' => $brands,
                    'regions' => $regions,
                    'access_types' => $access_types,
        ]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //validación
        $validate = $request->validate([
            'name' => ['required','max:30','alpha_num','unique:discounts'],
            'priority' => ['required','numeric','min:1','max:1000'],
            'from_days.0' => 'required|numeric|lt:to_days.0',
            'from_days.1' => 'exclude_if:from_days.1,null|lt:to_days.1|numeric',
            'from_days.2' => 'exclude_if:from_days.2,null|lt:to_days.2|numeric',
            'to_days.0' => 'required|numeric',
            'to_days.1' => 'exclude_if:to_days.1,null|numeric',
            'to_days.2' => 'exclude_if:to_days.2,null|numeric',
            'code.*' => 'alpha_num',
            'discount.*' => 'numeric|max:100',
            'code.0' => 'required_if:discount.0,null',
            'discount.0' => 'required_if:code.0,null',
            'code.1' => 'exclude_if:code.1,null|required_if:discount.1,null',
            'discount.1' => 'exclude_if:discount.1,null|required_if:code.1,null',
            'code.2' => 'exclude_if:code.2,null|required_if:discount.2,null',
            'discount.2' => 'exclude_if:discount.2,null|required_if:code.2,null',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'brand_id' => 'required',
            'access_type_code' => 'required',
            'region_id' => 'required',
        ], [
            'name.required' => 'El campo nombre es un campo obligatorio',
            'name.alpha_num' => 'El campo nombre solo puede contener letras y números',
            'name.unique' => 'El nombre ya se encuentra en uso',
            'name.max' => 'El nombre no puede tener mas de 30 caracteres',
            'priority.required' => 'El campo prioridad es un campo obligatorio',
            'priority.numeric' => 'El campo prioridad es un campo númerico',
            'priority.min' => 'El número ingresado debe ser mayor o igual a 1',
            'priority.max' => 'El número ingresado debe ser menor o igual a 1000',
            'start_date.required' => 'El campo Fecha de inicio es obligatorio',
            'end_date.required' => 'El campo Fecha de fin es obligatorio'
        ]);

        //Creamos el registro en la tabla discount
        $discount = new Discount;
        $discount->name = $validate['name'];
        $discount->start_date = $validate['start_date'];
        $discount->end_date = $validate['end_date'];
        $discount->priority = $validate['priority'];
        $discount->active = (isset($request->active) && $request->active == 'on') ? 1 : 0;
        $discount->region_id = $validate['region_id'];
        $discount->brand_id = $validate['brand_id'];
        $discount->access_type_code = $validate['access_type_code'];
        $discount->save();

        for($i = 0; $i <= 2; $i++){
            if(isset($validate['from_days'][$i]) && 
            isset($validate['to_days'][$i]) && 
            (isset($validate['code'][$i]) || 
            isset($validate['discount'][$i]))) {

                $discount_range = new DiscountRange;
                $discount_range->from_days = $validate['from_days'][$i];
                $discount_range->to_days = $validate['to_days'][$i];
                $discount_range->code = isset($validate['code'][$i]) ? $validate['code'][$i] : null;
                $discount_range->discount = isset($validate['discount'][$i]) ? $validate['discount'][$i] : null;
                $discount_range->discount_id = $discount->id;
                $discount_range->save();
            }
        }

        return redirect()->route('discounts.index');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Discount $discount) : View
    {
        //datos para los selectores
        $brands = Brand::where('active','1')->orderBy('display_order')->get();
        $regions = Region::orderBy('display_order')->get();
        $access_types = AccessType::orderBy('display_order')->get();

        return view('discounts.edit', [
                    'discount' => $discount,
                    'brands' => $brands,
                    'regions' => $regions,
                    'access_types' => $access_types,
        ]);
    }


    public function update(Request $request, Discount $discount)
    {   

        //validación
        $validate = $request->validate([
            'name' => ['required','max:30','alpha_num', Rule::unique('discounts')->ignore($discount)],
            'priority' => ['required','numeric','min:1','max:1000'],
            'from_days.0' => 'required|numeric|lt:to_days.0',
            'from_days.1' => 'exclude_if:from_days.1,null|lt:to_days.1|numeric',
            'from_days.2' => 'exclude_if:from_days.2,null|lt:to_days.2|numeric',
            'to_days.0' => 'required|numeric',
            'to_days.1' => 'exclude_if:to_days.1,null|numeric',
            'to_days.2' => 'exclude_if:to_days.2,null|numeric',
            'code.*' => 'alpha_num',
            'discount.*' => 'numeric|max:100',
            'code.0' => 'required_if:discount.0,null',
            'discount.0' => 'required_if:code.0,null',
            'code.1' => 'exclude_if:code.1,null|required_if:discount.1,null',
            'discount.1' => 'exclude_if:discount.1,null|required_if:code.1,null',
            'code.2' => 'exclude_if:code.2,null|required_if:discount.2,null',
            'discount.2' => 'exclude_if:discount.2,null|required_if:code.2,null',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'brand_id' => 'required',
            'access_type_code' => 'required',
            'region_id' => 'required',
        ], [
            'name.required' => 'El campo nombre es un campo obligatorio',
            'name.alpha_num' => 'El campo nombre solo puede contener letras y números',
            'name.unique' => 'El nombre ya se encuentra en uso',
            'name.max' => 'El nombre no puede tener mas de 30 caracteres',
            'priority.required' => 'El campo prioridad es un campo obligatorio',
            'priority.numeric' => 'El campo prioridad es un campo númerico',
            'priority.min' => 'El número ingresado debe ser mayor o igual a 1',
            'priority.max' => 'El número ingresado debe ser menor o igual a 1000',
            'start_date.required' => 'El campo Fecha de inicio es obligatorio',
            'end_date.required' => 'El campo Fecha de fin es obligatorio'
        ]);

        //Actualizamos los datos de la tabla discounts
        $discount->name = $validate['name'];
        $discount->start_date = $validate['start_date'];
        $discount->end_date = $validate['end_date'];
        $discount->priority = $validate['priority'];
        $discount->active = (isset($request->active) && $request->active == 'on') ? 1 : 0;
        $discount->region_id = $validate['region_id'];
        $discount->brand_id = $validate['brand_id'];
        $discount->access_type_code = $validate['access_type_code'];
        $discount->save();
        
        //Recorremos y actualizamos los registros de la tabla discount_ranges
        for($i = 0; $i <= 2; $i++){
            if(isset($validate['from_days'][$i]) && 
            isset($validate['to_days'][$i]) && 
            (isset($validate['code'][$i]) || 
            isset($validate['discount'][$i]))) {
                $discount_range = DiscountRange::find($discount->discount_ranges[$i]->id);
                $discount_range->from_days = $validate['from_days'][$i];
                $discount_range->to_days = $validate['to_days'][$i];
                $discount_range->code = isset($validate['code'][$i]) ? $validate['code'][$i] : null;;
                $discount_range->discount = isset($validate['discount'][$i]) ? $validate['discount'][$i] : null;
                $discount_range->save();
            }
        }

        return redirect()->route('discounts.index');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Discount $discount)
    {
        $discount->delete();
        return redirect()->route('discounts.index');
    }


    public function export(Request $request){
        $name = $request->get('discount_name');
        $code = $request->get('discount_code');
        $brand_id = $request->get('brand');
        $region_id = $request->get('region');

        return Excel::download(new DiscountExport([
            "name" => $name,
            "code" => $code,
            "brand_id" => $brand_id,
            "region_id" => $region_id,
        ]), 'discounts.xlsx');
    }
}
