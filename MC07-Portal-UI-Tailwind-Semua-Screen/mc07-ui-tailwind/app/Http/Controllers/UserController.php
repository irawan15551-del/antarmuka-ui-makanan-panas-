<?php
namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
class UserController extends Controller {
    public function index(){ return view('users.index',['users'=>User::latest()->get()]); }
    public function create(){ return view('users.form',['user'=>new User]); }
    public function store(Request $r){
        $d=$r->validate(['name'=>'required|string|max:255','email'=>'required|email|unique:users,email','password'=>'required|min:8','role'=>'required|in:admin,operator']);
        $d['password']=Hash::make($d['password']); User::create($d);
        return redirect()->route('users.index')->with('success','Pengguna berhasil ditambahkan.');
    }
    public function edit(User $user){ return view('users.form',compact('user')); }
    public function update(Request $r,User $user){
        $d=$r->validate(['name'=>'required|string|max:255','email'=>'required|email|unique:users,email,'.$user->id,'role'=>'required|in:admin,operator']);
        $user->update($d); return redirect()->route('users.index')->with('success','Role pengguna berhasil diperbarui.');
    }
}
