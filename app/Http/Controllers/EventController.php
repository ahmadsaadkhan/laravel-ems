<?php

namespace App\Http\Controllers;

use App\Models\Breakout;
use App\Models\Event;
use App\Models\EventLogo;
use App\Models\UserLoggedInEvent;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use stdClass;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $events = Event::latest()->get();
        return view('admin.events', compact('events'));
    }
}
