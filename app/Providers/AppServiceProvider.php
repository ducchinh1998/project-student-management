<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Faculty;
use App\Models\Classes;
use App\Models\SchoolYear;
use App\Models\Subject;
use App\Models\Account;
use App\Models\CreditClass;
use App\Models\Student;

use View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if (!\App::runningInConsole()) {
            View::share('faculties', Faculty::orderBy('created_at', 'asc')->get());
            View::share('classes', Classes::orderBy('created_at', 'asc')->get());
            View::share('credit_classes', CreditClass::orderBy('created_at', 'asc')->get());
            View::share('school_years', SchoolYear::orderBy('created_at', 'asc')->get());
            View::share('subjects', Subject::orderBy('created_at', 'asc')->get());
            View::share('students', Student::orderBy('created_at', 'asc')->get());
            View::share('lecturers', Account::where('position', 'Lecturer')->where('status', 1)->orderBy('created_at', 'asc')->get());
        }
    }
}
