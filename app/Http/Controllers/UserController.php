<?php

namespace App\Http\Controllers;

use App\Models\LevelModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

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
        $users = UserModel::select('user_id', 'username', 'nama', 'level_id')->with('level');

        if($request->level_id){
            $users->where('level_id',$request->level_id);
        }

        return DataTables::of($users)
            ->addIndexColumn()
            ->addColumn('action', function ($user) {
                // Generate action buttons
                $btn = '<a href="'.url('/user/' . $user->user_id).'" class="btn btn-info btn-sm">Detail</a> ';
                $btn .= '<a href="'.url('/user/' . $user->user_id . '/edit').'" class="btn btn-warning btn-sm">Edit</a> ';
                $btn .= '<form class="d-inline-block" method="POST" action="'. url('/user/'.$user->user_id) .'">'
                    . csrf_field() . method_field('DELETE') . 
                    '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Did you delete this data?\');">Delete</button>
                </form>';

                return $btn;
            })
            ->rawColumns(['action']) 
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

    return redirect('/user')->with('success', 'Data user berhasil diubah');
}



}
