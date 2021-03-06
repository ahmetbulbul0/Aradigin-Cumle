<?php

namespace App\Http\Controllers\Pages\System;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\UserTypes\UserTypesListController;

class UserTypesListPageController extends Controller
{
    public function index($data = NULL)
    {
        $data["page_title"] = "Kullanıcı Tipleri";
        if (!isset($data["data"])) {
            $data["data"] = UserTypesListController::getAllDataOnlyNotDeletedDatas();
        }
        return view("system.pages.user_types_list")->with("data", $data);
    }
    public function form(Request $request)
    {
        $listingType = $request->listingType;
        switch ($listingType) {
            case 'default':
                return redirect(route("kullanici_tipleri"));
                break;
            case 'no09':
                return redirect(route("kullanici_tipleri_no09"));
                break;
            case 'no90':
                return redirect(route("kullanici_tipleri_no90"));
                break;
            case 'nameAZ':
                return redirect(route("kullanici_tipleri_nameAZ"));
                break;
            case 'nameZA':
                return redirect(route("kullanici_tipleri_nameZA"));
                break;
        }
        return $this->index();
    }
    public function no09()
    {
        $data["data"] = UserTypesListController::getAllDataOnlyNotDeletedDatasOrderByAscNo();
        return $this->index($data);
    }
    public function no90()
    {
        $data["data"] = UserTypesListController::getAllDataOnlyNotDeletedDatasOrderByDescNo();
        return $this->index($data);
    }
    public function nameAZ()
    {
        $data["data"] = UserTypesListController::getAllDataOnlyNotDeletedDatasOrderByAscName();
        return $this->index($data);
    }
    public function nameZA()
    {
        $data["data"] = UserTypesListController::getAllDataOnlyNotDeletedDatasOrderByDescName();
        return $this->index($data);
    }
}
