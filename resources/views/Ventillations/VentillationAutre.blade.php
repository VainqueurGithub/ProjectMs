@extends('layout.base', ['title' => ' Generer Journal'])
@section('content')
        <div id="page-wrapper" >
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
        <h2 style="color: blue;font-weight: bold;">VENTILLATION GRUPE</h2>  
            <h5>GENERER 
            LA VENTILLATION </h5>
           
        </div>
                </div>
                 <!-- /. ROW  -->
                 <hr />
               <div class="row">
                <div class="col-md-12">
                    <!-- Form Elements -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                             Rechercher
                        </div>
                        <div class="panel-body">
                                    <form role="form" method="POST" action="{{ route('CreateGroupe')}}">
                                      {{ csrf_field() }}
                                    <div class="row">  
                                    <div class="col-md-3">
                                        <div class="form-group">
                                        <label for="disabledSelect">Origine</label>
                                          <select class="form-control" name="Origine">
                                            <option disabled="disabled" selected="selected">Groupe</option>
                                            @foreach($Partenaires as $Partenaire)
                                            <option value="{{ $Partenaire->Origine }}">{{ $Partenaire->Origine }}</option>
                                            @endforeach
                                            
                                           </select>
                                          </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                          <label for="disabledSelect">Du:</label>
                                          <input class="form-control"  type="date" name="debut" required="required"  />
                                        </div>
                                    </div>  
                                      
                                     
                                <div class="col-md-3">
                                <div class="form-group">
                                    <label for="disabledSelect">Au:</label>
                                    <input class="form-control"  type="date" name="Fin" required="required"  />
                                </div>
                                </div>
                                
                                <div class="col-md-3">
                                <div class="form-group">
                                    <label for="disabledSelect"></label>
                                    <input class="form-control btn btn-info"  type="submit" value="Rechercher"  />
                                </div>
                                </div>
                                </div>
                                    </form>
                                   <br />                    
                                
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
