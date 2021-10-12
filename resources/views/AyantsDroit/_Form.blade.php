<div class="row">
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label>Code *</label>
                                  <div class="input-group">
                                    <div class="input-group-prepend">
                                      <span class="input-group-text">{{$Affilier->Code}}.</span>
                                    </div>
                                    <input type="text" class="form-control" name="Code" value="{{ old('Code')?: $AyantDroit->Code}}">
                                    {!! $errors->first('Code', '<span class="error">:message</span>') !!}
                                  </div>
                                </div>

                                <div class="form-group">
                                    <label>Nom</label>
                                    <input class="form-control" placeholder="Nom" name="Nom" value="{{ old('Nom') ?: $AyantDroit->Nom }}"/>

                                    {!! $errors->first('Nom', '<span class="error">:message</span>') !!}
                                </div>

                                <div class="form-group" style="display: none;">
                                    <label>Affilier</label>
                                   <select class="form-control select2" name="Affilier">
                                      <option value="{{ $Affilier->id }}"> {{ $Affilier->Code }}/ {{ $Affilier->Nom }} {{ $Affilier->Prenom }}</option>
                                     </select>
                                    {!! $errors->first('Affilier', '<span class="error">:message</span>') !!}
                                </div>
                              </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                <label>Prenom</label>
                                <input class="form-control" placeholder="Prenom" name="Prenom" value="{{ old('Prenom') ?: $AyantDroit->Prenom }}"/>


                                {!! $errors->first('Prenom', '<span class="error">:message</span>') !!}
                              </div>

                              <div class="form-group">
                                <label>Lien</label>
                                 <select class="form-control" name="Lien">
                                    <option onclick="AutreLienFermer()" value="{{$AyantDroit->Lien}}">{{$AyantDroit->Lien}}</option>
                                    <option onclick="AutreLienFermer()" value="Epoux">Epoux</option>
                                    <option onclick="AutreLienFermer()" value="Epouse">Epouse</option>
                                    <option onclick="AutreLienFermer()" value="Fils (Fille)">Fils (Fille)</option>
                                    <option onclick="AutreLien()">Autres</option>
                                 </select>

                                {!! $errors->first('Lien', '<span class="error">:message</span>') !!}
                              </div>

                              <div class="form-group" style="display: none;" id="Autres">
                                <input class="form-control" placeholder="Autres Lien" name="LienA" value="{{ old('LienA') }}" />

                                {!! $errors->first('LienA', '<span class="error">:message</span>') !!}
                              </div>
                            </div>    
                            
                            <div class="col-md-12">
                              <button type="submit" class="btn btn-primary">{{ $ButtonSubmitTexe }}</button>