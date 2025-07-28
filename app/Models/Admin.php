<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable;
use Yajra\DataTables\Facades\DataTables;



use Illuminate\Auth\Authenticatable as AuthenticatableTrait;


class Admin extends Model implements Authenticatable
{
    use HasFactory, AuthenticatableTrait;

    protected $guarded = [
       
         
    ];

    public function permissions(){
       // return $this->hasMany(AdminPermission::class);
    }


    public static function getTableData($r) {

        $query = $data = self::query();
        $query= $query->where('role', 2);
        $data->orderBy('created_at', 'desc');
        
        $table = Datatables::of($query)
               
        ->editColumn('type', function ($r) {
            return $r->status == 0 ? '<span style="color: red;">Inactive</span>' : '<span style="color: #359FFF;">Active</span>';
        })
        ->addColumn('action', function ($q) {
            $params['is_view'] = 1;
            $params['model'] = $q;
            
        
          
            // $params['name'] = $q->name ?? '-';
            $params['view_route'] = route('admin.userDashboard.index', ['id' => $q->id]); 
            $params['name'] = $q->name ?? '-';
            return view('admin.datatable.action', $params)->render();
        })
                ->rawColumns(['status', 'action'])
                ->make(true);
        return $table->original;
    }
}
