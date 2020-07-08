<?php

namespace App\Http\Controllers\Eksportir;

use Illuminate\Http\Request;
use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class AnnualController extends Controller
{
    public function index()
    {
//        $id_user = Auth::guard('eksmp')->user()->id_profil;
//        dd($id_user);die();
        $pageTitle = "Annual Sales";
        return view('eksportir.annual_sales.index', compact('pageTitle'));
    }

    public function tambah()
    {
        $ldate = date('Y');
        $years = [];
        for ($year = $ldate - "10"; $year <= $ldate + "10"; $year++) $years[$year] = $year;
        $url = '/eksportir/annual_save';
        $pageTitle = 'Add Annual Sales';
        return view('eksportir.annual_sales.tambah', compact('pageTitle', 'url', 'years'));
    }

    public function store(Request $request)
    {
        $id_user = Auth::guard('eksmp')->user()->id_profil;
        DB::table('itdp_eks_sales')->insert([
            'id_itdp_profil_eks' => $id_user,
            'tahun' => $request->year,
            'nilai' => $request->value,
            'nilai_persen' => $request->persen,
            'nilai_ekspor' => $request->nilai_ekspor,
            'idcompanytahun' => $id_user . $request->year,
        ]);
        return redirect('eksportir/annual_sales')->with('success','Success Add Data');
    }

    public function datanya()
    {
        $user = DB::table('itdp_eks_sales')
            ->where('id_itdp_profil_eks', '=', Auth::guard('eksmp')->user()->id_profil)
            ->get();

        return \Yajra\DataTables\DataTables::of($user)
            ->addColumn('tahun', function ($mjl) {
                return '<div align="center">'.$mjl->tahun. '</div>';
            })
			->addColumn('action', function ($mjl) {
                return '
                <center>
                <a href="' . route('sales.view', $mjl->id) . '" class="btn btn-sm btn-info" title="View">
                    <i class="fa fa-eye text-white"></i> 
                </a>
                <a href="' . route('sales.detail', $mjl->id) . '" class="btn btn-sm btn-success"title="Edit">
                    <i class="fa fa-edit text-white"></i> 
                </a>
                <a href="' . route('sales.delete', $mjl->id) . '" class="btn btn-sm btn-danger" onclick="return confirm(\'Are You Sure ?\')" title="Delete">
                    <i class="fa fa-trash text-white"></i>
                </a>
                </center>
                ';
            })
            ->addIndexColumn()
            ->rawColumns(['action','tahun'])
            ->make(true);
    }


    public function edit($id)
    {
        $ldate = date('Y');
        $years = [];
        for ($year = $ldate - "10"; $year <= $ldate + "10"; $year++) $years[$year] = $year;
        $pageTitle = 'Detail Sales';
        $url = '/eksportir/sales_update';
        $data = DB::table('itdp_eks_sales')
            ->where('id', '=', $id)
            ->get();
        return view('eksportir.annual_sales.edit', compact('pageTitle', 'data', 'url', 'years'));
    }

    public function view($id)
    {
        $pageTitle = 'Detail Sales';
        $data = DB::table('itdp_eks_sales')
            ->where('id', '=', $id)
            ->get();
        return view('eksportir.annual_sales.view', compact('pageTitle', 'data'));
    }

    public function delete($id)
    {
        DB::table('itdp_eks_sales')->where('id', $id)
            ->delete();
        return redirect('eksportir/annual_sales')->with('error','Success Delete Data');
    }

    public function update(Request $request)
    {
        DB::table('itdp_eks_sales')->where('id', $request->id_sales)
            ->update([
                'tahun' => $request->year,
                'nilai' => $request->value,
                'nilai_persen' => $request->persen,
                'nilai_ekspor' => $request->nilai_ekspor,
            ]);
        return redirect('eksportir/annual_sales')->with('success','Succes Update Data');
    }

    public function indexadminannualsales($id)
    {
//        dd($id);
        $pageTitle = "List Exporter";
        return view('eksportir.annual_sales.indexadminannualsales', compact('pageTitle', 'id'));
    }

    public function indexadmin()
    {
        $pageTitle = "List Exporter";
        return view('eksportir.annual_sales.indexadmin', compact('pageTitle'));
    }

    public function datanyaadmin($id)
    {
//        dd('hahahaha');
        $user = DB::table('itdp_eks_sales')
            ->where('id_itdp_profil_eks', '=', $id)
            ->get();

        return \Yajra\DataTables\DataTables::of($user)
            ->addColumn('action', function ($mjl) {
                return '
                <center>
                <a href="' . route('sales.view', $mjl->id) . '" class="btn btn-sm btn-info" title="View">
                    <i class="fa fa-eye text-white"></i>
                </a>
                </center>
                ';
            })
            ->addIndexColumn()
            ->rawColumns(['action'])
            ->make(true);
    }

    public function getreporteksportir()
    {
        $pesan = DB::table('itdp_profil_eks')->select('itdp_profil_eks.id','itdp_profil_eks.company', 'itdp_profil_eks.addres', 'mst_province.province_en',
        'itdp_profil_eks.fax', 'itdp_company_users.status', 'itdp_company_users.verified_at','itdp_company_users.email')
        ->join('itdp_company_users','itdp_company_users.id_profil','itdp_profil_eks.id')
        ->join('mst_province','mst_province.id','itdp_profil_eks.id_mst_province')->where('itdp_company_users.status' , '1');
        // ->orderby('itdp_profil_eks.id','desc');
        // $pesan = DB::select("SELECT itdp_profil_eks.ID,itdp_profil_eks.company, itdp_profil_eks.addres, mst_province.province_en,
        //  itdp_profil_eks.fax, itdp_company_users.status, itdp_company_users.verified_at,itdp_company_users.email
        // FROM itdp_profil_eks JOIN itdp_company_users ON itdp_company_users.id_profil = itdp_profil_eks.id  
        // JOIN mst_province ON mst_province.id = itdp_profil_eks.id_mst_province 
        // WHERE itdp_company_users.status = '1' ORDER BY itdp_profil_eks.ID DESC ");
        // $pesan = DB::select("SELECT ID, company,addres,postcode,phone,fax FROM itdp_profil_eks ORDER BY ID DESC ");
    //    dd($pesan);
    
        return DataTables::of($pesan)
            ->addColumn('f1', function ($pesan) {
                return '<div align="left">'.$pesan->company.'</div>';
            })
            ->addColumn('f2', function ($pesan) {
                return '<div align="left">'. $pesan->addres.'</div>';

            })
            ->addColumn('province', function ($pesan) {
                return '<div align="left">'. $pesan->province_en.'</div>';
            })
            ->addColumn('email', function ($pesan) {
                return '<div align="left">'.$pesan->email.'</div>';
            })
            ->addColumn('pic_name', function ($pesan) {
                $namapicnya = '';
                $no = 0;
                $datapic = DB::table('itdp_contact_eks')->where('id_itdp_profil_eks' , $pesan->id)->get();
                if(count($datapic) > 0  ){
                    foreach($datapic as $namapic){
                        if($no == 0){
                            $namapicnya .=  $namapic->name;
                            }else{
                            $namapicnya .= ',' . $namapic->name;
                        }
                        $no++;
                    }
                }
                return'<div align="left">'. $namapicnya .'</div>';
            })
            ->addColumn('pic_telp', function ($pesan) {
                $telppicnya = '';
                $no2 = 0;

                $datapic2 = DB::table('itdp_contact_eks')->where('id_itdp_profil_eks' , $pesan->id)->get();
                if(count($datapic2) > 0  ){
                    foreach($datapic2 as $telppic){
                        if($no2 == 0){
                            $telppicnya .=  $telppic->phone;
                        }else{
                            $telppicnya .= ',' . $telppic->phone;
                        }
                        $no2++;
                    }
                }
                return'<div align="left">'. $telppicnya .'</div>';
            })
            
            // ->addColumn('f3', function ($pesan) {
            //     return $pesan->postcode;
            // })
            // ->addColumn('f4', function ($pesan) {
            //     return $pesan->phone;
            // }) 
            // ->addColumn('f5', function ($pesan) {
            //     return $pesan->fax;
            // })
            ->addColumn('verify_date', function ($pesan) {
                return date('d-m-Y',strtotime($pesan->verified_at));
            })
            ->addIndexColumn()
            ->addColumn('action', function ($pesan) {
                return '<a href="' . url('eksportir/listeksportir/' . $pesan->id) . '" class="btn btn-sm btn-info" title="Detail"><i class="fa fa-list text-white"></i></a>';
            })
            ->rawColumns(['action','f1','f2','province','email', 'pic_name','pic_telp'])
            ->make(true);
    }

    public function printexportirreport(){
        $datapic = DB::table('itdp_profil_eks')->select('itdp_profil_eks.id','itdp_profil_eks.company', 'itdp_profil_eks.addres', 'mst_province.province_en',
        'itdp_profil_eks.fax', 'itdp_company_users.status', 'itdp_company_users.verified_at','itdp_company_users.email')
        ->join('itdp_company_users','itdp_company_users.id_profil','itdp_profil_eks.id')
        ->join('mst_province','mst_province.id','itdp_profil_eks.id_mst_province')->where('itdp_company_users.status' , '1')
        ->orderby('itdp_profil_eks.id','desc')->get();

        $start = 0;

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                    'color' => ['argb' => '000000'],
                ],
            ],
        ];
        $sheet->getStyle('A1:I4')->getAlignment()->setHorizontal('center');

        $sheet->getColumnDimension('A')->setWidth(8);
        $sheet->getColumnDimension('B')->setWidth(40);
        $sheet->getColumnDimension('C')->setWidth(40);
        $sheet->getColumnDimension('D')->setWidth(30);
        $sheet->getColumnDimension('E')->setWidth(30);
        $sheet->getColumnDimension('F')->setWidth(30);
        $sheet->getColumnDimension('G')->setWidth(30);
        $sheet->getColumnDimension('H')->setWidth(30);
        $sheet->getColumnDimension('I')->setWidth(30);

        $sheet->setCellValue('A1', 'Data Exporter Report');


        $sheet->setCellValue('A3', 'NO');
        $sheet->setCellValue('B3', 'COMPANY');
        $sheet->setCellValue('C3', 'ADDRESS');
        $sheet->setCellValue('D3', 'PROVINCE');
        $sheet->setCellValue('E3', 'EMAIL');
        $sheet->setCellValue('F3', 'PIC NAME');
        $sheet->setCellValue('G3', 'PIC TELEPHONE');
        $sheet->setCellValue('H3', 'VERIFY DATE');

        $spreadsheet->getActiveSheet()->mergeCells('A1:H1');
        
        $rows = 4;
        $no = $start +1;
        foreach($datapic as $detail){
            $hitung= 0;
            $namapicnya = '';
            $telppicnya = '';
            $datapic = DB::table('itdp_contact_eks')->where('id_itdp_profil_eks' , $detail->id)->get();
            if(count($datapic) > 0  ){
                foreach($datapic as $pic){
                    if($hitung == 0){
                        $namapicnya .=  $pic->name;
                        $telppicnya .= $pic->phone;
                    }else{
                        $namapicnya .= ',' . $pic->name;
                        $telppicnya .= ',' . $pic->phone;
                    }
                    $hitung++;
                }
            }

            $sheet->setCellValue('A' . $rows, $no);
            $sheet->setCellValue('B' . $rows, $detail->company);
            $sheet->setCellValue('C' . $rows, $detail->addres);
            $sheet->setCellValue('D' . $rows, $detail->province_en);
            $sheet->setCellValue('E' . $rows, $detail->email);
            $sheet->setCellValue('F' . $rows, $namapicnya);
            $sheet->setCellValue('G' . $rows, $telppicnya);
            $sheet->setCellValue('H' . $rows, date('d-m-Y',strtotime($detail->verified_at)));
            $rows++;
            $no++;
        }

        $length = $rows-1;
        $sheet->getStyle('A3:H'.$length)->applyFromArray($styleArray);
        $sheet->getStyle('A4:H'.$length)->getAlignment()->setHorizontal('left');
        $sheet->getStyle('A3:H'.$length)->getAlignment()->setVertical('center');

        
        $sheet->getStyle('A3:A'.$length)->getAlignment()->setHorizontal('center');

        $sheet->getStyle('H3:H'.$length)->getAlignment()->setHorizontal('center');

        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, "Xlsx");
        $file_name = public_path()."/excel/ExporterReport.xlsx";
        $writer->save( $file_name);

        return response()->download($file_name);

    }

    public function listeksportir($id)
    {
//        dd('hahahaha');
        $data = DB::table('itdp_profil_eks')
            ->where('id', '=', $id)
            ->get();
        foreach ($data as $datanya) {
            $company = $datanya->company;
        }
//        dd($data);
        $pageTitle = "List Exporter";
        return view('eksportir.annual_sales.listeksportir', compact('id', 'pageTitle', 'company'));
    }
}
