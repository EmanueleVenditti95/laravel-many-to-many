@extends('layouts.app')

@section('content')
    <div class="container">
        <table class="table">
            <thead>
              <tr>
                <th scope="col">ID</th>
                <th scope="col">Project Name</th>
                <th scope="col">Img</th>
                <th scope="col"></th>
              </tr>
            </thead>
            <tbody>
                @forelse ($projects as $project)
                    <tr>
                        <th scope="row">{{ $project->id }}</th>
                        <td><a class="text-dark text-decoration-none" href="{{route('projects.show',$project)}}">{{ $project->title }}</a></td>
                        <td><img class="w-25" src="{{ asset('storage/'.$project->image) }}" alt=""></td>
                        <td>{{isset($project->type) ? $project->type->name : '-'}}</td>
                        <td>
                            <div class="col-auto d-flex">
                                <button class="btn btn-warning mx-2"><a class="text-dark text-decoration-none" href="{{ route('projects.edit',$project) }}">modifica</a></button>
                                <form action="{{route('projects.destroy',$project)}}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <input class="btn btn-danger" type="submit" value="elimina">
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <h1>Nessun progetto trovato!</h1>    
                @endforelse
            </tbody>
          </table>      
    </div>
@endsection