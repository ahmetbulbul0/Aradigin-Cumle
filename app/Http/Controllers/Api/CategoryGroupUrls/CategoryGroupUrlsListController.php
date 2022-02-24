<?php

namespace App\Http\Controllers\Api\CategoryGroupUrls;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CategoryGroupUrlsModel;

class CategoryGroupUrlsListController extends Controller
{
    static function getAll()
    {
        return CategoryGroupUrlsModel::get();
    }
    static function getAllOnlyNotDeleted()
    {
        return CategoryGroupUrlsModel::where("is_deleted", false)->get();
    }
    static function getAllOnlyNotDeletedAllRelationShips()
    {
        return CategoryGroupUrlsModel::where("is_deleted", false)->with("groupNo")->get()->toArray();
    }
    static function getFirstDataWithNoOnlyNotDeletedAllRelationShips($no)
    {
        return CategoryGroupUrlsModel::where(["is_deleted" => false, "no" => $no])->with("groupNo")->first()->toArray();
    }
}