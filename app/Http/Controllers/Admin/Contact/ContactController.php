<?php

namespace App\Http\Controllers\Admin\Contact;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ContactController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:show_contacts')->only(['index']);
        $this->middleware('can:show_contact')->only(['show']);
        // $this->middleware('can:replay_contact')->only(['reply']);
        $this->middleware('can:delete_contact')->only(['destroy']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $order_by = request()->order_by ?? 'desc';
        $sort_by = request()->sort_by ?? 'id';
        $limit_by = request()->limit_by ?? 5;

        $contacts = Contact::when(request()->keyword, function ($query) {
            $query->where('title', 'LIKE', '%' . request()->keyword . '%')
            ->orwhere('name', 'LIKE', '%' . request()->keyword . '%')
            ->orwhere('email', 'LIKE', '%' . request()->keyword . '%');

        })->when(!is_null(request()->status), function ($query) {
            $query->where('status', request()->status);
        });

        $contacts = $contacts->orderBy($sort_by, $order_by)->paginate($limit_by);
        return view('dashboard.contacts.index',compact('contacts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $contact = Contact::findOrFail($id);
        $contact->update([
            'status'=>1
        ]);
        return view('dashboard.contacts.show',compact('contact'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $contact = Contact::findOrFail($id);
        $contact->delete();
        Session::flash('success','deleted successfully');
        return redirect()->route('admin.contacts.index');

    }
}
