<?php

namespace App\Http\Controllers\Api\UserSettings;

use App\Http\Controllers\Controller;
use App\Models\UsersSettingsModel;
use Illuminate\Http\Request;

class UserSettingEditController extends Controller
{
    static function get($data)
    {
        $no = htmlspecialchars($data["data"]["no"]);
        $websiteTheme = htmlspecialchars($data["data"]["website_theme"]);
        $dashboardTheme = htmlspecialchars($data["data"]["dashboard_theme"]);

        $data["data"] = [
            "no" => $no,
            "website_theme" => $websiteTheme,
            "dashboard_theme" => $dashboardTheme
        ];

        return UserSettingEditController::check($data);
    }

    static function check($data)
    {
        $websiteTheme = $data["data"]["website_theme"];
        $dashboardTheme = $data["data"]["dashboard_theme"];

        switch ($websiteTheme) {
            case 'dark':
                break;
            case 'light':
                break;
            default:
                $data["data"]["websiteTheme"] = NULL;
                break;
        }

        switch ($dashboardTheme) {
            case 'dark':
                break;
            case 'light':
                break;
            default:
                $data["data"]["dashboardTheme"] = NULL;
                break;
        }

        return UserSettingEditController::work($data);
    }

    static function work($data)
    {
        $no = $data["data"]["no"];
        $websiteTheme = $data["data"]["website_theme"];
        $dashboardTheme = $data["data"]["dashboard_theme"];

        UsersSettingsModel::where(["is_deleted" => false, "no" => "$no"])->update([
            "website_theme" => $websiteTheme,
            "dashboard_theme" => $dashboardTheme
        ]);

        $data["editedData"] = UserSettingsListController::getFirstDataWithNoOnlyNotDeletedAllRelationships($no);

        return $data;
    }
}