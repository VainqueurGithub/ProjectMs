@extends('layout.base', ['title' => 'Assurance - Immobilier'])

@section('content')
  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
            <h3>Type des immobiliers</h3>
        </div>
      </div><!-- /.container-fluid -->
    </section><hr />
 <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
              <div class="card">
              <div class="card-header">
                <h3 class="card-title">Type des immobiliers</h3>
                <div class="row">
                  <div class="col-md-9"></div>
                  <div class="col-md-3">
                      <div class="btn btn-info pull-right" data-toggle="modal" data-target="#modal-sm"  style="margin-top: -5px">
                          <i class="fa fa-plus"></i> Ajouter un type
                      </div>
                  </div>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-striped">
                  <thead>
                  <tr>
                                            <th>#</th>
                                            <th>Type</th>
                                            <th>Action</th>
                                            <th>Immobiliers</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    
                                     @foreach ($Types as $Type)
                                        

                                         <tr class="odd gradeX">
                                            <td>{{ $Type->id }}</td>
                                            <td>{{ $Type->Type }}</td>
                                            <td>
                                              <button data-toggle="modal" data-target="#modal-default"  value="{{$Type->id}},{{$Type->Type}}" onclick="getTypeImmo(this);" style="border: none; cursor: pointer;">
                                                  modifier
                                              </button>
                                              <form action="{{ route('depreciationtype.destroy', $Type) }}" method="POST" style="display: inline-block;" onsubmit="return confirm('Etez -vous sur de cette Operation ?')">
                                                {{ csrf_field() }}
                                                {{ method_field('DELETE') }}
                    
                                                <button><i class="fas fa-trash"></i>
                                                  </button>
                                              </form>
                                             </td>

                                             <td>
                                                <a href="{{ route('depreciationtype.show', $Type) }}">
                                               <i class="fas fa-eye"></i>
                                             </a> 
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
             <!-- /. PAGE INNER  -->


<!-- MODEL POUR AJOUTER UN IMMOBILIER A LISTE DEBUT -->
   
   <div class="modal fade" id="modal-sm">
        <div class="modal-dialog modal-md">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">AJOUTER UN NOUVEAU TYPE D'IMMOBILIER </h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form method="POST" action="{{route('depreciationtype.store')}}">
                {{ csrf_field() }}
                  <div class="panel-body">
                    <div class="table-responsive">
                        <div class="form-group">
                         <label>Type *</label>
                           <input type="text" class="form-control" name="Type" value="{{ old('Type')}}" />
                          {!! $errors->first('Type', '<span class="error">:message</span>') !!}
                        </div> 
                        </div>
                    </div>
                
                 <div class="modal-footer justify-content-between">
                    <div class="col-md-6">
                        <div class="card-footer">
                          <button type="submit" class="btn btn-success swalDefaultSuccess"><i class="fas fa-save"></i> Valider L'action</button>
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

    <!-- MODEL POUR AJOUTER UN IMMOBILIER A LISTE FIN -->  



    <!-- MODEL POUR MODIFIER UN IMMOBILIER A LISTE DEBUT -->
   
   <div class="modal fade" id="modal-default">
        <div class="modal-dialog modal-md">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">MODIFIER LE TYPE D'IMMOBILIER</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
               <form method="POST" action="{{route('depreciationtypeupdate')}}" onsubmit='return confirm("Etez - vous sur de cette Operation ?")'>
                {{ csrf_field() }}
                {{ method_field('PUT') }}
                  <div class="panel-body">
                    <div class="table-responsive">
                        <input type="text" name="typeImmo" id="typeImmo" style="display: none;">
                        <div class="form-group">
                         <label>Type *</label>
                           <input type="text" class="form-control" name="Type" value="{{ old('Type')}}" id="Type" />
                          {!! $errors->first('Type', '<span class="error">:message</span>') !!}
                        </div>
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

    <!-- MODEL POUR MODIFIER UN IMMOBILIER A LISTE FIN -->            
@endsection 
<script type="text/javascript">
     function getPartenaire(va){
    var partenaire = $(va).val();
      $("#partenaire").val(partenaire);
  }

  function getTypeImmo(va){
    var typeImmo = $(va).val();
    myArr = typeImmo.split(",");
    $("#typeImmo").val(myArr[0]);
    $("#Type").val(myArr[1]);
  }
</script>