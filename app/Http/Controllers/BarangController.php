<?php

namespace App\Http\Controllers;

use App\Models\BarangModel;
use Illuminate\Http\Request;
use App\Models\KategoriModel;
use Barryvdh\DomPDF\Facade\Pdf;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


class BarangController extends Controller
{
    public function index()
    {
        $activeMenu = 'item';
        $breadcrumb = (object) [
            'title' => 'Item Data',
            'list' => ['Home', 'Barang']
        ];

        $kategori = KategoriModel::select('kategori_id', 'nama_kategori')->get();

        return view('barang.index', [
            'activeMenu' => $activeMenu,
            'breadcrumb' => $breadcrumb,
            'kategori' => $kategori
        ]);
    }

    public function list(Request $request)
    {
        $barang = BarangModel::select('barang_id', 'barang_kode', 'barang_nama', 'harga_beli', 'harga_jual', 'kategori_id')
            ->with('kategori');

        if ($request->filled('filter_kategori')) {
            $barang->where('kategori_id', $request->input('filter_kategori'));
        }

        return DataTables::of($barang)
            ->addIndexColumn()
            ->addColumn('action', function ($barang) {
                $btn  = '<button onclick="modalAction(\'' . url('/barang/' . $barang->barang_id . '/show') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/barang/' . $barang->barang_id . '/edit') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="confirmDelete(\'' . url('/barang/' . $barang->barang_id) . '\')" class="btn btn-danger btn-sm">Delete</button>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function create()
    {
        $kategori = KategoriModel::all();
        return view('barang.create', compact('kategori'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kategori_id'  => 'required|integer|exists:m_kategori,kategori_id',
            'barang_kode'  => 'required|string|min:3|max:20|unique:m_barang,barang_kode',
            'barang_nama'  => 'required|string|max:100',
            'harga_beli'   => 'required|numeric|min:0',
            'harga_jual'   => 'required|numeric|min:0|gte:harga_beli',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            BarangModel::create($request->all());
            return response()->json([
                'status' => true,
                'message' => 'Data created successfully',
                'redirect' => url('/barang')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to create data',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        $barang = BarangModel::with('kategori')->find($id);
        
        if (!$barang) {
            return response()->json([
                'status' => false,
                'message' => 'Data not found'
            ], 404);
        }

        return view('barang.show', compact('barang'));
    }

    public function edit($id)
    {
        $barang = BarangModel::find($id);
        $kategori = KategoriModel::all();
        
        if (!$barang) {
            return response()->json([
                'status' => false,
                'message' => 'Data not found'
            ], 404);
        }

        return view('barang.edit', compact('barang', 'kategori'));
    }

    public function update(Request $request, $id)
    {
        $barang = BarangModel::find($id);
        
        if (!$barang) {
            return response()->json([
                'status' => false,
                'message' => 'Data not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'kategori_id'  => 'required|integer|exists:m_kategori,kategori_id',
            'barang_kode'  => 'required|string|min:3|max:20|unique:m_barang,barang_kode,'.$id.',barang_id',
            'barang_nama'  => 'required|string|max:100',
            'harga_beli'   => 'required|numeric|min:0',
            'harga_jual'   => 'required|numeric|min:0|gte:harga_beli',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $barang->update($request->all());
            return response()->json([
                'status' => true,
                'message' => 'Data updated successfully',
                'redirect' => url('/barang')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to update data',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        $barang = BarangModel::find($id);
        
        if (!$barang) {
            return response()->json([
                'status' => false,
                'message' => 'Data not found'
            ], 404);
        }

        try {
            $barang->delete();
            return response()->json([
                'status' => true,
                'message' => 'Data deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to delete data',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function import()
    {
        return view('barang.import');
    }
    public function import_ajax(Request $request)
    {
    if($request->ajax() || $request->wantsJson()){
    $rules = [
    'file_barang' => ['required', 'mimes:XLSX', 'max:1024']
    ];
    $validator = Validator::make($request->all(), $rules);
    if($validator->fails()){
        return response()->json([
            'status' => false,
            'message' => 'Validation Failed',
            'msgField' => $validator->errors()
            ]);
            }
            $file = $request->file('file_barang'); 
            $reader = IOFactory::createReader('Xlsx');
            $reader->setReadDataOnly(true); 
            $spreadsheet = $reader->load($file->getRealPath()); 
            $sheet = $spreadsheet->getActiveSheet(); 
            $data = $sheet->toArray(null, false, true, true);
            $insert = [];
            if(count($data) > 1){ 
            foreach ($data as $baris => $value) {
            if($baris > 1){
            $insert[] = [
            'kategori_id' => $value['A'],
            'barang_kode' => $value['B'],
            'barang_nama' => $value['C'],
            'harga_beli' => $value['D'],
            'harga_jual' => $value['E'],
            'created_at' => now(),
            ];
            }
            }
            if(count($insert) > 0){
           
            BarangModel::insertOrIgnore($insert);
            }
            return response()->json([
            'status' => true,
            'message' => 'Data imported successfully'
            ]);
            }else{
            return response()->json([
            'status' => false,
            'message' => 'No data imported'
            ]);
            }
            }
            return redirect('/');
            }

            public function export_excel()
{
    // Ambil data dari database
    $barang = BarangModel::select('kategori_id','barang_kode', 'barang_nama', 'harga_beli', 'harga_jual')
        ->orderBy('kategori_id')
        ->with('kategori')
        ->get();

    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Header kolom
    $sheet->setCellValue('A1', 'No');
    $sheet->setCellValue('B1', 'Kode Barang');
    $sheet->setCellValue('C1', 'Nama Barang');
    $sheet->setCellValue('D1', 'Harga Beli');
    $sheet->setCellValue('E1', 'Harga Jual');
    $sheet->setCellValue('F1', 'Kategori');
    $sheet->getStyle('A1:F1')->getFont()->setBold(true);

    // Isi data
    $no = 1;
    $baris = 2;
    foreach ($barang as $value) {
        $sheet->setCellValue('A'.$baris, $no++);
        $sheet->setCellValue('B'.$baris, $value->barang_kode);
        $sheet->setCellValue('C'.$baris, $value->barang_nama);
        $sheet->setCellValue('D'.$baris, $value->harga_beli);
        $sheet->setCellValue('E'.$baris, $value->harga_jual);
        $sheet->setCellValue('F'.$baris, $value->kategori->kategori_nama ?? '-');
        $baris++;
    }

    // Auto size kolom
    foreach(range('A','F') as $columnID) {
        $sheet->getColumnDimension($columnID)->setAutoSize(true);
    }

    $sheet->setTitle('Data Barang');

    // Simpan ke file sementara
    $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
    $filename = 'Data Barang '.date('Y-m-d_H-i-s').'.xlsx';
    $temp_file = tempnam(sys_get_temp_dir(), 'excel_');
    $writer->save($temp_file);

    // Kembalikan response download
    return response()->download($temp_file, $filename)->deleteFileAfterSend(true);
}

public function export_pdf()
{
    // Get data from database with eager loading
    $barang = BarangModel::select('kategori_id', 'barang_kode', 'barang_nama', 'harga_beli', 'harga_jual')
        ->orderBy('kategori_id')
        ->orderBy('barang_kode')
        ->with('kategori')
        ->get();

    // Generate PDF
    $pdf = Pdf::loadView('barang.export_pdf', [
        'barang' => $barang,
        'title' => 'Data Barang',
        'date' => date('Y-m-d H:i:s')
    ]);

    // PDF configuration
    $pdf->setPaper('a4', 'portrait');
    $pdf->setOption('isRemoteEnabled', true);
    $pdf->setOption('isHtml5ParserEnabled', true);
    $pdf->setOption('isPhpEnabled', true);

    // Return the PDF as a download
    return $pdf->stream('Data_Barang_' . date('Y-m-d_His') . '.pdf');
}
            
        }
