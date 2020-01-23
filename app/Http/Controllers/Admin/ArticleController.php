<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ArticleTag;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Article;

class ArticleController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Article Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after Article.
     *
     * @var string
     */
    // protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('guest', ['except' => 'logout']);
    // }

    public function index(){
        return view('admin/article/index')->with('articles', Article::all());
    }

    public function create()
    {
        return view('admin/article/create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|unique:articles|max:255',
            'body' => 'required',
        ]);

        $article = new Article;
        $article->title = $request->get('title');
        $article->body = $request->get('body');
        $article->user_id = $request->user()->id;

        if ($article->save()) {
            return redirect('admin/articles');
        } else {
            return redirect()->back()->withInput()->withErrors('保存失败！');
        }
    }

    public function update(Request $request)
    {
        // $data = $request->except('_token');
        $this->validate($request, [
            'title' => 'required|unique:articles|max:255',

            'body' => 'required',
        ]);

        $article = new Article;
        $article->title = $request->get('title');
        $article->body = $request->get('body');
        // $article->user_id = $id;
        
        $data['title'] = $request->get('title');
        $data['body'] = $request->get('body');
        $id = $request->get('id');
        $where['id'] = $id;
        if (Article::where($where)->update($data)) {
            return redirect('admin/articles');
        } else {
            
            return redirect()->back()->withInput()->withErrors('保存失败！');
        }
    }

    public function edit($id,Request $request)
    { 
        if($request->old('title')!=null)
        { 
            return view('admin/article/edit')->withArticle((object)[ 'title'=>$request->old('title'), 'body'=>$request->old('body'), 'id'=>$request->old('id') ]); 
        } else { 
            return view('admin/article/edit')->withArticle(Article::find($id)); 

        } 
    }

    public function destroy($id)
    {
        Article::find($id)->delete();
        return redirect()->back()->withInput()->withErrors('删除成功！');
    }
}
