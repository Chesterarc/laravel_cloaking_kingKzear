@extends('backend.layouts.app')

@section('title', app_name() . ' | ' . __('labels.backend.access.email-templates.management'))

@section('breadcrumb-links')
@include('backend.email-templates.includes.breadcrumb-links')

@endsection
@section('content')

<div class="alert alert-success" id="message" style="display:none;" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
    </button>
    Success.
</div>
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-3">
                <button class="btn btn-primary btn-danger" onclick="block_btn()">Block Countries</button>
            </div>
            <div class="col-sm-2">
                <span>Blocked/Unblocked:</span>
            </div>
            <div class="col-sm-5">
                <select class="form-control" style="width:50%" id="country_key">
                </select>
            </div>
            <div class="col-sm-2">
                <a class="btn btn-primary" href="/admin/email-templates/create">Create Country</a>
            </div>
            <!--col-->
        </div>
        <!--row-->

        <div class="row mt-4">
            <div class="col">
                <div class="table-responsive">
                    <table id="email-templates-table" class="table" data-ajax_url="{{ route("admin.emailTemplates.get") }}">
                        <thead>
                            <tr>
                                <th>{{ trans('labels.backend.access.email-templates.table.title') }}</th>
                                <th>{{ trans('labels.backend.access.email-templates.table.content') }}</th>
                                <th>{{ trans('labels.backend.access.email-templates.table.third') }}</th>
                                <th>{{ trans('labels.backend.access.email-templates.table.status') }}</th>
                                <th>{{ trans('labels.general.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
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
        FTX.EmailTemplate.list.init();
    });

    function block_btn()
    {
        $.ajax({
          type: 'post',
          url: '/update_data',
          dataType: 'json',
          data: {'block_id': $('#country_key').val()},
          success: function success(result) {
            if(result.success == "true")
            {
                $('#message').removeAttr('style');       
                setTimeout(() => {
                    location.href = '/admin/email-templates';
                }, 2000);    
             }
          },
          error: function error() {
            alert("error");
          }
        });
    }
    $(document).ready(function(){
        $.ajax({
          type: 'post',
          url: '/get_data',
          dataType: 'json',
          success: function success(result) {
            var data = result.data;
            var html = '';
            html+= '<option value="0">'+ 'All' +'</option>';
            for(var i= 0; i < data.length; i++)
            {
                html += '<option value="'+ data[i].id +'">'+ data[i].content +'</option>';
            }
            $('#country_key').html(html);

          },
          error: function error() {
          }
        });
    });
</script>
@stop