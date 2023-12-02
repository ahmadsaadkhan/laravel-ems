<!-- resources/views/event.blade.php -->
<html>

<head>
    <title>Client Portal</title>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

</head>

<body>
    <div class="container">
        <div class="row mt-1">
            <div class="col-2 mb-1">
                @if($eventDetails->logo)
                <img class="logo" src="{{ asset('images/' . $eventDetails->logo) }}" alt="Event Logo" width="250" height="150">
                @endif
            </div>
            <div class="col-12">
                <h2 class="text-center fw-bold fs-1">{{$eventDetails->event_name}} </h2>
                <p class="text-center">
                    @if ($eventDetails->start_date == $eventDetails->end_date)
                    {{ \Carbon\Carbon::parse($eventDetails->start_date)->format('F j, Y') }}
                    @else
                    {{ \Carbon\Carbon::parse($eventDetails->start_date)->format('F j, Y') }} To {{ \Carbon\Carbon::parse($eventDetails->end_date)->format('F j, Y') }}
                    @endif
                </p>
            </div>
        </div>

        <div class="content">
            <div class="row">
                <p class="text-center">{{$eventDetails->viewer_instructions}}</p>


                <nav class="nav justify-content-center">
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-presentation" type="button" role="tab" aria-controls="nav-presentation" aria-selected="true">Presentations</button>
                        <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-breakouts" type="button" role="tab" aria-controls="nav-breakouts" aria-selected="false">Breakouts</button>
                        <button class="nav-link" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-presentation-backup" type="button" role="tab" aria-controls="nav-presentation-backup" aria-selected="false">Presentations Backup</button>
                        <button class="nav-link" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-breakouts-backup" type="button" role="tab" aria-controls="nav-breakouts-backup" aria-selected="false">Breakouts Backup</button>
                    </div>
                </nav>
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-presentation" role="tabpanel" aria-labelledby="nav-home-tab">

                        <div id="Presentations" class="mt-5">
                            <div class="flex-container">
                                @if(!empty($eventDetails->presentation_url))
                                {!! $eventDetails->presentation_url !!}
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="nav-breakouts" role="tabpanel" aria-labelledby="nav-profile-tab">
                        <div id="Breakouts" class="mt-5">
                            <div class="row">
                                @if($eventDetails->breakouts)
                                @foreach($eventDetails->breakouts as $breakout)
                                <div class="col-6 mt-5">
                                    <div class="flex-container">
                                        <h4 class="text-center">{{ $breakout->breakout_label}}</h4>
                                    </div>
                                    <div class="flex-container">
                                        {!! $breakout->breakout_url !!}
                                    </div>
                                </div>
                                @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="nav-presentation-backup" role="tabpanel" aria-labelledby="nav-contact-tab">
                        <div id="Presentations" class="mt-5">
                            <div class="flex-container w-100">
                                @if(!empty($eventDetails->presentation_url_backup))
                                {!! $eventDetails->presentation_url_backup !!}
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="nav-breakouts-backup" role="tabpanel" aria-labelledby="nav-contact-tab">
                        <div id="Breakouts" class="mt-5">
                            <div class="row">
                                @if($eventDetails->breakouts)
                                @foreach($eventDetails->breakouts as $breakout)
                                <div class="flex-container col-6 mt-5">
                                    <div class="flex-container">
                                        <h4 class="text-center">{{ $breakout->breakout_label}}</h4>
                                    </div>
                                    <div class="flex-container">
                                        {!! $breakout->backup_breakout_url !!}
                                    </div>
                                </div>
                                @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="flex-container mt-5">
            <p class="text-center">Copyright <?php echo date("Y"); ?>, Cutting Edge Communications. Confidential.</p>
        </div>
    </div>
</body>

</html>