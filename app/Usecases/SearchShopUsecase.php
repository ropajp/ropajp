<?php
namespace App\Http\Controllers\Usecases;

use App\Models\Shop;

class SearchShopUsecase
{
    public function __invoke($name = null, $state = null, $city = null, $category = null, $gender_for = null)
    {
        $shops = Shop::with('photos')->get();

        $result = $posts->when(!is_null($name), function ($query) use ($name) {
        return $query->where('shops.name', 'like', "%{$name}%");
    })->when(!is_null($state), function ($query) use ($state) {
        return $query->where('shops.state', 'like', "%{$state}%");
    })->when(!is_null($body), function ($query) use ($body) {
        return $query->where('posts.body', 'like', "%{$body}%");
    })->get();

        return $shops;

    }
}
