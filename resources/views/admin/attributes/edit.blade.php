@extends('layouts.admin')

@section('title', 'Modifier un Attribut')
@section('page-title', 'Modifier un Attribut')

@section('content')
<div class="row">
    <div class="col-lg-8 mx-auto">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-edit me-2"></i>Modifier l'attribut : {{ $attribute->name }}
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.attributes.update', $attribute) }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="name" class="form-label">Nom de l'attribut <span class="text-danger">*</span></label>
                        <input type="text"
                               class="form-control @error('name') is-invalid @enderror"
                               id="name"
                               name="name"
                               value="{{ old('name', $attribute->name) }}"
                               required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="type" class="form-label">Type d'attribut <span class="text-danger">*</span></label>
                        <select class="form-select @error('type') is-invalid @enderror"
                                id="type"
                                name="type"
                                required>
                            @foreach($types as $key => $label)
                                <option value="{{ $key }}"
                                    {{ old('type', $attribute->type) == $key ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                        @error('type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="sort_order" class="form-label">Ordre d'affichage</label>
                        <input type="number"
                               class="form-control @error('sort_order') is-invalid @enderror"
                               id="sort_order"
                               name="sort_order"
                               value="{{ old('sort_order', $attribute->sort_order) }}"
                               min="0">
                        @error('sort_order')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input"
                                   type="checkbox"
                                   id="is_required"
                                   name="is_required"
                                   {{ old('is_required', $attribute->is_required) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_required">
                                <strong>Attribut requis</strong>
                            </label>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input"
                                   type="checkbox"
                                   id="is_filterable"
                                   name="is_filterable"
                                   {{ old('is_filterable', $attribute->is_filterable) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_filterable">
                                <strong>Filtrable</strong>
                            </label>
                        </div>
                    </div>

                    <hr>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.attributes.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Retour
                        </a>
                        <button type="submit" class="btn btn-admin-primary">
                            <i class="fas fa-save me-2"></i>Enregistrer les modifications
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Gestion des valeurs pour les types select/multiselect/color -->
        @if(in_array($attribute->type, ['select', 'multiselect', 'color']))
        <div class="card mt-3">
            <div class="card-header">
                <i class="fas fa-list me-2"></i>Valeurs de l'attribut
            </div>
            <div class="card-body">
                @if($attribute->values->count() > 0)
                    <div class="table-responsive mb-3">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Valeur</th>
                                    <th class="text-center">Ordre</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($attribute->values as $value)
                                <tr>
                                    <td>
                                        @if($attribute->type === 'color')
                                            <span class="badge" style="background-color: {{ $value->value }}">
                                                {{ $value->value }}
                                            </span>
                                        @else
                                            {{ $value->value }}
                                        @endif
                                    </td>
                                    <td class="text-center">{{ $value->sort_order ?? 0 }}</td>
                                    <td class="text-center">
                                        <form method="POST"
                                              action="{{ route('admin.attributes.values.delete', [$attribute, $value]) }}"
                                              class="d-inline"
                                              onsubmit="return confirm('Supprimer cette valeur ?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-muted text-center">Aucune valeur définie pour cet attribut.</p>
                @endif

                <hr>

                <!-- Formulaire d'ajout de valeur -->
                <h6>Ajouter une valeur</h6>
                <form method="POST" action="{{ route('admin.attributes.values.add', $attribute) }}">
                    @csrf
                    <div class="row g-2">
                        <div class="col-md-6">
                            <input type="text"
                                   class="form-control"
                                   name="value"
                                   placeholder="Nouvelle valeur"
                                   required>
                        </div>
                        <div class="col-md-3">
                            <input type="number"
                                   class="form-control"
                                   name="sort_order"
                                   placeholder="Ordre"
                                   value="0"
                                   min="0">
                        </div>
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-success w-100">
                                <i class="fas fa-plus me-2"></i>Ajouter
                            </button>
                        </div>
                    </div>
                </form>

                @if($attribute->type === 'color')
                <div class="alert alert-info mt-3 mb-0">
                    <small>
                        <i class="fas fa-info-circle me-2"></i>
                        Pour les couleurs, utilisez le format hexadécimal (ex: #FF5733) ou les noms CSS (ex: red, blue).
                    </small>
                </div>
                @endif
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
