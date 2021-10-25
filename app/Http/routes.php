<?php
 use App\Http\Middleware\ExerciceComptableExist;
 use App\Http\Middleware\InitialBilan;
 use App\Http\Middleware\CheckDatabaseConnection;
 use App\Http\Controllers\RoleController;
 use App\Http\Controllers\PermissionController;
 use App\Http\Controllers\Auth\AuthController;
 use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

 // ROUTE POUR LA PAGE DE CONNEXION MST ET PARTENAIRE

Route::get('/', function () {
    return view('welcome');
});
Route::get('/Login', 'PartenaireController@Login')->name('Login');

Route::get('main-login', [AuthController::class, 'index'])->name('main_login');



Route::get('registration', [AuthController::class, 'registration'])->name('register');

Route::post('post-registration', [AuthController::class, 'postRegistration'])->name('register.post'); 

Route::get('/TableauDeBord', 'TableauDeBordController@TableauDeBord')->name('TableauDeBord'); 

Route::get('logout', [AuthController::class, 'logout'])->name('logout');


// MIDDLEWARE POUR VERIFIER SI LA BASE DE DONNEE EXISTES

Route::middleware([CheckDatabaseConnection::class])->group(function(){

Route::post('/file_upload', 'RepportageController@uploadfile')->name('uploadfile');
Route::post('post-login', [AuthController::class, 'postLogin'])->name('login.post'); 
//Route::post('/main/Verification', 'ConnexionController@Verification')->name('Verification');

Route::post('/main/VerifLogin', 'ConnexionController@VerifLogin')->name('VerifLogin');


Route::group(['middleware' => 'auth'], function(){

Route::get('/configuration_ms_syst', function () {
    return view('configuration');
})->name('configuration');

Route::get('/documentcomptable', function(){
    return view('documentcomptable');
})->name('documentcomptable');

Route::get('/historique_cotisation_M/{id}', 'CotisationController@historiquecotisationM')->name('historiquecotisationM');
Route::post('/changeAmountCotisation', 'CotisationController@changeAmountCotisation')->name('changeAmountCotisation');
Route::resource('panier', 'CartController');
Route::resource('Bien', 'bienController');
Route::resource('depreciationtype', 'depreciationtypeController');
Route::resource('sous_compte', 'SousCompteController');
Route::get('rapport_comptabilite', 'ComptabiliteController@rapport_comptabilite')->name('rapport_comptabilite');
Route::get('availablePartener/{Aff}', 'AffilierController@availablePartener')->name('availablePartener');
Route::get('availablePrestation', 'AffilierController@availablePrestation')->name('availablePrestation');
Route::get('CleanFile', 'OrigineController@cleanFile')->name('cleanFile');
Route::post('AttachAccount', 'PartenaireController@AttachAccount')->name('AttachAccount');
Route::delete('Deletemulite', 'AffilierController@Deletemulite')->name('Deletemulite');	
Route::get('/details_bilan/{periode}/{compte}', 'JournalController@details_bilan')->name('details_bilan');
Route::get('/Categorize/{Servi}', 'medicamentsserviceController@Categorize')->name('Categorize');
Route::post('/DefCategorie/{id}', 'medicamentsserviceController@DefCategorie')->name('DefCategorie');
Route::post('/depreciationForm', 'depreciationController@depreciationForm')->name('depreciationForm');
Route::get('/depreciationForm', 'depreciationController@depreciationForm')->name('depreciationForm');
Route::resource('depreciation', 'depreciationController');
Route::get('getTypeCompteId', 'TypeController@getTypeCompteId')->name('getTypeCompteId');

Route::get('/index', 'ComptabiliteController@index')->name('index');
Route::get('RattacherPartenaire/{medicament}', 'medicamentPartenaireController@Rattacher')->name('RattacherPartenaire');
Route::get('getProduiBenfic', 'FactureController@getProduiBenfic')->name('getProduiBenfic');
Route::put('/update_result_configuration', 'JournalController@update_result_configuration')->name('update_result_configuration');

Route::get('/main/Deconnexion', 'ConnexionController@Deconnexion')->name('Deconnexion');
Route::get('details_mvt/{periode}/{type_beneficiaire}/{type_mvt}', 'mouvement_affiliersController@details_mvt')->name('details_mvt');
Route::get('details_mvt_suivi/{periode}/{mois}/{type_beneficiaire}/{type_mvt}', 'mouvement_affiliersController@details_mvt_suivi')->name('details_mvt_suivi');
Route::resource('Affiliers', 'AffilierController');
Route::resource('Services', 'ServiceController');
Route::resource('Commandes', 'CommandeController');
Route::resource('Origines', 'OrigineController');
Route::resource('Medicaments', 'medicamentsserviceController');
Route::resource('medicamentPartenaire', 'medicamentPartenaireController');
Route::resource('mouvement_affilier', 'mouvement_affiliersController');
Route::resource('Taux_cotisation','TauxcotisationController');
Route::get('prestation_form/{service}/{adherant}', 'PrestationController@form_prest')->name('form_prest');
Route::get('/CorbAyantD', 'AyantDroitController@CorbAyantD')->name('CorbAyantD');

Route::post('researchAdherant', 'AffilierController@research')->name('researchAffilier');
Route::get('/AffilierPartenaire', 'AffilierController@AffilierPartenaire')->name('AffilierPartenaire');
Route::get('/beneficiairestatus/{aff}/{type_ben}', 'AffilierController@beneficiairestatus')->name('beneficiairestatus');
Route::get('/FicheAdhesion/{Affilier}', 'AffilierController@FicheAdhesion')->name('FicheAdhesion');

Route::get('/CarteAdhesion/{Affilier}', 'AffilierController@CarteAdhesion')->name('CarteAdhesion');

Route::get('registre_adhesion/{periodbig}/{periodend}', 'AffilierController@registre_adhesion')->name('registre_adhesion');
Route::get('tableau_suivi/{currentyear}', 'AffilierController@tableau_suivi')->name('tableau_suivi');

Route::post('registre_adhesion_generate', 'AffilierController@registre_adhesion_generate')->name('registre_adhesion_generate');

Route::put('/AffilierPatenerD', 'AffilierController@AffilierPatenerD')->name('AffilierPatenerD');
Route::get('/ChangerAdresse', 'ConsomationController@ChangerAdresse')->name('ChangerAdresse');
Route::put('/ModifierAdresse/{Adresse}', 'ConsomationController@ModifierAdresse')->name('ModifierAdresse');

Route::get('/CorbAffil', 'AffilierController@CorbAffil')->name('CorbAffil');

Route::get('/CorbFact', 'FactureController@CorbFact')->name('CorbFact');

Route::get('/CorbPaterner', 'PartenaireController@CorbPaterner')->name('CorbPaterner');

Route::get('/CorbCotisation', 'CotisationController@CorbCotisation')->name('CorbCotisation');

Route::get('/CorbUser', 'UtilisateurController@CorbUser')->name('CorbUser');

Route::get('/JournalC', 'CotisationController@Journal')->name('Journal');

Route::get('/JournalFacture', 'FactureController@JournalFacture')->name('JournalFacture');

Route::get('/RestaureAff/{Aff}', 'AffilierController@RestaureAff')->name('RestaureAff');

Route::get('/AttacherAff/{Service}', 'ServiceController@AttacherAff')->name('AttacherAff');
Route::get('/ChangerPrix/{Medicament}', 'medicamentsserviceController@ChangerPrix')->name('ChangerPrix');

Route::put('/ChangerPrixStore/{Medicament}', 'medicamentsserviceController@ChangerPrixStore')->name('StoreChange');

Route::delete('/SupprimerDef/{Affilier}', 'AffilierController@SupprimerDef')->name('SupprimerDef');
Route::delete('/SupprimerDefinitivement/{Facture}', 'FactureController@SupprimerDefini')->name('SupprimerDefini');
Route::delete('/SupprimerDefiniCot/{Cotisation}', 'CotisationController@SupprimerDefiniCot')->name('SupprimerDefiniCot');


Route::get('/SupprimerDefinitivement/{AyantsDroit}', 'AyantDroitController@SupprimerDefinitivement')->name('SupprimerDefinitivement');

Route::post('/AttacherAffStore', 'ServiceController@AttacherAffStore')->name('AttacherAffStore');

Route::get('Affiliers/addBillForm/{Aff}', 'AffilierController@addBillForm')->name('addBillForm');

Route::get('/RestaurerUser/{User}', 'UtilisateurController@RestaurerUser')->name('RestaurerUser');

Route::get('/Commandecreate/{User}', 'CommandeController@Commandecreate')->name('Commandecreate');

Route::get('/RestaureCot/{Cot}', 'CotisationController@RestaureCot')->name('RestaureCot');

Route::get('/RestaurePaterner/{Paterner}', 'PartenaireController@RestaurePaterner')->name('RestaurePaterner');

Route::get('/RestaureFact/{Facture}', 'FactureController@RestaureFact')->name('RestaureFact');

Route::get('/RestaureAyD/{AyD}', 'AyantDroitController@RestaureAyD')->name('RestaureAyD');
Route::resource('Utilisateurs', 'UtilisateurController');
Route::resource('AyantsDroit', 'AyantDroitController');
Route::resource('Cotisations', 'CotisationController');
Route::resource('Partenaires', 'PartenaireController');

Route::resource('Factures', 'FactureController');
Route::get('Ventillations/VentillationGeneral', 'VentillationController@VentillationGeneral')->name('VentillationGeneral');
Route::get('Ventillations/VentillationAutre', 'VentillationController@VentillationAutre')->name('VentillationAutre');
Route::post('Ventillations/CreateGroupe', 'VentillationController@CreateGroupe')->name('CreateGroupe');
Route::post('Ventillations/CreateGeneral', 'VentillationController@CreateGeneral')->name('CreateGeneral');

Route::get('Ventillations/VentillationIndividu', 'VentillationController@VentillationIndividu')->name('VentillationIndividu');

Route::get('Ventillations/ConsommationDetail', 'VentillationController@ConsommationDetail')->name('ConsommationDetail');

Route::get('Ventillations/VentillationGroupe', 'VentillationController@VentillationGroupe')->name('VentillationGroupe');

Route::post('Ventillations/CreateGroupe', 'VentillationController@CreateGroupe')->name('CreateGroupe');


Route::post('Ventillations/CreateIndividu', 'VentillationController@CreateIndividu')->name('CreateIndividu');

Route::get('Ventillations/PdfVentillationGeneral', 'VentillationController@PdfVentillationGeneral')->name('PdfVentillationGeneral');

Route::get('/PdfFacture/{Facture}', 'FactureController@PdfFacture')->name('PdfFacture');

Route::get('Affiliers/PdfListeAffilie/{Origine}', 'AffilierController@PdfListeAffilie')->name('PdfListeAffilie');

Route::get('Ventillations/PdfVentillationGroupe', 'VentillationController@PdfVentillationGroupe')->name('PdfVentillationGroupe');

Route::post('Ventillations/PdfCreateGeneral', 'VentillationController@PdfCreateGeneral')->name('PdfCreateGeneral');

Route::post('Cotisations/PdfCreateCotisation', 'CotisationController@PdfCreateCotisation')->name('PdfCreateCotisation');

Route::post('Factures/PdfCreateFactures', 'FactureController@PdfCreateFactures')->name('PdfCreateFactures');


Route::post('Ventillations/PdfCreateGroupe', 'VentillationController@PdfCreateGroupe')->name('PdfCreateGroupe');

Route::post('Ventillations/PdfCreateIndividu', 'VentillationController@PdfCreateIndividu')->name('PdfCreateIndividu');

Route::post('Ventillations/PdfViewDetails', 'VentillationController@PdfViewDetails')->name('PdfViewDetails');


Route::post('Affiliers/AffilierPartenaire', 'AffilierController@AffilierPartenaire')->name('AffilierPartenaire');

Route::get('/restaureMotDePasse/{User}', 'UtilisateurController@restaureMotDePasse')->name('restaureMotDePasse');

Route::get('/ModifierMotdePasse', 'UtilisateurController@ModifierMotdePasse')->name('ModifierMotdePasse');

Route::put('/updateProfil/{User}', 'UtilisateurController@updateProfil')->name('updateProfil');

Route::get('/ListeAffilier/{P}', 'PartenaireController@ListeAffilier')->name('ListeAffilier');

Route::get('graphic', 'TableauDeBordController@graphic')->name('graphic');
Route::get('consommer', 'TableauDeBordController@consommer')->name('consommer');
Route::get('ecart', 'TableauDeBordController@ecart')->name('ecart');
Route::get('dettePart', 'TableauDeBordController@dettePart')->name('dettePart');




Route::post('AyantsDroit/research', 'AyantDroitController@research')->name('researchAyant');


Route::post('researchF', 'FactureController@research')->name('researchJournalFacture');
Route::get('researchC', 'CotisationController@research')->name('researchAffilierCotisation');
//Route::put('researchCP', 'CotisationController@research')->name('researchAffilierCotisation');
Route::get('researchV', 'VentillationController@research')->name('researchVentillationIndiv');

Route::get('researchArticle', 'medicamentsserviceController@research')->name('researchmedicament');
Route::get('/PdfAllMedicaments', 'medicamentsserviceController@PdfAllMedicaments')->name('PdfAllMedicaments');
Route::get('/Historique/{Medicament}', 'medicamentsserviceController@Historique')->name('Historique');
Route::post('/ImporterFile', 'medicamentsserviceController@ImporterFile')->name('ImporterFile');

Route::get('getOrigineId', 'OrigineController@getOrigineId')->name('getOrigineId');


Route::get('/Getimport/{Partenaire}', 'medicamentsserviceController@Getimport')->name('Getimport');
Route::post('/PostImport', 'medicamentsserviceController@PostImport')->name('PostImport');

Route::post('/perfomAction', 'OrigineController@perfomAction')->name('perfomAction');
Route::post('/uplodaAyantDroit', 'AyantDroitController@uplodaAyantDroit')->name('uplodaAyantDroit');

Route::get('/ExportMedicament', 'medicamentsserviceController@ExportMedicament')->name('ExportMedicament');
Route::get('/ExportExcelMedicament/{Partenaire}', 'medicamentsserviceController@ExportExcelMedicament')->name('ExportExcelMedicament');

Route::get('/elaborer_facture', 'FactureController@elaborer_facture')->name('elaborer_facture');



// ROUTES POUR LE MODULE DE COMPTABILITE

 Route::get('/index', 'ComptabiliteController@index')->name('index');

 Route::middleware([ExerciceComptableExist::class])->group(function(){

    Route::resource('Journal', 'JournalController'); 
    Route::get('Balance', 'JournalController@Balance')->name('Balance');
    Route::get('AfficherGdLivre', 'JournalController@AfficherGdLivre')->name('AfficherGdLivre');
    Route::get('AfficherBalance', 'JournalController@AfficherBalance')->name('AfficherBalance');
    Route::get('CompteResultat', 'JournalController@CompteResultat')->name('CompteResultat');
    Route::get('Bilan', 'JournalController@Bilan')->name('Bilan');
    Route::get('JournalPdf', 'JournalController@JournalPdf')->name('JournalPdf');
    Route::post('JournalPdf', 'JournalController@JournalPdf')->name('JournalPdf');
    Route::post('BilanPdf', 'JournalController@BilanPdf')->name('BilanPdf');
    Route::get('ResultatPdf', 'JournalController@ResultatPdf')->name('ResultatPdf');
    Route::post('ResultatPdf', 'JournalController@ResultatPdf')->name('ResultatPdf');	 
      
 });

Route::resource('ComptePrincipal', 'ComptePrincipalController');
Route::resource('Comptedivisionnaire', 'CompteSudbivisionnaireController');
Route::resource('ExerciceComptable', 'ExerciceComptableController');
Route::resource('TypeCompte', 'TypeController');
Route::resource('CodeJournaux','CodeJournauxController');
Route::resource('CompteJournal','CompteJournalController');
Route::resource('CompteRepport','CompteRepportController');
Route::resource('Parametre_generaux','ParametreController');

Route::middleware([InitialBilan::class])->group(function(){

    Route::resource('Repportage','RepportageController');
    Route::get('/uploadinitialbilanform', 'RepportageController@uploadinitialbilanform')->name('uploadinitialbilanform');
    Route::post('file_upload', 'RepportageController@uploadfile')->name('uploadfile');
    
});

Route::put('Update_typeCompte', 'TypeController@Update_typeCompte')->name('Update_typeCompte');
Route::put('UpdateComptePrincipal', 'ComptePrincipalController@UpdateComptePrincipal')->name('UpdateComptePrincipal');

Route::put('UpdateCompteSudb', 'CompteSudbivisionnaireController@UpdateCompteSudb')->name('UpdateCompteSudb');
Route::put('UpdateSousCompte', 'SousCompteController@UpdateSousCompte')->name('UpdateSousCompte');

//Route::get('SaisieNouveauForm','RepportageController@SaisieNouveauForm')->name('SaisieNouveauForm');
Route::get('researchComptesReported', 'CompteRepportController@researchComptesReported')->name('researchComptesReported');
Route::get('PlanComptable', 'JournalController@PlanComptable')->name('PlanComptable');



Route::post('CloseExercice', 'ExerciceComptableController@CloseExercice')->name('CloseExercice');
Route::get('ReouvrirExercice/{ExerciceId}', 'ExerciceComptableController@ReouvrirExercice')->name('ReouvrirExercice');

Route::get('AddACount/{Journal}', 'CompteJournalController@AddACount')->name('AddACount');
Route::post('attachedAccount', 'CompteRepportController@attachedAccount')->name('attachedAccount');
Route::put('dettachedAccount', 'CompteRepportController@dettachedAccount')->name('dettachedAccount');
Route::get('SettedAccountAsRepported/{Compte}', 'CompteRepportController@SettedAccountAsRepported')->name('SettedAccountAsRepported');
Route::get('SettedAccountAsJournal/{Compte}', 'CodeJournauxController@SettedAccountAsJournal')->name('SettedAccountAsJournal');

Route::post('attachedJournal', 'CodeJournauxController@attachedJournal')->name('attachedJournal');
Route::put('dettacheJournal', 'CodeJournauxController@dettacheJournal')->name('dettacheJournal');
Route::get('getComptePrincipalId', 'ComptePrincipalController@getComptePrincipalId')->name('getComptePrincipalId');
Route::get('getCompteSubdivislId', 'CompteSudbivisionnaireController@getCompteSubdivislId')->name('getCompteSubdivislId');
Route::get('getSCompteId', 'SousCompteController@getSCompteId')->name('getSCompteId');
Route::get('TransfererCompta/{ligne}', 'bienController@TransfererCompta')->name('TransfererCompta');
Route::get('Amortissement_sous_compte/{Compte}', 'CompteSudbivisionnaireController@Amortissement_sous_compte')->name('Amortissement_sous_compte');
Route::get('PlanAmortissement', 'depreciationController@PlanAmortissement')->name('PlanAmortissement');

Route::get('getRepportageId', 'RepportageController@getRepportageId')->name('getRepportageId');
Route::put('depreciationtypeupdate', 'depreciationtypeController@depreciationtypeupdate')->name('depreciationtypeupdate');
Route::get('soldeJournalierForm', 'SoldeJournalierController@soldeJournalierForm')->name('soldeJournalierForm');
Route::put('SoldeJournalierAccount', 'SoldeJournalierController@SoldeJournalierAccount')->name('SoldeJournalierAccount');
Route::get('SoldeJournalier', 'SoldeJournalierController@SoldeJournalier')->name('SoldeJournalier');
Route::get('getSolde', 'SoldeJournalierController@getSolde')->name('getSolde');
Route::get('/solde_detail/{account}/{period}', 'SoldeJournalierController@solde_detail')->name('solde_detail');
Route::resource('SoldeJour', 'SoldeJournalierController');

Route::resource('guichet', 'GuichetController');

//ROUTES POUR LA GESTION DES DROITS D'ACCESS AU SYSTEME MS
    Route::resource('roles', 'RoleController');
    Route::resource('permissions', 'PermissionController');
    Route::post('add_permission', 'UtilisateurController@add_permission')->name('add_permission');
});

});


