@extends('layout.base', ['title' => 'Affiliers En Corbeille'])
@section('content')
              <div id="page-wrapper" >
            <div id="page-inner">
                <div class="row">
                  <div class="col-md-12">
                    <h2 style="color: red;font-weight: bold;text-align: center;">LISTE DES AFFILIERS SUPPRIMES</h2>   
                       
                  </div>
                </div>
               <hr />
                 <!-- /. ROW  -->
                
               
            <div class="row">
                <div class="col-md-12">
                    <!-- Advanced Tables -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           Liste des Affiliers Supprimés
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th><input type="checkbox" name="Affilier" class="form-control" onclick="checkall()"></th>
                                            <th>Code</th>
                                            <th>Adherant</th>
                                            <th>Origine</th>
                                            <th>Date Entrée</th>
                                            <th>Cot.Mens</th>
                                            <th>S.A</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                      @foreach ($Affiliers as $Affilier)

                                         <tr class="odd gradeX">
                                            <td><input type="checkbox" name="Affilier" class="checkboxid" value="{{ $Affilier->id }}"></td>
                                            <td>{{ $Affilier->Code }}</td>
                                            <td>{{ $Affilier->Nom }} {{ $Affilier->Prenom }}</td>
                                            <td>{{ $Affilier->Origine }}</td>
                                            <td>{{ $Affilier->DateEntree }}</td>
                                            <td>{{ $Affilier->CotisationM }}</td>
                                            <td>{{ $Affilier->SoinsAmbilatoire }}%</td>
                                             <td>
                                               <a href="{{ route('RestaureAff', $Affilier) }}"><img src="{{ url('icons/icons8_Reset_24px.png') }}" width="20px" height="20px"></a>

                                               <form action="{{ route('SupprimerDef', $Affilier)}}" method='POST' style="display: inline-block;">
                                               {{ csrf_field() }} 
                                                {{ method_field('DELETE') }}
                                                <button><i class='fa fa-trash'></i>
                                              </button>
                                
                                                </form>
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
        </div>
               
    </div>
             <!-- /. PAGE INNER  -->
@endsection 
<script type="text/javascript">
  function checkall(){
    document.getElementByNameClass("uploadForm").style.display = 'block';
  }
</script>