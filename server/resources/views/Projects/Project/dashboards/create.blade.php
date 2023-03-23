@extends('layouts.project-dashboard')

@section('project')
    <div class="bg-white p-4 rounded">
        <div class="lead">
            Add new table
        </div>

        <div class="container mt-4 p-0">
            <form method="POST" action="{{ route('home.project.dashboard.store', ['project' => $project]) }}" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input value="{{ old('name') }}"
                           type="text"
                           class="form-control shadow-none @error('name') is-invalid @enderror"
                           name="name"
                           placeholder="Name" required>
                </div>

                @error('name')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror

{{--                <div class="mb-3">--}}
{{--                    <label for="category_id" class="form-label">Select category</label>--}}
{{--                    <select class="form-select shadow-none @error('category_id') is-invalid @enderror" name="category_id"--}}
{{--                            id="inputGroupSelect01">--}}
{{--                        <option selected>Select category</option>--}}
{{--                        @foreach($categories as $category)--}}
{{--                            <option--}}
{{--                                value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : ''}}>{{ $category->name }}</option>--}}
{{--                        @endforeach--}}
{{--                    </select>--}}
{{--                </div>--}}

{{--                @error('category_id')--}}
{{--                <div class="alert alert-danger">{{ $message }}</div>--}}
{{--                @enderror--}}

                <button type="submit" class="btn btn-outline-primary shadow-none">Create table</button>
            </form>
        </div>

    </div>
@endsection
