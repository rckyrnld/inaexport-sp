<?php

namespace App\Http\Controllers\ResearchCorner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;
use Auth;

class ResearchCornerController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:eksmp');
    }

    public function index()
    {
        if (Auth::guard('eksmp')->user()->id_role == 2) {
            $pageTitle = 'Research Corner';
            return view('research-corner.eksportir.index', compact('pageTitle'));
        } else {
            return redirect('/home');
        }
    }

    public function getData()
    {
        if (Auth::guard('eksmp')->user()->id_role == 2) {
            $array_kategori = array();
            $array_research = array();
            $id_profil = Auth::guard('eksmp')->user()->id_profil;

            $kategori = DB::table('csc_product_single')->where('id_itdp_profil_eks', $id_profil)
                ->select('id_csc_product as kategori', 'id_csc_product_level1 as sub_kategori', 'id_csc_product_level2 as sub_sub_kategori')
                ->distinct('kategori', 'sub_kategori', 'sub_sub_kategori')->get();

            foreach ($kategori as $key) {
                if (!in_array($key->kategori, $array_kategori)) {
                    array_push($array_kategori, $key->kategori);
                }
                if ($key->sub_kategori != null) {
                    if (!in_array($key->sub_kategori, $array_kategori)) {
                        array_push($array_kategori, $key->sub_kategori);
                    }
                }
                if ($key->sub_sub_kategori != null) {
                    if (!in_array($key->sub_sub_kategori, $array_kategori)) {
                        array_push($array_kategori, $key->sub_sub_kategori);
                    }
                }
            }

            $tambahan = DB::table('csc_download_research_corner')->where('id_itdp_profil_eks', $id_profil)->get();
            foreach ($tambahan as $key) {
                if (!in_array($key->id_research_corner, $array_research)) {
                    array_push($array_research, $key->id_research_corner);
                }
            }

            $research = DB::table('csc_broadcast_research_corner as a')->join('csc_research_corner as b', 'a.id_research_corner', '=', 'b.id')
                ->whereIn('a.id_categori_product', $array_kategori)
                ->orWhereIn('a.id_research_corner', $array_research)
//                ->orderby('b.publish_date', 'desc')
                ->orderby('a.created_at', 'desc')
                ->distinct('a.id_research_corner')
                ->select('b.*','a.created_at','a.id_research_corner')
                ->get();

            return \Yajra\DataTables\DataTables::of($research)
                ->addIndexColumn()
				->addColumn('title_en', function ($value) {
            
					  return '<div align="left">'.$value->title_en.'</div>';
					
				  })
                ->addColumn('country', function ($value) {
                    $data = DB::table('mst_country')->where('id', $value->id_mst_country)->first();
                    return $data->country;
                })
                ->addColumn('type', function ($value) {
                    $data = DB::table('csc_research_type')->where('id', $value->id_csc_research_type)->first();
                    return $data->nama_en;
                })
                ->addColumn('date', function ($data) {
                    return getTanggalIndo(date('Y-m-d', strtotime($data->publish_date))) . ' ( ' . date('H:i', strtotime($data->publish_date)) . ' )';
                })
                ->addColumn('action', function ($data) {
                    $id_profil = Auth::guard('eksmp')->user()->id_profil;
                    $download = DB::table('csc_download_research_corner')
                        ->where('id_research_corner', $data->id)
                        ->where('id_itdp_profil_eks', $id_profil)
                        ->first();
                    if ($download) {
                        return '<center>
                      <a href="' . route("research-corner.view", $data->id) . '" style="" class="btn btn-sm btn-info" title="View"><i class="fa fa-eye"></i></a>
                      </center>';
                    } else {
                        return '<center>
                      <a href="' . url('/') . '/uploads/Research Corner/File/' . $data->exum . '" style="" onclick="cek_download(' . $data->id . ', event, this)" class="btn btn-sm btn-warning text-white" title="Download"><i class="fa fa-download"></i></a>&nbsp;&nbsp;
                      <a href="' . route("research-corner.view", $data->id) . '" style="" class="btn btn-sm btn-info" title="View"><i class="fa fa-eye"></i></a>
                      </center>';
                    }
                })
                ->rawColumns(['action','title_en'])
                ->make(true);
        } else {
            return redirect('/home');
        }

    }

    public function download(Request $req)
    {
        date_default_timezone_set('Asia/Jakarta');
        if (Auth::guard('eksmp')->user()->id_role == 2) {
            $id_profil = Auth::guard('eksmp')->user()->id_profil;
            $id_user = Auth::guard('eksmp')->user()->id;
            $date = date('Y-m-d H:i:s');
            $checking = DB::table('csc_download_research_corner')->where('id_itdp_profil_eks', $id_profil)->where('id_research_corner', $req->id)->first();
            if ($checking) {
                $hasil = 'positif';
            } else {
                $id = DB::table('csc_download_research_corner')->orderby('id', 'desc')->first();
                if ($id) {
                    $id = $id->id + 1;
                } else {
                    $id = 1;
                }
                DB::table('csc_download_research_corner')->insert([
                    'id' => $id,
                    'id_itdp_profil_eks' => $id_profil,
                    'id_research_corner' => $req->id,
                    'waktu' => $date
                ]);

                $notif = DB::table('notif')->where('url_terkait', 'research-corner/read')->where('id_terkait', $req->id)->where('untuk_id', $id_user)->first();
                if ($notif) {
                    DB::table('notif')->where('url_terkait', 'research-corner/read')->where('id_terkait', $req->id)->where('untuk_id', $id_user)->update([
                        'status_baca' => 1
                    ]);
                }

                $before = DB::table('csc_research_corner')->where('id', $req->id)->first();
                DB::table('csc_research_corner')->where('id', $req->id)->update([
                    'download' => $before->download + 1
                ]);

                $hasil = 'nihil';
            }
            echo json_encode($hasil);
        } else {
            return redirect('/home');
        }
    }

    public function read($id)
    {
        if (Auth::guard('eksmp')->user()->id_role == 2) {
            $id_user = Auth::guard('eksmp')->user()->id;
            $notif = DB::table('notif')->where('url_terkait', 'research-corner/read')
                ->where('id_terkait', $id)
                ->where('untuk_id', $id_user)
                ->first();

            if ($notif) {
                DB::table('notif')->where('url_terkait', 'research-corner/read')->where('id_terkait', $id)->where('untuk_id', $id_user)->update([
                    'status_baca' => 1
                ]);
            }

            $pageTitle = "Research Corner";
            $data = DB::table('csc_research_corner')->where('id', $id)->first();
            return view('research-corner.eksportir.view', compact('data', 'pageTitle'));
        } else {
            return redirect('/home');
        }
    }
}
