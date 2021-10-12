@extends('layout.base', ['title' => 'Assurance - Ventillation General'])

@section('content')
              <div id="page-wrapper" >
            <div id="page-inner">
                <div class="row">
                  <div class="col-md-7">
                    <h2 style="color: blue;font-weight: bold;text-align: center;">VENTILLATION GENERALE</h2>   
                  </div>
                  <div class="col-md-5">
                     <form method="POST" action="{{ route('PdfCreateGeneral')}}">
                        {{ csrf_field() }}
                        <div class="row" style="width:94%;">
                            <div class="col-md-5">
                              <div class="form-group">
                                 <label>Du :</label>
                                 <input type="date" class="form-control" name="Debut"/>
                                </div>
                            </div>

                            <div class="col-md-5">
                              <div class="form-group">
                                <label>Au :</label>
                                <input type="date" class="form-control" name="Fin"/>
                              </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                <label style="visibility: hidden;">Rech</label>
                                <button type="submit" class="btn btn-primary">Rechercher</button>
                                </div> 
                            </div>
                        </div>
                     </form> 
                  </div>
                </div>
               <hr />
                 <!-- /. ROW  -->
            <div class="row">
                <div class="col-md-12">
                    <!-- Advanced Tables -->
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>ADHERANT</th>
                                            <th>JAN.</th>
                                            <th>FEV.</th>
                                            <th>MARS</th>
                                            <th>AVRIL</th>
                                            <th>MAI</th>
                                            <th>JUIN</th>
                                            <th>JUILLE</th>
                                            <th>AOUT</th>
                                            <th>SEPT.</th>
                                            <th>OCTO.</th>
                                            <th>NOV.</th>
                                            <th>DEC.</th>
                                            <th>TOTAL</th>
                                            <th>ECART</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                       {!! $tableListe !!}
                                       
                                    </tbody>
                                    <tfoot>
                                        @foreach($Somme as $S)
                                        <tr>
                                           <th>{{ $S->AF }}</th>
                                            <th>{{ $S->J }}</th>
                                            <th>{{ $S->F }}</th>
                                            <th>{{ $S->M }}</th>
                                            <th>{{ $S->A }}</th>
                                            <th>{{ $S->Ma }}</th>
                                            <th>{{ $S->Ju }}</th>
                                            <th>{{ $S->Jui }}</th>
                                            <th>{{ $S->Ao }}</th>
                                            <th>{{ $S->S }}</th>
                                            <th>{{ $S->O }}</th>
                                            <th>{{ $S->N }}</th>
                                            <th>{{ $S->D }}</th>
                                            <th>{{ $S->ST }}</th>
                                            <th>ECART</th>
                                       </tr>
                                       @endforeach
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!--End Advanced Tables -->
                </div>
            </div>
        </div>
               
    </div>
             <!-- /. PAGE INNER  -->
@endsection 
