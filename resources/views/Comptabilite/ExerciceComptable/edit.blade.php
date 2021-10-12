@extends('layout.base')
@section('content')  
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <div class="page-breadcrumb">
                <div class="row">
                    <div class="col-12 d-flex no-block align-items-center">
                        <h4 class="page-title">Modification d'un Exercice Comptable</h4>
                        <div class="ml-auto text-right">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Library</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
          
            <div class="container-fluid">
                <div class="container-fluid">
                
                        <div class="card">
                            <div class="card-body">
                                <form method="POST" action="{{route('ExerciceComptable.update', $ExerciceComptable)}}">

                              {{ csrf_field() }}
                              {{ method_field('PUT') }}

                                <div class="row">
                                <div class="col-6">
                                     <div class="form-group">
                                       <label for="hue-demo">Debut *</label>
                                       <input type="date" id="hue-demo" class="form-control" value="{{ old('Debut') ?: $ExerciceComptable->Debut }}" name="Debut">

                                       {!! $errors->first('Debut', '<span class="error">:message</span>') !!}
                                    </div> 

                                     <div class="form-group">
                                       <label for="hue-demo">Devise *</label>
                                       <input type="text" id="hue-demo" class="form-control" value="{{ old('Devise') ?:$ExerciceComptable->Devise }}" name="Devise">

                                       {!! $errors->first('Prenom', '<span class="error">:message</span>') !!}
                                    </div> 

                                    <div class="form-group">
                                       <label for="hue-demo">Nombre decimal *</label>
                                       <input type="text" id="hue-demo" class="form-control" value="{{ old('NbreDecimal') ?: $ExerciceComptable->NbreDecimal }}" name="NbreDecimal">

                                       {!! $errors->first('NbreDecimal', '<span class="error">:message</span>') !!}
                                    </div>
                              </div>
                              <div class="border-top">
                                <div class="card-body">
                                    <button type="submit" class="btn btn-success">Modifier</button>
                                    <button type="reset" class="btn btn-danger">Annuler</button>
                                </div>
                               </div>
                              <div class="col-6">

                                    <div class="form-group">
                                       <label for="hue-demo">Fin *</label>
                                       <input type="text"  class="form-control" value="{{ old('Fin') ?: $ExerciceComptable->Fin }}" name="Fin">

                                       {!! $errors->first('Fin', '<span class="error">:message</span>') !!}
                                    </div>  
                                   
                               
                                       <div class="form-group">
                                       <label for="hue-demo">separateur Decimal *</label>
                                       <input type="text" class="form-control" value="{{ old('SeparateurDecimal') ?: $ExerciceComptable->separateurDecimal}}" name="SeparateurDecimal">

                                       {!! $errors->first('SeparateurDecimal', '<span class="error">:message</span>') !!}
                                    </div> 

                                     <div class="form-group">
                                       <label for="hue-demo">separateur Milieu *</label>
                                       <input type="text" class="form-control" value="{{ old('separateurMilieu') ?: $ExerciceComptable->separateurMilieu }}" name="separateurMilieu">

                                       {!! $errors->first('separateurMilieu', '<span class="error">:message</span>') !!}
                                    </div> 
                              </div>

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
           @endsection