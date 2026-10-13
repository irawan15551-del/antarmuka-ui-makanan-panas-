<?php
namespace App\Http\Controllers;
use App\Models\MachineConfiguration;
use Illuminate\Http\Request;
class MachineConfigurationController extends Controller {
    public function index(){ return view('machine.index'); }
    public function store(Request $r){
        $d=$r->validate(['temperature'=>'required|numeric','heating_time'=>'required|integer|min:1','target_slot'=>'required|string|max:20','mode'=>'required|string']);
        MachineConfiguration::create(['user_id'=>$r->user()->id,'payload'=>$d,'status'=>'pending','response'=>null]);
        return redirect()->route('machine.confirm')->with('success','Parameter berhasil disiapkan untuk dikirim.');
    }
    public function confirm(){ return view('machine.confirm'); }
}
