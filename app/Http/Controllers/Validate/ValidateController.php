<?php

namespace App\Http\Controllers\Validate;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ValidateController extends BaseController
{
    public function getOrder(Request $request)
    {
        $phone = trim(chunk_split($request->input('phone'), 5, ' '));;

        $data = DB::table("bas_sp_orders")
            ->join("bas_fulfillment", "bas_sp_orders.orderId", "=", "bas_fulfillment.orderId")
            ->where('deliveryAddress', 'like', '%' . $phone . '%')
            ->whereIn('sku', explode(',', env('SKUS')))
            ->orderBy('deliveredDate', 'desc')
            ->select("bas_sp_orders.sku", "bas_sp_orders.title", "bas_fulfillment.deliveredDate")
            ->get();

        if (count($data)) {
            $return = $data[0];
            $deliveredDate = Carbon::parse($data[0]->deliveredDate);
            $currentDate = Carbon::now();
            $daysDifference = $currentDate->diffInDays($deliveredDate);
            $return->days = $daysDifference;
            $return->deliveredDate = date("d M, Y", strtotime($return->deliveredDate));
            return json_encode(["type" => "success", "data" => $return]);
        } else {
            return json_encode(["type" => "error", "data" => "Order not found"]);
        }
    }

    public function saveReview()
    {
        $data = request()->all();
        $insert = array(
            "firstname" => $data["firstname"],
            "lastname" => $data["lastname"],
            "sku" => $data["sku"],
            "design" => $data["design"],
            "valueForMoney" => $data["valueForMoney"],
            "strap" => $data["strap"],
            "buckle" => $data["buckle"],
            "durability" => $data["durability"],
            "functionality" => $data["functionality"],
            "support" => $data["support"],
            "comfort" => $data["comfort"],
            "review" => $data["review"]
        );
        DB::table("bas_prototype_review")->insert($insert);
        return json_encode(["type" => "success"]);
    }
}
