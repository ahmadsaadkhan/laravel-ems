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
                <h2 class="text-center text-capitalize fw-bold fs-1">{{$eventDetails->event_name}} </h2>
                <p class="text-center">
                    {{ \Carbon\Carbon::parse($eventDetails->start_date)->format('F j, Y') }}
                    To
                    {{ \Carbon\Carbon::parse($eventDetails->end_date)->format('F j, Y') }}
                </p>
            </div>
        </div>

        <div class="content">
            <div class="row">
                <p class="text-center">{{$eventDetails->viewer_instructions}}</p>
                <div class="col flex-container">
                    <button class="btn btn-primary focus" id="presentationsBtn">Presentations Backup</button>
                    <button class="btn btn-warning" id="breakoutsBtn">Breakouts Backup</button>
                </div>
                <div id="Presentations" class="mt-5">
                    <div class="flex-container w-100">
                        @if(!empty($eventDetails->presentation_url_backup))
                        {!! $eventDetails->presentation_url_backup !!}
                        @endif
                    </div>
                </div>
                <div id="Breakouts" class="mt-5" style="display: none;">
                    <div class="row">
                        @if($eventDetails->breakouts)
                        @foreach($eventDetails->breakouts as $breakout)
                        <div class="flex-container col-6 mt-5">
                            {!! $breakout->backup_breakout_url !!}
                        </div>
                        @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="flex-container mt-5">
            <p class="text-center">Copyright <?php echo date("Y"); ?>, Cutting Edge Communications. Confidential.</p>
        </div>
    </div>
</body>
<script src="{{asset('js/jquery.min.js')}}"></script>
<script>
    $(document).ready(function() {
        $("#presentationsBtn").click(function() {
            toggleSections("#Presentations", "#Breakouts", this);
        });

        $("#breakoutsBtn").click(function() {
            toggleSections("#Breakouts", "#Presentations", this);
        });

        function toggleSections(showSection, hideSection, clickedBtn) {
            $(hideSection).hide();
            $(clickedBtn).addClass("focus");
            $(clickedBtn).siblings().removeClass("focus");
            $(showSection).show();
        }
    });
</script>

</html>