@extends('layout.base', ['title' => 'Tableau De Bord'])
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
  <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
                     <form method="POST" action="{{route('registre_adhesion_generate')}}" target="blank">
                        {{ csrf_field() }}
                        <div class="row" style="width:80%;">
                            <div class="col-md-5">
                              <div class="form-group">
                                 <label>Année d'étude</label>
                                 <select class="form-control select2">
                                   @foreach($annees as $annee)
                                      <option value="{{$annee->annee}}">{{$annee->annee}}</option>
                                   @endforeach
                                 </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                <label>generer</label>
                                <button type="submit" class="btn btn-primary">Imprimer</button>
                                </div> 
                            </div>
                        </div>
                     </form> 
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
              <div class="card">
              <div class="card-header">
                <h3 class="card-title">TABLEAU DE SUIVI</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table class="table table-striped">
                  <thead>
                    <tr style="text-align: center;">
                        <th></th>
                        <th>Dec {{$LastYear}}</th>
                        <th>Janv</th>
                        <th>Fev</th>
                        <th>Mars</th>
                        <th>Avril</th>
                        <th>Mai</th>
                        <th>Juin</th>
                        <th>Juillet</th>
                        <th>Aout</th>
                        <th>Sept</th>
                        <th>Oct</th>
                        <th>Nov</th>
                        <th>Dec</th>
                        <th>TOTAL</th>
                    </tr>
                  </thead>
                    <tbody style="text-align: center;">
                        @foreach($EntreesAdh as $EntreeAdh)
                        <tr>
                            <td>Nv.adhérents</td>
                            <td></td>
                            <td><button style='border: none;cursor: pointer;' target='PromoteFirefoxWindowName' onclick='openFFPromotionPopup(this); return false;' value="{{$currentyear}}*1*1*1">{{$EntreeAdh->J}}</button></td>
                            <td><button style='border: none;cursor: pointer;' target='PromoteFirefoxWindowName' onclick='openFFPromotionPopup(this); return false;' value="{{$currentyear}}*2*1*1">{{$EntreeAdh->F}}</button></td>
                            <td><button style='border: none;cursor: pointer;' target='PromoteFirefoxWindowName' onclick='openFFPromotionPopup(this); return false;' value="{{$currentyear}}*3*1*1">{{$EntreeAdh->M}}</button></td>
                            <td><button style='border: none;cursor: pointer;' target='PromoteFirefoxWindowName' onclick='openFFPromotionPopup(this); return false;' value="{{$currentyear}}*4*1*1">{{$EntreeAdh->A}}</button></td>
                            <td><button style='border: none;cursor: pointer;' target='PromoteFirefoxWindowName' onclick='openFFPromotionPopup(this); return false;' value="{{$currentyear}}*5*1*1">{{$EntreeAdh->M}}</button></td>
                            <td><button style='border: none;cursor: pointer;' target='PromoteFirefoxWindowName' onclick='openFFPromotionPopup(this); return false;' value="{{$currentyear}}*6*1*1">{{$EntreeAdh->Ju}}</button></td>
                            <td><button style='border: none;cursor: pointer;' target='PromoteFirefoxWindowName' onclick='openFFPromotionPopup(this); return false;' value="{{$currentyear}}*7*1*1">{{$EntreeAdh->Jui}}</button></td>
                            <td><button style='border: none;cursor: pointer;' target='PromoteFirefoxWindowName' onclick='openFFPromotionPopup(this); return false;' value="{{$currentyear}}*8*1*1">{{$EntreeAdh->Ao}}</button></td>
                            <td><button style='border: none;cursor: pointer;' target='PromoteFirefoxWindowName' onclick='openFFPromotionPopup(this); return false;' value="{{$currentyear}}*9*1*1">{{$EntreeAdh->S}}</button></td>
                            <td><button style='border: none;cursor: pointer;' target='PromoteFirefoxWindowName' onclick='openFFPromotionPopup(this); return false;' value="{{$currentyear}}*10*1*1">{{$EntreeAdh->O}}</button></td>
                            <td><button style='border: none;cursor: pointer;' target='PromoteFirefoxWindowName' onclick='openFFPromotionPopup(this); return false;' value="{{$currentyear}}*11*1*1">{{$EntreeAdh->N}}</button></td>
                            <td><button style='border: none;cursor: pointer;' target='PromoteFirefoxWindowName' onclick='openFFPromotionPopup(this); return false;' value="{{$currentyear}}*12*1*1">{{$EntreeAdh->D}}</button></td>
                            <th>{{$EntreeAdh->ST}}</th>
                        </tr>    
                        @endforeach

                        @foreach($SortiesAdh as $SortieAdh)
                        <tr>
                            <td>Retraits.adhérents</td>
                            <td></td>
                            <td><button style='border: none;cursor: pointer;' target='PromoteFirefoxWindowName' onclick='openFFPromotionPopup(this); return false;' value="{{$currentyear}}*1*1*2">{{$SortieAdh->J}}</button></td>
                            <td><button style='border: none;cursor: pointer;' target='PromoteFirefoxWindowName' onclick='openFFPromotionPopup(this); return false;' value="{{$currentyear}}*2*1*2">{{$SortieAdh->F}}</button></td>
                            <td><button style='border: none;cursor: pointer;' target='PromoteFirefoxWindowName' onclick='openFFPromotionPopup(this); return false;' value="{{$currentyear}}*3*1*2">{{$SortieAdh->M}}</button></td>
                            <td><button style='border: none;cursor: pointer;' target='PromoteFirefoxWindowName' onclick='openFFPromotionPopup(this); return false;' value="{{$currentyear}}*4*1*2">{{$SortieAdh->A}}</button></td>
                            <td><button style='border: none;cursor: pointer;' target='PromoteFirefoxWindowName' onclick='openFFPromotionPopup(this); return false;' value="{{$currentyear}}*5*1*2">{{$SortieAdh->M}}</button></td>
                            <td><button style='border: none;cursor: pointer;' target='PromoteFirefoxWindowName' onclick='openFFPromotionPopup(this); return false;' value="{{$currentyear}}*6*1*2">{{$SortieAdh->Ju}}</button></td>
                            <td><button style='border: none;cursor: pointer;' target='PromoteFirefoxWindowName' onclick='openFFPromotionPopup(this); return false;' value="{{$currentyear}}*7*1*2">{{$SortieAdh->Jui}}</button></td>
                            <td><button style='border: none;cursor: pointer;' target='PromoteFirefoxWindowName' onclick='openFFPromotionPopup(this); return false;' value="{{$currentyear}}*8*1*2">{{$SortieAdh->Ao}}</button></td>
                            <td><button style='border: none;cursor: pointer;' target='PromoteFirefoxWindowName' onclick='openFFPromotionPopup(this); return false;' value="{{$currentyear}}*9*1*2">{{$SortieAdh->S}}</button></td>
                            <td><button style='border: none;cursor: pointer;' target='PromoteFirefoxWindowName' onclick='openFFPromotionPopup(this); return false;' value="{{$currentyear}}*10*1*2">{{$SortieAdh->O}}</button></td>
                            <td><button style='border: none;cursor: pointer;' target='PromoteFirefoxWindowName' onclick='openFFPromotionPopup(this); return false;' value="{{$currentyear}}*11*1*2">{{$SortieAdh->N}}</button></td>
                            <td><button style='border: none;cursor: pointer;' target='PromoteFirefoxWindowName' onclick='openFFPromotionPopup(this); return false;' value="{{$currentyear}}*12*1*2">{{$SortieAdh->D}}</button></td>
                            <th>{{$SortieAdh->ST}}</th>
                        </tr>    
                        @endforeach
                        {!!$totalAdh!!}

                         @foreach($EntreesAyants as $EntreeAyants)
                        <tr>
                            <td>Nv.bénefic.</td>
                            <td></td>
                            <td><button style='border: none;cursor: pointer;' target='PromoteFirefoxWindowName' onclick='openFFPromotionPopup(this); return false;' value="{{$currentyear}}*1*2*1">{{$EntreeAyants->J}}</button></td>
                            <td><button style='border: none;cursor: pointer;' target='PromoteFirefoxWindowName' onclick='openFFPromotionPopup(this); return false;' value="{{$currentyear}}*2*2*1">{{$EntreeAyants->F}}</button></td>
                            <td><button style='border: none;cursor: pointer;' target='PromoteFirefoxWindowName' onclick='openFFPromotionPopup(this); return false;' value="{{$currentyear}}*3*2*1">{{$EntreeAyants->M}}</button></td>
                            <td><button style='border: none;cursor: pointer;' target='PromoteFirefoxWindowName' onclick='openFFPromotionPopup(this); return false;' value="{{$currentyear}}*4*2*1">{{$EntreeAyants->A}}</button></td>
                            <td><button style='border: none;cursor: pointer;' target='PromoteFirefoxWindowName' onclick='openFFPromotionPopup(this); return false;' value="{{$currentyear}}*5*2*1">{{$EntreeAyants->M}}</button></td>
                            <td><button style='border: none;cursor: pointer;' target='PromoteFirefoxWindowName' onclick='openFFPromotionPopup(this); return false;' value="{{$currentyear}}*6*2*1">{{$EntreeAyants->Ju}}</button></td>
                            <td><button style='border: none;cursor: pointer;' target='PromoteFirefoxWindowName' onclick='openFFPromotionPopup(this); return false;' value="{{$currentyear}}*7*2*1">{{$EntreeAyants->Jui}}</button></td>
                            <td><button style='border: none;cursor: pointer;' target='PromoteFirefoxWindowName' onclick='openFFPromotionPopup(this); return false;' value="{{$currentyear}}*8*2*1">{{$EntreeAyants->Ao}}</button></td>
                            <td><button style='border: none;cursor: pointer;' target='PromoteFirefoxWindowName' onclick='openFFPromotionPopup(this); return false;' value="{{$currentyear}}*9*2*1">{{$EntreeAyants->S}}</button></td>
                            <td><button style='border: none;cursor: pointer;' target='PromoteFirefoxWindowName' onclick='openFFPromotionPopup(this); return false;' value="{{$currentyear}}*10*2*1">{{$EntreeAyants->O}}</button></td>
                            <td><button style='border: none;cursor: pointer;' target='PromoteFirefoxWindowName' onclick='openFFPromotionPopup(this); return false;' value="{{$currentyear}}*11*2*1">{{$EntreeAyants->N}}</button></td>
                            <td><button style='border: none;cursor: pointer;' target='PromoteFirefoxWindowName' onclick='openFFPromotionPopup(this); return false;' value="{{$currentyear}}*12*1*2">{{$EntreeAyants->D}}</button></td>
                            <th>{{$EntreeAyants->ST}}</th>
                        </tr>    
                        @endforeach

                        @foreach($SortiesAyants as $SortieAyants)
                        <tr>
                            <td>Retraits.bénefic.</td>
                            <td></td>
                            <td><button style='border: none;cursor: pointer;' target='PromoteFirefoxWindowName' onclick='openFFPromotionPopup(this); return false;' value="{{$currentyear}}*1*2*2">{{$SortieAyants->J}}</button></td>
                            <td><button style='border: none;cursor: pointer;' target='PromoteFirefoxWindowName' onclick='openFFPromotionPopup(this); return false;' value="{{$currentyear}}*2*2*2">{{$SortieAyants->F}}</button></td>
                            <td><button style='border: none;cursor: pointer;' target='PromoteFirefoxWindowName' onclick='openFFPromotionPopup(this); return false;' value="{{$currentyear}}*3*2*2">{{$SortieAyants->M}}</button></td>
                            <td><button style='border: none;cursor: pointer;' target='PromoteFirefoxWindowName' onclick='openFFPromotionPopup(this); return false;' value="{{$currentyear}}*4*2*2">{{$SortieAyants->A}}</button></td>
                            <td><button style='border: none;cursor: pointer;' target='PromoteFirefoxWindowName' onclick='openFFPromotionPopup(this); return false;' value="{{$currentyear}}*5*2*2">{{$SortieAyants->M}}</button></td>
                            <td><button style='border: none;cursor: pointer;' target='PromoteFirefoxWindowName' onclick='openFFPromotionPopup(this); return false;' value="{{$currentyear}}*6*2*2">{{$SortieAyants->Ju}}</button></td>
                            <td><button style='border: none;cursor: pointer;' target='PromoteFirefoxWindowName' onclick='openFFPromotionPopup(this); return false;' value="{{$currentyear}}*7*2*2">{{$SortieAyants->Jui}}</button></td>
                            <td><button style='border: none;cursor: pointer;' target='PromoteFirefoxWindowName' onclick='openFFPromotionPopup(this); return false;' value="{{$currentyear}}*8*2*2">{{$SortieAyants->Ao}}</button></td>
                            <td><button style='border: none;cursor: pointer;' target='PromoteFirefoxWindowName' onclick='openFFPromotionPopup(this); return false;' value="{{$currentyear}}*9*2*2">{{$SortieAyants->S}}</button></td>
                            <td><button style='border: none;cursor: pointer;' target='PromoteFirefoxWindowName' onclick='openFFPromotionPopup(this); return false;' value="{{$currentyear}}*10*2*2">{{$SortieAyants->O}}</button></td>
                            <td><button style='border: none;cursor: pointer;' target='PromoteFirefoxWindowName' onclick='openFFPromotionPopup(this); return false;' value="{{$currentyear}}*11*2*2">{{$SortieAyants->N}}</button></td>
                            <td><button style='border: none;cursor: pointer;' target='PromoteFirefoxWindowName' onclick='openFFPromotionPopup(this); return false;' value="{{$currentyear}}*12*2*2">{{$SortieAyants->D}}</button></td>
                            <th>{{$SortieAyants->ST}}</th>
                        </tr>    
                        @endforeach
                        {!!$totalAyants!!}
                        {!!$tailleMoyenneFam!!}
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

      <script type="text/javascript">
         var WindowObjectReference = null; // variable globale
function openFFPromotionPopup(va) {
     var id = $(va).val();
     var tab = id.split("*");
     var periode = tab[0];
     var moi = tab[1];
     var type_beneficiaire = tab[2];
     var type_mvt = tab[3];
    var url1 = "{{ route('details_mvt_suivi', ['periode'=>":periode",'moi'=>":moi", 'type_beneficiaire'=>":type_beneficiaire", 'type_mvt'=>":type_mvt"])}}";
    url1 = url1.replace(':periode', periode);
    url1 = url1.replace(':moi', moi);
    url1 = url1.replace(':type_beneficiaire', type_beneficiaire);
    url1 = url1.replace(':type_mvt', type_mvt);

  if (WindowObjectReference == null || WindowObjectReference.closed) {
    WindowObjectReference = window.open(url1,
           "PromoteFirefoxWindowName", "width=940,height=500,resizable,scrollbars=yes,status=1");
  }
  else {
    WindowObjectReference.focus();
  };
}
      </script>