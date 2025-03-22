<?php

namespace App\Http\Controllers;

use App\Models\LevelModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
// Menampilkan halaman awal user
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Tambah User',
            'list' => ['Home', 'User']
    ];

    $page = (object) [
    'title' => 'Tambah User'

    ];

    $activeMenu = 'user'; // set menu yang sedang aktif
    $level = LevelModel::all();

    return view('user.index', ['breadcrumb' => $breadcrumb, 'page' => $page,'level' => $level,'activeMenu' => $activeMenu]);
    }

    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Tambah User',
            'list' => ['Home', 'User', 'Tambah']
    ];

    $page = (object) [
    'title' => 'Tambah User Baru'

    ];

    $level = LevelModel::all();
    $activeMenu = 'user'; // set menu yang sedang aktif

    return view('user.create', compact('breadcrumb', 'page', 'level', 'activeMenu'));
    }

    public function show(String $id)
    {
        $user = UserModel::with('level')->find($id);

        $breadcrumb = (object) [
            'title' => 'Detail User',
            'list' => ['Home', 'User', 'Detail']
    ];

    $page = (object) [
    'title' => 'Detail User'

    ];

    $activeMenu = 'user'; // set menu yang sedang aktif

    return view('user.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'user' => $user, 'activeMenu' => $activeMenu]);
    }

    // Menampilkan halaman awal user
    public function list(Request $request)  
    {
        // Select users with the required columns and eager load the 'level' relationship
        $users = UserModel::select('user_id', 'username', 'nama', 'level_id')
            ->with('level');
        
        // Filter user data by level_id if provided in the request
        if ($request->level_id) { 
            $users->where('level_id', $request->level_id); 
        } 
        
        return DataTables::of($users)  
            ->addIndexColumn() // Adds an index/no sort column (default column name: DT_RowIndex)
            ->addColumn('action', function ($user) { // Add action column  
                $btn = '<button onclick="modalAction(\''.url('/user/' . $user->user_id . '/show_ajax').'\')" 
                        class="btn btn-info btn-sm">Detail</button> ';
                
                $btn .= '<button onclick="modalAction(\''.url('/user/' . $user->user_id . '/edit_ajax').'\')" 
                         class="btn btn-warning btn-sm">Edit</button> ';
                
                $btn .= '<button onclick="modalAction(\''.url('/user/' . $user->user_id . '/delete_ajax').'\')" 
                         class="btn btn-danger btn-sm">Delete</button> ';
                
                return $btn;  
            })  
            ->rawColumns(['action']) // Tells DataTables that the action column contains raw HTML  
            ->make(true);  
    }
    

    
    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|string|min:3|unique:m_user,username',
            'nama' => 'required|string|max:100',
            'password' => 'required|min:5',
            'level_id' => 'required|integer',
        ]);

        UserModel::create([
            'username' => $request->username,
            'nama' => $request->nama,
            'password' => bcrypt($request->password),
            'level_id' => $request->level_id,
        ]);

        return redirect('/user')->with('success', 'Data user berhasil disimpan');
    }

    public function destroy(string $id)
    {
    // Mengecek apakah data user dengan id yang dimaksud ada atau tidak
    $check = UserModel::find($id);
    
    if (!$check) {
        return redirect('/user')->with('error', 'Data user tidak ditemukan');
    }

    try {
        UserModel::destroy($id); // Hapus data user
        return redirect('/user')->with('success', 'Data user berhasil dihapus');
    } catch (\Illuminate\Database\QueryException $e) {
        // Jika terjadi error ketika menghapus data, redirect kembali ke halaman dengan membawa pesan error
        return redirect('/user')->with('error', 'Data user gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
    }
}



    // Menampilkan halaman form edit user
    public function edit(string $id)
    {
        $user = UserModel::find($id);
        $level = LevelModel::all();

        $breadcrumb = (object) [
            'title' => 'Edit User',
            'list'  => ['Home', 'User', 'Edit']
        ];

        $page = (object) [
            'title' => 'Edit User'
        ];

        $activeMenu = 'user'; // Set menu yang sedang aktif

        return view('user.edit', [
            'breadcrumb' => $breadcrumb,
            'page'       => $page,
            'user'       => $user,
            'level'      => $level,
            'activeMenu' => $activeMenu
        ]);
    }

    // Menyimpan perubahan data user
   public function update(Request $request, string $id)
{

    $request->validate([
        'username' => 'required|string|min:3|unique:m_user,username,' . $id . ',user_id',
        'nama' => 'required|string|max:100',
        'password' => 'nullable|min:5',
        'level_id' => 'required|integer'
    ]);

    $user = UserModel::find($id);
    $user->update([
        'username' => $request->username,
        'nama' => $request->nama,
        'password' => $request->password ? bcrypt($request->password) : $user->password,
        'level_id' => $request->level_id
    ]);

    return redirect('/user')->with('success', 'Data user berhasil diubah');
}

    public function create_ajax()
{
    $levels = LevelModel::all();$levels = LevelModel::all(); // Assuming Level is your model
    return view('user.create_ajax', compact('levels'));
}

    public function store_ajax(Request $request) {
    // Cek apakah request berupa AJAX
    if ($request->ajax() || $request->wantsJson()) {
        $rules = [
            'level_id' => 'required|integer',
            'username' => 'required|string|min:3|unique:m_user,username',
            'name' => 'required|string|max:100',
            'password' => 'required|min:6'
        ];

        // Gunakan Validator
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false, // response status, false: error/gagal, true: berhasil
                'message' => 'Validasi Gagal',
                'msgField' => $validator->errors(), // pesan error validasi
            ]);
        }

        // Simpan data user
        UserModel::create($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Data user berhasil disimpan'
        ]);
    }

    return redirect('/');
}

public function edit_ajax(string $id)
{
    // Fetch the level data based on level_id
    $user = UserModel::find($id);
    $level = LevelModel::select('level_id', 'level_nama')->get();

    return view('user.edit_ajax', ['user'=>$user,'level'=> $level]);
}


    public function update_ajax(Request $request, $id)
    {
        // Check if the request is from AJAX
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'level_id' => 'required|integer',
                'username' => 'required|max:20|unique:m_user,username,' . $id . ',user_id',
                'nama' => 'required|max:100', // Change 'name' to 'nama'
                'password' => 'nullable|min:6|max:20'
            ];     

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false, // JSON response, true: successful, false: failed
                    'message' => 'Validation failed.',
                    'msgField' => $validator->errors() // Indicates which field has an error
                ]);
            }

            $user = UserModel::find($id);
            if ($user) {
                // If the password is not filled, remove it from the request
                if (!$request->filled('password')) {
                    $request->request->remove('password');
                }

                $user->update($request->all());
                return response()->json([
                    'status' => true,
                    'message' => 'Data updated successfully'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data not found'
                ]);
            }
        }
        return redirect('/');
    }

    public function confirm_ajax(string $id){
        $user = UserModel::find($id);

        return view('user.confirm_ajax', ['user' => $user]);
    }

    public function delete_ajax(Request $request, $id)
{
    // Cek apakah request berasal dari AJAX
    if ($request->ajax() || $request->wantsJson()) {
        $user = UserModel::find($id);
        if ($user) {
            $user->delete();
            return response()->json([
                'status' => true,
                'message' => 'Data berhasil dihapus'
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan'
            ]);
        }
    }
    return redirect('/');
}

    
}
