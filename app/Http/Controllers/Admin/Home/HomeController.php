<?php

namespace App\Http\Controllers\Admin\Home;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use LaravelDaily\LaravelCharts\Classes\LaravelChart;

class HomeController extends Controller
{
        public function __construct()
    {
        $this->middleware('can:home');
    }

    public function index()
    {
        $chart_options = [
            'chart_title' => 'Posts by months',
            'report_type' => 'group_by_date',
            'model' => 'App\Models\Post',
            'group_by_field' => 'created_at',
            'group_by_period' => 'month',
            'chart_type' => 'line',

            'filter_field' => 'created_at',
            'filter_days' => 3600, // show only last 30 days
        ];

        $posts_chart = new LaravelChart($chart_options);

        $chart_options_users = [
            'chart_title' => 'Users by months',
            'report_type' => 'group_by_date',
            'model' => 'App\Models\User',
            'group_by_field' => 'created_at',
            'group_by_period' => 'month',
            'chart_type' => 'bar',

            'filter_field' => 'created_at',
            'filter_days' => 360, // show only last 30 days
        ];

        $users_chart = new LaravelChart($chart_options_users);


        // Pie Chart -> توزيع الأخبار حسب الأقسام
    $chart_options_news_categories = [
        'chart_title' => 'News Distribution by Category',
        'report_type' => 'group_by_relationship',
        'model' => 'App\Models\Post',
        'relationship_name' => 'category',   // العلاقة بين news و category
        'group_by_field' => 'name',          // اسم العمود اللي في categories
        'chart_type' => 'pie',
    ];

    $news_by_category_chart = new LaravelChart($chart_options_news_categories);

    // Bar Chart -> أكثر كاتب نشر أخبار
    $chart_options_authors = [
        'chart_title' => 'Top Authors by News Count',
        'report_type' => 'group_by_relationship',
        'model' => 'App\Models\Post',
        'relationship_name' => 'user',   // العلاقة بين news و user
        'group_by_field' => 'name',      // اسم الكاتب
        'chart_type' => 'bar',

        // الحساب
        'aggregate_function' => 'count',
        'aggregate_field' => 'id',

        // التحكم في النتائج
        'top_results' => 5,  // يجيب أعلى 5
        'order' => 'desc',   // يرتبهم تنازلياً
    ];



    $authors_chart = new LaravelChart($chart_options_authors);


        return view('dashboard.index', 
        compact('posts_chart' , 'users_chart','authors_chart','news_by_category_chart'));
    }       

}
