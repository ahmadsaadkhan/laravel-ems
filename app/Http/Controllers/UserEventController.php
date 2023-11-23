<?php

namespace App\Http\Controllers;

use App\Models\Breakout;
use App\Models\Event;
use App\Models\UserLoggedInEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class UserEventController extends Controller
{
    public function ValidateEvent(Request $request, $slug)
    {
        if (empty(Auth::user())) {
            $username = Session::get('username');
            $user_password = Session::get('user_password');
            $eventDetails = Event::where('username', $username)
                ->where('password', md5($user_password))
                ->where('status', 1)
                ->first();

            if ($eventDetails) {
                return view('user.event', compact('eventDetails'));
            } else {
                return redirect('/')->with('event_not_found', 'Event Not Found');
            }
        } else {
            $eventDetails = Event::where('event_url', $slug)->first();
            return view('user.event', compact('eventDetails'));
        }
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->route('user.login')
                ->withErrors($validator)
                ->withInput();
        }

        $eventDetails = Event::where('username', $request->username)
            ->where('event_name', $request->name)
            ->where('password', md5($request['password']))
            ->where('status', 1)->first();
        if ($eventDetails) {
            Session::put('username', $request->username);
            Session::put('user_password', $request->password);

            $userLoggedInData = new UserLoggedInEvent();
            $userLoggedInData->event_id = $eventDetails->id;
            $userLoggedInData->event_name = $request->name;
            $userLoggedInData->username = $request->username;
            $userLoggedInData->ip_address = request()->ip();
            $userLoggedInData->save();

            return redirect()->route('user.validate-event', $eventDetails->event_url);
        } else {
            return redirect()
                ->back()
                ->withErrors(['event_not_found' => 'Event not found.']);
        }
    }
}
