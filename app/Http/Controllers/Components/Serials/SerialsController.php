<?php

namespace App\Http\Controllers\Components\Serials;

use App\Http\Controllers\Controller;
use App\Models\Serial;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SerialsController extends Controller
{
    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function edit($id)
    {
        try {
            $serial = Serial::findOrFail($id);
            $suppliers = \App\Models\Supplier::orderBy('name', 'asc')->get();

            return view('components.serials.edit', compact('serial', 'suppliers'));
        } catch (\Exception $e) {
            return redirect()->route('components.index')->withErrors($e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        try {
            $input = $request->all();

            // If the "reset fields" checkbox is checked, reset the fields to null
            if (isset($input['reset_fields']) && $input['reset_fields'] == 1) {
                foreach($input as $key => $value) {
                    if ($key != 'reset_fields') {
                        $input[$key] = null;
                    }
                }
            }

            $validator = Validator::make($input, [
                'supplier_id' => 'nullable|numeric|exists:suppliers,id',
                'purchase_date' => 'nullable|date',
                'purchase_cost' => 'nullable|numeric',
                'purchase_order' => 'nullable|string',
                'warranty_months' => 'nullable|numeric',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $serial = Serial::findOrFail($id);
            $serial->supplier_id = !empty($input['supplier_id']) ? $input['supplier_id'] : null;
            $serial->purchase_date = !empty($input['purchase_date']) ? Carbon::parse($input['purchase_date']) : null;
            $serial->purchase_cost = !empty($input['purchase_cost']) ? $input['purchase_cost'] : null;
            $serial->purchase_order = !empty($input['purchase_order']) ? $input['purchase_order'] : null;
            $serial->warranty_date = !empty($input['warranty_months']) ? Carbon::now()->addMonths($input['warranty_months']) : null;
            $serial->notes = !empty($input['notes']) ? $input['notes'] : null;
            $serial->saveOrFail();

            return redirect()->route('components.index', $serial->component_id)->with('success', 'Serial ' . $serial->serial_number . ' updated successfully');
        } catch (\Exception $e) {
            return redirect()->route('components.index')->withErrors($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        try {
            $serial = Serial::findOrFail($id);
            $serial_num = $serial->serial_number;

            if ($serial->status == 0 || $serial->status == 2) {
                $serial->delete();
                return redirect()->route('components.index')->with('success', 'Serial ' . $serial_num . ' deleted successfully');
            }

            return redirect()->route('components.index', $serial->component_id)->withErrors('Serial ' . $serial_num . ' cannot be deleted because it is in use');
        } catch (\Exception $e) {
            return redirect()->route('components.index')->withErrors($e->getMessage());
        }
    }
}
