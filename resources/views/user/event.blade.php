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
                <img class="logo" src="{{asset('images/event-logo.png')}}" width="200" height="150" />
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
                    <button class="btn btn-primary focus" id="presentationsBtn">Presentations</button>
                    <button class="btn btn-warning" id="breakoutsBtn">Breakouts</button>
                </div>
                <div id="Presentations" class="mt-5">
                    <div class="flex-container">
                        @if(!empty($eventDetails->presentation_url))
                        <iframe src="{{ $eventDetails->presentation_url }}" width="100%" style="aspect-ratio: 16/9; min-height: 340px;" frameborder="0" scrolling="no" allowfullscreen webkitallowfullscreen mozallowfullscreen oallowfullscreen msallowfullscreen></iframe>
                        @endif
                    </div>
                </div>
                <div id="Breakouts" class="mt-5" style="display: none;">
                    <div class="row">
                        @if($eventDetails->breakouts)
                        @foreach($eventDetails->breakouts as $breakout)
                        <div class="flex-container col-6 mt-5">
                            <iframe src="{{ $breakout->breakout_url }}" width="100%" style="aspect-ratio: 16/9; min-height: 340px;" frameborder="0" scrolling="no" allowfullscreen webkitallowfullscreen mozallowfullscreen oallowfullscreen msallowfullscreen></iframe>
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