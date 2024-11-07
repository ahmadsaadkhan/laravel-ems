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
        <div class="col-9 border p-3">
            <h1 class="mb-3">Create Event</h1>
            <form method="post" action="{{ route('event.store') }}" id="myform" enctype="multipart/form-data">
                @csrf
                @if(isset($event))
                <input name="event_id" value="{{$event->id}}" hidden />
                @endif
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="event_name" class="form-label">Event Name</label>
                        <input type="text" class="form-control" id="event_name" name="event_name" value="{{ isset($event) ? $event->event_name : old('event_name') }}" placeholder="Event Name" maxlength="255">
                    </div>

                    <div class="col-md-6">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-control" name="status" id="status">
                            <option value="" {{ (isset($event) ? $event->status : old('status')) == '' ? "selected" : "" }}>Select Status</option>
                            <option value="1" {{ (isset($event) ? $event->status : old('status')) == '1' ? "selected" : "" }}>Active</option>
                            <option value="0" {{ (isset($event) ? $event->status : old('status')) == '0' ? "selected" : "" }}>Inactive</option>
                            <option value="2" {{ (isset($event) ? $event->status : old('status')) == '2' ? "selected" : "" }}>Completed</option>
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
                                <input type="text" class="form-control" id="url_slug" placeholder="Slug" name="event_url" maxlength="30" value="{{ isset($event) ? $event->event_url : old('event_url') }}">
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
                    <div class="col-md-6">
                        <label for="your-subject" class="form-label">Password</label>
                        <input type="text" class="form-control" id="password" name="password" placeholder="Password" maxlength="50" value="{{ isset($event) ? $event->password : old('password') }}">
                    </div>
                    <div class="col-md-6">
                        <label for="your-subject" class="form-label">Billing Code</label>
                        <input type="text" class="form-control" id="billing_code" name="billing_code" placeholder="Billing Code" maxlength="50" value="{{ isset($event) ? $event->billing_code : old('billing_code') }}">
                    </div>
                    <div class="col-md-6">
                        <div class="form-check mt-4">
                            <input type="hidden" name="billed" value="0">
                            <input type="checkbox" class="form-check-input p-1" id="billed" name="billed" value="1" {{ old('billed', isset($event) && $event->billed ? 'checked' : '') }}>
                            <label for="your-subject" class="form-check-label">Billed</label>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <label for="your-subject" class="form-label">Viewer instructions</label>
                        <textarea class="form-control" id="viewer_instructions" name="viewer_instructions" placeholder="Click the play button below to view the livestream" maxlength="200">{{ isset($event) ? $event->viewer_instructions : old('viewer_instructions') }}</textarea>
                    </div>

                    <div class="col-md-12">
                        <label for="your-subject" class="form-label">Presentation URL</label>
                        <textarea class="editor form-control editor" name="presentation_url" placeholder="Coming soon">{!! isset($event) && !empty($event->presentation_url) ? $event->presentation_url : (old('presentation_url') ?: 'Coming Soon') !!}
                        </textarea>
                    </div>

                    <div class="col-md-12">
                        <label for="your-subject" class="form-label">Presentation URL Backup</label>
                        <textarea class="editor form-control editor" name="presentation_url_backup" placeholder="Coming soon">{!! isset($event) && !empty($event->presentation_url_backup) ? $event->presentation_url_backup : (old('presentation_url_backup') ?: 'Coming Soon') !!}
                        </textarea>
                    </div>

                    <div class="col-md-6">
                        <label for="your-subject" class="form-label">Number of Breakouts</label>
                        <select class="form-control" name="number_of_breakouts" id="number_of_breakouts">
                            <option {{ (isset($event) ? $event->number_of_breakouts : old('number_of_breakouts')) == '0' ? "selected" : "" }} value="0">0</option>
                            <option {{ (isset($event) ? $event->number_of_breakouts : old('number_of_breakouts')) == '1' ? "selected" : "" }} value="1">1</option>
                            <option {{ (isset($event) ? $event->number_of_breakouts : old('number_of_breakouts')) == '2' ? "selected" : "" }} value="2">2</option>
                            <option {{ (isset($event) ? $event->number_of_breakouts : old('number_of_breakouts')) == '3' ? "selected" : "" }} value="3">3</option>
                            <option {{ (isset($event) ? $event->number_of_breakouts : old('number_of_breakouts')) == '4' ? "selected" : "" }} value="4">4</option>
                            <option {{ (isset($event) ? $event->number_of_breakouts : old('number_of_breakouts')) == '5' ? "selected" : "" }} value="5">5</option>
                            <option {{ (isset($event) ? $event->number_of_breakouts : old('number_of_breakouts')) == '6' ? "selected" : "" }} value="6">6</option>
                        </select>
                    </div>

                    <div class="row mt-5" id="breakout_section_1" style="{{ isset($breakouts) && isset($breakouts->breakout_label_1) ? 'display:block' : 'display:none' }}">
                        <div class="col-md-6">
                            <label for="your-subject" class="form-label">Breakout 1 Label</label>
                            <input type="text" class="form-control" id="breakout_label_1" name="breakout_label_1" placeholder="Breakout 1" maxlength="50" value="{{ isset($breakouts) && !empty($breakouts->breakout_label_1) ? $breakouts->breakout_label_1 : (old('breakout_label_1') ?: 'Breakout 1') }}">
                        </div>
                        <div class="col-md-12 mt-2">
                            <label for="your-subject" class="form-label">Breakout 1 Embed URL</label>
                            <textarea class="editor form-control" name="breakout_url_1" placeholder="Coming soon">{{ isset($breakouts) && !empty($breakouts->breakout_url_1) ? $breakouts->breakout_url_1 : (old('breakout_url_1') ?: 'Coming Soon') }}
                             </textarea>
                        </div>

                        <div class="col-md-12 mt-2">
                            <label for="your-subject" class="form-label">Backup Breakout 1 Embed URL</label>
                            <textarea class="editor form-control" name="backup_breakout_url_1" placeholder="Coming soon">{{ isset($breakouts) && !empty($breakouts->backup_breakout_url_1) ? $breakouts->backup_breakout_url_1 : (old('backup_breakout_url_1') ?: 'Coming Soon') }}
                            </textarea>
                        </div>
                    </div>
                    <div class="row mt-4" id="breakout_section_2" style="{{ isset($breakouts) && isset($breakouts->breakout_label_2) ? 'display:block' : 'display:none' }}">
                        <div class="col-md-6">
                            <label for="your-subject" class="form-label">Breakout 2 Label</label>
                            <input type="text" class="form-control" id="breakout_label_2" name="breakout_label_2" placeholder="Breakout 2" maxlength="50" value="{{ isset($breakouts) && !empty($breakouts->breakout_label_2) ? $breakouts->breakout_label_2 : (old('breakout_label_2') ?: 'Breakout 2') }}">
                        </div>
                        <div class="col-md-12 mt-2">
                            <label class="form-label">Breakout 2 Embed URL</label>
                            <textarea class="editor form-control" name="breakout_url_2" placeholder="Coming soon">{{ isset($breakouts) && !empty($breakouts->breakout_url_2) ? $breakouts->breakout_url_2 : (old('breakout_url_2') ?: 'Coming Soon') }}</textarea>
                        </div>

                        <div class="col-md-12 mt-2">
                            <label for="your-subject" class="form-label">Backup Breakout 2 Embed URL</label>
                            <textarea class="editor form-control" name="backup_breakout_url_2" placeholder="Coming soon">{{ isset($breakouts) && !empty($breakouts->backup_breakout_url_2) ? $breakouts->backup_breakout_url_2 : (old('backup_breakout_url_2') ?: 'Coming Soon') }}
                            </textarea>
                        </div>
                    </div>
                    <div class="row mt-4" id="breakout_section_3" style="{{ isset($breakouts) && isset($breakouts->breakout_label_3) ? 'display:block' : 'display:none' }}">
                        <div class="col-md-6">
                            <label class="form-label">Breakout 3 Label</label>
                            <input type="text" class="form-control" id="breakout_label_3" name="breakout_label_3" placeholder="Breakout 3" maxlength="50" value="{{ isset($breakouts) && !empty($breakouts->breakout_label_3) ? $breakouts->breakout_label_3 : (old('breakout_label_3') ?: 'Breakout 3') }}">
                        </div>
                        <div class="col-md-12 mt-2">
                            <label class="form-label">Breakout 3 Embed URL</label>
                            <textarea class="editor form-control" name="breakout_url_3" placeholder="Coming soon">{{ isset($breakouts) && !empty($breakouts->breakout_url_3) ? $breakouts->breakout_url_3 : (old('breakout_url_3') ?: 'Coming Soon') }}
                            </textarea>
                        </div>

                        <div class="col-md-12 mt-2">
                            <label for="your-subject" class="form-label">Backup Breakout 3 Embed URL</label>
                            <textarea class="editor form-control" name="backup_breakout_url_3" placeholder="Coming soon">{{ isset($breakouts) && !empty($breakouts->backup_breakout_url_3) ? $breakouts->backup_breakout_url_3 : (old('backup_breakout_url_3') ?: 'Coming Soon') }}
                            </textarea>
                        </div>
                    </div>
                    <div class="row mt-4" id="breakout_section_4" style="{{ isset($breakouts) && isset($breakouts->breakout_label_4) ? 'display:block' : 'display:none' }}">
                        <div class="col-md-6">
                            <label class="form-label">Breakout 4 Label</label>
                            <input type="text" class="form-control" id="breakout_label_4" name="breakout_label_4" placeholder="Breakout 4" maxlength="50" value="{{ isset($breakouts) && !empty($breakouts->breakout_label_4) ? $breakouts->breakout_label_4 : (old('breakout_label_4') ?: 'Breakout 4') }}">
                        </div>
                        <div class="col-md-12 mt-2">
                            <label class="form-label">Breakout 4 Embed URL</label>
                            <textarea class="editor form-control" name="breakout_url_4" placeholder="Coming soon">{{ isset($breakouts) && !empty($breakouts->breakout_url_4) ? $breakouts->breakout_url_4 : (old('breakout_url_4') ?: 'Coming Soon') }}
                            </textarea>
                        </div>

                        <div class="col-md-12 mt-2">
                            <label for="your-subject" class="form-label">Backup Breakout 4 Embed URL</label>
                            <textarea class="editor form-control" name="backup_breakout_url_4" placeholder="Coming soon">{{ isset($breakouts) && !empty($breakouts->backup_breakout_url_4) ? $breakouts->backup_breakout_url_4 : (old('backup_breakout_url_4') ?: 'Coming Soon') }}
                            </textarea>
                        </div>
                    </div>

                    <div class="row mt-4" id="breakout_section_5" style="{{ isset($breakouts) && isset($breakouts->breakout_label_5) ? 'display:block' : 'display:none' }}">
                        <div class="col-md-6">
                            <label class="form-label">Breakout 5 Label</label>
                            <input type="text" class="form-control" id="breakout_label_5" name="breakout_label_5" placeholder="Breakout 5" maxlength="50" value="{{ isset($breakouts) && !empty($breakouts->breakout_label_5) ? $breakouts->breakout_label_5 : (old('breakout_label_5') ?: 'Breakout 5') }}">
                        </div>
                        <div class="col-md-12 mt-2">
                            <label class="form-label">Breakout 5 Embed URL</label>
                            <textarea class="editor form-control" name="breakout_url_5" placeholder="Coming soon">{{ isset($breakouts) && !empty($breakouts->breakout_url_5) ? $breakouts->breakout_url_5 : (old('breakout_url_5') ?: 'Coming Soon') }}</textarea>
                        </div>

                        <div class="col-md-12 mt-2">
                            <label for="your-subject" class="form-label">Backup Breakout 5 Embed URL</label>
                            <textarea class="editor form-control" name="backup_breakout_url_5" placeholder="Coming soon">{{ isset($breakouts) && !empty($breakouts->backup_breakout_url_5) ? $breakouts->backup_breakout_url_5 : (old('backup_breakout_url_5') ?: 'Coming Soon') }}
                            </textarea>
                        </div>
                    </div>

                    <div class="row mt-4" id="breakout_section_6" style="{{ isset($breakouts) && isset($breakouts->breakout_label_6) ? 'display:block' : 'display:none' }}">
                        <div class="col-md-6">
                            <label class="form-label">Breakout 6 Label</label>
                            <input type="text" class="form-control" id="breakout_label_6" name="breakout_label_6" placeholder="Breakout 6" maxlength="50" value="{{ isset($breakouts) && !empty($breakouts->breakout_label_6) ? $breakouts->breakout_label_6 : (old('breakout_label_6') ?: 'Breakout 6') }}">
                        </div>
                        <div class="col-md-12 mt-2">
                            <label class="form-label">Breakout 6 Embed URL</label>
                            <textarea class="editor form-control" name="breakout_url_6" placeholder="Coming soon">{{ isset($breakouts) && !empty($breakouts->breakout_url_6) ? $breakouts->breakout_url_6 : (old('breakout_url_6') ?: 'Coming Soon') }}</textarea>
                        </div>

                        <div class="col-md-12 mt-2">
                            <label for="your-subject" class="form-label">Backup Breakout 6 Embed URL</label>
                            <textarea class="editor form-control" name="backup_breakout_url_6" placeholder="Coming soon">{{ isset($breakouts) && !empty($breakouts->backup_breakout_url_6) ? $breakouts->backup_breakout_url_6 : (old('backup_breakout_url_6') ?: 'Coming Soon') }}</textarea>
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

<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>


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
    // Select all elements with the class 'editor'
    document.querySelectorAll('.editor').forEach(editorElement => {
        ClassicEditor
            .create(editorElement, {
                height: '200px',
            })
            .then(editor => {
                editor.ui.view.editable.element.style.height = '200px';
            })
            .catch(error => {
                console.error(error);
            });
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