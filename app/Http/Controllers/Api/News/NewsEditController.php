<?php

namespace App\Http\Controllers\Api\News;

use App\Http\Controllers\Api\CategoryGroups\CategoryGroupsListController;
use App\Models\NewsModel;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Tools\LinkUrlGenerator;
use App\Http\Controllers\Api\News\NewsListController;
use App\Http\Controllers\Api\ResourcePlatforms\ResourcePlatformsListController;
use App\Http\Controllers\Api\ResourceUrls\ResourceUrlsCreateController;
use App\Http\Controllers\Api\ResourceUrls\ResourceUrlsListController;

class NewsEditController extends Controller
{
    static function get($data)
    {
        $no = htmlspecialchars($data["data"]["no"]);
        $content = $data["data"]["content"];
        $category = htmlspecialchars($data["data"]["category"]);
        $publishDate = htmlspecialchars($data["data"]["publish_date"]);
        $speDate = htmlspecialchars($data["data"]["spe_date"]);
        $speTime = htmlspecialchars($data["data"]["spe_time"]);
        $resourcePlatform = htmlspecialchars($data["data"]["resource_platform"]);
        $resourceUrl = htmlspecialchars($data["data"]["resource_url"]);

        $category = intval($category);
        $resourcePlatform = intval($resourcePlatform);

        $data["data"] = [
            "no" => $no,
            "content" => $content,
            "category" => $category,
            "publish_date" => $publishDate,
            "spe_date" => $speDate,
            "spe_time" => $speTime,
            "resource_platform" => $resourcePlatform,
            "resource_url" => $resourceUrl
        ];

        return NewsEditController::check($data);
    }
    static function check($data)
    {
        $no = $data["data"]["no"];
        $content = $data["data"]["content"];
        $category = $data["data"]["category"];
        $resourcePlatform = $data["data"]["resource_platform"];
        $resourceUrl = $data["data"]["resource_url"];
        $publishDate = $data["data"]["publish_date"];
        $speDate = $data["data"]["spe_date"];
        $speTime = $data["data"]["spe_time"];

        if (!isset($content) || empty($content)) {
            $data["errors"]["content"] = "????erik Alan?? Bo?? Olamaz";
        }

        if (!isset($category) || empty($category)) {
            $data["errors"]["category"] = "Kategori Alan?? Bo?? Olamaz";
        }

        if (!isset($resourcePlatform) || empty($resourcePlatform)) {
            $data["errors"]["resource_platform"] = "Kaynak Site Alan?? Bo?? Olamaz";
        }

        if (!isset($resourceUrl) || empty($resourceUrl)) {
            $data["errors"]["resource_url"] = "Kaynak Url Alan?? Bo?? Olamaz";
        }

        if (!isset($publishDate) || empty($publishDate)) {
            $data["errors"]["publish_date"] = "Yay??n Tarihi Alan?? Bo?? Olamaz";
        }

        if (isset($content) && !empty($content) && NewsListController::getFirstDataOnlyNotDeletedDatasAllRelationShipsWhereContentWhereNotNo($no, $content)) {
            $data["errors"]["content"] = "[$content] Bu ????erik Daha ??nceden Yaz??lm????, Ba??ka Bir ????erik Metni Ekleyiniz";
        }

        if (isset($category) && !empty($category) && !CategoryGroupsListController::getFirstDataOnlyNotDeletedDatasAllRelationShipsWhereNo($category)) {
            $data["errors"]["category"] = "B??yle Bir Kategori Grubu Yok";
        }

        if (isset($resourcePlatform) && !empty($resourcePlatform) && !ResourcePlatformsListController::getFirstDataOnlyNotDeletedDatasWhereNo($resourcePlatform)) {
            $data["errors"]["resource_platform"] = "B??yle Bir Kaynak Site Yok";
        }

        if ($publishDate == "specialDate") {
            if (!isset($speDate) || empty($speDate)) {
                $data["errors"]["spe_date"] = "Tarih Se?? Alan??nda Tarih Alan?? Zorunludur";
            }
            if (!isset($speTime) || empty($speTime)) {
                $data["errors"]["spe_time"] = "Tarih Se?? Alan??nda Zaman Alan?? Zorunludur";
            }
        }

        switch ($publishDate) {
            case 'now':
                $data["data"]["publish_date"] = time();
                break;
            case 'task':
                $data["data"]["publish_date"] = 0;
                break;
            case 'specialDate':
                $publishDate = $speDate . " " . $speTime;
                $data["data"]["publish_date"] = strtotime($publishDate);
                break;
            default:
                $data["errors"]["publish_date"] = "Ge??ersiz Yay??n Durumu";
                break;
        }

        if (isset($data["errors"])) {
            return $data;
        }

        return NewsEditController::work($data);
    }
    static function work($data)
    {
        $no = $data["data"]["no"];
        $content = $data["data"]["content"];
        $category = $data["data"]["category"];
        $resourcePlatform = $data["data"]["resource_platform"];
        $resourceUrl = $data["data"]["resource_url"];
        $publishDate = $data["data"]["publish_date"];
        $linkUrl = LinkUrlGenerator::single($content, 10);

        if (ResourceUrlsListController::getFirstDataOnlyNotDeletedDatasWhereUrl($resourceUrl)) {
            $resourceUrlNo = ResourceUrlsListController::getFirstDataOnlyNotDeletedDatasWhereUrl($resourceUrl)->no;
        }

        if (!ResourceUrlsListController::getFirstDataOnlyNotDeletedDatasWhereUrl($resourceUrl)) {

            $dataForResourceUrl["data"] = [
                "news_no" => $no,
                "resource_platform" => $resourcePlatform,
                "url" => $resourceUrl
            ];

            $resourceUrlCreate = ResourceUrlsCreateController::get($dataForResourceUrl);

            if ($resourceUrlCreate["errors"]) {
                dd("HATA");
            }

            $resourceUrlNo = $resourceUrlCreate["createdData"]["no"];
        }

        NewsModel::where(["is_deleted" => false, "no" => "$no"])->update([
            "content" => $content,
            "category" => $category,
            "resource_platform" => $resourcePlatform,
            "resource_url" => $resourceUrlNo,
            "publish_date" => $publishDate,
            "link_url" => $linkUrl
        ]);

        $data["editedData"] = NewsListController::getFirstDataOnlyNotDeletedDatasAllRelationShipsWhereNo($no);

        return $data;
    }
}
