<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Builder;

class MacroServiceProvider extends ServiceProvider
{

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {

        Builder::macro('singleSearchWithRelation', function ($attributes, string $searchTerm) {
            $this->where(function (Builder $query) use ($attributes, $searchTerm) {
                foreach (array_wrap($attributes) as $attribute) 
                {
                    $query->when(
                        str_contains($attribute, '.'),
                        function (Builder $query) use ($attribute, $searchTerm) {
                            [$relationName, $relationAttribute] = explode('.', $attribute);

                            $query->orWhereHas($relationName, function (Builder $query) use ($relationAttribute, $searchTerm) {
                                $query->where($relationAttribute, 'LIKE', "%{$searchTerm}%");
                            });
                        },
                        function (Builder $query) use ($attribute, $searchTerm) {
                            $query->orWhere($attribute, 'LIKE', "%{$searchTerm}%");
                        }
                    );
                }
            });

            return $this;
        });

        Builder::macro('singleSearchWithOutRelation', function ($attributes, string $searchTerm) {
            $this->where(function (Builder $query) use ($attributes, $searchTerm) {
                foreach (array_wrap($attributes) as $attribute) {
                    $query->orWhere($attribute, 'LIKE', "%{$searchTerm}%");
                }
            });

            return $this;
        });

        Builder::macro('search',function($attributes,$searchTerms){

            $searchTerms = !is_array($searchTerms)  ? explode(' ', $searchTerms) : $searchTerms;

            $this->where(function(Builder $query) use ($attributes,$searchTerms){

                foreach (array_wrap($attributes) as $attribute) 
                {
                    $query->orWhere(function($query) use ($attribute,$searchTerms){
                        foreach ($searchTerms as $searchTerm) 
                        {
                            $query->where($attribute,'LIKE',"%{$searchTerm}%");
                        }
                    });
                }


            });
            return $this;
        });



       Builder::macro('multipleSearchWithOutRelation',function($attributes, $terms){

       $terms = !is_array($terms)  ? explode(' ', $terms) : $terms;

        $this->where(function($query) use ($attributes, $terms)
            {
                foreach (array_wrap($attributes) as $attribute) 
                {
                    foreach (array_wrap($terms) as $term) 
                    {
                        $query->orWhere($attribute, 'LIKE', "%{$term}%");
                    }
                }
            });
        return $this;
       });
                        
    }
}
