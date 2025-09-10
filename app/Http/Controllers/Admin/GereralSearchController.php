<?php

namespace App\Http\Controllers\Admin;

use App\Models\Post;
use App\Models\User;
use App\Models\Contact;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GereralSearchController extends Controller
{
        public function search(Request $request)
    {
        if($request->option == 'user'){
            return  $this->searchUsers($request);

        }elseif($request->option == 'post'){
            return  $this->searchPosts($request);

        }elseif($request->option== 'category'){
            return  $this->searchCategories($request);

        }elseif($request->option == 'contact'){
            return  $this->searchContact($request);

        }else{
            return redirect()->back();
        }
    }

    private function searchUsers($request)
    {
        $users = User::where('name' , 'LIKE' , '%'.$request->keyword.'%')->paginate(3);
        return view('dashboard.users.index' , compact('users'));
    }
    private function searchCategories($request)
    {
        $categories = Category::where('name' , 'LIKE' , '%'.$request->keyword.'%')->paginate(3);
        return view('dashboard.categories.index' , compact('categories'));

    }
    private function searchPosts($request)
    {
        $posts = Post::where('title' , 'LIKE' , '%'.$request->keyword.'%')->paginate(3);
        return view('dashboard.posts.index' , compact('posts'));
    }
    private function searchContact($request)
    {
        $contacts = Contact::where('name' , 'LIKE' , '%'.$request->keyword.'%')->paginate(3);
        return view('dashboard.contacts.index' , compact('contacts'));
    }
}
