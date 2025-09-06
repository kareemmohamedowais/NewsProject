<?php

namespace App\Http\Controllers\Admin\Authorization;

use App\Http\Controllers\Controller;
use App\Models\Authorizations;
use Illuminate\Http\Request;

class AuthorizationController extends Controller
{
    /**
     * Display a listing of the resource.
     */

        public function __construct(){
        $this->middleware('can:authorizations');
    }
    public function index()
    {
        $authorizations = Authorizations::paginate(5);
        return view('dashboard.authorizations.index',compact('authorizations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.authorizations.create');

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'role'=>'required|min:2|max:60',
            'permissions'=>'required|array|min:1',
        ]);

        $authorizations = new Authorizations();
        $authorizations->role = $request->role;
        $authorizations->permissions = json_encode($request->permissions);
        $authorizations->save();
        // $authorizations = Authorizations::create($request->only(['role','permissions']));
        return redirect()->back()->with('success' , 'Role Created Successfully!');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $authorization = Authorizations::findOrFail($id);
        return view('dashboard.authorizations.edit' , compact('authorization'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // $request->validate([
        //     'role'=>'required|min:2|max:60',
        //     'permissions'=>'required|array|min:1',
        // ]);
        $authorization = Authorizations::findOrFail($id);
        $authorization->role = $request->role;
        $authorization->permissions = json_encode($request->permissions);
        $authorization->save();
        return redirect()->route('admin.authorizations.index')->with('success' , 'Role Updated Successfully!');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $role = Authorizations::findOrFail($id);

        if($role->admins->count()>0){
            return redirect()->back()->with('error' , 'Please Delete Related Admin first!');
        }
        $role = $role->delete();

        if(!$role){
            return redirect()->back()->with('error' , 'try again latter!');
        }
            return redirect()->back()->with('success' , 'Role Deleted Successfully!');

    }
}
