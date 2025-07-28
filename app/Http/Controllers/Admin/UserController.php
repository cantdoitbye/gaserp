<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminPermission;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Rider;
use App\Models\RiderRating;
use App\Models\Feedback;
use App\Models\UserRating;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $r)
    {
     
        
        //
        if ($r->ajax()) {
            if($r->input('id')){
                $id = $r->id;
                $type = $r->type;
                if ($type == 3) {
                    User::where('id', $id)->forceDelete();
                    return ajaxResponse(1, 'Userdeleted successfully');
                } elseif ($type == 2) {
                    User::withTrashed()->find($id)->restore();
                    return ajaxResponse(1, 'User restored successfully');
                } else {
                    User::where('id', $id)->delete();
                    return ajaxResponse(1, 'User deleted successfully');
                }
            }
            return User::getTableDataEmp($r);
        }

        $dateParams = filterDateParameters($r);
        $params = $dateParams['params'];
        $start = $dateParams['start'];
        $end = $dateParams['end'];
        $params['deleted'] = request()->deleted;


        return view('admin.user.index', $params);
    }


    public function detail($id){
        try {
            $params['userData'] = $data = User::with('parcels')->findOrFail($id);
            $params['parcelCount'] = $data->parcels ? $data->parcels->count() : 0;


            $params['highestOrder'] = $data->parcels ? $data->parcels->max('amount') : '--';




            $params['registration_date'] = Carbon::parse($data->created_at)->isoFormat('MMM D YYYY, h:mmA');

            $params['rating'] = calUserRating($data->id);

            $params['reviews'] = RiderRating::where('user_id', $id)->get();
           
            // $params['feedbacks'] = Feedback::where($data->id);
            $params['feedbacks'] = Feedback::where('sender_id', $data->id)
                                ->where('sender_type', 'App\Models\User') 
                                ->get();


            

         


            $params['id'] = $id;
            // dd($params);
            // $params['btnColor'] = $data->acceptedParcels ? getStatusBtnColor($data->acceptedParcels->status) : 'rgba(255, 152, 31, 1)';

            return view('admin.user.detail', $params);



        } catch (ModelNotFoundException $e) {
            abort(404);
        }
       
     
    }

}
