<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Category;
use App\Rules\FilterRule;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class CategoriesController extends Controller
{
    protected $rules = [
        'name' => [-
            'required',
            'string',
            'between:2,255',
            'filter',
        ],
        'parent_id' => ['nullable', 'int', 'exists:categories,id'],
        'description' => ['required', 'string'],
        'art_file' => ['nullable', 'image'],
    ];

    protected $messages = [
        'image' => 'The :attribute should be an image type',
        'name.required' => 'The :attribute field is mandatory.'
    ];

    // Actions
    public function index()
    {
        //$categories = DB::table('categories')->get();
        $categories = Category::leftJoin('categories as parents', 'parents.id', '=', 'categories.parent_id')
            ->select([
                'categories.*',
                'parents.name as parent_name',
            ])
            ->paginate();

        //$flashMessage = session('success', false);
        //$flashMessage = session()->get('success', false);
        //$flashMessage = Session::get('success', false);
        //Session::forget('success');

        return view('categories.index', [
            'categories' => $categories,
            'title' => 'Categories',
            //'flashMessage' => $flashMessage,
        ]);
    }

    public function show(Category $category)
    {
        // $category = DB::table('categories')
        //     ->where('id', '=', $id)
        //     ->first();

        // $category = Category::where('id', '=', $id)->firstOrFail();
        // $category = Category::findOrFail($id);

        // if ($category == null) {
        //     abort(404);
        // }

        return view('categories.show', [
            'category' => $category,
        ]);
    }

    public function create()
    {
        $parents = Category::all();
        $category = new Category;
        return view('categories.create', compact('category', 'parents'));
    }

    public function store(Request $request)
    {

        $clean = $request->validate($this->rules(), $this->messages);
        //dd ($clean, $request->all());
        //$clean = $this->validate($request, $rules, $messages);

        // $validator = Validator::make($request->all(), $rules, $messages);
        // //$clean = $validator->validate();
        // if ($validator->fails()) {
        //     return redirect()->back()->withErrors($validator);
        // }

        // $clean['name']

        //     $request->name;
        //     $request->input('name');
        //     $request->post('name'); // Only post, put, patch requests
        //     $request->get('name');
        //     $request['name'];
        //     $request->query('name'); // Only query parameters

        //DB::table('categories')->insert([]);
        // $category = new Category();
        // $category->name = $request->input('name');
        // $category->description = $request->input('description');
        // $category->parent_id = $request->input('parent_id');
        // $category->slug = Str::slug($category->name);
        // $category->save();

        $data = $request->all();
        if (!$data['slug']) {
            $data['slug'] = Str::slug($data['name']);
        }

        $category = Category::create($data);


        // PRG: Post Redirect Get
        return redirect()
            ->route('categories.index')
            ->with('success', 'Category created!');
    }

    public function edit(Category $category)
    {
        //$category = Category::findOrFail($id);
        $parents = Category::all();

        //dd($parents->pluck('name', 'id')->toArray());

        return view('categories.edit', compact('category', 'parents'));
    }

    public function update(Request $request, Category $category)
    {
        //$category = Category::findOrFail($id);

        $clean = $request->validate($this->rules(), $this->messages);

        // $category->name = $request->input('name');
        // $category->description = $request->input('description');
        // $category->parent_id = $request->input('parent_id');
        // $category->slug = Str::slug($category->name);        
        // $category->save();

        $category->update($request->all());

        return redirect()
            ->route('categories.index')
            ->with('success', 'Category updated!');
    }

    public function destroy($id)
    {
        // DB::table('categories')->where('id', $id)->delete();
        // Category::where('id', $id)->delete();
        Category::destroy($id);

        // $category = Category::findOrFail($id);
        // $category->delete();

        //session()->flash('success', 'Category deleted!');
        //Session::flash('success', 'Category deleted!');
        //Session::put('success', 'Category deleted!');

        return redirect()
            ->route('categories.index')
            ->with('success', 'Category deleted!');
    }

    protected function rules()
    {
        $rules = $this->rules;

        // $rules['name'][] = function($attribute, $value, $fail) {
        //     if ($value == 'god') {
        //         $fail('This word is not allowed');
        //     }
        // };

        //$rules['name'][] = new FilterRule();

        //$rules['name'][] = 'filter';

        return $rules;
    }
}
