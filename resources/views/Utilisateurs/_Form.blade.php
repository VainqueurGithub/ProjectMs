 <div class="form-group">
                                            <label>Nom</label>
                                            <input class="form-control" name="Nom" value="{{ old('Nom') ?: $Utilisateur->Nom }}"/>

                                            {!! $errors->first('Nom', '<span class="error">:message</span>') !!}
                                        </div>

                                        <div class="form-group">
                                            <label>Prenom</label>
                                            <input class="form-control" name="Prenom" value="{{ old('Prenom') ?: $Utilisateur->Prenom }}" />

                                            {!! $errors->first('Prenom', '<span class="error">:message</span>') !!}
                                        </div>
                                      </div>
                                      
                                      <div class="col-md-6">
                                        <div>
                                        <label>Email</label>
                                            <input type="Email"  class="form-control" name="Email" value="{{ old('Email') ?: $Utilisateur->Email }}" />

                                            {!! $errors->first('Email', '<span class="error">:message</span>') !!}
                                        </div>
                                      <div class="form-group">
                                        <label>Profil</label>
                         
                                        <select class="form-control" name="Profil">
                                             <option value="{{ $Utilisateur->Profil }}"> {{$Utilisateur->Profil}}</option>
                                            <option value="Receptioniste"> Receptioniste</option>
                                             <option value="Financier"> Financier</option>

                                             <option value="Admin"> Admin</option>
                                         </select>
                                            {!! $errors->first('Profil', '<span class="error">:message</span>') !!}
                                        </div>

                                        <label></label><br>
                                        <button type="submit" class="btn btn-primary">{{$ButtonSubmitTexe}}</button>
                                      </div>
                                     