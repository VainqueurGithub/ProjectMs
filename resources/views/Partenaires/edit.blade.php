@extends('layout.base', ['title' => 'Assurance - Edition Partenaire'])
@section('content')
        <div id="page-wrapper" >
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
        <h2 style="color: blue;font-weight: bold;text-align: center;">Edition Partenaire</h2>
        </div>
                </div>
                 <!-- /. ROW  -->
                 <hr />
               <div class="row">
                <div class="col-md-12">
                    <!-- Form Elements -->
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <form role="form" method="POST" action="{{ route('Partenaires.update', $Partenaire)}}">
                                      {{ csrf_field() }}
                                      {{ method_field('PUT') }}
                                        @include('Partenaires._Form', ['ButtonSubmitTexe'=>'Modifier'])
                                        <button type="reset" class="btn btn-default">Annuler</button>
                                      </div>
                                     
                                    </form>
                                    <br />                    
    </div>

                            </div>
                        </div>
                    </div>
                     <!-- End Form Elements -->
                </div>
            </div>
    </div>
             <!-- /. PAGE INNER  -->
            </div>
         <!-- /. PAGE WRAPPER  -->
@endsection 
