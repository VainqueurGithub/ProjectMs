@extends('layout.base', ['title' => 'Assurance - Ayant Droit'])
@section('content')
  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
               <div class="row">
                <div class="col-md-10"></div>
                  <div class="col-md-2">
                     
                           <!--  <a href="{{ route('PdfAllMedicaments') }}" target="blank" style="text-decoration: none;color: white">
                             <div class="btn btn-info pull-right"  style="margin-top: -5px">
                            <i class="fa fa-print"></i> Imprimer la Liste 
                            </a> -->

                             <a href="{{ route('ExportMedicament') }}" target="blank" class="btn btn-primary">
                            <i class="fa fa-export"></i> Export Excel 
                            </a>
                        
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
                     <a href="{{ route('Medicaments.create') }}" style="text-decoration: none;color: white">
                        <div class="btn btn-info pull-right"  style="margin-top: -5px">
                        <i class="fa fa-plus"></i> Ajouter une Prestation
                    </a>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-striped">
                  <thead>

                                        <tr>
                                           <th>Identifiant</th>
                                            <th>Libellé</th>
                                            <th>Propriété</th>
                                            <th>Date Enregistrement</th>
                                            <th>Action</th>
                                            <th>Details</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                      @foreach($results as $result)
                                        <tr class="odd gradeX">
                                          <td>{{$result->id}}</td>
                                          <td>{{$result->propriete}}</td>
                                          <td>{{$result->libelle}}</td> 
                                          <td>{!! date('d/M/y', strtotime($result->created_at)) !!}</td>

                
                                          <td class="center f-icon">
                                           <form action="{{route('Medicaments.destroy',$result->id)}}"method="POST">
                            <a href="{{route('Medicaments.edit',$result->id)}}"><i class="fa fa-edit"></i></a>
                            
                                {{csrf_field()}}
                                {{method_field('DELETE')}}
                                <button style="border: none;"><i class="fa fa-trash"></i>
                                </button>
                            </form>
                            
                        </td>

                         <td>
                          <a href="{{route('Medicaments.show',$result->id)}}"><i class="fa fa-eye"></i></a>
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
