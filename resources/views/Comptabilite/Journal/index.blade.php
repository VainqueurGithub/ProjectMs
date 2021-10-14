@extends('layout.base')
@section('content')                        
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
        <section class="content">
      <div class="container-fluid">
                                  <div class="row">
                                         <div class="col-12">
                                    <form method="POST" action=" {{route('Journal.store')}}" name="P_form">  
                                          {{ csrf_field() }}
                                          <div class="row">

                                              <!--div class="col-1">
                                                 <div class="form-group">
                                                    <label>N° ordre</label>
                                                   <input type="text" id="hue" class="form-control" data-control="hue" name="Ordre" value="{{ old('Ordre') ?: $NewJournal
                                                   ->Ordre }}">
                                                   {!! $errors->first('Ordre', '<span class="error">:message</span>') !!}
                                                 </div>
                                              </div-->
                                              
                                              <div class="col-9">
                                                <div class="row">
                                                  <input type="text" name="sc_compte1" id="sc_compte1" style="display: none;">
                                                  <input type="text" name="Csubdiv1" id="Csubdiv1" style="display: none;">

                                              <div class="col-4">
                                                 <div class="form-group">
                                                    <label>Compte D.</label>
                                                  
                                                    <select class="form-control select2" name="CD" target="PromoteFirefoxWindowName" onchange="openSComptesPopUp(this); return false;">
                                                       <option></option>
                                                       @foreach($CompteSubdivisionnaires as $CompteSubdivisionnaire)
                                                          <option value="{{ $CompteSubdivisionnaire->id }}"> {{ $CompteSubdivisionnaire->NumeroCompte}} -- {{ $CompteSubdivisionnaire->Intitule}}</option>
                                                       @endforeach
                                                   </select>
                                                 </div>
                                                 {!! $errors->first('CD', '<span class="error">:message</span>') !!}
                                              </div>

                                              <div class="col-4">
                                                 <div class="form-group">
                                                    <label>Compte C.</label>
                                                    <select class="form-control select2" name="CC" target="PromoteFirefoxWindowName" onchange="openSComptesPopUp(this); return false;">
                                                       <option></option>
                                                       @foreach($CompteSubdivisionnaires as $CompteSubdivisionnaire)
                                                          <option value="{{ $CompteSubdivisionnaire->id }}"> {{ $CompteSubdivisionnaire->NumeroCompte}} -- {{ $CompteSubdivisionnaire->Intitule}}</option>
                                                       @endforeach
                                                   </select>
                                                 </div>
                                                  {!! $errors->first('CC', '<span class="error">:message</span>') !!}
                                              </div>

                                            <div class="col-4" id="sccomte_int1" style="display: none;">

                                              <div class="form-group">

                                              <label>Sous Compte.</label>
                                              <div class="form-inline">

                                                <input type="text" name="sccomte_int1" class="form-control" style="border: none;width:80%;" readonly=""><span target="PromoteFirefoxWindowName" onclick="hideSousComptes(); return false;" style="cursor: pointer;"><i class="fas fa-trash"></i></span>
                                              </div>
                                            </div>
                                          </div>

                                              <div class="col-3">
                                                 <div class="form-group">
                                                     <label>Date Ecr.</label>
                                                   <input type="date" id="hue" class="form-control" data-control="hue" name="DateOperation" value="{{ old('DateOperation') ?: $NewJournal->DateOperation }}">
                                                    {!! $errors->first('DateOperation', '<span class="error">:message</span>') !!}
                                                 </div>
                                              </div>

                                              <div class="col-1">
                                                 <div class="form-group">
                                                    <label>N.Pièce</label>
                                                   <input type="text" id="hue" class="form-control" data-control="hue" name="Piece" value="{{ old('Piece') ?: $NewJournal->Piece }}">
                                                    {!! $errors->first('Piece', '<span class="error">:message</span>') !!}
                                                 </div>
                                              </div>

                                              <div class="col-4">
                                                  <div class="form-group">
                                                    <label>Montant D.</label>
                                                   <input type="text" id="hue-demo" class="form-control" data-control="hue" name="MD" value="{{ old('MD') ?: $NewJournal->MD }}" style="display:;" id="MD">
                                                    {!! $errors->first('MD', '<span class="error">:message</span>') !!}
                                                 </div> 
                                              </div>

                                              <div class="col-4">
                                                  <div class="form-group">
                                                    <label>Montant C.</label>
                                                   <input type="text" id="hue-demo" class="form-control" data-control="hue" name="MC" value="{{ old('MC') ?: $NewJournal->MC }}" style="display:;" id="MC">
                                                    {!! $errors->first('MC', '<span class="error">:message</span>') !!}
                                                 </div> 
                                              </div>

                                              <div class="col-2">
                                                  <div class="form-group">
                                                   <button style="margin-top: 30px;" type="submit" class="form-control btn btn-success">Valider</button>
                                                 </div> 
                                              </div>

                                                </div>
                                              </div>


                                              <div class="col-3">
                                                  <div class="form-group">
                                                    <label>Libelle.</label>
                                                    <textarea id="hue-demo" class="form-control" data-control="hue" name="Libelle">{{ old('Libelle')}}</textarea>
                                                
                                                    {!! $errors->first('Libelle', '<span class="error">:message</span>') !!}
                                                 </div> 
                                              </div>
                                          </div>
                                           </form>  
                                        </div>
                                  </div>
                                </div>
                              </section>


    <section class="content">
      <div class="container-fluid">
        <div class="row">
                                <div class="table-responsive">
                                   <div class="col-12">
                                    <table id="example1" class="table table-striped">
                                        <thead>
                                            <tr style="text-align: center;">
                                                <th rowspan="2">Date</th>
                                                <th rowspan="2">N° d'ordre</th>
                                                <th colspan="2">N° des comptes</th>
                                                <th rowspan="2">Intitulé</th>
                                                <th colspan="2">Montants</th>
                                                <th rowspan="2">Action</th>
                                            </tr>

                                            <tr>
                                                <th>D</th>
                                                <th>C</th>
                                                <th>Débit</th>
                                                <th>Crédit</th>
                                            </tr>

                                        </thead>
                                        <tbody>
                                          @foreach($Journals as $Journ)
                                            @if($Journ->TypeMvt==1)
                                              <tr>
                                                <td>
                                                  {{Carbon\Carbon::parse($Journ->DateOperation)->format('d-m-Y')}}</td>
                                                <td>{{$Journ->id}}</td>
                                                <td>{{$Journ->NumeroCompte}}</td>
                                                <td></td>
                                                <td>{{$Journ->Libelle}}</td>
                                                <td>{{number_format($Journ->MD,session()->get('ExerciceNbreDecimal'),session()->get('ExerciceSeparateurDecimal'),session()->get('ExerciceseparateurMilieu')).' '.session()->get('ExerciceDevise')}}</td>
                                                <td>{{number_format($Journ->MC,session()->get('ExerciceNbreDecimal'),session()->get('ExerciceSeparateurDecimal'),session()->get('ExerciceseparateurMilieu')).' '.session()->get('ExerciceDevise')}}</td>

                                                <td><a href="{{route('Journal.edit', $Journ->id)}}"><i class="fas fa-edit"></i></a>
                                                  <form action="{{route('Journal.destroy', $Journ->id)}}" method="POST" style="display: inline-block;" onsubmit="return confirm('Etez -vous sur de cette Operation ?')">
                                                    {{csrf_field()}}
                                                    {{method_field('DELETE')}}
                    
                                                  <button onclick="return confirm('Etez -vous sur de cette Operation ?')"><i class="fas fa-trash"></i></button>
                                                  </form>
                                                </td>
                                              </tr>
                                            @elseif($Journ->TypeMvt==2)
                                               <tr>
                                                <td>{{$Journ->DateOperation}}</td>
                                                <td>{{$Journ->id}}</td>
                                                <td></td>
                                                <td>{{$Journ->NumeroCompte}}</td>
                                                <td>{{$Journ->Libelle}}</td>
                                                <td>{{number_format($Journ->MD,session()->get('ExerciceNbreDecimal'),session()->get('ExerciceSeparateurDecimal'),session()->get('ExerciceseparateurMilieu')).' '.session()->get('ExerciceDevise')}}</td>
                                                <td>{{number_format($Journ->MC,session()->get('ExerciceNbreDecimal'),session()->get('ExerciceSeparateurDecimal'),session()->get('ExerciceseparateurMilieu')).' '.session()->get('ExerciceDevise')}}</td>

                                                <td> <a href="{{route('Journal.edit', $Journ->id)}}"><i class="fas fa-edit"></i></a>
                                                  <form action="{{route('Journal.destroy', $Journ->id)}}" method="POST" style="display: inline-block;" onsubmit="return confirm('Etez -vous sur de cette Operation ?')">
                                                    {{csrf_field()}}
                                                    {{method_field('DELETE')}}
                    
                                                  <button onclick="return confirm('Etez -vous sur de cette Operation ?')"><i class="fas fa-trash"></i></button>
                                                  </form>
                                                </td>
                                              </tr>
                                            @endif
                                             
                                          @endforeach
                                         
                                        </tbody>
                                        <tfoot>
                                             <tr>
                                                <td></td>
                                              <!--   <td></td>
                                                <td></td>
                                                <td></td> -->
                                                <td colspan="4">TOTAL</td>
                                                <td>{{ $MD }}</td>
                                                <td>{{ $MC }}</td>
                                                <td></td>
                                             </tr>   
                                        </tfoot>
                                    </table>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </section>
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
var WindowObjectReference = null; // variable globale
function openSComptesPopUp(va) {
     var id = $(va).val();
     var url = "{{ route('Comptedivisionnaire.show', ":id") }}";
     url = url.replace(':id', id);
  if (WindowObjectReference == null || WindowObjectReference.closed) {
    WindowObjectReference = window.open(url,'rating', "width=500,height=250,left=540,top=400,resizable,scrollbars=yes,status=1,menubar=no");
  }
  else {
    WindowObjectReference.focus();
  };
}

function hideSousComptes() {
      var SousId = $('#Csubdiv1').val();
      document.P_form.sc_compte1.value = '';
      document.P_form.sccomte_int1.value = '';
      document.getElementById('sccomte_int1').style.display = 'none';
      var url = "{{ route('Comptedivisionnaire.show', ":SousId") }}";
      url = url.replace(':SousId', SousId);
      if (WindowObjectReference == null || WindowObjectReference.closed) {
        WindowObjectReference = window.open(url,'rating', "width=500,height=250,left=540,top=400,resizable,scrollbars=yes,status=1,menubar=no");
      }
      else {
        WindowObjectReference.focus();
      };
}
</script>                                                                          