                                  <div class="table-responsive">
                                   <div class="col-12">
                                    <table id="zero_config" class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>N° des comptes</th>
                                                <th>Date Operation</th>
                                                <th>Transferer Au</th>
                                                <th>Montants</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($Soldes as $Solde)
                                              <tr>
                                                <td>{{$Solde->NumeroCompte}}{{$Solde->Isc}}</td>
                                                <td>{{$Solde->dateOperation}}</td>
                                                <td>{{$Solde->repporterAu}}</td>
                                                <td>{{$Solde->montant}}</td>
                                                <td></td>
                                              </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    </div>
                                </div>