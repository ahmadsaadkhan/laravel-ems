@extends('layouts.app')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        @if (\Session::has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="uil uil-check me-2"></i>
            {!! \Session::get('success') !!}
        </div>
        @endif

        @if (\Session::has('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="uil uil-times me-2"></i>
            {!! \Session::get('error') !!}
        </div>
        @endif
        <div class="col-9">
            <h1 class="mb-3">Create Event</h1>
            <form method="post" action="{{ route('event.store') }}" id="myform" enctype="multipart/form-data">
                @csrf
                @if(isset($event))
                <input name="event_id" value="{{$event->id}}" hidden />
                @endif
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="event_name" class="form-label">Event Name</label>
                        <input type="text" class="form-control" id="event_name" name="event_name" value="{{ isset($event) ? $event->event_name : old('event_name') }}" placeholder="Event Name" maxlength="30">
                    </div>

                    <div class="col-md-6">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-control" name="status" id="status">
                            <option value="" {{ (isset($event) ? $event->status : old('status')) == '' ? "selected" : "" }}>Select Status</option>
                            <option value="1" {{ (isset($event) ? $event->status : old('status')) == '1' ? "selected" : "" }}>Active</option>
                            <option value="0" {{ (isset($event) ? $event->status : old('status')) == '0' ? "selected" : "" }}>Inactive</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label for="basic-url" class="form-label">Start Date</label>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control datepicker" id="start_date" name="start_date" readonly value="{{ isset($event) ? \Carbon\Carbon::parse($event->start_date)->format('m-d-Y') : old('start_date') }}">
                            <span class="input-group-text" id="basic-addon1"><i class="bi bi-calendar-date"></i></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="basic-url" class="form-label">End Date</label>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control datepicker" id="end_date" name="end_date" readonly value="{{ isset($event) ? \Carbon\Carbon::parse($event->end_date)->format('m-d-Y') : old('end_date') }}">
                            <span class="input-group-text" id="basic-addon1"><i class="bi bi-calendar-date"></i></span>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="row d-flex justify-content-between">
                            <label for="your-subject" class="form-label">Event URL </label>
                            <div class="col-4">
                                <span>{{ url('portal') }}/</span>
                            </div>
                            <div class="col-6">
                                <input type="text" class="form-control" id="url_slug" placeholder="Slug" name="event_url" maxlength="30" value="{{ isset($event) ? $event->event_url : old('slug') }}">
                            </div>
                        </div>

                    </div>

                    <div class="col-md-12">
                        <label for="your-subject" class="form-label">Full URL</label>
                        <p id="full_url">{{ isset($event) ? url('portal'.'/'.$event->event_url) : '' }}</p>

                        <input type="hidden" class="form-control" id="full_event_url" placeholder="Full URL" name="event_full_url" maxlength="200" value="{{ isset($event) ? $event->event_url : old('event_url') }}">
                    </div>
                    <div class="col-md-6">
                        <label for="your-subject" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username" placeholder="Username" maxlength="50" value="{{ isset($event) ? $event->username : old('username') }}">
                    </div>
                    @if(!isset($event))
                    <div class="col-md-6">
                        <label for="your-subject" class="form-label">Password</label>
                        <input type="text" class="form-control" id="password" name="password" placeholder="Password" maxlength="30" value="{{ old('password') }}">
                    </div>
                    @endif
                    <div class="col-md-12">
                        <label for="your-subject" class="form-label">Viewer instructions</label>
                        <textarea class="form-control" id="viewer_instructions" name="viewer_instructions" placeholder="Viewer instructions" maxlength="200">{{ isset($event) ? $event->viewer_instructions : old('viewer_instructions') }}</textarea>
                    </div>

                    <div class="col-md-12">
                        <label for="your-subject" class="form-label">Presentation URL</label>
                        <textarea class="ckeditor form-control editor" name="presentation_url">{!! isset($event) ? $event->presentation_url : old('presentation_url') !!}</textarea>
                    </div>

                    <div class="col-md-12">
                        <label for="your-subject" class="form-label">Presentation URL Backup</label>
                        <textarea class="ckeditor form-control editor" name="presentation_url_backup">{!! isset($event) ? $event->presentation_url_backup : old('presentation_url_backup') !!}</textarea>
                    </div>

                    <div class="col-md-6">
                        <label for="your-subject" class="form-label">Number of Breakouts</label>
                        <select class="form-control" name="number_of_breakouts" id="number_of_breakouts">
                            <option {{ (isset($event) ? $event->number_of_breakouts : old('number_of_breakouts')) == '0' ? "selected" : "" }} value="0">0</option>
                            <option {{ (isset($event) ? $event->number_of_breakouts : old('number_of_breakouts')) == '1' ? "selected" : "" }} value="1">1</option>
                            <option {{ (isset($event) ? $event->number_of_breakouts : old('number_of_breakouts')) == '2' ? "selected" : "" }} value="2">2</option>
                            <option {{ (isset($event) ? $event->number_of_breakouts : old('number_of_breakouts')) == '3' ? "selected" : "" }} value="3">3</option>
                            <option {{ (isset($event) ? $event->number_of_breakouts : old('number_of_breakouts')) == '4' ? "selected" : "" }} value="4">4</option>
                        </select>
                    </div>

                    <div class="row mt-5" id="breakout_section_1" style="{{ isset($breakouts) && isset($breakouts->breakout_label_1) ? 'display:block' : 'display:none' }}">
                        <div class="col-md-6">
                            <label for="your-subject" class="form-label">Breakout 1 Label</label>
                            <input type="text" class="form-control" id="breakout_label_1" name="breakout_label_1" placeholder="Breakout 1 Label" maxlength="50" value="{{isset($breakouts) && isset($breakouts->breakout_label_1) ? $breakouts->breakout_label_1 : old('breakout_label_1') }}">
                        </div>
                        <div class="col-md-12 mt-2">
                            <label for="your-subject" class="form-label">Breakout 1 Embed URL</label>
                            <textarea class="ckeditor form-control" name="breakout_url_1">{{isset($breakouts) && isset($breakouts->backup_breakout_url_1) ? $breakouts->backup_breakout_url_1 : old('backup_breakout_url_1')}}</textarea>
                        </div>
                       
                        <div class="col-md-12 mt-2">
                            <label for="your-subject" class="form-label">Backup Breakout 1 Embed URL</label>
                            <textarea class="ckeditor form-control" name="backup_breakout_url_1">{{isset($breakouts) && isset($breakouts->backup_breakout_url_1) ? $breakouts->backup_breakout_url_1 : old('backup_breakout_url_1')}}</textarea>
                        </div>
                    </div>
                    <div class="row mt-4" id="breakout_section_2" style="{{ isset($breakouts) && isset($breakouts->breakout_label_2) ? 'display:block' : 'display:none' }}">
                        <div class="col-md-6">
                            <label for="your-subject" class="form-label">Breakout 2 Label</label>
                            <input type="text" class="form-control" id="breakout_label_2" name="breakout_label_2" placeholder="Breakout 2 Label" maxlength="50" value="{{isset($breakouts) && isset($breakouts->breakout_label_2) ? $breakouts->breakout_label_2 : old('breakout_label_2') }}">
                        </div>
                        <div class="col-md-12 mt-2">
                            <label class="form-label">Breakout 2 Embed URL</label>
                            <textarea class="ckeditor form-control" name="breakout_url_2">{{isset($breakouts) && isset($breakouts->breakout_url_2) ? $breakouts->breakout_url_2 : old('breakout_url_2')}}</textarea>
                        </div>
                        
                        <div class="col-md-12 mt-2">
                            <label for="your-subject" class="form-label">Backup Breakout 2 Embed URL</label>
                            <textarea class="ckeditor form-control" name="backup_breakout_url_2">{{isset($breakouts) && isset($breakouts->backup_breakout_url_2) ? $breakouts->backup_breakout_url_2 : old('backup_breakout_url_2')}}</textarea>
                        </div>
                    </div>
                    <div class="row mt-4" id="breakout_section_3" style="{{ isset($breakouts) && isset($breakouts->breakout_label_3) ? 'display:block' : 'display:none' }}">
                        <div class="col-md-6">
                            <label class="form-label">Breakout 3 Label</label>
                            <input type="text" class="form-control" id="breakout_label_3" name="breakout_label_3" placeholder="Breakout 3 Label" maxlength="50" value="{{isset($breakouts) && isset($breakouts->breakout_label_3) ? $breakouts->breakout_label_3 : old('breakout_label_3') }}">
                        </div>
                        <div class="col-md-12 mt-2">
                            <label class="form-label">Breakout 3 Embed URL</label>
                            <textarea class="ckeditor form-control" name="breakout_url_3">{{isset($breakouts) && isset($breakouts->breakout_url_3) ? $breakouts->breakout_url_3 : old('breakout_url_3')}}</textarea>
                        </div>

                        <div class="col-md-12 mt-2">
                            <label for="your-subject" class="form-label">Backup Breakout 3 Embed URL</label>
                            <textarea class="ckeditor form-control" name="backup_breakout_url_3">{{isset($breakouts) && isset($breakouts->backup_breakout_url_3) ? $breakouts->backup_breakout_url_3 : old('backup_breakout_url_3')}}</textarea>
                        </div>
                    </div>
                    <div class="row mt-4" id="breakout_section_4" style="{{ isset($breakouts) && isset($breakouts->breakout_label_4) ? 'display:block' : 'display:none' }}">
                        <div class="col-md-6">
                            <label class="form-label">Breakout 4 Label</label>
                            <input type="text" class="form-control" id="breakout_label_4" name="breakout_label_4" placeholder="Breakout 4 Label" maxlength="50" value="{{isset($breakouts) && isset($breakouts->breakout_label_4) ? $breakouts->breakout_label_4 : old('breakout_label_4') }}">
                        </div>
                        <div class="col-md-12 mt-2">
                            <label class="form-label">Breakout 4 Embed URL</label>
                            <textarea class="ckeditor form-control" name="breakout_url_4">{{isset($breakouts) && isset( $breakouts->breakout_url_4) ? $breakouts->breakout_url_4 : old('breakout_url_4')}}</textarea>
                        </div>

                        <div class="col-md-12 mt-2">
                            <label for="your-subject" class="form-label">Backup Breakout 4 Embed URL</label>
                            <textarea class="ckeditor form-control" name="backup_breakout_url_4">{{isset($breakouts) && isset($breakouts->backup_breakout_url_4) ? $breakouts->backup_breakout_url_4 : old('backup_breakout_url_4')}}</textarea>
                        </div>
                    </div>

                    <div class="row mt-5">
                        <input type="hidden" class="form-control" name="formimage" id="formLogo" value="{{ isset($event) ? $event->logo : '' }}" />
                        <div class="col-md-6">
                            <label for="formLogo" class="form-label">Logo</label>
                            <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#logoModal">Upload Logo</button>
                        </div>
                        <div class="col-md-6 {{ isset($event) && isset($event->logo) ? 'block' : 'd-none'}}" id="preview-image">
                            <img id="uploaded-logo" src="{{ isset($event) ? '/images/'.$event->logo : '#' }}" alt="your image" style="height: 100px; width: 100px;" />
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="row">
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary w-100 fw-bold">Save</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="logoModal" role="dialog">
    <div class="modal-dialog">
        <form method="POST" id="mylogo" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-body">
                    <div class="col-md-12">
                        <label for="your-subject" class="form-label">Upload Logo</label>
                        <input type="file" id="logo-image" class="form-control" name="image" accept="image/png, image/gif, image/jpeg" />
                    </div>
                </div>

                @if (isset($logoStore))
                <div class="modal-body">
                    <div class="col-md-12">
                        <label for="your-subject" class="form-label">Choose from Existing</label>
                    </div>
                </div>

                <div class="modal-body row">
                    @foreach ($logoStore as $logo)
                    @php
                    $filePath = public_path('/images/'.$logo->image_name);
                    @endphp
                    @if(file_exists($filePath))
                    <div class="col-md-3">
                        <input type="radio" name="oldimage" value="{{$logo->image_name}}" class="old-images">
                        <img style="height: 55px; width: 70px;" src="{{asset('images/'.$logo->image_name)}}" alt="Logo">
                    </div>
                    @endif
                    @endforeach
                </div>
                @endif

                <div class="modal-footer">
                    <button type="button" class="btn btn-info" id="logoupload" data-dismiss="modal">Done</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script src="{{asset('js/jquery.min.js')}}"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/css/bootstrap-datepicker.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/js/bootstrap-datepicker.min.js"></script>
<!-- <script src="https://cdn.ckeditor.com/ckeditor5/40.1.0/classic/ckeditor.js"></script> -->
<!-- <script src="https://cdn.ckeditor.com/ckeditor5/43.0.1/classic/ckeditor.js"></script> -->
<script src="https://cdn.ckeditor.com/4.10.1/standard/ckeditor.js"></script>

<script type="text/javascript">
    $('.datepicker').datepicker({
        format: 'mm-dd-yyyy'
    });
</script>
<script>
    var $urlSlug = $('#url_slug');
    var $fullUrl = $('#full_url');
    var $fullEventUrl = $('#full_event_url');
    $urlSlug.on('keyup', function() {
        var tags = $(this).val();
        var base_url = window.location.origin;
        var combinedUrl = base_url + '/portal/' + tags;
        $fullUrl.html(combinedUrl);
        $fullEventUrl.val(combinedUrl);
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var editorElements = document.querySelectorAll('.editor');

        editorElements.forEach(function(element) {
            CKEDITOR.replace(element, {
                allowedContent: true,
                extraPlugins: 'codeblock',
                codeBlock_languages: [{
                        value: 'plaintext',
                        language: 'Plain Text'
                    },
                    {
                        value: 'javascript',
                        language: 'JavaScript'
                    },
                    {
                        value: 'html',
                        language: 'HTML'
                    }
                ],
                toolbar: [{
                    name: 'insert',
                    items: ['CodeBlock']
                }]
            });
        });
    });
    $(document).ready(function() {
        if (CKEDITOR) {
            CKEDITOR.config.allowedContent = true;
            CKEDITOR.config.autoParagraph = false;
        } else {
            console.log("CKEDITOR not found");
        }
    });
</script>
<script>
    $(document).ready(function() {
        $("#number_of_breakouts").change(function() {
            $('[id^="breakout_section_"]').hide();
            var selectedValue = $(this).val();
            if (selectedValue !== "0") {
                for (var i = 1; i <= selectedValue; i++) {
                    $("#breakout_section_" + i).show();
                }
            }
        });
    });
</script>
<script>
    $(document).ready(function() {
        var myLogoForm = $('#mylogo');
        var logoImageInput = $('#logo-image');
        var uploadedLogo = $('#uploaded-logo');
        var previewImage = $('#preview-image');
        var formLogo = $('#formLogo');

        function storeLogo() {
            var formData = new FormData(myLogoForm[0]);
            $.ajax({
                url: "{{ route('add.logo') }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
            }).done(function(msg) {
                formLogo.val(msg.imageName);
                $('#logoModal').modal('hide');
            });
        }

        $("#logoupload").click(function() {
            var selectedExistingLogo = $('input[name="oldimage"]:checked').length;
            var choosenImage = logoImageInput.val();

            if (selectedExistingLogo === 0 && choosenImage !== null && choosenImage !== "") {
                if (logoImageInput[0].files && logoImageInput[0].files[0]) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        var image = e.target.result;
                        uploadedLogo.attr('src', image);
                    }
                    reader.readAsDataURL(logoImageInput[0].files[0]);
                    previewImage.removeClass('d-none');
                }
            } else if (selectedExistingLogo > 0) {
                var selectedLogo = $('input[name="oldimage"]:checked').next('img').attr('src');
                uploadedLogo.attr('src', selectedLogo);
                previewImage.removeClass('d-none');
            }

            storeLogo();
        });
    });
</script>
@endsection