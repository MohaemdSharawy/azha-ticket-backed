<?php

namespace App\Livewire\DiscoverCategory;

use App\Models\DiscoverCategory;
use Livewire\Component;

class DiscoverCategoryList extends Component
{

    public int $limit = 10;
    public int $rank;
    public int $id = 0 ;
    public String $title_ar = '';
    public String $title_en = '';
    public String $description_ar = '';
    public String $description_en = '';
    public $search;

    public function activation($category_id)
    {
        $category =  DiscoverCategory::find($category_id);
        ($category->active  == 1) ? $category->active = 0 : $category->active = 1;
        $category->save();
    }


    public function save(): void
    {
        $inputs  = [
            'title_ar' => $this->title_ar,
            'title_en' => $this->title_en,
            'description_ar' => $this->description_ar,
            'description_en' => $this->description_en,
            'rank' => $this->rank
        ];
        if($this->id && $this->id !=  0){
            $category =  DiscoverCategory::find($this->id);
            $category->update($inputs);
            session()->flash('success_notify', 'Category Updated Successfully Successfully');
            $this->redirect('/discover-category');
        }else{
            $add =   DiscoverCategory::create($inputs);
            if ($add) {
                session()->flash('success_notify', 'Category Created Successfully Successfully');
                $this->redirect('/discover-category');
            }
        }
    }

    public function set_value($id = false)
    {
        if(!$id){
            $this->id =  0;
            $this->title_ar = '';
            $this->title_en = '';
            $this->description_ar = '';
            $this->description_en = '';
            $this->rank =  DiscoverCategory::orderBy('id' , 'DESC')->first()->id;
        }else{
            $this->id = $id;
            $category =  DiscoverCategory::find($id);
            $this->title_ar = $category->title_ar;
            $this->title_en = $category->title_en;
            $this->description_ar = $category->description_ar;
            $this->description_en = $category->description_en;
            $this->rank =  $category->rank;
        }
    }


    public function delete($id){
        $category = DiscoverCategory::find($id);
        $category->deleted = 1;
        $category->save();
        session()->flash('success_notify', 'Category Deleted Successfully Successfully');
        $this->redirect('/discover-category');
    }

    public function render()
    {
        $data['categories'] =  DiscoverCategory::search($this->search)->where(['deleted' => 0])->orderBy('id', 'DESC')->paginate($this->limit);
        return view('livewire.discover-category.discover-category-list', $data);
    }
}
