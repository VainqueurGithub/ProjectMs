@extends('layout.base', ['title' => 'Assurance - Nouvelle Facture'])
@section('content')
 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
       <!-- End Form Elements -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card-header">
              DOCUMENT COMPTABLE
            </div>
            <div class="card">
              <div class="card-body">
                  <ol>
                    <li><a href="{{ route('rapport_comptabilite')}}">Rapport Comptabilité</a></li>
                    <li><a href="{{ route('AfficherGdLivre') }}"> Grand Livre </a></li>
                    <li><a href="{{ route('AfficherBalance') }}"> Balance </a></li>
                    <li><a href="{{ route('CompteResultat') }}"> Compte de Résultat </a></li>
                    <li><a href="{{ route('Bilan') }}"> Bilan </a></li>
                    <li><a href="{{ route('depreciationForm') }}"> Dotation Amortissement </a></li>
                    <li><a href="{{ route('SoldeJournalier') }}"> Solde Journalier </a></li>
                  </ol>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>





                         <!-- Modal Add Category -->

                <!-- END MODAL -->
  </div>
@endsection 