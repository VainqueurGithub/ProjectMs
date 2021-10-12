@extends('layout.base', ['title' => 'Assurance - Edition Facture'])
@section('content')
        <div id="page-wrapper" >
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
        <h2 style="color: blue;font-weight: bold;text-align: center;">Edition Facture</h2>
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
                                    <form role="form" method="POST" action="{{ route('Factures.update', $Facture)}}">
                                      {{ csrf_field() }}
                                      {{ method_field('PUT') }}
                                      <div class="col-md-6">
                                        <div class="form-group">
                                    <label>Date Payement</label>
                                            <input type="date" class="form-control" name="DatePay" placeholder="Date Payement" value="{{ $Facture->DatePayement }}" />

                                            {!! $errors->first('DatePay', '<span class="error">:message</span>') !!}
                                        </div>

                                        <div class="form-group">
                                            <label>Mode Payement</label>
                                            <input type="text" class="form-control" placeholder="Mode Payement" name="ModePay" value="{{ old('ModePay') ?: $Facture->ModePayement }}" />

                                            {!! $errors->first('ModePay', '<span class="error">:message</span>') !!}
                                        </div>
                                       <label></label><br>
                                        <button type="submit" name="Payement" class="btn btn-primary">Modifier</button>
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
