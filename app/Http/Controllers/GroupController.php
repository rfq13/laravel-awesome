<?php
    
namespace App\Http\Controllers;
    
use App\Models\Group;
use Illuminate\Http\Request;
    
class GroupController extends Controller
{ 
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:group-list|group-create|group-edit|group-delete', ['only' => ['index','show']]);
         $this->middleware('permission:group-create', ['only' => ['create','store']]);
         $this->middleware('permission:group-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:group-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $groups = Group::paginate(5);
        return view('groups.index',compact('groups'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('groups.create');
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
            'city' => 'required',
        ]);

        Group::create($request->all());
    
        return redirect()->route('groups.index')
                        ->with('success','Group created successfully.');
    }
    
    /**
     * Display the specified resource.
     *
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function show(Group $group)
    {
        return view('groups.show',compact('group'));
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function edit(Group $group)
    {
        return view('groups.edit',compact('group'));
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Group $group)
    {
         request()->validate([
            'name' => 'required',
            'city' => 'required',
        ]);
    
        $group->update($request->all());
    
        return redirect()->route('groups.index')
                        ->with('success','Group updated successfully');
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function destroy(Group $group)
    {
        $group->delete();
    
        return redirect()->route('groups.index')
                        ->with('success','Group deleted successfully');
    }
}