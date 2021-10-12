                                          <div class="row">
                                              <input type="text" name="sc_compte" id="sc_compte" style="display: none;">

                                                <input type="text" name="Csubdiv" id="Csubdiv" style="display: none;">
                                              <div class="col-5">
                                                 <div class="form-group">
                                                    <label>Compte.</label>
                                                    <select class="form-control select2" required="" name="Compte">
                                                        <option></option>
                                                       @foreach($CompteSubdivisionnaires as $CompteSubdivisionnaire)
                                                         <option value="{{$CompteSubdivisionnaire->id}}">{{$CompteSubdivisionnaire->NumeroCompte}} -- {{$CompteSubdivisionnaire->Intitule}}</option>
                                                       @endforeach
                                                   </select>
                                                   {!! $errors->first('Compte', '<span class="error">:message</span>') !!}
                                                 </div>
                                              </div>

                                        
                                              <div class="col-2">
                                                  <div class="form-group">
                                                    <label>Montant.</label>
                                                   <input type="text" id="hue-demo" class="form-control" data-control="hue" required="" name="Montant" value="{{ old('Montant')?:$Repportage->montant}}">
                                                    {!! $errors->first('Montant', '<span class="error">:message</span>') !!}
                                                 </div> 
                                              </div>

                                            
                                    <div class="col-3">
                                      <div class="form-group">
                                        <label>Type</label>
                                        @if($Repportage->type_mvt==1)
                                        <div class="custom-control custom-radio">
                                            <input type="radio" class="custom-control-input" id="customControlValidation1" name="Categorie" value="1" checked="checked">
                                            <label class="custom-control-label" for="customControlValidation1">Débit</label>
                                        </div>
                                         <div class="custom-control custom-radio">
                                            <input type="radio" class="custom-control-input" id="customControlValidation2" name="Categorie" value="2">
                                            <label class="custom-control-label" for="customControlValidation2">Crédit</label>
                                        </div>
                                        @elseif($Repportage->type_mvt==2)
                                        <div class="custom-control custom-radio">
                                            <input type="radio" class="custom-control-input" id="customControlValidation1" name="Categorie" value="1">
                                            <label class="custom-control-label" for="customControlValidation1">Débit</label>
                                        </div>
                                         <div class="custom-control custom-radio">
                                            <input type="radio" class="custom-control-input" id="customControlValidation2" name="Categorie" value="2" checked="checked">
                                            <label class="custom-control-label" for="customControlValidation2">Crédit</label>
                                        </div>
                                        @else
                                         <div class="custom-control custom-radio">
                                            <input type="radio" class="custom-control-input" id="customControlValidation1" name="Categorie" value="1" checked="checked">
                                            <label class="custom-control-label" for="customControlValidation1">Débit</label>
                                        </div>
                                         <div class="custom-control custom-radio">
                                            <input type="radio" class="custom-control-input" id="customControlValidation2" name="Categorie" value="2">
                                            <label class="custom-control-label" for="customControlValidation2">Crédit</label>
                                        </div>
                                        @endif
                                       </div>  
                                    </div>
                                
                                 <div class="col-2">
                                                  <div class="form-group">
                                                   <button style="margin-top: 30px;" type="submit" class="form-control btn btn-success">{{$LibelleButton}}</button>
                                                 </div> 
                                              </div>
                                           
                                          </div>