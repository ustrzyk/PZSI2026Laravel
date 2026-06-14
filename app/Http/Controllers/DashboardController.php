<?php

namespace App\Http\Controllers;

use App\Services\DashboardService;

class DashboardController extends Controller
{
    private DashboardService $dashboardService;

    public function __construct(DashboardService $dashboardService)
    {
        $this->dashboardService = $dashboardService;
    }

    public function index()
    {
        $statistics = $this->dashboardService->getStatistics();

        return view('dashboard.index', [
            'statistics' => $statistics
        ]);
    }
}