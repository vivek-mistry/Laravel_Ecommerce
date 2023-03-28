<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class DataTablePaginate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {

        $draw = $request->draw;
		$start = $request->start;
		$rowperpage = $request->length;
		$columnIndex = $request->order[0]['column'];
		$columnName = $request->columns[$columnIndex]['data'];
		$columnSortOrder = $request->order[0]['dir'];
		$searchValue = $request->search['value'];

        /**
         * Set Request
         */
        $request->draw = $draw;
        $request->start = $start;
        $request->rowperpage = $rowperpage;
        $request->columnName = $columnName;
        $request->columnSortOrder = $columnSortOrder;
        $request->searchValue = $searchValue;
        return $next($request);
    }
}
