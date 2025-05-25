<?php

namespace App\Http\Controllers;

use App\Models\Package;
use Illuminate\Http\Request;
use App\Models\LocksWReadyCard;
use Illuminate\Support\Facades\App;
use App\Models\Page; // Assuming AppPage is the model

class AppPageController extends Controller
{
    public function showPage($slug)
    {
        // Get the page by slug and ensure it's active
        $page = Page::where('slug', $slug)
                    ->where('is_active', true)
                    ->firstOrFail();
    
        // Get current locale
        $locale = App::getLocale();
    
        // Prepare data for the view
        $data = [
            'title' => $locale === 'ar' ? $page->title_ar : $page->title_en,
            'content' => $locale === 'ar' ? $page->description_ar : $page->description_en,
            'page' => $page // pass the entire page object if needed
        ];
    
        return view('app.pages.dynamic', $data);
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