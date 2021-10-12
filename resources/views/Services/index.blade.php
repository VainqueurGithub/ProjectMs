@extends('layout.base', ['title' => 'Assurance - Nos Services'])
@section('content')
<div class="content-wrapper">
 <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
              <div class="card">
              <div class="card-header">
                <div class="row">
                  <div class="col-md-9"></div>
                  <div class="col-md-3">
                     <div class="btn btn-info pull-right" data-toggle="modal" data-target="#modal-sm"  style="margin-top: -5px">
                        <a href="{{ route('Services.create') }}" style="text-decoration: none;color: white">
                             <div class="btn btn-info pull-right"  style="margin-top: -5px">
                            <i class="fa fa-plus"></i> Ajouter un service
                            </a>
                    
                  </div>
                </div>
              </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-striped">
                  <thead>
                  <tr>
                                          <th>Ref</th>
                                          <th>Service</th>
                                          <th>Couverture</th>
                                          <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                      @foreach ($Services as $Service)

                                         <tr class="odd gradeX">
                                            <td>{{ $Service->id }}</td>
                                            <td>{{ $Service->service }}</td>
                                            <td>
                                            @if($Service->Traitement==1)
                                             Soins Ambulatoire hors Medicament et Lunette
                                             @elseif($Service->Traitement==2)
                                             Hospitalisation Sans Maternité
                                             @elseif($Service->Traitement==3)
                                             Hospitalisation Avec Maternité
                                             @elseif($Service->Traitement==4)
                                             Soins Ambulatoire Medicament
                                             @elseif($Service->Traitement==5)
                                             Soins Ambulatoire Lunette
                                             @elseif($Service->Traitement==6)
                                             Soins Ambulatoire Dent
                                             @elseif($Service->Traitement==7)
                                             Soins Ambulatoire Laboratoire
                                             @elseif($Service->Traitement==8)
                                             Soins Ambulatoire Kinesitherapie
                                             @elseif($Service->Traitement==9)
                                             Soins Ambulatoire Reanimation
                                             @elseif($Service->Traitement=10)
                                             Soins Ambulatoire Imagerie Medicale
                                             @endif

                                            </td>
                                                        
                              <td>
                                <a href="{{ route('Services.edit', $Service) }}"><i class="fas fa-edit"></i></a>

                                <form action="{{ route('Services.destroy', $Service) }}" method="POST" style="display: inline-block;">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                    
                                <button style="border: none;" class="btn btn-danger btn-sm" onclick='return confirm("Etez -vous sur d\'effectuer cette Operation ?")'><i class="fas fa-trash"></i>
                                </button>
                               </form>

                               <!-- <a href="{{ route('AttacherAff', $Service) }}">Attacher Affilié</a> -->

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
