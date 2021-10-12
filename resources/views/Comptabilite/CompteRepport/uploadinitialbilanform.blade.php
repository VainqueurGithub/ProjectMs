@extends('layout.base')
@section('content')                        
                         <!-- ============================================================== -->
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
           
            <!-- ============================================================== -->
            <!-- End Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                   <div class="col-12">
                                       <form method="POST" action="{{ route('uploadfile') }}" enctype="multipart/form-data">
                @csrf
                <div class="gst form-group">
                    <input name="file" id="poster" type="file" class="form-control"><br/>
                    <div class="progress">
                        <div class="bar"></div >
                        <div class="percent">0%</div >
                    </div>
                    <input type="submit"  value="Submit" class="btn btn-success">
                </div>
            </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- End PAge Content -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Right sidebar -->
                <!-- ============================================================== -->
                <!-- .right-sidebar -->
                <!-- ============================================================== -->
                <!-- End Right sidebar -->
                <!-- ============================================================== -->
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->

@endsection
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.js"></script>
<script src="//malsup.github.com/jquery.form.js"></script>
@section('content2')


<script type="text/javascript">

    function validate(formData, jqForm, options) {
        var form = jqForm[0];
        if (!form.file.value) {
            alert('File not found');
            return false;
        }
    }

    (function() {

    var bar = $('.bar');
    var percent = $('.percent');
    var status = $('#status');

    $('form').ajaxForm({
        beforeSubmit: validate,
        beforeSend: function() {
            status.empty();
            var totalValPercentage = '0%';
            var posterValue = $('input[name=file]').fieldValue();
            bar.width(totalValPercentage)
            percent.html(totalValPercentage);
        },
        uploadProgress: function(event, position, total, percentComplete) {
            var totalValPercentage = percentComplete + '%';
            bar.width(totalValPercentage)
            percent.html(totalValPercentage);
        },
        success: function() {
            var totalValPercentage = 'Wait, Saving';
            bar.width(totalValPercentage)
            percent.html(totalValPercentage);
        },
        complete: function(xhr) {
            status.html(xhr.responseText);
            alert('Good Luck Your File or Images Uploaded Successfully');
            window.location.href = "/live-img-file-upload-example";
        }
    });

    })();
</script>
@endsection