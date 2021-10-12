@extends('layout.base', ['title' => 'Assurance - Nouvelle Facture'])
@section('content')
 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
       <!-- End Form Elements -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-6">
            <div class="card-header">
              MS-SYSTEM
            </div>
            <div class="card">
              <div class="card-body">
                  <ol>
                    <li><a href="{{ route('Partenaires.index')}}">Géstion des Partenaires</a></li>
                    <li><a href="{{ route('Origines.index')}}">Géstion des Origines</a></li>
                    <li><a href="{{ route('Taux_cotisation.index')}}">Reglage Taux Cotisation</a></li>
                    <li><a href="{{ route('Services.index')}}">Gestions des Services</a></li>
                    <li><a href="{{ route('ChangerAdresse')}}">Gestion d'identité du MS</a></li>
                    <li><a href="{{ route('depreciationForm')}}">Ammortir les immobiliers</a></li>
                  </ol>
              </div>
            </div>
          </div>

          <div class="col-6">
            <div class="card-header">
              COMPTABILITE
            </div>
            <div class="card">
              <div class="card-body">
                  <ol>
                    <li><a href="{{ route('ExerciceComptable.index')}}">Exercice Comptable </a></li>
                    <li><a href="{{ route('TypeCompte.index')}}">Type de Comptes </a></li>
                    <li><a href="{{ route('ComptePrincipal.index')}}"> Compte Principal </a></li>
                    <li><a href="{{ route('Comptedivisionnaire.index')}}"> Compte subdivisionnaire </a></li>
                    <li><a href="{{ route('sous_compte.index')}}"> Sous Comptes </a></li>
                    <li><a href="{{ route('CodeJournaux.index')}}">Journeaux</a></li>
                    <!--li><a href="{{ route('CompteJournal.index')}}">Compte Journal</a></li-->
                    <li><a href="{{ route('uploadinitialbilanform')}}">Uploader Bilan Initial</a></li>
                    <li><a href="{{ route('Repportage.index')}}">Saisie des à nouveaux</a></li>
                    <li><a href="{{ route('Parametre_generaux.edit', 1)}}">Parametres générales</a></li>
                    <li><a href="{{route('soldeJournalierForm')}}"> Cloture Periodique </a></li>
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