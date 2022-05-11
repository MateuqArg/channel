<?php
 
namespace App\Providers;
 
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Models\User;
 
class ViewServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $exhibitors = User::role('exhibitor')->get();
        View::share('exhibitors', $exhibitors);
    }
}