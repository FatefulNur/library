@extends('layouts.app')

@section('content')
    <div class="w-50 alert alert-dark mx-auto p-4">
        <h3 class="text-center">Create Author</h3>
        <form action="{{url('/authors')}}" method="POST" class="text-center">
            @csrf
                <input type="text" name="name" placeholder="Full name" class="form-control w-50 mx-auto mb-2">
                @error('name')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
                <input type="text" name="dob" placeholder="Date of birth" class="form-control w-50 mx-auto mb-2">
                @error('name')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
                <button class="btn btn-primary w-50">Add new author</button>
            </div>
        </form>
    </div>
@endsection
