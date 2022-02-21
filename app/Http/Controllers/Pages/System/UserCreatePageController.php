<?php

namespace App\Http\Controllers\Pages\System;

use App\Http\Controllers\Api\Users\UserCreateController;
use App\Http\Controllers\Api\UserSettings\UserSettingCreateController;
use App\Http\Controllers\Api\UserTypes\UserTypesListController;
use Illuminate\Http\Request;
use App\Models\UserTypesModel;
use App\Http\Controllers\Controller;

class UserCreatePageController extends Controller
{
    public function index($data = NULL) {
        $data["page_title"] = "Kullanıcı Ekle";
        $data["userTypes"] = UserTypesListController::getAllOnlyNotDeleted();
        return view("system.pages.user_create")->with("data", $data);
    }

    public function form(Request $request) {
        $data["data"] = [
            "full_name" => $request->fullName,
            "username" => $request->username,
            "password" => $request->password,
            "type" => $request->type
        ];

        $created = UserCreateController::get($data);

        if (isset($created["errors"])) {return $this->index($created);}

        $created["createdDataName"] = "Kullanıcı";

        $created["createdData"] = [
            [
                "column" => "No",
                "value" => $created["createdData"]["no"]
            ],
            [
                "column" => "Tam Adı",
                "value" => $created["createdData"]["full_name"]
            ],
            [
                "column" => "Kullanıcı Adı",
                "value" => $created["createdData"]["username"]
            ],
            [
                "column" => "Parolası",
                "value" => $created["createdData"]["password"]
            ],
            [
                "column" => "Kullanıcı Tipi",
                "value" => $created["createdData"]['type']['name']
            ]
        ];

        return $this->index($created);
    }
}
