<?php

namespace App\Modules\Event\Controllers;

use App\Modules\Comment\Models\Comment;
use App\Modules\Event\Models\Event;
use App\Modules\Home\Models\Banner;
use App\Modules\Product\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EventController extends Controller
{
    public function getSingle($slug)
    {
        $banner = Banner::where('type', '=', 'event')->where('status', '=', 1)->orderBy('order', '=', 'ASC')->first();
        $products = Product::where('order', '=', 'ASC')->paginate(6);
        $blog = Event::where('slug', '=', $slug)->first();
        $blog_relate = Event::where('status', '=', 1)->where('slug', '!=', $slug)->orderBy('order', '=', 'ASC')->paginate(6);
        return view('Event::single', ['blog' => $blog, 'blog_relate' => $blog_relate, 'products' => $products, 'banner' => $banner]);
    }

    public function commentSingle(Request $request){
        Comment::create(array(
            'event_id' => $request->product_id,
            'gender' => $request->gender,
            'name' => $request->author,
            'phone' => $request->phone,
            'email' => $request->email,
            'content' => $request->content_comment,
            'status' => 0,
        ));

        return \redirect()->to($request->product_slug.'#comment')->with('comment', 'Bình luận của bạn đang chờ kiểm duyệt!');
    }

    public function commenChildtSingle(Request $request){
        Comment::create(array(
            'event_id' => $request->product_id,
            'gender' => $request->gender,
            'name' => $request->author,
            'phone' => $request->phone,
            'email' => $request->email,
            'content' => $request->content_comment,
            'parent' => $request->parent_id,
            'status' => 0,
        ));

        return \redirect()->to($request->product_slug.'#comment')->with('comment', 'Bình luận của bạn đang chờ kiểm duyệt!');
    }
}