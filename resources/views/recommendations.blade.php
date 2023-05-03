@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Add New Recommendation</h1>
        <form method="POST" action="{{ route('create-recommendation') }}" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="image">Image:</label>
                <input type="file" name="image" id="image" class="form-control-file">
            </div>

            <div class="form-group">
                <label for="cure">Cure:</label>
                <input type="text" name="cure" id="cure" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="disease_name">Disease Name:</label>
                <input type="text" name="disease_name" id="disease_name" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary">Add Recommendation</button>
        </form>
    </div>
@endsection
