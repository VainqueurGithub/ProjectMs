<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\IAffilie;
use App\Models\Affilier;
use App\Interfaces\IOrigine;
use App\Models\Origine;
use App\Interfaces\IAyantDroit;
use App\Models\AyantDroit;
use App\Interfaces\IService;
use App\Models\Service;
use App\Interfaces\IPartenaire;
use App\Models\Partenaire;
use App\Interfaces\IExcelImport;
use App\Models\ExcelImport;
use App\Models\Commande;
use App\Interfaces\ICommande;
use App\Models\Facture;
use App\Interfaces\IFacture;
use App\Models\medicamentsservice;
use App\Interfaces\IMedicamentservice;
use App\Models\Repportage;
use App\Interfaces\IRepportage;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(IAffilie::class, Affilier::class);
        $this->app->bind(IOrigine::class, Origine::class);
        $this->app->bind(IAyantDroit::class, AyantDroit::class);
        $this->app->bind(IService::class, Service::class);
        $this->app->bind(IPartenaire::class, Partenaire::class);
        $this->app->bind(IExcelImport::class, ExcelImport::class);
        $this->app->bind(IExcelImport::class, ExcelImport::class);
        $this->app->bind(ICommande::class, Commande::class);
        $this->app->bind(IFacture::class, Facture::class);
        $this->app->bind(IMedicamentservice::class, medicamentsservice::class);
        $this->app->bind(IRepportage::class, Repportage::class);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
