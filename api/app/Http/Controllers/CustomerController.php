<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /** 
     * Get all customers
     * 
     * @param Request $request
     *      - per_page (optional) how many items per page
     *      - page (optional) required page number
     *      - search (optional) search string
     * 
     * @return JsonResponse
     *      - data (array) array of customers
     *      - current_page (int) current page number
     *      - total_pages (int) total number of pages
     *      - from (int) first item number
     *      - to (int) last item number
     * 
     * */
    public function index(Request $request): JsonResponse
    {
        // validate user inputs here
        $inputs = $request->validate([
            'per_page'=>'sometimes|integer|between:1,1000',
            'search'=>'sometimes|string',
        ]);

        // get customers

        // if search is provided
        $query = Customer::query();

        if(isset($inputs['search'])){
            // do search
            $query
            ->where('first_name','like','%'.$inputs['search'].'%')
            ->orWhere('last_name','like','%'.$inputs['search'].'%')
            ->orWhere('email','like','%'.$inputs['search'].'%');
        }

        // get paginated customers
        $customers_paginated = $query->paginate($inputs['per_page'] ?? 10);

        return response()->json([
            'data' => $customers_paginated->items(),
            'current_page' => $customers_paginated->currentPage(),
            'total_pages' => $customers_paginated->lastPage(),
            'from' => $customers_paginated->firstItem(),
            'to' => $customers_paginated->lastItem(),
        ]);
    }
    
    /** 
     * Get specific customer informations
     * 
     * @param int $id customer id
     * @return JsonResponse Customer object including IP address and company details
     * */
    public function customer(int $id): JsonResponse
    {
        $customer = Customer::find($id);

        if ($customer){   
            // read IP address and company details
            $customer->ip_addresses;
            $customer->companies;
            return response()->json($customer);
        }
    
        return response()->json([
            'message' => 'Customer not found',
        ], 404);
    }
}
