<?php
namespace App\Modules\Home\Controllers;

use App\Modules\Blog\Models\Blog;
use App\Modules\Home\Models\Brand;
use App\Modules\Home\Models\Commitment;
use App\Modules\Product\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CommitmentController extends Controller
{
    public function getSingle(Request $request)
    {
        $currentUrl = $request->url();
        $urlSegments = explode('/', $currentUrl);
        $slug = array_slice($urlSegments, -1, 1);

        $commitment = Commitment::where('slug', $slug[0])->first();
        $products_related = Product::where('status', 1)->orderBy('order', 'ASC')->orderBy('created_at', 'DESC')->skip(0)->take(10)->get();
        $blog_relate = Blog::where('status', '=', 1)->orderBy('order', 'ASC')->inRandomOrder()->paginate(6);

        return view('Home::Commitment.single', ['commitment' => $commitment, 'blog_relate' => $blog_relate, 'products_related' => $products_related]);
    }
}
