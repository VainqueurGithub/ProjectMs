@extends('layout.base', ['title' => 'Assurance - Historique Prix'])
@section('content')
 <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
               <div class="row">
                  <div class="col-md-12">
                      HISTORIQUE DES PRIX POUR LA PRESTATION {{ $medicaments->code }} / {{ $medicaments->designation }}
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
              <div class="card-body">
                <table id="example1" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Medicament</th>
                                            <th>Prix</th>
                                            <th>Fin</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                      @foreach ($results as $result) 
                                        <tr>
                                          <td>{{$result->code}}</td>
                                          <td>{{$result->Prix}}</td>
                                          <td>{{$result->Fin}}</td>
                                        </tr>
                                      @endforeach
                                    </tbody>
                                </table>
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
