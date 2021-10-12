@extends('layout.base', ['title' => 'Assurance - Ayant Droit'])
@section('content')
        <div id="page-wrapper" >
            <div id="page-inner">
               <div class="row">
                  <div class="col-md-8">
                    <h2 style="color: blue;font-weight: bold;text-align: center;">LISTE DES MEDICAMENTS ET SERVICES</h2>    
                  </div>
                  <div class="col-md-4">
                     
                            <a href="{{ route('PdfAllMedicaments') }}" target="blank" style="text-decoration: none;color: white">
                             <div class="btn btn-info pull-right"  style="margin-top: -5px">
                            <i class="fa fa-print"></i> Imprimer la Liste 
                            </a>
                        
                  </div>
                </div>
               <hr />
                 <!-- /. ROW  -->
               <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                      @if(session()->get('Profil')=='User')
                       <div class="panel-heading">
                             <a href="{{ route('RattacherPartenaire', $id) }}" style="text-decoration: none;color: white">
                             <div class="btn btn-info pull-right"  style="margin-top: -5px">
                            <i class="fa fa-plus"></i> Rattacher à un Partaire
                            </a>
                        </div><br />
                      @endif  
                      <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>Code</th>
                                            <th>Libellé</th>
                                            <th>Partenaire</th>
                                            <th>Prix</th>
                                            <th>Date Enregistrement</th>
                                            <th>Changer Prix</th>
                                            <th>Action</th>
                                            <th>Historique</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($results as $result) 
                                     <tr>
                                      <td>{{$result->code}}</td>
                                      <td>{{$result->propriete}}</td>
                                      <td>{{$result->Partenaire}}</td>
                                      <td>{{$result->prix}}</td>
                                      <td>{{$result->created_at}}</td>
                                      <td><a href="{{route('ChangerPrix',$result->id)}}">Changer Prix</a></td>
                                      <td class="center f-icon">
                            <form action="{{route('medicamentPartenaire.destroy',$result->id)}}" method="POST">
                            <a href="{{route('medicamentPartenaire.edit',$result->id)}}"><i class="fa fa-pencil"></i></a>
                            
                                {{csrf_field()}}
                                {{method_field('DELETE')}}
                                <button><img src="{{url('icons/icons8_Delete_52px.png')}}" width="20px" height="20px">
                                    </button>
                            </form>
                            
                </td>
                <td>
                    <a href="{{route('Historique',$result->id)}}"><img src="{{url('icons/icons8_Clock_32px.png')}}" width="20px" height="20px"></a>
                </td>
            </tr>
            @endforeach

        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                      </div>
                      </div>
                     </div>
                </div>
            </div>
    </div>
             <!-- /. PAGE INNER  -->
            </div>
         <!-- /. PAGE WRAPPER  -->
@endsection 
