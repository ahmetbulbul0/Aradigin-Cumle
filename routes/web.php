<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Pages\Visitor\HomePageController;
use App\Http\Controllers\Pages\Visitor\SignInPageController;
use App\Http\Controllers\Pages\System\NewsEditPageController;
use App\Http\Controllers\Pages\System\UserEditPageController;
use App\Http\Controllers\Pages\Visitor\SignOutPageController;
use App\Http\Controllers\Pages\System\UsersListPageController;
use App\Http\Controllers\Pages\Author\MyNewsEditPageController;
use App\Http\Controllers\Pages\Author\MyNewsListPageController;
use App\Http\Controllers\Pages\Author\NewsCreatePageController;
use App\Http\Controllers\Pages\System\NewsDeletePageController;
use App\Http\Controllers\Pages\System\UserCreatePageController;
use App\Http\Controllers\Pages\System\UserDeletePageController;
use App\Http\Controllers\Pages\System\VisitorBanPageController;
use App\Http\Controllers\Pages\Visitor\NewsDetailPageController;
use App\Http\Controllers\Pages\Author\MyNewsDeletePageController;
use App\Http\Controllers\Pages\Common\WebSiteSetupPageController;
use App\Http\Controllers\Pages\System\CategoryEditPageController;
use App\Http\Controllers\Pages\System\UserTypeEditPageController;
use App\Http\Controllers\Pages\System\VisitorsListPageController;
use App\Http\Controllers\Pages\System\VisitorUnBanPageController;
use App\Http\Controllers\Pages\System\UserTypesListPageController;
use App\Http\Controllers\Pages\Author\AuthorSettingsPageController;
use App\Http\Controllers\Pages\System\CategoriesListPageController;
use App\Http\Controllers\Pages\System\CategoryCreatePageController;
use App\Http\Controllers\Pages\System\CategoryDeletePageController;
use App\Http\Controllers\Pages\System\NewsStatisticsPageController;
use App\Http\Controllers\Pages\System\SystemNewsListPageController;
use App\Http\Controllers\Pages\System\SystemSettingsPageController;
use App\Http\Controllers\Pages\System\UserTypeCreatePageController;
use App\Http\Controllers\Pages\System\UserTypeDeletePageController;
use App\Http\Controllers\Pages\Author\AuthorDashboardPageController;
use App\Http\Controllers\Pages\System\ResourceUrlEditPageController;
use App\Http\Controllers\Pages\System\SystemDashboardPageController;
use App\Http\Controllers\Pages\System\UserSettingEditPageController;
use App\Http\Controllers\Pages\Author\MyNewsStatisticsPageController;
use App\Http\Controllers\Pages\System\CategoryTypeEditPageController;
use App\Http\Controllers\Pages\System\ResourceUrlsListPageController;
use App\Http\Controllers\Pages\System\UserSettingsListPageController;
use App\Http\Controllers\Pages\Visitor\VisitorNewsListPageController;
use App\Http\Controllers\Pages\System\CategoryGroupEditPageController;
use App\Http\Controllers\Pages\System\CategoryTypesListPageController;
use App\Http\Controllers\Pages\System\NewsStatisticTimePageController;
use App\Http\Controllers\Pages\System\ResourceUrlDeletePageController;
use App\Http\Controllers\Pages\System\UserSettingDeletePageController;
use App\Http\Controllers\Pages\System\CategoryGroupsListPageController;
use App\Http\Controllers\Pages\System\CategoryTypeCreatePageController;
use App\Http\Controllers\Pages\System\CategoryTypeDeletePageController;
use App\Http\Controllers\Pages\Author\MyNewsStatisticTimePageController;
use App\Http\Controllers\Pages\System\CategoryGroupCreatePageController;
use App\Http\Controllers\Pages\System\CategoryGroupDeletePageController;
use App\Http\Controllers\Pages\System\NewsStatisticDetailPageController;
use App\Http\Controllers\Pages\System\CategoryGroupUrlEditPageController;
use App\Http\Controllers\Pages\System\ResourcePlatformEditPageController;
use App\Http\Controllers\Pages\Author\MyNewsStatisticDetailPageController;
use App\Http\Controllers\Pages\System\CategoriesSchemePageController;
use App\Http\Controllers\Pages\System\CategoryGroupUrlsListPageController;
use App\Http\Controllers\Pages\System\ResourcePlatformsListPageController;
use App\Http\Controllers\Pages\System\ResourcePlatformCreatePageController;
use App\Http\Controllers\Pages\System\ResourcePlatformDeletePageController;
use App\Http\Controllers\Pages\System\CategoryGroupUrlsDeletePageController;
use App\Http\Controllers\Pages\Visitor\AllNewsListingsCheckPageController;
use App\Http\Controllers\Pages\Visitor\AllNewsReadingsCheckPageController;
use App\Http\Controllers\Pages\Visitor\VisitorChangeWebSiteThemePageController;

Route::prefix("/kurulum")->controller(WebSiteSetupPageController::class)->group(function () {
    Route::get("/asama-1", "stage1")->name("website_setup_stage1")->middleware("isTheWebSiteNotSetup");
    Route::get("/asama-2", "stage2")->name("website_setup_stage2")->middleware("isTheWebSiteNotSetup");
    Route::get("/asama-3", "stage3")->name("website_setup_stage3")->middleware("isTheWebSiteNotSetup");
    Route::get("/asama-4", "stage4")->name("website_setup_stage4")->middleware("isTheWebSiteNotSetup");
    Route::get("/son", "finish")->name("website_setup_finish")->middleware("isTheWebSiteSetup");
});

Route::prefix("/")->middleware(['isTheWebSiteSetup'])->group(function () {
    /* V??S??TOR PAGES */
        Route::middleware(["isItVisitor", "visitorDataCheck", "userDataCheckIfIsUser"])->group(function () {
            // ANASAYFA
                Route::get("/", [HomePageController::class, "index"])->name("anasayfa");
            // HABERLER L??STES??
                Route::prefix("/haberler")->controller(VisitorNewsListPageController::class)->group(function () {
                    Route::get("/{listType}/{page?}", "index")->name("haberler_listesi");
                    Route::get("/yazar/{authorUserName}/{listType}/{page?}", "author")->name("haberler_listesi_yazar");
                    Route::get("/kaynak/{resourcePlatformLinkUrl}/{listType}/{page?}", "resourcePlatform")->name("haberler_listesi_kaynak");
                    Route::get("/kategori/{categoryGroupLinkUrl}/{listType}/{page?}", "category")->name("haberler_listesi_kategori");
                });
            // HABER DETAY
                Route::get("/haber/{newsLinkUrl}", [NewsDetailPageController::class, "index"])->name("haber_detay");
            // YAZAR G??R??????
                Route::prefix("/yazar-girisi")->controller(SignInPageController::class)->middleware("isItNotUser")->group(function () {
                    Route::get("/", "index")->name("yazar_girisi");
                    Route::post("/", "form");
                });
            // Z??YARET???? TEMA DE??????T??R
                Route::post("/ziyaretci-tema-degistir", [VisitorChangeWebSiteThemePageController::class, "form"])->name("visitor_website_theme_change");
            });
        // ??IKI?? YAP
            Route::get("/cikis-yap", [SignOutPageController::class, "index"])->name("cikis_yap");
    /* AUTHOR PAGES */
        Route::prefix("/yazar-paneli")->middleware(['isItAuthor', 'userDataCheck'])->group(function () {
            // YAZAR PANEL?? ANA PANEL
                Route::get("/", [AuthorDashboardPageController::class, "index"])->name("yazar_paneli_anapanel");
            // HABER EKLE
                Route::prefix("/haber/ekle")->controller(NewsCreatePageController::class)->group(function () {
                    Route::get("/", "index")->name("haber_ekle");
                    Route::post("/", "form");
                });
            // HABERLER??M
                Route::prefix("/haberlerim")->group(function () {
                    // HABERLER??M L??STES?? "TODO"
                        Route::get("/", [MyNewsListPageController::class, "index"])->name("haberlerim");
                    // HABERLER??MDEN HABER D??ZENLE
                    Route::prefix("/d??zenle/{no}")->controller(MyNewsEditPageController::class)->group(function () {
                        Route::get("/", "index")->name("haberlerim_d??zenle");
                        Route::post("/", "form");
                    });
                    // HABERLER??MDEN HABER S??L "TODO"
                        Route::prefix("/sil/{no}")->controller(MyNewsDeletePageController::class)->group(function () {
                            Route::get("/", "index")->name("haberlerim_sil");
                            Route::post("/", "form");
                        });
                });
            // HABERLER??M ??STAT??ST??KLER?? "TODO"
                Route::prefix("/haber/istatistiklerim")->group(function () {
                    // HABERLER??M ??STAT??ST??KLER?? "TODO"
                        Route::get("/", [MyNewsStatisticsPageController::class, "index"])->name("haber_istatistiklerim");
                    // HABERLER??M ??STAT??ST??KLER?? ZAMANA G??RE "TODO"
                        Route::get("/zaman/{timeType}/{listType}", [MyNewsStatisticTimePageController::class, "index"])->name("haber_istatistiklerim_zaman");
                    // HABERLER??M ??STAT??ST??KLER?? DETAY "TODO"
                        Route::get("/detay/{newsNo}", [MyNewsStatisticDetailPageController::class, "index"])->name("haber_istatistiklerim_detay");
                });
            // YAZAR PANEL?? AYARLAR
                Route::prefix("/ayarlar")->controller(AuthorSettingsPageController::class)->group(function () {
                    // YAZAR PANEL?? AYARLAR PROF??L??M
                    Route::prefix("/profilim")->group(function () {
                        Route::get("/", "myAccount")->name("yazar_paneli_ayarlar_profilim");
                        Route::post("/", "myAccountForm");
                    });
                    // YAZAR PANEL?? AYARLAR TEMA
                        Route::prefix("/tema")->group(function () {
                            Route::get("/", "theme")->name("yazar_paneli_ayarlar_tema");
                            Route::post("", "themeForm");
                            Route::post("/panel", "dashboardThemeChange")->name("author_user_fast_dashboard_theme_change");
                            Route::post("/website", "websiteThemeChange")->name("author_user_fast_website_theme_change");;
                        });
                });
        });
    /* SYSTEM PAGES */
        Route::prefix("/sistem-paneli")->middleware(["isItSystem", "userDataCheck"])->group(function () {
            // S??STEM PANEL?? ANA PANEL
                Route::get("/", [SystemDashboardPageController::class, "index"])->name("sistem_paneli_anapanel");
            // KULLANICI T??P?? ????LEMLER??
                Route::prefix("/kullanici-tipi")->group(function () {
                    // KULLANICI T??P?? EKLE
                        Route::prefix("/ekle")->controller(UserTypeCreatePageController::class)->group(function () {
                            Route::get("/", "index")->name("kullanici_tipi_ekle");
                            Route::post("/", "form");
                        });
                    // KULLANICI T??P?? D??ZENLE
                        Route::get("/d??zenle/{no}", [UserTypeEditPageController::class, "index"])->name("kullanici_tipi_d??zenle");
                    // KULLANICI T??P?? S??L
                        Route::get("/sil/{no}", [UserTypeDeletePageController::class, "index"])->name("kullanici_tipi_sil");
                });
            // KULLANICI T??PLER?? L??STES??
                Route::prefix("/kullanici-tipleri")->controller(UserTypesListPageController::class)->group(function () {
                    Route::get("/", "index")->name("kullanici_tipleri");
                    Route::get("/no09", "no09")->name("kullanici_tipleri_no09");
                    Route::get("/no90", "no90")->name("kullanici_tipleri_no90");
                    Route::get("/nameAZ", "nameAZ")->name("kullanici_tipleri_nameAZ");
                    Route::get("/nameZA", "nameZA")->name("kullanici_tipleri_nameZA");
                });
            // KULLANICI ????LEMLER??
                Route::prefix("/kullanici")->group(function () {
                    // KULLANICI EKLE
                        Route::prefix("/ekle")->controller(UserCreatePageController::class)->group(function () {
                            Route::get("/", "index")->name("kullanici_ekle");
                            Route::post("/", "form");
                        });
                    // KULLANICI D??ZENLE
                        Route::get("/d??zenle/{no}", [UserEditPageController::class, "index"])->name("kullanici_d??zenle");
                    // KULLANICI S??L
                        Route::get("/sil/{no}", [UserDeletePageController::class, "index"])->name("kullanici_sil");
                });
            // KULLANICILAR L??STES??
                Route::prefix("/kullanicilar")->controller(UsersListPageController::class)->group(function () {
                    Route::get("/", "index")->name("kullanicilar");
                    Route::get("/no09", "no09")->name("kullanicilar_no09");
                    Route::get("/no90", "no90")->name("kullanicilar_no90");
                    Route::get("/fullNameAZ", "fullNameAZ")->name("kullanicilar_fullNameAZ");
                    Route::get("/fullNameZA", "fullNameZA")->name("kullanicilar_fullNameZA");
                    Route::get("/usernameAZ", "usernameAZ")->name("kullanicilar_usernameAZ");
                    Route::get("/usernameZA", "usernameZA")->name("kullanicilar_usernameZA");
                    Route::get("/typeAZ", "typeAZ")->name("kullanicilar_typeAZ");
                    Route::get("/typeZA", "typeZA")->name("kullanicilar_typeZA");
                });
            // KULLANICI AYARI ????LEMLER??
                Route::prefix("/kullanici-ayari")->group(function () {
                    // KULLANICI AYARI D??ZENLE
                        Route::get("/d??zenle/{no}", [UserSettingEditPageController::class, "index"])->name("kullanici_ayari_d??zenle");
                    // KULLANICI AYARI S??L
                        Route::get("/sil/{no}", [UserSettingDeletePageController::class, "index"])->name("kullanici_ayari_sil");
                });
            // KULLANICI AYARLARI L??STES??
                Route::prefix("/kullanici-ayarlari")->controller(UserSettingsListPageController::class)->group(function () {
                    Route::prefix("/")->group(function () {
                        Route::get("/", "index")->name("kullanici_ayarlari");
                        Route::post("/", "form");
                    });
                    Route::prefix("/no09")->group(function () {
                        Route::get("/", "no09")->name("kullanici_ayarlari_no09");
                        Route::post("/", "form");
                    });
                    Route::prefix("/no90")->group(function () {
                        Route::get("/", "no90")->name("kullanici_ayarlari_no90");
                        Route::post("/", "form");
                    });
                    Route::prefix("/userAZ")->group(function () {
                        Route::get("/", "userAZ")->name("kullanici_ayarlari_userAZ");
                        Route::post("/", "form");
                    });
                    Route::prefix("/userZA")->group(function () {
                        Route::get("/", "userZA")->name("kullanici_ayarlari_userZA");
                        Route::post("/", "form");
                    });
                    Route::prefix("/webSiteThemeAZ")->group(function () {
                        Route::get("/", "webSiteThemeAZ")->name("kullanici_ayarlari_webSiteThemeAZ");
                        Route::post("/", "form");
                    });
                    Route::prefix("/webSiteThemeZA")->group(function () {
                        Route::get("/", "webSiteThemeZA")->name("kullanici_ayarlari_webSiteThemeZA");
                        Route::post("/", "form");
                    });
                    Route::prefix("/dashboardThemeAZ")->group(function () {
                        Route::get("/", "dashboardThemeAZ")->name("kullanici_ayarlari_dashboardThemeAZ");
                        Route::post("/", "form");
                    });
                    Route::prefix("/dashboardThemeZA")->group(function () {
                        Route::get("/", "dashboardThemeZA")->name("kullanici_ayarlari_dashboardThemeZA");
                        Route::post("/", "form");
                    });
                });
            // KAYNAK S??TE ????LEMLER??
                Route::prefix("/kaynak-site")->group(function () {
                    // KAYNAK S??TE EKLE
                        Route::prefix("/ekle")->controller(ResourcePlatformCreatePageController::class)->group(function () {
                            Route::get("/", "index")->name("kaynak_site_ekle");
                            Route::post("/", "form");
                        });
                    // KAYNAK S??TE D??ZENLE
                        Route::get("/d??zenle/{no}", [ResourcePlatformEditPageController::class, "index"])->name("kaynak_site_d??zenle");
                    // KAYNAK S??TE S??L
                        Route::get("/sil/{no}", [ResourcePlatformDeletePageController::class, "index"])->name("kaynak_site_sil");
                });
            // KAYNAK S??TELER L??STES??
                Route::prefix("/kaynak-siteler")->controller(ResourcePlatformsListPageController::class)->group(function () {
                    Route::get("/", "index")->name("kaynak_siteler");
                    Route::get("/no09", "no09")->name("kaynak_siteler_no09");
                    Route::get("/no90", "no90")->name("kaynak_siteler_no90");
                    Route::get("/nameAZ", "nameAZ")->name("kaynak_siteler_nameAZ");
                    Route::get("/nameZA", "nameZA")->name("kaynak_siteler_nameZA");
                    Route::get("/websiteLinkAZ", "websiteLinkAZ")->name("kaynak_siteler_websiteLinkAZ");
                    Route::get("/websiteLinkZA", "websiteLinkZA")->name("kaynak_siteler_websiteLinkZA");
                    Route::get("/linkUrlAZ", "linkUrlAZ")->name("kaynak_siteler_linkUrlAZ");
                    Route::get("/linkUrlZA", "linkUrlZA")->name("kaynak_siteler_linkUrlZA");
                });
            // KAYNAK L??NKLER?? ????LEMLER??
                Route::prefix("/kaynak-linki")->group(function () {
                    // KAYNAK L??NK?? S??L
                        Route::get("/sil/{no}", [ResourceUrlDeletePageController::class, "index"])->name("kaynak_linki_sil");
                    // KAYNAK L??NK?? D??ZENLE
                        Route::get("/d??zenle/{no}", [ResourceUrlEditPageController::class, "index"])->name("kaynak_linki_d??zenle");
                });
            // KAYNAK L??NKLER?? L??STES??
                Route::prefix("/kaynak-linkleri")->controller(ResourceUrlsListPageController::class)->group(function () {
                    Route::prefix("/")->group(function () {
                        Route::get("/", "index")->name("kaynak_linkler");
                        Route::post("/", "form");
                    });
                    Route::prefix("/no09")->group(function () {
                        Route::get("/", "no09")->name("kaynak_linkler_no09");
                        Route::post("/", "form");
                    });
                    Route::prefix("/no90")->group(function () {
                        Route::get("/", "no90")->name("kaynak_linkler_no90");
                        Route::post("/", "form");
                    });
                    Route::prefix("/newsAZ")->group(function () {
                        Route::get("/", "newsAZ")->name("kaynak_linkler_newsAZ");
                        Route::post("/", "form");
                    });
                    Route::prefix("/newsZA")->group(function () {
                        Route::get("/", "newsZA")->name("kaynak_linkler_newsZA");
                        Route::post("/", "form");
                    });
                    Route::prefix("/resourcePlatformAZ")->group(function () {
                        Route::get("/", "resourcePlatformAZ")->name("kaynak_linkler_resourcePlatformAZ");
                        Route::post("/", "form");
                    });
                    Route::prefix("/resourcePlatformZA")->group(function () {
                        Route::get("/", "resourcePlatformZA")->name("kaynak_linkler_resourcePlatformZA");
                        Route::post("/", "form");
                    });
                    Route::prefix("/urlAZ")->group(function () {
                        Route::get("/", "urlAZ")->name("kaynak_linkler_urlAZ");
                        Route::post("/", "form");
                    });
                    Route::prefix("/urlZA")->group(function () {
                        Route::get("/", "urlZA")->name("kaynak_linkler_urlZA");
                        Route::post("/", "form");
                    });
                });
            // KAYNAK T??PLER?? ????LEMLER??
                Route::prefix("/kategori-tipi")->group(function () {
                    // KATEGOR?? T??P?? EKLE
                        Route::prefix("/ekle")->controller(CategoryTypeCreatePageController::class)->group(function () {
                            Route::get("/", "index")->name("kategori_tipi_ekle");
                            Route::post("/", "form");
                        });
                    // KATEGOR?? T??P?? D??ZENLE
                        Route::get("/d??zenle/{no}", [CategoryTypeEditPageController::class, "index"])->name("kategori_tipi_d??zenle");
                    // KATEGOR?? T??P?? S??L
                        Route::get("/sil/{no}", [CategoryTypeDeletePageController::class, "index"])->name("kategori_tipi_sil");
                });
            // KATEGOR?? T??PLER?? L??STES??
                Route::prefix("/kategori-tipleri")->controller(CategoryTypesListPageController::class)->group(function () {
                    Route::get("/", "index")->name("kategori_tipleri");
                    Route::get("/no09", "no09")->name("kategori_tipleri_no09");
                    Route::get("/no90", "no90")->name("kategori_tipleri_no90");
                    Route::get("/nameAZ", "nameAZ")->name("kategori_tipleri_nameAZ");
                    Route::get("/nameZA", "nameZA")->name("kategori_tipleri_nameZA");
                });
            // KATEGOR?? ????LEMLER??
                Route::prefix("/kategori")->group(function () {
                    // KATEGOR?? EKLE
                        Route::prefix("/ekle")->controller(CategoryCreatePageController::class)->group(function () {
                            Route::get("/", "index")->name("kategori_ekle");
                            Route::post("/", "form");
                        });
                    // KATEGOR?? D??ZENLE
                        Route::get("/d??zenle/{no}", [CategoryEditPageController::class, "index"])->name("kategori_d??zenle");
                    // KATEGOR?? S??L
                        Route::get("/sil/{no}", [CategoryDeletePageController::class, "index"])->name("kategori_sil");
                });
            // KATEGOR??LER L??STES??
                Route::prefix("/kategoriler")->controller(CategoriesListPageController::class)->group(function () {
                    Route::get("/", "index")->name("kategoriler");
                    Route::get("/no09", "no09")->name("kategoriler_no09");
                    Route::get("/no90", "no90")->name("kategoriler_no90");
                    Route::get("/nameAZ", "nameAZ")->name("kategoriler_nameAZ");
                    Route::get("/nameZA", "nameZA")->name("kategoriler_nameZA");
                    Route::get("/typeAZ", "typeAZ")->name("kategoriler_typeAZ");
                    Route::get("/typeZA", "typeZA")->name("kategoriler_typeZA");
                    Route::get("/mainCategoryAZ", "mainCategoryAZ")->name("kategoriler_mainCategoryAZ");
                    Route::get("/mainCategoryZA", "mainCategoryZA")->name("kategoriler_mainCategoryZA");
                    Route::get("/linkUrlAZ", "linkUrlAZ")->name("kategoriler_linkUrlAZ");
                    Route::get("/linkUrlZA", "linkUrlZA")->name("kategoriler_linkUrlZA");
                });
            // KATEGOR?? A??ACI
                Route::get("/kategoriler-semasi", [CategoriesSchemePageController::class, "index"])->name("kategoriler_semasi");
            // KATEGOR?? GRUPLARI ????LEMLER??
                Route::prefix("/kategori-grubu")->group(function () {
                    // KATEGOR?? GRUBU EKLE
                        Route::prefix("/ekle")->controller(CategoryGroupCreatePageController::class)->group(function () {
                            Route::get("/", "index")->name("kategori_grubu_ekle");
                            Route::post("/", "form");
                        });
                    // KATEGOR?? GRUBU D??ZENLE
                        Route::get("/d??zenle/{no}", [CategoryGroupEditPageController::class, "index"])->name("kategori_grubu_d??zenle");
                    // KATEGOR?? GRUBU S??L
                        Route::get("/sil/{no}", [CategoryGroupDeletePageController::class, "index"])->name("kategori_grubu_sil");
                });
            // KATEGOR?? GRUPLARI L??STES??
                Route::prefix("/kategori-gruplari")->controller(CategoryGroupsListPageController::class)->group(function () {
                    Route::get("/", "index")->name("kategori_gruplari");
                    Route::get("/no09", "no09")->name("kategori_gruplari_no09");
                    Route::get("/no90", "no90")->name("kategori_gruplari_no90");
                    Route::get("/mainAZ", "mainAZ")->name("kategori_gruplari_mainAZ");
                    Route::get("/mainZA", "mainZA")->name("kategori_gruplari_mainZA");
                    Route::get("/sub1AZ", "sub1AZ")->name("kategori_gruplari_sub1AZ");
                    Route::get("/sub1ZA", "sub1ZA")->name("kategori_gruplari_sub1ZA");
                    Route::get("/sub2AZ", "sub2AZ")->name("kategori_gruplari_sub2AZ");
                    Route::get("/sub2ZA", "sub2ZA")->name("kategori_gruplari_sub2ZA");
                    Route::get("/sub3AZ", "sub3AZ")->name("kategori_gruplari_sub3AZ");
                    Route::get("/sub3ZA", "sub3ZA")->name("kategori_gruplari_sub3ZA");
                    Route::get("/sub4AZ", "sub4AZ")->name("kategori_gruplari_sub4AZ");
                    Route::get("/sub4ZA", "sub4ZA")->name("kategori_gruplari_sub4ZA");
                    Route::get("/sub5AZ", "sub5AZ")->name("kategori_gruplari_sub5AZ");
                    Route::get("/sub5ZA", "sub5ZA")->name("kategori_gruplari_sub5ZA");
                    Route::get("/linkUrlAZ", "linkUrlAZ")->name("kategori_gruplari_linkUrlAZ");
                    Route::get("/linkUrlZA", "linkUrlZA")->name("kategori_gruplari_linkUrlZA");
                });
            // KATEGOR?? GRUBU L??NK MET??NLER?? ????LEMLER??
                Route::prefix("/kategori-grubu-link-metni")->group(function () {
                    // KATEGOR?? GRUBU L??NK METN?? D??ZENLE
                        Route::get("/d??zenle/{no}", [CategoryGroupUrlEditPageController::class, "index"])->name("kategori_grubu_linki_d??zenle");
                    // KATEGOR?? GRUBU L??NK METN?? S??L
                        Route::get("/sil/{no}", [CategoryGroupUrlsDeletePageController::class, "index"])->name("kategori_grubu_linki_sil");
                });
            // KATEGOR?? GRUBU L??NK MET??NLER?? L??STES??
                Route::prefix("/kategori-grubu-link-metinleri")->controller(CategoryGroupUrlsListPageController::class)->group(function () {
                    Route::prefix("/")->group(function () {
                        Route::get("/", "index")->name("kategori_grubu_linkleri");
                        Route::post("/", "form");
                    });
                    Route::prefix("/no09")->group(function () {
                        Route::get("/", "no09")->name("kategori_grubu_linkleri_no09");
                        Route::post("/", "form");
                    });
                    Route::prefix("/no90")->group(function () {
                        Route::get("/", "no90")->name("kategori_grubu_linkleri_no90");
                        Route::post("/", "form");
                    });
                    Route::prefix("/categoryGroupAZ")->group(function () {
                        Route::get("/", "categoryGroupAZ")->name("kategori_grubu_linkleri_categoryGroupAZ");
                        Route::post("/", "form");
                    });
                    Route::prefix("/categoryGroupZA")->group(function () {
                        Route::get("/", "categoryGroupZA")->name("kategori_grubu_linkleri_categoryGroupZA");
                        Route::post("/", "form");
                    });
                    Route::prefix("/linkUrlAZ")->group(function () {
                        Route::get("/", "linkUrlAZ")->name("kategori_grubu_linkleri_linkUrlAZ");
                        Route::post("/", "form");
                    });
                    Route::prefix("/linkUrlZA")->group(function () {
                        Route::get("/", "linkUrlZA")->name("kategori_grubu_linkleri_linkUrlZA");
                        Route::post("/", "form");
                    });
                });
            // HABER ????LEMLER??
                Route::prefix("/haber")->group(function () {
                    // HABER D??ZENLE
                        Route::get("/d??zenle/{no}", [NewsEditPageController::class, "index"])->name("haber_d??zenle");
                    // HABER S??L
                        Route::get("/sil/{no}", [NewsDeletePageController::class, "index"])->name("haber_sil");
                });
            // HABERLER L??STES??
                Route::prefix("/haberler")->controller(SystemNewsListPageController::class)->group(function () {
                    Route::get("/", "index")->name("haberler");
                    Route::get("/no09", "no09")->name("haberler_no09");
                    Route::get("/no90", "no90")->name("haberler_no90");
                    Route::get("/contentAZ", "contentAZ")->name("haberler_contentAZ");
                    Route::get("/contentZA", "contentZA")->name("haberler_contentZA");
                    Route::get("/authorAZ", "authorAZ")->name("haberler_authorAZ");
                    Route::get("/authorZA", "authorZA")->name("haberler_authorZA");
                    Route::get("/categoryAZ", "categoryAZ")->name("haberler_categoryAZ");
                    Route::get("/categoryZA", "categoryZA")->name("haberler_categoryZA");
                    Route::get("/resourcePlatformAZ", "resourcePlatformAZ")->name("haberler_resourcePlatformAZ");
                    Route::get("/resourcePlatformZA", "resourcePlatformZA")->name("haberler_resourcePlatformZA");
                    Route::get("/publishDateAZ", "publishDateAZ")->name("haberler_publishDateAZ");
                    Route::get("/publishDateZA", "publishDateZA")->name("haberler_publishDateZA");
                    Route::get("/writeTimeAZ", "writeTimeAZ")->name("haberler_writeTimeAZ");
                    Route::get("/writeTimeZA", "writeTimeZA")->name("haberler_writeTimeZA");
                });
            // Z??YARET????LER L??STES??
                Route::prefix("/ziyaretciler")->controller(VisitorsListPageController::class)->group(function () {
                    Route::prefix("/")->group(function () {
                        Route::get("/", "index")->name("ziyaretciler");
                        Route::post("/", "form");
                    });
                    Route::prefix("/no09")->group(function () {
                        Route::get("/", "no09")->name("ziyaretciler_no09");
                        Route::post("/", "form");
                    });
                    Route::prefix("/no90")->group(function () {
                        Route::get("/", "no90")->name("ziyaretciler_no90");
                        Route::post("/", "form");
                    });
                    Route::prefix("/ip09")->group(function () {
                        Route::get("/", "ip09")->name("ziyaretciler_ip09");
                        Route::post("/", "form");
                    });
                    Route::prefix("/ip90")->group(function () {
                        Route::get("/", "ip90")->name("ziyaretciler_ip90");
                        Route::post("/", "form");
                    });
                    Route::prefix("/browserAZ")->group(function () {
                        Route::get("/", "browserAZ")->name("ziyaretciler_browserAZ");
                        Route::post("/", "form");
                    });
                    Route::prefix("/browserZA")->group(function () {
                        Route::get("/", "browserZA")->name("ziyaretciler_browserZA");
                        Route::post("/", "form");
                    });
                    Route::prefix("/lastLoginTimeAZ")->group(function () {
                        Route::get("/", "lastLoginTimeAZ")->name("ziyaretciler_lastLoginTimeAZ");
                        Route::post("/", "form");
                    });
                    Route::prefix("/lastLoginTimeZA")->group(function () {
                        Route::get("/", "lastLoginTimeZA")->name("ziyaretciler_lastLoginTimeZA");
                        Route::post("/", "form");
                    });
                    Route::prefix("/webSiteThemeAZ")->group(function () {
                        Route::get("/", "webSiteThemeAZ")->name("ziyaretciler_webSiteThemeAZ");
                        Route::post("/", "form");
                    });
                    Route::prefix("/webSiteThemeZA")->group(function () {
                        Route::get("/", "webSiteThemeZA")->name("ziyaretciler_webSiteThemeZA");
                        Route::post("/", "form");
                    });
                });
            // Z??YARET???? YASAKLA
                Route::prefix("/ziyaretci/yasakla/{no}")->controller(VisitorBanPageController::class)->group(function () {
                    Route::get("/", "index")->name("ziyaretci_yasakla");
                    Route::post("/", "form");
                });
            // Z??YARET???? YASAKLA
                Route::prefix("/ziyaretci/yasak-kaldir/{no}")->controller(VisitorUnBanPageController::class)->group(function () {
                    Route::get("/", "index")->name("ziyaretci_yasak_kaldir");
                    Route::post("/", "form");
                });
            // HABER ??STAT??ST??KLER?? "TODO"
                Route::prefix("/haberler/istatistikleri")->group(function () {
                    // HABER ??STAT??ST??KLER?? "TODO"
                        Route::get("/", [NewsStatisticsPageController::class, "index"])->name("haber_istatistikleri");
                    // HABER ??STAT??ST??KLER?? ZAMANA G??RE "TODO"
                        Route::get("/zaman", [NewsStatisticTimePageController::class, "index"]);
                    // HABER ??STAT??ST??KLER?? DETAY "TODO"
                        Route::get("/detay/{no}", [NewsStatisticDetailPageController::class, "index"])->name("haber_istatistikleri_detay");
                });
            // S??STEM PANEL?? AYARLAR
                Route::prefix("/ayarlar")->controller(SystemSettingsPageController::class)->group(function () {
                    // YAZAR PANEL?? AYARLAR
                        Route::prefix("/ayarlar")->controller(SystemSettingsPageController::class)->group(function () {
                            // S??STEM PANEL?? AYARLAR SAB??TLER
                                Route::prefix("/sabitler")->group(function () {
                                    Route::get("/", "constants")->name("ayarlar_sabitler");
                                    Route::post("/", "constantsForm");
                                });
                            // S??STEM PANEL?? AYARLAR PROF??L??M
                                Route::prefix("/profilim")->group(function () {
                                    Route::get("/", "myAccount")->name("sistem_paneli_ayarlar_profilim");
                                    Route::post("/", "myAccountForm");
                                });
                            // S??STEM PANEL?? AYARLAR TEMA
                                Route::prefix("/tema")->group(function () {
                                    Route::get("/", "theme")->name("sistem_paneli_ayarlar_tema");
                                    Route::post("", "themeForm");
                                    Route::post("/panel", "dashboardThemeChange")->name("system_user_fast_dashboard_theme_change");
                                    Route::post("/website", "websiteThemeChange")->name("system_user_fast_website_theme_change");;
                                });
                        });


                    // YAZAR PANEL?? AYARLAR SAB??TLER

                });
        });
    // FORM
        /* AUTHOR PAGES */
            // HABER EKLE
                Route::post("/yazar-paneli/haber/ekle", [NewsCreatePageController::class, "form"]);
        /* SYSTEM PAGES */
            // KULLANICI T??PLER?? L??STES??
                Route::post("/sistem-paneli/kullanici-tipleri/", [UserTypesListPageController::class, "form"]);
                Route::post("/sistem-paneli/kullanici-tipleri/no09", [UserTypesListPageController::class, "form"]);
                Route::post("/sistem-paneli/kullanici-tipleri/no90", [UserTypesListPageController::class, "form"]);
                Route::post("/sistem-paneli/kullanici-tipleri/nameAZ", [UserTypesListPageController::class, "form"]);
                Route::post("/sistem-paneli/kullanici-tipleri/nameZA", [UserTypesListPageController::class, "form"]);
            // KULLANICI T??P?? D??ZENLE
                Route::post("/sistem-paneli/kullanici-tipi/d??zenle/{no}", [UserTypeEditPageController::class, "form"]);
            // KULLANICI T??P?? S??L
                Route::post("/sistem-paneli/kullanici-tipi/sil/{no}", [UserTypeDeletePageController::class, "form"]);
            // KULLANICILAR L??STES??
                Route::post("/sistem-paneli/kullanicilar/", [UsersListPageController::class, "form"]);
                Route::post("/sistem-paneli/kullanicilar/no09", [UsersListPageController::class, "form"]);
                Route::post("/sistem-paneli/kullanicilar/no90", [UsersListPageController::class, "form"]);
                Route::post("/sistem-paneli/kullanicilar/fullNameAZ", [UsersListPageController::class, "form"]);
                Route::post("/sistem-paneli/kullanicilar/fullNameZA", [UsersListPageController::class, "form"]);
                Route::post("/sistem-paneli/kullanicilar/usernameAZ", [UsersListPageController::class, "form"]);
                Route::post("/sistem-paneli/kullanicilar/usernameZA", [UsersListPageController::class, "form"]);
                Route::post("/sistem-paneli/kullanicilar/typeAZ", [UsersListPageController::class, "form"]);
                Route::post("/sistem-paneli/kullanicilar/typeZA", [UsersListPageController::class, "form"]);
            // KULLANICI D??ZENLE
                Route::post("/sistem-paneli/kullanici/d??zenle/{no}", [UserEditPageController::class, "form"]);
            // KULLANICI S??L
                Route::post("/sistem-paneli/kullanici/sil/{no}", [UserDeletePageController::class, "form"]);
            // KAYNAK S??TELER
                Route::post("/sistem-paneli/kaynak-siteler/", [ResourcePlatformsListPageController::class, "form"]);
                Route::post("/sistem-paneli/kaynak-siteler/no09", [ResourcePlatformsListPageController::class, "form"]);
                Route::post("/sistem-paneli/kaynak-siteler/no90", [ResourcePlatformsListPageController::class, "form"]);
                Route::post("/sistem-paneli/kaynak-siteler/nameAZ", [ResourcePlatformsListPageController::class, "form"]);
                Route::post("/sistem-paneli/kaynak-siteler/nameZA", [ResourcePlatformsListPageController::class, "form"]);
                Route::post("/sistem-paneli/kaynak-siteler/websiteLinkAZ", [ResourcePlatformsListPageController::class, "form"]);
                Route::post("/sistem-paneli/kaynak-siteler/websiteLinkZA", [ResourcePlatformsListPageController::class, "form"]);
                Route::post("/sistem-paneli/kaynak-siteler/linkUrlAZ", [ResourcePlatformsListPageController::class, "form"]);
                Route::post("/sistem-paneli/kaynak-siteler/linkUrlZA", [ResourcePlatformsListPageController::class, "form"]);
            // KAYNAK S??TE D??ZENLE
                Route::post("/sistem-paneli/kaynak-site/d??zenle/{no}", [ResourcePlatformEditPageController::class, "form"]);
            // KAYNAK S??TE S??L
                Route::post("/sistem-paneli/kaynak-site/sil/{no}", [ResourcePlatformDeletePageController::class, "form"]);
            // KATEGOR?? T??P?? EKLE
                Route::post("/sistem-paneli/kategori-tipi/ekle", [CategoryTypeCreatePageController::class, "form"]);
            // KATEGOR?? T??PLER?? L??STES??
                Route::post("/sistem-paneli/kategori-tipleri", [CategoryTypesListPageController::class, "form"]);
                Route::post("/sistem-paneli/kategori-tipleri/no09", [CategoryTypesListPageController::class, "form"]);
                Route::post("/sistem-paneli/kategori-tipleri/no90", [CategoryTypesListPageController::class, "form"]);
                Route::post("/sistem-paneli/kategori-tipleri/nameAZ", [CategoryTypesListPageController::class, "form"]);
                Route::post("/sistem-paneli/kategori-tipleri/nameZA", [CategoryTypesListPageController::class, "form"]);
            // KATEGOR?? T??P?? D??ZENLE
                Route::post("/sistem-paneli/kategori-tipi/d??zenle/{no}", [CategoryTypeEditPageController::class, "form"]);
            // KATEGOR?? T??P?? S??L
                Route::post("/sistem-paneli/kategori-tipi/sil/{no}", [CategoryTypeDeletePageController::class, "form"]);
            // KATEGOR?? D??ZENLE
                Route::post("/sistem-paneli/kategori/d??zenle/{no}", [CategoryEditPageController::class, "form"]);
            // KATEGOR??LER
                Route::post("/sistem-paneli/kategoriler", [CategoriesListPageController::class, "form"]);
                Route::post("/sistem-paneli/kategoriler/no09", [CategoriesListPageController::class, "form"]);
                Route::post("/sistem-paneli/kategoriler/no90", [CategoriesListPageController::class, "form"]);
                Route::post("/sistem-paneli/kategoriler/nameAZ", [CategoriesListPageController::class, "form"]);
                Route::post("/sistem-paneli/kategoriler/nameZA", [CategoriesListPageController::class, "form"]);
                Route::post("/sistem-paneli/kategoriler/typeAZ", [CategoriesListPageController::class, "form"]);
                Route::post("/sistem-paneli/kategoriler/typeZA", [CategoriesListPageController::class, "form"]);
                Route::post("/sistem-paneli/kategoriler/mainCategoryAZ", [CategoriesListPageController::class, "form"]);
                Route::post("/sistem-paneli/kategoriler/mainCategoryZA", [CategoriesListPageController::class, "form"]);
                Route::post("/sistem-paneli/kategoriler/linkUrlAZ", [CategoriesListPageController::class, "form"]);
                Route::post("/sistem-paneli/kategoriler/linkUrlZA", [CategoriesListPageController::class, "form"]);
            // KATEGOR?? S??L
                Route::post("/sistem-paneli/kategori/sil/{no}", [CategoryDeletePageController::class, "form"]);
            // KATEGOR?? GRUBU EKLE
                Route::post("/sistem-paneli/kategori-grubu/ekle", [CategoryGroupCreatePageController::class, "form"]);
            // KATEGOR?? GRUPLARI
                Route::post("/sistem-paneli/kategori-gruplari/", [CategoryGroupsListPageController::class, "form"]);
                Route::post("/sistem-paneli/kategori-gruplari/no09", [CategoryGroupsListPageController::class, "form"]);
                Route::post("/sistem-paneli/kategori-gruplari/no90", [CategoryGroupsListPageController::class, "form"]);
                Route::post("/sistem-paneli/kategori-gruplari/mainAZ", [CategoryGroupsListPageController::class, "form"]);
                Route::post("/sistem-paneli/kategori-gruplari/mainZA", [CategoryGroupsListPageController::class, "form"]);
                Route::post("/sistem-paneli/kategori-gruplari/sub1AZ", [CategoryGroupsListPageController::class, "form"]);
                Route::post("/sistem-paneli/kategori-gruplari/sub1ZA", [CategoryGroupsListPageController::class, "form"]);
                Route::post("/sistem-paneli/kategori-gruplari/sub2AZ", [CategoryGroupsListPageController::class, "form"]);
                Route::post("/sistem-paneli/kategori-gruplari/sub2ZA", [CategoryGroupsListPageController::class, "form"]);
                Route::post("/sistem-paneli/kategori-gruplari/sub3AZ", [CategoryGroupsListPageController::class, "form"]);
                Route::post("/sistem-paneli/kategori-gruplari/sub3ZA", [CategoryGroupsListPageController::class, "form"]);
                Route::post("/sistem-paneli/kategori-gruplari/sub4AZ", [CategoryGroupsListPageController::class, "form"]);
                Route::post("/sistem-paneli/kategori-gruplari/sub4ZA", [CategoryGroupsListPageController::class, "form"]);
                Route::post("/sistem-paneli/kategori-gruplari/sub5AZ", [CategoryGroupsListPageController::class, "form"]);
                Route::post("/sistem-paneli/kategori-gruplari/sub5ZA", [CategoryGroupsListPageController::class, "form"]);
                Route::post("/sistem-paneli/kategori-gruplari/linkUrlAZ", [CategoryGroupsListPageController::class, "form"]);
                Route::post("/sistem-paneli/kategori-gruplari/linkUrlZA", [CategoryGroupsListPageController::class, "form"]);
            // KATEGOR?? GRUBU D??ZENLE
                Route::post("/sistem-paneli/kategori-grubu/d??zenle/{no}", [CategoryGroupEditPageController::class, "form"]);
            // KATEGOR?? GRUBU S??L
                Route::post("/sistem-paneli/kategori-grubu/sil/{no}", [CategoryGroupDeletePageController::class, "form"]);
            // HABERLER L??STES??
                Route::post("/sistem-paneli/haberler", [SystemNewsListPageController::class, "form"]);
                Route::post("/sistem-paneli/haberler/no09", [SystemNewsListPageController::class, "form"]);
                Route::post("/sistem-paneli/haberler/no90", [SystemNewsListPageController::class, "form"]);
                Route::post("/sistem-paneli/haberler/contentAZ", [SystemNewsListPageController::class, "form"]);
                Route::post("/sistem-paneli/haberler/contentZA", [SystemNewsListPageController::class, "form"]);
                Route::post("/sistem-paneli/haberler/authorAZ", [SystemNewsListPageController::class, "form"]);
                Route::post("/sistem-paneli/haberler/authorZA", [SystemNewsListPageController::class, "form"]);
                Route::post("/sistem-paneli/haberler/categoryAZ", [SystemNewsListPageController::class, "form"]);
                Route::post("/sistem-paneli/haberler/categoryZA", [SystemNewsListPageController::class, "form"]);
                Route::post("/sistem-paneli/haberler/resourcePlatformAZ", [SystemNewsListPageController::class, "form"]);
                Route::post("/sistem-paneli/haberler/resourcePlatformZA", [SystemNewsListPageController::class, "form"]);
                Route::post("/sistem-paneli/haberler/publishDateAZ", [SystemNewsListPageController::class, "form"]);
                Route::post("/sistem-paneli/haberler/publishDateZA", [SystemNewsListPageController::class, "form"]);
                Route::post("/sistem-paneli/haberler/writeTimeAZ", [SystemNewsListPageController::class, "form"]);
                Route::post("/sistem-paneli/haberler/writeTimeZA", [SystemNewsListPageController::class, "form"]);
            // HABER D??ZENLE
                Route::post("/sistem-paneli/haber/d??zenle/{no}", [NewsEditPageController::class, "form"]);
            // HABER S??L
                Route::post("/sistem-paneli/haber/sil/{no}", [NewsDeletePageController::class, "form"]);
            // KULLANICI AYARI D??ZENLE
                Route::post("/sistem-paneli/kullanici-ayari/d??zenle/{no}", [UserSettingEditPageController::class, "form"]);
            // KULLANICI AYARI S??L
                Route::post("/sistem-paneli/kullanici-ayari/sil/{no}", [UserSettingDeletePageController::class, "form"]);
            // KAYNAK L??NK?? S??L
                Route::post("/sistem-paneli/kaynak-linki/sil/{no}", [ResourceUrlDeletePageController::class, "form"]);
            // KAYNAK L??NK?? D??ZENLE
                Route::post("/sistem-paneli/kaynak-linki/d??zenle/{no}", [ResourceUrlEditPageController::class, "form"]);
            // KATEGOR?? GRUBU L??NK METN?? S??L
                Route::post("/sistem-paneli/kategori-grubu-link-metni/sil/{no}", [CategoryGroupUrlsDeletePageController::class, "form"]);
            // KATEGOR?? GRUBU L??NK METN?? D??ZENLE
                Route::post("/sistem-paneli/kategori-grubu-link-metni/d??zenle/{no}", [CategoryGroupUrlEditPageController::class, "form"]);

});
