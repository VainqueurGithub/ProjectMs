@extends('layout.base', ['title' => 'Assurance - Nouvelle Facture'])
@section('content')
 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
       <!-- End Form Elements -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
              <div class="card">
              <div class="card-header">
                <input type="hidden" value="{{session()->get('Aff')}}" id="adherantId"/>
                 <button value="{{session()->get('service')}}" style="border: none;cursor: pointer;" target="PromoteFirefoxWindowName" class="btn btn-primary" onclick="openFFPromotionPopupPrestation(this); return false;">
                  Continuer les Commandes
            </button>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-striped">
                  <thead>
                    <tr>
                      <th>ID</th>
                        <th>PRIX</th>
                        <th>QUANTITE</th>
                        <th>PT</th>
                        <th>DESIGNATION</th>
                        <th>SEJOUR</th>
                        <th>ACTION</th>
                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($content as $item) 
                                       <tr>
                                           <td>{{$item->id}}</td>
                                            <td>{{$item->price}}</td>
                                             <td>{{$item->quantity}}</td>
                                              <td>{{$item->prixtotal}}</td>
                                             <td>{{$item->name}}</td>
                                             <td>{{$item->sejour}}</td>
                                             <td>
                                              <form action="{{route('panier.destroy', $item->id)}}" method='POST' style='display: inline-block;' onsubmit='return confirm("Etez -vous sur de cette Operation ?")'>
                                                  {{csrf_field()}}
                                                  {{method_field('DELETE')}}
                    
                                                  <button style="border: none;" onclick='return confirm("Etez -vous sur de cette Operation ?")'>
                                                  <i class='fa fa-trash'></i>
                                                  </button>
                                              </form>
                                             </td>
                                        </tr>
                                    @endforeach   
                                    </tbody>
                                    <tfoot>
                                       <tr>
                                          <td>TOTAL</td>
                                          <td rowspan="5">{{$total}}</td>
                                        </tr>
                                    </tfoot>
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

<script type="text/javascript">
  var WindowObjectReference = null; // variable globale
   function getBeneficiaire(va){
     var id_affilier= $(va).val();

      $.get('{{ route('getProduiBenfic') }}',
          {id_affilier:id_affilier},
          function(data){
            $('#AyantDroits').html(data);
          });
   }

 function openFFPromotionPopupPrestation(va){
     var service = $(va).val();
     var adherant = $('#adherantId').val();
     var url1 = "{{ route('form_prest', ['service'=>":service", 'adherant'=>":adherant"])}}";
     url1 = url1.replace(':service', service);
     url1 = url1.replace(':adherant', adherant);
  if (WindowObjectReference == null || WindowObjectReference.closed) {
    WindowObjectReference = window.open(url1,
           "PromoteFirefoxWindowName", "width=830,height=550,resizable,scrollbars=yes,status=1");
  }
  else {
    WindowObjectReference.focus();
  };
}  
</script>