<?php

namespace App\Http\Controllers;

use App\Models\Circle;
use App\Models\CircleDt;
use App\Models\Dashboard;
use App\Models\Departemen;
use App\Models\Group;
use App\Models\Langkah;
use App\Models\Org;
use App\Models\Periode;
use App\Models\Section;
use App\Models\Slider;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{
    public function index() {
        $data = [
            'user' => Auth::user(),
            'slides' => Slider::all(),
            // fyadm
            'fyAdm' => Dashboard::where('category', Dashboard::FYADM)->value('foto'),
            // fybody
            'fyBody' => Dashboard::where('category', Dashboard::FYBODY)->value('foto'),
            // bodymaps
            'bodyMaps' => Dashboard::where('category', Dashboard::BODYMAPS)->value('foto'),
            // structure
            'structure' => Dashboard::where('category', Dashboard::STRUCTURE)->value('foto'),
            
        ];
        return view('home.index', $data);
    }
    public function admin() {
        $data = [
            'user' => Auth::user(),
            'fy_adm' => Dashboard::where('category', Dashboard::FYADM)->first(),
            'fy_body' => Dashboard::where('category', Dashboard::FYBODY)->first(),
            'body_maps' => Dashboard::where('category', Dashboard::BODYMAPS)->first(),
            'structure' => Dashboard::where('category', Dashboard::STRUCTURE)->first(),
        ];
        return view('home.admin.index', $data);
    }

    // ------ fy adm upload ----
    function getSettings($category) {
        $item = Dashboard::where('category', $category)->first();
        if (is_null($item)) {
            $obj = new Dashboard();
            $obj->category = $category;
            $obj->foto = '#';
            $obj->save();
            return $obj;
        }
        return $item;
    }
    public function updateGeneralSettings(Request $request) {
        if ($request->fy_adm) {
            $obj = $this->getSettings(Dashboard::FYADM);

            $imageName = time().'.'.$request->fy_adm->extension();
            $imagePath = 'dashboard/'. Dashboard::FYADM;
            $request->fy_adm->move(public_path($imagePath), $imageName);
            $imgPath = 'dashboard/'. Dashboard::FYADM .'/' . $imageName;

            $obj->foto = $imgPath;
            $obj->save();
        } 
        if ($request->fy_body) {
            $obj = $this->getSettings(Dashboard::FYBODY);

            $imageName = time().'.'.$request->fy_body->extension();
            $imagePath = 'dashboard/'. Dashboard::FYBODY;
            $request->fy_body->move(public_path($imagePath), $imageName);
            $imgPath = 'dashboard/'. Dashboard::FYBODY .'/' . $imageName;

            $obj->foto = $imgPath;
            $obj->save();
        } 
        if ($request->body_maps) {
            $obj = $this->getSettings(Dashboard::BODYMAPS);

            $imageName = time().'.'.$request->body_maps->extension();
            $imagePath = 'dashboard/'. Dashboard::BODYMAPS;
            $request->body_maps->move(public_path($imagePath), $imageName);
            $imgPath = 'dashboard/'. Dashboard::BODYMAPS .'/' . $imageName;

            $obj->foto = $imgPath;
            $obj->save();
        } 
        if ($request->structure) {
            $obj = $this->getSettings(Dashboard::STRUCTURE);

            $imageName = time().'.'.$request->structure->extension();
            $imagePath = 'dashboard/'. Dashboard::STRUCTURE;
            $request->structure->move(public_path($imagePath), $imageName);
            $imgPath = 'dashboard/'. Dashboard::STRUCTURE .'/' . $imageName;

            $obj->foto = $imgPath;
            $obj->save();
        } 
    
        return redirect()->back()->with('success', 'success edit content!');
    }

    // -------------slides--------------
    public function slides() {
        $data = [
            'user' => Auth::user(),
            'title' => 'Slides',
            'slides' => Slider::where('status', Slider::STATUS_ACTIVE)->orderBy('order', 'asc')->get()
        ];
        return view('home.admin.slides.index', $data);
    }

    public function forms() {
        $data = [
            'user' => Auth::user(),
            'title' => 'Form Add Slides',
            'dataCount' => Slider::orderBy('order', 'asc')->count() + 1
        ];

        return view('home.admin.slides.forms', $data);
    }

    // create slides

    public function doValidate($request, $id=null) {
        $model = [
            'order' => 'required',
            'link' => 'required',
            'title' => 'required',
            'description' => 'required'
        ];
        // if ($id === null) {
        //     $model['img_url'] = 'required';
        // }
        $request->validate($model);
    }

    public function storeOrUpdate($request, $id=null) {

        $obj = $id === null ? new Slider() : Slider::find($id);
        // $obj->identifier = Generic::SLIDES;
        $obj->order = $request->order;
        $obj->link = $request->link;
        $obj->title = $request->title;
        $obj->description = $request->description;

        if ($request->hasFile('img_url')) {
            date_default_timezone_set('Asia/Jakarta');
            $imageName = date('dmYHis') . '.' .$request->img_url->extension();
            $imagePath = 'images/' . Slider::SLIDES;
            $request->img_url->move(public_path($imagePath), $imageName);
            $imgPath = 'images/' . Slider::SLIDES . '/' . $imageName;
    
            $obj->img_url = $imgPath;
        }
        
        $obj->save();
    }

    public function add(Request $request) {
        try {

            $this->doValidate($request);
            
            $this->storeOrUpdate($request);
            
            return redirect()->route('adminSlides')
            ->with('success', 'success add new slides!');
        } 
            catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menambahkan slides. Error: ' . $e->getMessage());
        }
    }

    // Edit Slides
    public function edit($id) {
        $data = [
                        'user' => Auth::user(),

            'title' => 'Forms Edit Slides',
            'forms' => Slider::find($id)
        ];
        return view('home.admin.slides.forms', $data);
    }

    public function update(Request $request, $id) {
        try {
            $this->doValidate($request);
    
            $this->storeOrUpdate($request, $id);
    
            return redirect()->route('adminSlides')
                ->with('success', 'success edit slides!');
        }

            catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal edit slides. Error: ' . $e->getMessage());
        }
    }
    // Delete Slides
    public function softDelete($id) {
    try {
        $obj = Slider::find($id);
        if (!$obj) {
            return redirect()->back()->with('error', 'Data not found.');
        }
        $item = $obj->title;
        $obj->status = Slider::STATUS_DELETED;
        $obj->save();
        $obj->forceDelete();
        return redirect()->back()->with('success', 'Successfully Deleted ' . $item . '!');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Failed to delete slides. Error: ' . $e->getMessage());
    }
}



   
}
