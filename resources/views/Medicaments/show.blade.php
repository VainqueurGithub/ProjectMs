@extends('layout.base', ['title' => 'Assurance - Ayant Droit'])
@section('content')

 <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
               <div class="row">
                <div class="col-md-9"></div>
                  <div class="col-md-3">
                             <!--a href="{{ route('PdfAllMedicaments') }}" target="blank" class="btn btn-primary">
                            <i class="fa fa-print"></i> Imprimer la Liste 
                            </a-->
                        
                  </div>
                </div>
             </div>
           </section>


          <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
              <div class="card">
              <div class="card-header">
                <div class="row">
                  <div class="col-md-8"></div>
                  <div class="col-md-4">
                     <a href="{{ route('RattacherPartenaire', $id) }}" style="text-decoration: none;color: white">
                        <div class="btn btn-info pull-right"  style="margin-top: -5px">
                        <i class="fa fa-plus"></i> Rattacher à un Partaire
                    </a>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Code</th>
                                            <th>Libellé</th>
                                            <th>Partenaire</th>
                                            <th>Prix</th>
                                            <th>Enregistrer le</th>
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
                                      <td>{!! date('d/M/y', strtotime($result->created_at)) !!}</td>
                                      <td><a href="{{route('ChangerPrix',$result->id)}}">Changer Prix</a></td>
                                      <td class="center f-icon">
                            <form action="{{route('medicamentPartenaire.destroy',$result->id)}}" method="POST">
                            <a href="{{route('medicamentPartenaire.edit',$result->id)}}"><i class="fa fa-edit"></i></a>
                            
                                {{csrf_field()}}
                                {{method_field('DELETE')}}
                                <button style="border: none;"><i class="fa fa-trash"></i>
                                    </button>
                            </form>
                            
                </td>
                <td>
                    <a href="{{route('Historique',$result->id)}}"><i class="fa fa-clock"></i></a>
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
@endsection 
