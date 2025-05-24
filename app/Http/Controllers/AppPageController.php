<?php

namespace App\Http\Controllers;

use App\Models\Package;
use Illuminate\Http\Request;
use App\Models\LocksWReadyCard;
use Illuminate\Support\Facades\App;
use App\Models\Page; // Assuming AppPage is the model

class AppPageController extends Controller
{
    public function privacy()
    {
        $page = Page::where('slug', 'privacy')->where('is_active', true)->firstOrFail();
        $locale = App::getLocale();
        $title = $locale === 'ar' ? $page->title_ar : $page->title_en;
        $description = $locale === 'ar' ? $page->description_ar : $page->description_en;

        return view('app.pages.privacy', compact('title', 'description'));
    }

    public function terms()
    {
        $page = Page::where('slug', 'terms')->where('is_active', true)->firstOrFail();
        $locale = App::getLocale();
        $title = $locale === 'ar' ? $page->title_ar : $page->title_en;
        $description = $locale === 'ar' ? $page->description_ar : $page->description_en;

        return view('app.pages.terms', compact('title', 'description'));
    }

    public function benefits()
    {
        $page = Page::where('slug', 'benefits')->where('is_active', true)->firstOrFail();
        $locale = App::getLocale();
        $title = $locale === 'ar' ? $page->title_ar : $page->title_en;
        $description = $locale === 'ar' ? $page->description_ar : $page->description_en;

        return view('app.pages.benefits', compact('title', 'description'));
    }

    public function prices()
    {

        return view('app.pages.prices');
    }
    public function balances()
    {


        $packages = Package::where('is_active', true)->get();

        return view('app.pages.balances',compact('packages'));
    }
    public function locks()
    {
        $locks = LocksWReadyCard::where('type', 'lock')->where('is_active', true)->get();

        return view('app.pages.locks',compact('locks'));
    }
    public function cards()
    {
        $cards = LocksWReadyCard::where('type', 'read_card')->where('is_active', true)->get();

        return view('app.pages.cards',compact('cards'));
    }
    
}