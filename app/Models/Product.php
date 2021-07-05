<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['category_id', 'name', 'description', 'image'];

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function getResults($data)
    {
        if(!isset($data['filter']) && (!isset($data['name']) && !isset($data['description'])));
            return $this->paginate();

        return $this->where(function($query) use ($data){
                if(isset($data['filter'])){
                    $filter = $data['filter'];
                    $query->where('name', 'LIKE', "%{$filter}%");
                    $query->where('description', 'LIKE', "%{$filter}%");
                }

                if (isset($data['name'])){
                    $name = $data['name'];
                    $query->where('name', 'LIKE', "%{$name}%");
                }

                if (isset($data['description'])){
                    $description = $data['description'];
                    $query->where('description', 'LIKE', "%{$description}%");
                }
        })->paginate();
    }
}
