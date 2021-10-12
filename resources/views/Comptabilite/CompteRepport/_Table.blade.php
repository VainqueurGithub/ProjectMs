                                <div class="table-responsive">
                                   <div class="col-12">
                                    <table id="zero_config" class="table table-striped">
                                        <thead>
                                            <tr style="text-align: center;">
                                                <th colspan="2">N° des comptes</th>
                                                <th colspan="2">Montants</th>
                                                <th>Action</th>
                                            </tr>

                                            <tr>
                                                <th>D</th>
                                                <th>C</th>
                                                <th>Débit</th>
                                                <th>Crédit</th>
                                            </tr>

                                        </thead>
                                        <tbody>
                                            @foreach($Saisies as $Saisie)
                                                @if($Saisie->type_mvt==1)
                                                  <tr>
                                                    <td>{{$Saisie->NumeroCompte}}</td>
                                                    <td></td>
                                                    <td>{{$Saisie->montant}}</td>
                                                    <td></td>
                                                    <td>
                                                     <a href="{{route('Repportage.edit', $Saisie->id)}}"><i class="fas fa-edit"></i></a>

                                                      <form action="{{route('Repportage.destroy', $Saisie->id)}}" method="POST" style="display: inline-block;" onsubmit="return confirm('Etez -vous sur de cette Operation ?')">
                                                     {{csrf_field()}}
                                                     {{method_field('DELETE')}}
                    
                                                      <button onclick="return confirm('Etez -vous sur de cette Operation ?')" ><i class='fas fa-trash'></i>
                                                     </button>
                                                    </form></td>
                                                  </tr>
                                                @elseif($Saisie->type_mvt==2)
                                                  <tr>
                                                    <td></td>
                                                    <td>{{$Saisie->NumeroCompte}}</td>
                                                    <td></td>
                                                    <td>{{$Saisie->montant}}</td>
                                                    <td>
                                                      <!--button data-toggle="modal" data-target="#add-older-event" value="  {{$Saisie->id}}" onclick="getRepportage(this)">
                                                          <i class="fas fa-edit"></i>
                                                      </button-->
                                                      <a href="{{route('Repportage.edit', $Saisie->id)}}"><i class="fas fa-edit"></i></a>

                                                      <form action="{{route('Repportage.destroy', $Saisie->id)}}" method="POST" style="display: inline-block;" onsubmit="return confirm('Etez -vous sur de cette Operation ?')">
                                                     {{csrf_field()}}
                                                     {{method_field('DELETE')}}

                                                      <button onclick="return confirm('Etez -vous sur de cette Operation ?')" ><i class='fas fa-trash'></i>
                                                     </button>
                                                    </form></td>
                                                  </tr>
                                                @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                    </div>
                                </div>