<?php

namespace App\Http\Controllers\Admin\Category;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function __construct()
    {
        $this->middleware('can:categories');
    }
    public function index()
    {
        $order_by = request()->order_by ?? 'desc';
        $sort_by = request()->sort_by ?? 'id';
        $limit_by = request()->limit_by ?? 5;

        $categories = Category::withCount('posts')->when(request()->keyword, function ($query) {
            $query->where('name', 'LIKE', '%' . request()->keyword . '%');
        })->when(!is_null(request()->status), function ($query) {
            $query->where('status', request()->status);
        });

        $categories = $categories->orderBy($sort_by, $order_by)->paginate($limit_by);

        return view('dashboard.categories.index', compact('categories'));
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
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'status' => 'nullable|in:0,1',
        ]);

        $category = Category::create($request->except('_token'));
        if (!$category) {
            Session::flash('error', ' Try again latter!');
            return redirect()->route('admin.categories.index');
        }
        Session::flash('success', 'Category Created Suuccessfully!');
        return redirect()->route('admin.categories.index');
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validation
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $id,
            'status' => 'nullable|in:0,1',
        ]);

        // Find category
        $category = Category::findOrFail($id);

        // Update
        $updated = $category->update($request->except(['_token', '_method']));

        if (!$updated) {
            Session::flash('error', 'Try Again Later!');
            return redirect()->route('admin.categories.index');
        }

        Session::flash('success', 'Category Updated Successfully!');
        return redirect()->route('admin.categories.index');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::findOrFail($id);

        if ($category->delete()) {
            Session::flash('success', 'Category Deleted Successfully!');
        } else {
            Session::flash('error', 'Failed to delete category, please try again later!');
        }

        return redirect()->route('admin.categories.index');
    }


    public function changeStatus($id)
    {
        $category = Category::findOrFail($id);

        if ($category->status == 1) {
            $category->update([
                'status' => 0,
            ]);
            Session::flash('success', 'Category Blocked Successfully!!');
        } else {
            $category->update([
                'status' => 1,
            ]);
            Session::flash('success', 'Category Activated Successfully!!');
        }
        return redirect()->back();
    }
}
