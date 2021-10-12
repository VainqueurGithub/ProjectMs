                                          <div class="row">
                                            @foreach($ComptePrincipals as $CompteP) 
                                             <tr>
                                                @if($CompteP->soldeJournalier==1)
                                                 <td><input type="checkbox" checked="" name="compte[]" value="{{ $CompteP->id}}" class="compteChecked"></td>
                                                @else
                                                  <td><input type="checkbox" class="compteChecked" name="compte[]" value="{{ $CompteP->id}}"></td>
                                                @endif 
                                                 <td>{{ $CompteP->NumeroCompte}}</td>
                                                 <td>{{ $CompteP->Intitule }}</td>
                                               </tr>
                                              @endforeach 
                                          </div>