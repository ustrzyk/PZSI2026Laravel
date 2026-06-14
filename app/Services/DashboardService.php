<?php

namespace App\Services;

use App\Models\Accessory;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;

class DashboardService
{
    public function getStatistics(): array
    {
        return [
            'productsCount' => Product::where('IsActive', 1)->count(),

            'categoriesCount' => Category::where('IsActive', 1)->count(),

            'accessoriesCount' => Accessory::where('IsActive', 1)->count(),

            'usersCount' => User::where('IsActive', 1)->count(),

            'ordersCount' => Order::where('IsActive', 1)->count(),

            'ordersTotal' => Order::where('IsActive', 1)
                ->where('Status', '!=', 'Cancelled')
                ->sum('TotalPrice'),

            'latestOrders' => Order::with('user')
                ->where('IsActive', 1)
                ->orderBy('CreationDateTime', 'desc')
                ->take(5)
                ->get(),

            'lowStockProducts' => Product::with('category')
                ->where('IsActive', 1)
                ->where('Stock', '<=', 3)
                ->orderBy('Stock')
                ->orderBy('Name')
                ->get(),
        ];
    }
}