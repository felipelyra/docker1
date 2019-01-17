<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use App\Http\Resources\Api\V1\ProductResource;
use DB;
use App\Http\Resources\ProductCollection;
use Log;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        #xxxx
        echo "some data1";
    }

    public function search(Request $request, Product $product) {
        //start logging
        DB::enableQueryLog();
        $products = Product::query();

        if ($request->has('q') && trim($request->input('q') != "")) {
            #xxx echo "\$q: [{$request->input('q')}]<br>";
            /**
             * Decides query type to use for field "title" based on API Version.
             * V1 - SQL 'like'
             * V2 - Full text search
             */
            if(config('app.api_version', config('app.api_latest')) == 2) {
                $products->SearchFullText($request->input('q'));
            } else {
                $products->where('title', 'like', '%' . $request->input('q') . '%');
            }
        }

        // Search for a product based on their brand.
        if ($request->has('filter')) {
            $filterInput = $request->input('filter');
            $filterParams = $this->prepareFilterParams($request, $product);
            foreach($filterParams as $filterParam => $filterValue) {

                if (in_array($filterParam, $product->getFilterable()) && trim($filterValue) != "") {
                    #xxx echo "aplicando filtro";

                    switch($filterParam) {
                        case 'price':
                            $products->where('price', $filterValue);
                            break;
                        case 'pricemin':
                            if(is_numeric($filterValue)) {
                                $products->where('price', '>=', $filterValue);
                            }
                            break;
                        case 'pricemax':
                            if(is_numeric($filterValue)) {
                                $products->where('price', '<=', $filterValue);
                            }
                            break;
                        case 'brand':
                            $products->whereHas('brand', function ($query) use ($filterValue) {
                                $query->where('brands.brand', $filterValue);
                            });
                            break;
                        default:
                            $products->where($filterParam, $filterValue);
                    }
                }
            }
        }

        if ($request->has('sort')) {
            $sortParams = $this->prepareSortParams($request, $product);
            foreach($sortParams as $sortParam => $sortValue) {
                $products->orderBy($sortParam, $sortValue);
            }
        }

        #xxx echo "<br>";
        $products->select('products.id as id', 'title', 'brand', 'price', 'stock');
        $products->join('brands', 'brands.id', '=', 'products.brand_id');
        $ap = $products->paginate();
        $ap->appends(request()->query())->links();
        
        //end logging
        $laQuery = DB::getQueryLog();
        #xxx echo "<br><br><br><br><br>";
        #xxx print_r($laQuery); # <-------
        Log::info("laQuery [". print_r($laQuery, true) ."]");
        #xxx echo "<br><br><br><br><br>";
        DB::disableQueryLog();

        return ProductResource::collection($ap);
    }

    private function prepareFilterParams(Request $request, Product $product) {
        $filterInput = $request->input('filter');
        $filterInputsArray = explode(',', $filterInput);

        $filterReturnArray = array();
        foreach($filterInputsArray as $param) {
            if(strstr($param, ':')) {
                list($filterParam, $filterValue) = explode(':', $param, 2);
                if(in_array($filterParam, $product->getFilterable())) {
                    $filterReturnArray[$filterParam] = $filterValue;
                }
            }
        }
        return $filterReturnArray;
    }

    private function prepareSortParams(Request $request, Product $product) {
        $sortInput = strtolower($request->input('sort'));
        $sortInputsArray = explode(',', $sortInput);

        $sortReturnArray = array();
        foreach($sortInputsArray as $param) {
            if(strstr($param, ':')) {
                list($sortParam, $sortValue) = explode(':', $param, 2);
                if(in_array($sortParam, $product->getSortable())) {
                    $sortReturnArray[$sortParam] = $sortValue;
                }
            } else {
                if(in_array($param, $product->getSortable())) {
                    $sortReturnArray[$param] = 'asc';
                }
            }
        }
        return $sortReturnArray;
    }

    // /**
    //  * Show the form for creating a new resource.
    //  *
    //  * @return \Illuminate\Http\Response
    //  */
    // public function create()
    // {
    //     //
    // }

    // /**
    //  * Store a newly created resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @return \Illuminate\Http\Response
    //  */
    // public function store(Request $request)
    // {
    //     //
    // }

    // /**
    //  * Display the specified resource.
    //  *
    //  * @param  \App\Product  $product
    //  * @return \Illuminate\Http\Response
    //  */
    // public function show(Product $product)
    // {
    //     //
    // }

    // /**
    //  * Show the form for editing the specified resource.
    //  *
    //  * @param  \App\Product  $product
    //  * @return \Illuminate\Http\Response
    //  */
    // public function edit(Product $product)
    // {
    //     //
    // }

    // /**
    //  * Update the specified resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @param  \App\Product  $product
    //  * @return \Illuminate\Http\Response
    //  */
    // public function update(Request $request, Product $product)
    // {
    //     //
    // }

    // /**
    //  * Remove the specified resource from storage.
    //  *
    //  * @param  \App\Product  $product
    //  * @return \Illuminate\Http\Response
    //  */
    // public function destroy(Product $product)
    // {
    //     //
    // }
}
