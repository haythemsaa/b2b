@extends('layouts.app')

@section('title', 'Modifier Adresse')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <!-- Header -->
            <div class="mb-4 animate__animated animate__fadeInDown">
                <h1><i class="bi bi-pencil me-2 text-primary"></i>Modifier l'Adresse</h1>
                <p class="text-muted">Mettez à jour les informations de l'adresse</p>
            </div>

            <!-- Form Card -->
            <div class="card shadow-sm border-0 animate__animated animate__fadeInUp">
                <div class="card-body p-4">
                    <form action="{{ route('addresses.update', $address) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Label -->
                        <div class="mb-3">
                            <label for="label" class="form-label">
                                <i class="bi bi-tag me-1"></i>Libellé (optionnel)
                            </label>
                            <select class="form-select @error('label') is-invalid @enderror"
                                    id="label" name="label">
                                <option value="">Choisir un libellé...</option>
                                <option value="Domicile" {{ old('label', $address->label) == 'Domicile' ? 'selected' : '' }}>Domicile</option>
                                <option value="Bureau" {{ old('label', $address->label) == 'Bureau' ? 'selected' : '' }}>Bureau</option>
                                <option value="Entrepôt" {{ old('label', $address->label) == 'Entrepôt' ? 'selected' : '' }}>Entrepôt</option>
                                <option value="Magasin" {{ old('label', $address->label) == 'Magasin' ? 'selected' : '' }}>Magasin</option>
                                <option value="Autre" {{ old('label', $address->label) == 'Autre' ? 'selected' : '' }}>Autre</option>
                            </select>
                            @error('label')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <!-- Full Name -->
                            <div class="col-md-6 mb-3">
                                <label for="full_name" class="form-label">
                                    <i class="bi bi-person me-1"></i>Nom complet <span class="text-danger">*</span>
                                </label>
                                <input type="text"
                                       class="form-control @error('full_name') is-invalid @enderror"
                                       id="full_name" name="full_name"
                                       value="{{ old('full_name', $address->full_name) }}"
                                       required>
                                @error('full_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Company Name -->
                            <div class="col-md-6 mb-3">
                                <label for="company_name" class="form-label">
                                    <i class="bi bi-building me-1"></i>Entreprise
                                </label>
                                <input type="text"
                                       class="form-control @error('company_name') is-invalid @enderror"
                                       id="company_name" name="company_name"
                                       value="{{ old('company_name', $address->company_name) }}">
                                @error('company_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Phone -->
                        <div class="mb-3">
                            <label for="phone" class="form-label">
                                <i class="bi bi-telephone me-1"></i>Téléphone <span class="text-danger">*</span>
                            </label>
                            <input type="tel"
                                   class="form-control @error('phone') is-invalid @enderror"
                                   id="phone" name="phone"
                                   value="{{ old('phone', $address->phone) }}"
                                   required>
                            @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Address Line 1 -->
                        <div class="mb-3">
                            <label for="address_line1" class="form-label">
                                <i class="bi bi-geo-alt me-1"></i>Adresse ligne 1 <span class="text-danger">*</span>
                            </label>
                            <input type="text"
                                   class="form-control @error('address_line1') is-invalid @enderror"
                                   id="address_line1" name="address_line1"
                                   value="{{ old('address_line1', $address->address_line1) }}"
                                   placeholder="Numéro et nom de rue"
                                   required>
                            @error('address_line1')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Address Line 2 -->
                        <div class="mb-3">
                            <label for="address_line2" class="form-label">
                                <i class="bi bi-geo-alt me-1"></i>Adresse ligne 2
                            </label>
                            <input type="text"
                                   class="form-control @error('address_line2') is-invalid @enderror"
                                   id="address_line2" name="address_line2"
                                   value="{{ old('address_line2', $address->address_line2) }}"
                                   placeholder="Appartement, bâtiment, étage...">
                            @error('address_line2')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <!-- Postal Code -->
                            <div class="col-md-4 mb-3">
                                <label for="postal_code" class="form-label">
                                    <i class="bi bi-mailbox me-1"></i>Code postal <span class="text-danger">*</span>
                                </label>
                                <input type="text"
                                       class="form-control @error('postal_code') is-invalid @enderror"
                                       id="postal_code" name="postal_code"
                                       value="{{ old('postal_code', $address->postal_code) }}"
                                       required>
                                @error('postal_code')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- City -->
                            <div class="col-md-4 mb-3">
                                <label for="city" class="form-label">
                                    <i class="bi bi-pin-map me-1"></i>Ville <span class="text-danger">*</span>
                                </label>
                                <input type="text"
                                       class="form-control @error('city') is-invalid @enderror"
                                       id="city" name="city"
                                       value="{{ old('city', $address->city) }}"
                                       required>
                                @error('city')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- State -->
                            <div class="col-md-4 mb-3">
                                <label for="state" class="form-label">
                                    <i class="bi bi-map me-1"></i>Région
                                </label>
                                <input type="text"
                                       class="form-control @error('state') is-invalid @enderror"
                                       id="state" name="state"
                                       value="{{ old('state', $address->state) }}">
                                @error('state')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Country -->
                        <div class="mb-3">
                            <label for="country" class="form-label">
                                <i class="bi bi-globe me-1"></i>Pays <span class="text-danger">*</span>
                            </label>
                            <select class="form-select @error('country') is-invalid @enderror"
                                    id="country" name="country" required>
                                <option value="TN" {{ old('country', $address->country) == 'TN' ? 'selected' : '' }}>Tunisie (TN)</option>
                                <option value="DZ" {{ old('country', $address->country) == 'DZ' ? 'selected' : '' }}>Algérie (DZ)</option>
                                <option value="MA" {{ old('country', $address->country) == 'MA' ? 'selected' : '' }}>Maroc (MA)</option>
                                <option value="FR" {{ old('country', $address->country) == 'FR' ? 'selected' : '' }}>France (FR)</option>
                            </select>
                            @error('country')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Notes -->
                        <div class="mb-3">
                            <label for="notes" class="form-label">
                                <i class="bi bi-info-circle me-1"></i>Notes / Instructions
                            </label>
                            <textarea class="form-control @error('notes') is-invalid @enderror"
                                      id="notes" name="notes" rows="3"
                                      placeholder="Instructions de livraison, code d'accès, etc.">{{ old('notes', $address->notes) }}</textarea>
                            @error('notes')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Default Address -->
                        <div class="mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox"
                                       id="is_default" name="is_default"
                                       value="1" {{ old('is_default', $address->is_default) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_default">
                                    <i class="bi bi-star me-1"></i>Définir comme adresse par défaut
                                </label>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save me-2"></i>Enregistrer
                            </button>
                            <a href="{{ route('addresses.index') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-x-circle me-2"></i>Annuler
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
