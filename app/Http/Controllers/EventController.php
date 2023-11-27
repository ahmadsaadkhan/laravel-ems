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

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $logoStore = EventLogo::latest()->get();
        return view('admin.create-event', compact('logoStore'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {

            $request->validate([
                'event_name' => ['required'],
                'start_date' => ['required'],
                'end_date' => ['required'],
                'event_url' => ['required'],
                'status' => ['required'],

                'username' => [
                    'required',
                    Rule::unique('events', 'username')->ignore($request->event_id),
                ],
                'password' => ['sometimes', 'required'],
                'viewer_instructions' => ['required'],
                'presentation_url' => ['required'],
            ], [
                'username.unique' => 'The username has already been taken.',
            ]);

            if ($request->event_id) {
                $eventStore = Event::find($request->event_id);
            } else {
                $eventStore = new Event;
                $eventStore->password = md5($request['password']);
            }
            $eventStore->event_name = $request->event_name;
            $eventStore->start_date = Carbon::createFromFormat('m-d-Y', $request->input('start_date'))->format('Y-m-d');
            $eventStore->end_date = Carbon::createFromFormat('m-d-Y', $request->input('end_date'))->format('Y-m-d');
            $eventStore->event_url = $request->event_url;
            $eventStore->status = $request->status;
            $eventStore->username = $request->username;
            $eventStore->viewer_instructions = $request->viewer_instructions;
            $eventStore->presentation_url = $request->presentation_url;
            $eventStore->presentation_url_backup = $request->presentation_url_backup;
            $eventStore->number_of_breakouts = $request->number_of_breakouts;
            $eventStore->logo = $request->formimage;
            $eventStore->save();

            if ($request->event_id) {
                $breakouts = Breakout::where('event_id', $request->event_id)->delete();
            }
            $breakoutAttributes = ['breakout_url_', 'breakout_label_'];
            $backupBreakoutAttributes = ['backup_breakout_url_', 'backup_breakout_label_'];
            for ($i = 1; $i <= $request->number_of_breakouts; $i++) {
                $breakouts = new Breakout();
                $breakouts->breakout_url = $request->input($breakoutAttributes[0] . $i);
                $breakouts->breakout_label = $request->input($breakoutAttributes[1] . $i);
                $breakouts->backup_breakout_url = $request->input($backupBreakoutAttributes[0] . $i);
                $breakouts->backup_breakout_label = $request->input($backupBreakoutAttributes[1] . $i);
                $breakouts->event_id = $eventStore->id;
                $breakouts->save();
            }
            return redirect()->route('admin.events')->with('success', 'Event Created');
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (Exception $e) {
            Log::error("Event Store Flow Error: " . $e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event, $id)
    {
        $logoStore = EventLogo::latest()->get();
        $event = Event::with('breakouts')->find($id);
        $breakouts = new stdClass();
        foreach ($event->breakouts as $index => $breakout) {
            $breakouts->{'breakout_url_' . ($index + 1)} = $breakout->breakout_url;
            $breakouts->{'breakout_label_' . ($index + 1)} = $breakout->breakout_label;
            $breakouts->{'backup_breakout_url_' . ($index + 1)} = $breakout->breakout_url;
            $breakouts->{'backup_breakout_label_' . ($index + 1)} = $breakout->breakout_label;
        }
        return view('admin.create-event', compact('event', 'breakouts', 'logoStore'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $event = Event::find($id);
        if (!$event) {
            return response()->json(['message' => 'Event not found'], 404);
        }
        $event->delete();
        return response()->json(['message' => 'Event deleted successfully']);
    }

    public function userList()
    {
        $usersList = UserLoggedInEvent::latest()->get();
        return view('admin.user-list', compact('usersList'));
    }
    public function EventUserList($id)
    {
        $usersList = UserLoggedInEvent::where('event_id', $id)->latest()->get();
        return view('admin.user-list', compact('usersList', 'id'));
    }

    public function UserListExport()
    {
        $usersList = UserLoggedInEvent::latest()->get();
        return $this->Export($usersList);
    }
    public function EventUserListExport($id)
    {
        $usersList = UserLoggedInEvent::where('event_id', $id)->latest()->get();
        return $this->Export($usersList);
    }

    public function Export($data)
    {
        $fileName = 'user-list.csv';
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0",
        ];
        $columns = ['Name', 'Username', 'IP Address', 'Created'];
        $callback = function () use ($data, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);
            foreach ($data as $task) {
                $row['Name']      = $task->event_name;
                $row['Username']  = $task->username;
                $row['IP Address'] = $task->ip_address;
                $row['Created']    = $task->created_at;

                fputcsv($file, array_values($row));
            }
            fclose($file);
        };
        return response()->stream($callback, 200, $headers);
    }

    public function saveLogo(Request $request)
    {
        try {
            if (empty($request->file('image'))) {
                $imageName = $request->oldimage;
                return response()->json(["imageName" => $imageName]);
            }

            $request->validate([
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $imageName);

            $logoStore = new EventLogo();
            $logoStore->image_name = $imageName;
            $logoStore->save();

            return response()->json(["imageName" => $imageName]);
        } catch (Exception $e) {
            Log::info("Event Store Flow Error: " . $e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }
}
