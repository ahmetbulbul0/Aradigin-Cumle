<?php

namespace App\Http\Controllers\Pages\Visitor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NewsDetailPageController extends Controller
{
    public function index() {
        return view('public/pages/news_detail');
    }
}