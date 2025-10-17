<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        Blade::if('notblocked', function () {
            $user = Auth::user();
            if (! $user) {
                return false;
            }

            $blockedEmails = config('blocked.emails');

            return ! in_array($user->email, $blockedEmails);
        });
        // dd(Auth::user());
        Blade::if('role', function ($role) {
            // dd($role);
            return Auth::user()->hasRole($role);
        });
        // Blade::if('studentPassed', function () {
        //     $user = auth()->user();
        //     $user->load([
        //     'student_details:id,user_id,result',
        // ]);
        //     return $user
        //         && $user->user_type === 'student'
        //         && $user->student_details
        //         && $user->student_details->result === 'pass';
        // });
        // // For students who are in progress
        // Blade::if('studentInProgress', function () {
        //     // dd('ss');
        //     $user = auth()->user();
        //     $user->load([
        //     'student_details:id,user_id,result',
        // ]);
        //     return $user
        //         && $user->user_type === 'student'
        //         && $user->student_details
        //         && $user->student_details->result === 'In_progress';
        // });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Livewire::setUpdateRoute(function ($handle) {
            $prefix = trim(env('LIVEWIRE_PREFIX', ''), '/');
            $uri = ($prefix ? "/{$prefix}" : '').'/livewire/update';

            return Route::post($uri, $handle)
                ->middleware(['web', 'throttle:120,1'])
                ->name('livewire.update');
        });
        Livewire::setScriptRoute(function ($handle) {
            return Route::get('/custom/livewire/livewire.js', $handle);
        });
    }
}
