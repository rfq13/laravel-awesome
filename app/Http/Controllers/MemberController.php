<?php
    
namespace App\Http\Controllers;

use App\Imports\MembersImport;
use App\Models\Group;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class MemberController extends Controller
{ 
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:member-list|member-create|member-edit|member-delete', ['only' => ['index','show','inspect']]);
         $this->middleware('permission:member-create', ['only' => ['create','store']]);
         $this->middleware('permission:member-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:member-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $members = Member::paginate(5);
        return view('members.index',compact('members'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $groups = Group::all();
        return view('members.create',compact('groups'));
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate([
            'name' => 'required',
            'group_id' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'email' => 'required',
            'profile_pic' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
        ]);
        $create =$request->all();

        // upload image
        $path = $request->file('profile_pic')->store('public/profile_pic');
        
        $create['profile_pic'] = Storage::url($path);


        Member::create($create);
    
        return redirect()->route('members.index')
                        ->with('success','Member created successfully.');
    }
    
    /**
     * Display the specified resource.
     *
     * @param  \App\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function show(Member $member)
    {
        $member->profile_pic = Storage::url($member->profile_pic);

        return view('members.show',compact('member'));
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function inspect(Member $member)
    {
        $member->profile_pic = Storage::url($member->profile_pic);

        return response()->json($member);
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function edit(Member $member)
    {
        $groups = Group::all();
        $member->profile_pic = Storage::url($member->profile_pic);
        return view('members.edit',compact('member','groups'));
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Member $member)
    {
         request()->validate([
            'name' => 'required',
            'group_id' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'email' => 'required',
            'profile_pic' => ['image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
        ]);

        $update = $request->all();

        if ($request->hasFile('profile_pic')) {
            $path = $request->profile_pic->store('public/profile_pic');
            $update['profile_pic'] = $path;
            
            // delete old image
            Storage::delete($member->profile_pic);
        }
    
        $member->update($update);
    
        return redirect()->route('members.index')
                        ->with('success','Member updated successfully');
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function destroy(Member $member)
    {
        Storage::delete($member->profile_pic);
        $member->delete();
    
        return redirect()->route('members.index')
                        ->with('success','Member deleted successfully');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xls,xlsx'
        ]);
        
        Excel::import(new MembersImport, $request->file);
        return back()->with('success', 'Insert Record successfully.');
    }
}