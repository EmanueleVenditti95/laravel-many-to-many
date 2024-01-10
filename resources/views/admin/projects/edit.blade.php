@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Modifica il progetto</h1>

        <form action="{{route('projects.update',$project)}}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="title">Titolo</label>
                <input type="text" class="form-control" name="title" id="title" placeholder="Inserisci titolo" value="{{$project->title}}" required>
            </div>
            <div class="form-group">
                <label for="technologies">Tecnologie applicate :</label>
                <div>
                    @foreach ($technologies as $technology)
                        <input name="technologies[]" type="checkbox" class="btn-check" value="{{$technology->id}}" id="{{$technology->id}}" @checked( in_array($technology->id, old('technologies',$project->technologies->pluck('id')->all()) ) )>
                        <label class="btn btn-outline-info my-2 py-0" for="{{$technology->id}}">{{$technology->name}}</label>
                    @endforeach
                </div>
            </div>
            <div class="form-group">
                <label for="type_id">Tipo di progetto</label>
                <select class="form-select" name="type_id" id="type_id">
                    <option value="">-</option>
                    @foreach ($types as $type)
                        <option @selected(old('type_id',optional($project->type)->id)==$type->id) value="{{$type->id}}">{{$type->name}}</option>  
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="image">Immagine</label>
                <input type="url" class="form-control" name="image" id="image" placeholder="URL immagine" value="{{$project->image}}" required>
            </div>
            <div class="form-group">
                <label for="description">Descrizione</label>
                <input type="text" class="form-control" name="description" id="description" placeholder="Descrizione" value="{{$project->description}}">
            </div>
            <div class="col-auto d-flex">
                <input type="submit" class="btn btn-warning mt-3 mx-2" value="modifica">
            </div>    
        </form>
        <form action="{{route('projects.destroy',$project)}}" method="POST">
            @csrf
            @method('DELETE')
            <input class="btn btn-danger mt-3 mx-2" type="submit" value="elimina">
        </form>
    </div>    
@endsection