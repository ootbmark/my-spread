<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Services\SeoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class DashboardController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        SeoService::setPageMeta('dashboard');
        return view('dashboard.index');
    }


    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function alerts()
    {
        SeoService::setPageMeta('dashboard');
        return view('dashboard.alerts');
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sendDailyAlerts()
    {
        set_time_limit(1000000);
        Artisan::call('daily_alert');
        flash()->success('Alert sent');
        return back();
    }
    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sendWeeklyAlerts()
    {
        set_time_limit(1000000);
        Artisan::call('weekly_alert');
        flash()->success('Alert sent');
        return back();
    }
}
