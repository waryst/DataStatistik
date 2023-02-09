<?php

namespace App\Http\Controllers\Adminweb;

use App\models\Visualisasi;
use Illuminate\Support\Str;
use App\Traits\GetNavTraits;
use Illuminate\Http\Request;
use App\models\DataStatistik;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class VisualAdminController extends Controller
{
    use GetNavTraits;
    public function createvisual()
    {
        $data['instansi'] =  auth()->user()->instansi;
        $data['nav'] =$this->getnav();
        return view('adminweb.pos_visual',$data);

    }
    public function data_visualisasi()
    {
        $data['instansi'] =  auth()->user()->instansi;
        $data['nav'] =$this->getnav();
        $data['visual']=Visualisasi::all();
        return view('adminweb.visualisasi',$data);
    }
    public function postvisual(Request $request)
    {
        $ValidatedData=$request->validate([
            'title' => 'required|max:255|unique:visualisasis',
            'visual' => 'required',
            'image' =>'required|image|file|max:1024',
            'deskripsi' =>'required'
        ]);  
        $ValidatedData['user_id']=auth()->user()->id;
        $ValidatedData['slug']=Str::of($request->title)->slug('-');
            if($request->draf=='draf'){
                $ValidatedData['publish_at']=null;
                $ValidatedData['updated_at']=null;
                Visualisasi::create($ValidatedData);
            }
            else if($request->simpan=='simpan'){
                $ValidatedData['publish_at']=date(now());
                $ValidatedData['updated_at']=null;
                if($request->file('image'))
                {
                    $ValidatedData['image']=$request->file('image')->store('visual-images');
                }
                Visualisasi::create($ValidatedData);
            }
        return redirect('/visualisasi_data')->with('toast_success','Berita Berhasil Dibuat');
    }

    public function updatevisual(Request $request, Visualisasi $slug)
    {
      if($request->show=='show'){
            $ValidatedData['publish_at']=null;
            Visualisasi::where('id',$slug->id)
                    ->update($ValidatedData);
            return redirect('/visualisasi_data')->with('toast_success','Berita Berhasil Diunpublish');
        }
        else if($request->unshow=='unshow'){
            $ValidatedData['publish_at']=date(now());
            Visualisasi::where('id',$slug->id)
                    ->update($ValidatedData);
            return redirect('/visualisasi_data')->with('toast_success','Berita Berhasil Dipublish');
        }
        $rules=[
            'category_id' =>'required',
            'news' =>'required'
        ];
        if($request->title != $slug->title)
        {
            $rules['title'] ='required|max:255|unique:news';
        }
        $ValidatedData=$request->validate($rules);
        if($request->UpdatePublish=='UpdatePublish'){
            $ValidatedData['publish_at']=date(now());
            $ValidatedData['updated_at']=date(now());
            $ValidatedData['slug']=Str::of($request->title)->slug('-');
            $ValidatedData['user_id']=auth()->user()->id;
            Visualisasi::where('id',$slug->id)
                    ->update($ValidatedData);
                    return redirect('/adminweb/news')->with('toast_success','Berita Berhasil Di Update dan Di Publish');
        }
        else if($request->UpdateDraf=='UpdateDraf'){
            $ValidatedData['publish_at']=null;
            $ValidatedData['updated_at']=date(now());
            $ValidatedData['slug']=Str::of($request->title)->slug('-');
            $ValidatedData['user_id']=auth()->user()->id;
            Visualisasi::where('id',$slug->id)
                    ->update($ValidatedData);
                    return redirect('/adminweb/news')->with('toast_success','Berita Berhasil Di Update tidak Di Pablish');
        }
    }
    public function destroy(Visualisasi $slug)
    {
        Storage::delete($slug->image);
        Visualisasi::destroy($slug->id);
        return redirect('/visualisasi_data')->with('toast_success','Berita Berhasil Dihapus');
    }

}
