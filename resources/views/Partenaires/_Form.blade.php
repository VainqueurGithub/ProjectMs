                                        <div class="form-group">
                                            <label>Code</label>
                                            <input class="form-control" placeholder="Code du Partenaire" name="Code" value="{{ old('Code') ?: $Partenaire->Code }}"/>

                                            {!! $errors->first('Code', '<span class="error">:message</span>') !!}
                                        </div>

                                        <div class="form-group">
                                            <label>Nom</label>
                                            <input class="form-control" placeholder="Nom du Partenaire" name="Nom" value="{{ old('Nom') ?: $Partenaire->Partenaire }}"/>

                                            {!! $errors->first('Nom', '<span class="error">:message</span>') !!}
                                        </div>
                                      </div>
                                      
                                      <div class="col-md-6">
                                        <div class="form-group">
                                        <label>Type Partenaire</label>

                                         <select class="form-control" name="Type">
                                          <option value="{{ $Partenaire->Type }}"> {{ $Partenaire->Type }}</option>
                                            <option value="Hopital"> HOPITAL</option>
                                             <option value="Pharmacie"> PHARMACIE</option>
                                         </select>
                                            {!! $errors->first('Type', '<span class="error">:message</span>') !!}
                                        </div>

                                        <label></label><br>
                                        <button type="submit" class="btn btn-primary">{{ $ButtonSubmitTexe }}</button>