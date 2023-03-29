@extends('backend.layouts.app')

@section('title', app_name() . ' | ' . __('labels.backend.access.pages.management'))

@section('breadcrumb-links')
@include('backend.pages.includes.breadcrumb-links')
@endsection

@section('content')
<div class="alert alert-success" id="message" style="display:none;" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
    </button>
    File has been uploaded successfully
</div>
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-5">
                <h4 class="card-title mb-0">
                    Upload Database <small class="text-muted"></small>
                </h4>
            </div>
            <!--col-->
        </div>
        <!--row-->

        <div class="row mt-4">
            <div class="col">
            <form method="POST" enctype="multipart/form-data" id="laravel-ajax-file-upload" action="javascript:void(0)" >
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <input type="file" name="file" placeholder="Choose File" id="file">
                            <span class="text-danger">{{ $errors->first('file') }}</span>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary" id="transport">Submit</button>
                    </div>
                </div>     
            </form>
            </div>
            <!--col-->
        </div>
        <!--row-->

    </div>
    <!--card-body-->
</div>
<!--card-->
@endsection

@section('pagescript')
<script>
    FTX.Utils.documentReady(function() {
        FTX.Pages.list.init();
    });
$(document).ready(function (e) {
    $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    $('#laravel-ajax-file-upload').submit(function(e) {
        e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                type:'POST',
                url: '/admin/pages/store_data',
                data: formData,
                cache:false,
                contentType: false,
                processData: false,
                success: (data) => {
                    this.reset();
                    $('#message').removeAttr('style');       
                    $('#transport').removeAttr('disabled');       

                },
                error: function(data){
                    console.log('error');
            }
        });
    });
});
</script>
@endsection