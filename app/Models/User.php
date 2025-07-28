<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Yajra\DataTables\DataTables;
use Laravel\Sanctum\HasApiTokens;




class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'mobile',
        'mobile_verified_at',
        'country_id',
        'latitude', 
        'longitude',
        'fcm_token',
        'device_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    
    public static function getTableDataEmp($r) {

        $query = $data = self::query()->withTrashed();
        $data->orderBy('created_at', 'desc');
        if ($r->filled('filterStartDate') && $r->filled('filterEndDate')) {
            $startDate = $r->filterStartDate;
            $endDate = $r->filterEndDate;
    
            // Filter data based on the provided date range
            $query->whereBetween('created_at', [$startDate, $endDate]);
        }
        if (isset($r->deleted) && $r->deleted == 1) {
            $query->onlyTrashed();
        }
        $table = Datatables::of($query)
                ->editColumn('created_at', function ($r) {
                    if ($r->created_at) {
                      return  $date = convertUtcToTimezone($r->created_at);

                        return $date['date']; 
                    }
                    return '--';
                })
            
                ->editColumn('id', function ($r) {

                    return '<span style="color: #359FFF;">'.$r->id.'</span>';

                })->editColumn('name', function ($r) {
                    return $r->name;
                })->addColumn('status', function ($r) {
                    $text = $r->deleted_at ? 'Deleted' : 'Active';

                    return '<span style="color: #359FFF;">'.$text.'</span>';

                })
                
                ->addColumn('action', function ($q) {
                    $params['is_view'] = 0;
                  
                    // $params['name'] = $q->name ?? '-';
                    $params['view_route'] = route('admin.user.detail', ['id' => $q->id]); 
        
                    // $params['is_delete'] = 1;
                    $params['model'] = $q;
                    // $params['delete_route'] = route('admin.users');
                    $params['name'] = $q->name ?? '-';
                    return view('admin.datatable.action', $params)->render();
                })
                ->rawColumns(['id','status','action'])
                ->make(true);
        $table->original['deletedRecord'] = $data->onlyTrashed()->count();
        return $table->original;
    }





        /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier() {
        return $this->getKey();
    }
    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims() {
        return [];
    }    

   
}
