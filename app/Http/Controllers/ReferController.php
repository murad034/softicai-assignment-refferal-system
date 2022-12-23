<?php

namespace App\Http\Controllers;



use App\Order;
use App\Refer;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\Facades\DataTables;


class ReferController extends Controller
{

    public $user;
    public $extra_title;
    public function __construct()
    {
        $this->extra_title = "- Referral System";
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            return $next($request);
        });
    }

    public function displayRefer(Request $request){
        if (is_null($this->user) ||  !$this->user->can('refer')) {
            $message = 'You are not allowed to access this page !';
            return view('errors.403', compact('message'));
        }
        $extra_title = $this->extra_title;
        $particularPro = Auth::user();
        $refferal_link = url('/')."/register?refer=".$particularPro->refer_code;
        $total_refferal = Refer::where('referrer', $particularPro->id)->count();
        $total_points = Refer::where('referrer', $particularPro->id)->sum('reward_points');
        return view('refers.profile', compact('extra_title','particularPro','refferal_link', 'total_refferal', 'total_points'));
    }

    public function displayReferList(Request $request){
        if (is_null($this->user) ||  !$this->user->can('referList')) {
            $message = 'You are not allowed to access this page !';
            return view('errors.403', compact('message'));
        }
        $data["extra_title"] = $this->extra_title;
        if (request()->ajax()) {

            $user_logs = User::query()->with('referrerFunc','totalRefer');

            $datatable = DataTables::of($user_logs)
                ->editColumn('id', function ($row) {
                    return $row->id;
                })
                ->editColumn('name', function ($row) {
                    return $row->name;
                })
                ->editColumn('email', function ($row) {
                    return $row->email;
                })
                ->editColumn('total_refer', function ($row) {
                    if($row->totalRefer->count()>0) {
                        $html = $row->totalRefer->count();
                    }else{
                        $html = 0;
                    }
                    return $html;
                })
                ->editColumn('total_point', function ($row) {
                    if($row->totalRefer->count()>0) {
                        $html = $row->totalRefer->sum('reward_points');
                    }else{
                        $html = 0;
                    }
                    return $html;
                })
                ->editColumn('referrer', function ($row) {
                    if(!empty($row->referrerFunc->userFunc->name)) {
                        $html = $row->referrerFunc->userFunc->name;
                    }else{
                        $html = "Not Specified";
                    }
                    return $html;
                })
                ->editColumn('created_at', function ($row) {
                    $html = "";
                    if(!empty($row->created_at)){
                        $html = date_format(date_create($row->created_at),'Y-m-d');
                    }
                    return $html;
                })
            ;

            $rawColumns = [
                'id',
                'name',
                'email',
                'total_refer',
                'total_point',
                'referrer',
                'created_at',
            ];
            return $datatable->rawColumns($rawColumns)->make(true);
        }
        return view('refers.referLogList', $data);
    }

    
}
