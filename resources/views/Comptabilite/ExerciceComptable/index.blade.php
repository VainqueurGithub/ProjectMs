@extends('layout.base')
@section('content')                        
  <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
              <div class="card">
              <div class="card-header">
                <h3 class="card-title">Exercice comptable</h3>
                <div class="row">
                  <div class="col-md-9"></div>
                  <div class="col-md-3">
                    <a href="javascript:void(0)" data-toggle="modal" data-target="#add-new-event" class="btn m-t-20 btn-info btn-block waves-effect waves-light">
                        <i class="ti-plus"></i> Nouvel Exercice
                    </a>
                  </div>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-striped">
                  <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Debut</th>
                                                <th>Fin</th>
                                                <th>Devise</th>
                                                <th>Nbre Decimal</th>
                                                <th>Sep.Decimal</th>
                                                <th>Sep.Milier</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                          @foreach($Exercices as $Exercice) 
                                               <tr>
                                                 <td>{{ $Exercice->id}}</td>
                                                 <td>{{ $Exercice->Debut}}</td>
                                                 <td>{{ $Exercice->Fin }}</td>
                                                 <td>{{ $Exercice->Devise }}</td>
                                                 <td>{{ $Exercice->NbreDecimal }}</td>
                                                 <td>{{ $Exercice->separateurDecimal }}</td>
                                                 <td>{{ $Exercice->separateurMilieu }}</td>
                                                 <td>
                                                   <a href="{{ route('ExerciceComptable.edit', $Exercice->id)}}"><i class='fas fa-edit'></i></a>
                                                <form action="{{route('ExerciceComptable.destroy', $Exercice->id)}}" method='POST' style='display: inline-block;' onsubmit="return confirm('Etez-vous sur de cette Operation ?')">
                                                {{ csrf_field()}}
                                                {{method_field('DELETE')}}
                    
                                                <button onclick="return confirm('Etez -vous sur de cette Operation ?')"><i class='fas fa-trash'></i>
                                                </button>
                                               </form>
                                               
                                               @if($Exercice->Cloturer==0)
                                                <!--a title="Cloture L'Exercice Comptable" href="{{ route('CloseExercice', $Exercice->id)}}" onclick="return confirm('Etez -vous sur de cloturer cet Exercice Comptable ?')"><i class='far fa-check-circle'></i></a-->
                                                 
                                                <button value="{{$Exercice->id}}" class="btn btn-secondary" onclick="getExercice(this);" data-toggle="modal" data-target="#assistantnewexercice">
                                                    <i class='far fa-check-circle'></i>
                                                </button>
                                                 <a title="Cloture L'Exercice Comptable" href="{{ route('CloseExercice', $Exercice->id)}}" onclick="return confirm('Etez -vous sur de cloturer cet Exercice Comptable ?')"></a>

                                               @elseif($Exercice->Cloturer==1) 
                                               <a title="Reouvrir L'Exercice Comptable" href="{{ route('ReouvrirExercice', $Exercice->id)}}" onclick="return confirm('Etez -vous sur de vouloir Reouvrir cet Exercice Comptable ?')"><i class='fas fa-window-close'></i></a>
                                               @endif
                                                 </td>
                                               </tr>
                                          @endforeach
                                         </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!--End Advanced Tables -->
                </div>
            </div>
        </section>
      </div>
                     <!-- Modal Add Category -->
                <div class="modal fade none-border" id="add-new-event">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title"><strong>Creer un Exercice Comptable</strong></h4>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            </div>
                        <form method="POST" action="{{ route('ExerciceComptable.store')}}" onsubmit='return confirm("Avant d\'effectuer cette Operation assurez-vous d\'avoir repporté données de l\'exercice précedente")'>

                            <div class="modal-body">
                                    {{ csrf_field() }}
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label class="control-label">Debut *</label>
                                            <input class="form-control form-white" placeholder="Debut Exercice Comptable" type="date" name="Debut" />
                                            {!! $errors->first('Debut', '<span class="error">:message</span>') !!}

                                            <label class="control-label">Devise *</label>
                                            <input class="form-control form-white" placeholder="Devise" type="text" name="Devise" />
                                            {!! $errors->first('Devise', '<span class="error">:message</span>') !!}

                                            <label class="control-label">Separateur decimal *</label>
                                            <input class="form-control form-white" placeholder="Separateur decimal" type="text" name="SeparateurDecimal" />

                                            {!! $errors->first('SeparateurDecimal', '<span class="error">:message</span>') !!}
                                        </div>
                                        <div class="col-md-6">

                                            <label class="control-label">Fin *</label>
                                            <input class="form-control form-white" placeholder="Fin Exercice Comptable" type="date" name="Fin" />
                                            {!! $errors->first('Fin', '<span class="error">:message</span>') !!}

                                            <label class="control-label">Nbre decimal *</label>
                                            <input class="form-control form-white" placeholder="Nombre decimal" type="text" name="NbreDecimal" />
                                            {!! $errors->first('NbreDecimal', '<span class="error">:message</span>') !!}

                                            <label class="control-label">Separateur du Milier *</label>
                                            <input class="form-control form-white" placeholder="Separateur du Milier" type="text" name="SeparateurMilieu" />
                                            {!! $errors->first('SeparateurMilieu', '<span class="error">:message</span>') !!}
                                        </div>
                                    </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary waves-effect waves-light save-category" onsubmit='return confirm("Avant d\'effectuer cette Operation assurez-vous d\'avoir repporté données de l\'exercice précedente")'>Enregistrer</button>
                                <button type="reset" class="btn btn-secondary waves-effect" data-dismiss="modal">Annuler</button>
                            </div>
                           </form> 
                        </div>
                    </div>
                </div>
                <!-- END MODAL -->






                     <!-- Modal Add Category -->
                <div class="modal fade none-border" id="assistantnewexercice">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title"><strong>Assistant de cloture d'un exercice comptable</strong></h4>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            </div>

                            <div class="col-12">
                                
                            </div>
                        <form method="POST" name="myForm" action="{{route('CloseExercice')}}">
                            <div class="modal-body">
                                    {{ csrf_field() }}
                                    <div class="row">
                                        <div class="col-md-12">
                                            
                                            <input type="text" style="display: none;" name="Exerciceid" id="Exerciceid">
                                            
                                            <div class="form-inline">
                                            <input type="radio" class="form-control" name="optioncheck" checked="" value="1" onclick="desappearinput()"> <label> Tous les comptes </label></div>
                                            
                                            <div class="form-inline">
                                            <input type="radio" class="form-control" name="optioncheck" value="2" onclick="appearinput()"> <label> Plage de compte</label> </div>
                                            
                                            <div class="form-inline">
                                            <input type="radio" class="form-control" name="optioncheck" value="3" onclick="appearinput()"> <label> Liste de compte </label> </div> <br>
                                            
                                            <div style="display: none;" id="inputcompte">
                                            <label class="control-label">Spécifiez les comptes concernés par le repport </label>
                                            <input class="form-control form-white" placeholder="Les comptes concernés par le repport" type="text" name="comptes" />
                                            {!! $errors->first('comptes', '<span class="error">:message</span>') !!}
                                        </div>
                                        </div>
                                    </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary waves-effect waves-light save-category" id="cloturer" onclick="return isEmpty();">Cloturer</button>
                                <button type="reset" class="btn btn-secondary waves-effect" data-dismiss="modal">Annuler</button>
                            </div>
                           </form> 
                        </div>
                    </div>
                </div>
                <!-- END MODAL -->


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
<script type="text/javascript">
    function getExercice(va){
    var exercice = $(va).val();
      $("#Exerciceid").val(exercice);
  }

   function desappearinput(){
    document.getElementById("inputcompte").style.display = 'none';
    document.getElementById("cloturer").style.display = 'block';
  }

  function appearinput(){
    document.getElementById("inputcompte").style.display = 'block';
    //document.getElementById("cloturer").style.display = 'none';
  }

  function isEmpty(){
    
    if(document.forms['myForm'].optioncheck.value==1){
        document.forms["myForm"].submit();
    }else{
         var str = document.forms['myForm'].comptes.value;
          if( !str.replace(/\s+/, '').length ) {
             alert( "Veuillez reiseinger les comptes a repport!" );
             return false;
         }else{
            document.forms["myForm"].submit();
         }
    }
    return confirmSubmit();
  }


function confirmSubmit()
{
   var agree=confirm("Vous êtes sur le point de clôturer cet exercice, Apres cette opération aucune modification ne sera possible pour cet exercice, vous n’aurez accès qu’à la consultation de vos données.");
    if (agree)
      return true ;
    else
      return false ;
}
</script>                        