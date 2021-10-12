@extends('layout.base', ['title' => 'Assurance - Immobilier'])

@section('content')
  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
      </div><!-- /.container-fluid -->
    </section><hr />
 <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
              <div class="card">
              <div class="card-header">
                <h3 class="card-title">Liste des Immobiliers</h3>
                <div class="row">
                  <div class="col-md-9"></div>
                  <div class="col-md-3">
                  </div>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-striped">
                  <thead>
                  <tr>
                                            <th>Nom</th>
                                            <th>Type</th>
                                            <th>Date acquis</th>
                                            <th>Moyen acquis</th>
                                            <th>Mise en service</th>
                                            <th>Montant</th>
                                            <th>Durée (ans)</th>
                                            <th>Taux (%)</th>
                                            <th>Methode Appliquée</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    
                                     @foreach ($Biens as $Bien)
                                        

                                         <tr class="odd gradeX">
                                            <td>{{ $Bien->Nom }}</td>
                                            <td>{{ $Bien->Type }}</td>
                                            <td>{{ $Bien->Date_acquis }}</td>
                                            <td>{{ $Bien->Moyen_acquis }}</td>
                                            <td>{{ $Bien->Mis_service }}</td>
                                            <td>{{ $Bien->Montant }}</td>
                                            <td>{{ $Bien->Duree }}</td>
                                            <td>{{ $Bien->Taux }}</td>
                                            <td>{{ $Bien->Methode }}</td>
                                            <td>
                                              <button data-toggle="modal" data-target="#modal-default"  value="{{$Bien}}" style="border: none; cursor: pointer;">
                                                 <i class="fa fa-edit"></i>
                                              </button>
                      
                                             <!--a href="{{ route('Bien.show', $Bien) }}">
                                               <i class="fas fa-eye"></i>
                                             </a--> 

                                             <button style="border: none;cursor: pointer;" target="PromoteFirefoxWindowName" onclick="openFFPromotionPopupForDepreciationPlan(this); return false;" value="{{$Bien->id}}"><i class="fa fa-eye"></i></button>
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
@endsection 

<script type="text/javascript">
   var WindowObjectReference = null; // variable globale
   function openFFPromotionPopupForDepreciationPlan(va) {
     var id = $(va).val();
     var url = "{{ route('Bien.show', ":id") }}";
     url = url.replace(':id', id);
  if (WindowObjectReference == null || WindowObjectReference.closed) {
    WindowObjectReference = window.open(url,"PromoteFirefoxWindowName", "toolbar=no,scrollbars=no,location=no,statusbar=no,width=940,height=500,resizable,scrollbars=yes,status=1,menubar=no");
  }
  else {
    WindowObjectReference.focus();
  };
}
</script>