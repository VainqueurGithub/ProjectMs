@extends('layout.base', ['title' => 'Assurance - Nos Partenaires'])

@section('content')
  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
            <h3>Liste des Partenaires</h3>
        </div>
      </div><!-- /.container-fluid -->
    </section><hr />
 <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
              <div class="card">
              <div class="card-header">
                <h3 class="card-title">Liste des Partenaires</h3>
                <div class="row">
                  <div class="col-md-9"></div>
                  <div class="col-md-3">
                    <a href="{{ route('Partenaires.create') }}" style="text-decoration: none;color: white">
                    <div class="btn btn-info pull-right"  style="margin-top: -5px">
                    <i class="fa fa-plus"></i> Ajouter un Partenaire
                    </a>
                  </div>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-striped">
                  <thead>
                  <tr>
                                            <th>Code</th>
                                            <th>Partenaire</th>
                                            <th>Type</th>
                                            <th>Action</th>
                                            <th>Compte</th>
                                            <th>Services</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    
                                     @foreach ($Partenaires as $Partenaire)
                                        

                                         <tr class="odd gradeX">
                                            <td>{{ $Partenaire->Code }}</td>
                                            <td>{{ $Partenaire->Partenaire }}</td>
                                            <td>{{ $Partenaire->Type }}</td>
                                             <td>
                                               <a href="{{ route('Partenaires.edit', $Partenaire) }}"><i class="fas fa-edit"></i></a>

                                                <form action="{{ route('Partenaires.destroy', $Partenaire) }}" method="POST" style="display: inline-block;" onsubmit="return confirm('Etez -vous sur de cette Operation ?')">
                                                {{ csrf_field() }}
                                                {{ method_field('DELETE') }}
                    
                                                <button><i class="fas fa-trash"></i>
                                                  </button>
                                              </form>

                                             <a href="{{ route('ListeAffilier', $Partenaire) }}">
                                               <i class="fas fa-print"></i>
                                             </a> 
                                             </td>
                                             @if($Partenaire->account!=null)
                                             <td>
                                                 <button value="{{$Partenaire->id}}" onclick="getPartenaire(this);" data-toggle="modal" data-target="#modal-default" class="btn btn-default btn-sm">Compte <img src="{{ url('icons/icons8_Checkmark_26px_1.png') }}" width="20px" height="20px"></button> 
                                             </td>
                                             @else
                                               <td>
                                                 <button value="{{$Partenaire->id}}" onclick="getPartenaire(this);" data-toggle="modal" data-target="#modal-default" class="btn btn-default btn-sm">Compte</button> 
                                              </td>
                                             @endif
                                             <td><a href="{{ route('Getimport', $Partenaire) }}">Services</a> </td>
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
             <!-- /. PAGE INNER  -->




   <div class="modal fade" id="modal-default">
        <div class="modal-dialog modal-md">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">CHOISIR LE COMPTE</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form method="POST" action="{{route('AttachAccount')}}" onsubmit='return confirm("Etez - vous sur de cette Operation ?")'>
                {{ csrf_field() }}
                 <input type="text" style="display: none;" name="partenaire" id="partenaire">
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                          <th>#</th>
                                          <th>Numero de Compte</th>
                                          <th>Intitulé</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                      @foreach ($CompteSubdivisionnaires as $CompteSubdivisionnaire)

                                         <tr class="odd gradeX">
                                            <td><input type="radio" required="" name="compte" value="{{$CompteSubdivisionnaire->id}}">
                                            </td>
                                            <td>{{ $CompteSubdivisionnaire->NumeroCompte }}</td>
                                            <td>{{ $CompteSubdivisionnaire->Intitule }} 
                                    </tr> 
                                    @endforeach   
                                    </tbody>
                                </table>
                            </div>
                        </div>
                
                 <div class="modal-footer justify-content-between">
                    <div class="col-md-6">
                        <div class="card-footer">
                          <button type="submit" class="btn btn-success swalDefaultSuccess" onclick='return confirm("Etez -vous sur d\'effectuer cette Operation ?")'><i class="fas fa-save"></i> Valider L'action</button>
                        </div>
                      </div>
                </div>
              </form>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>            
@endsection 
<script type="text/javascript">
     function getPartenaire(va){
    var partenaire = $(va).val();
      $("#partenaire").val(partenaire);
  }
</script>