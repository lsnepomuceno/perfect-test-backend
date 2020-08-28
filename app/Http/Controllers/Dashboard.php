<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Customers, Products, Sales};
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\View;

class Dashboard extends Controller
{
    public function __invoke(Request $request): View
    {
        $sales = $this->getSales($request);
        return view('dashboard', [
            'customers'     => Customers::all(),
            'products'      => Products::all(),
            'customerUuid'  => $request->customer ?? null,
            'interval'      => $request->interval ?? null,
            'sales'         => $sales,
            'total'         => number_format($sales->sum('total_value'), 2, ',', '.')
        ]);
    }

    private function getSales(Request $request): Collection
    {
        $sales = (new Sales());

        if ($request->filled('customer')) {
            $sales = $sales::where(
                'customer_id',
                (new Customers)->findIdByUuid($request->customer)
            );
        }

        if ($request->filled('interval')) {
            list($startDate, $endDate) = explode('-', str_replace(' ', '', $request->interval));
            $sales = $sales->whereDate('sold_at', '>=',  Carbon::createFromFormat('d/m/Y', $startDate))
                ->whereDate('sold_at', '<=',  Carbon::createFromFormat('d/m/Y', $endDate));
        }

        return $request->all() ? $sales->get() : $sales->all();
    }
}
