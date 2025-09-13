<?php

namespace App\Http\Controllers\Frontend;

use App\Models\NewSubsriber;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Mail\Frontend\NewSubscriber;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class NewsSubscriberController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email', Rule::unique(NewSubsriber::class, 'email')],
        ], [
            'email.required' => 'البريد الإلكتروني مطلوب',
            'email.email' => 'يرجى إدخال بريد إلكتروني صالح',
            'email.unique' => 'هذا البريد مشترك بالفعل',
        ]);

        try {
            $newsubscriber = NewSubsriber::create([
                'email' => $request->email,
            ]);

            Mail::to($request->email)->send(new NewSubscriber());
            
            return redirect()->back()->with('success', 'Thanks for subscribing');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong.');
        }



    }

    //  public function store(Request $request)
    // {
    //     // Validate user input
    //     $validated = $request->validate([
    //         'email' => ['required', 'email', Rule::unique(NewSubscriber::class, 'email')],
    //     ], [
    //         'email.required' => 'البريد الإلكتروني مطلوب.',
    //         'email.email' => 'يرجى إدخال بريد إلكتروني صالح.',
    //         'email.unique' => 'هذا البريد الإلكتروني مسجل بالفعل.',
    //     ]);

    //     try {
    //         // Store subscriber
    //         $subscriber = NewSubscriber::create([
    //             'email' => $validated['email'],
    //         ]);

    //         // Send confirmation email
    //         Mail::to($subscriber->email)->send(new NewSubscriberMail());

    //         return back()->with('success', 'شكراً لاشتراكك في النشرة البريدية!');
    //     } catch (\Throwable $e) {
    //         // Log the exception for debugging
    //         Log::error('Newsletter Subscription Failed: ' . $e->getMessage(), [
    //             'email' => $request->input('email'),
    //             'trace' => $e->getTraceAsString(),
    //         ]);

    //         return back()->with('error', 'حدث خطأ أثناء الاشتراك. الرجاء المحاولة لاحقاً.');
    //     }
    // }
}
