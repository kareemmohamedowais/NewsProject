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
        $this->middleware('can:show_roles')->only(['index']);
        $this->middleware('can:create_role')->only(['create','store']);
        $this->middleware('can:edit_role')->only(['edit','update']);
        $this->middleware('can:delete_role')->only(['destroy']);    }
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
        'role' => 'required|string|min:2|max:60|unique:authorizations,role',
        'permissions' => 'required|array|min:1',
    ]);

    // ناخد البرميشنز المختارة
    $permissions = $request->permissions;

    // نجيب dependencies من ملف config/permissions.php
    $dependencies = config('authorization.dependencies');

    // نضيف dependencies تلقائي لو مش موجودة
    foreach ($permissions as $perm) {
        if (isset($dependencies[$perm])) {
            foreach ($dependencies[$perm] as $dep) {
                if (!in_array($dep, $permissions)) {
                    $permissions[] = $dep;
                }
            }
        }
    }

    // إنشاء الرول
    $authorizations = new Authorizations();
    $authorizations->role = $request->role;
    $authorizations->permissions = json_encode($permissions);
    $authorizations->save();

    return redirect()->back()->with('success', 'Role Created Successfully!');
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
    public function update(Request $request, $id)
{
    $request->validate([
        'role' => 'required|string|min:2|max:60|unique:authorizations,role,' . $id,
        'permissions' => 'required|array|min:1',
    ]);

    // ناخد البرميشنز المختارة
    $permissions = $request->permissions;
    // نجيب dependencies من ملف config/permissions.php
    $dependencies = config('authorization.dependencies');

    // نضيف dependencies تلقائي لو مش موجودة
    foreach ($permissions as $perm) {
        if (isset($dependencies[$perm])) {
            foreach ($dependencies[$perm] as $dep) {
                if (!in_array($dep, $permissions)) {
                    $permissions[] = $dep;
                }
            }
        }
    }

    // نعدل على الـ role
    $authorizations = Authorizations::findOrFail($id);
    $authorizations->role = $request->role;
    $authorizations->permissions = json_encode($permissions);
    $authorizations->save();

    return redirect()->back()->with('success', 'Role Updated Successfully!');
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
