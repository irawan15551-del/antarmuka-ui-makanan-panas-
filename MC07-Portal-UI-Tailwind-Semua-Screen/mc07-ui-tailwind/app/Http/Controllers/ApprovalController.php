<?php
namespace App\Http\Controllers;
use App\Models\Approval;
class ApprovalController extends Controller {
    public function index(){ return view('approvals.index',['approvals'=>Approval::latest()->get()]); }
}
