@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Crea nuovo progetto</h1>

    <form action="{{ route('projects.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label for="title">Titolo</label>
            <input type="text" class="form-control" name="title" id="title" placeholder="Inserisci titolo" required>
        </div>
        <div class="form-group">
            <label for="technologies">Tecnologie applicate :</label>
            <div>
                @foreach ($technologies as $technology)
                    <input name="technologies[]" type="checkbox" class="btn-check" value="{{$technology->id}}" id="{{$technology->id}}" @checked( in_array($technology->id, old('technologies',[]) ) )>
                    <label class="btn btn-outline-info my-2 py-0" for="{{$technology->id}}">{{$technology->name}}</label>
                @endforeach
            </div>
        </div>
        <div class="form-group">
            <label for="type_id">Tipo di progetto</label>
            <select class="form-select" name="type_id" id="type_id">
                <option value="">-</option>
                @foreach ($types as $type)
                    <option @selected(old('type_id')==$type->id) value="{{$type->id}}">{{$type->name}}</option>  
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Immagine</label>
            <input class="form-control" type="file" id="image" name="image">
        </div>
        <div class="form-group">
            <label for="description">Descrizione</label>
            <input type="text" class="form-control" name="description" id="description" placeholder="Descrizione">
        </div>
        <input type="submit" class="btn btn-primary mt-3" value="Crea">
    </form>
</div>  
@endsection