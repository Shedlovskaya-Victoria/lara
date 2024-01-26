<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Home</title>
</head>
<body>
<form action="{{route('category.create')}}" method="get">
    <button type="submit">Add</button>
</form>

@foreach($categories as $category)
    <div>
        <a href="category/{{$category->id}}">{{$category->id}} - {{ $category->title}}</a>

        <form action="{{route('category.update', $category->id)}}" method="post">
            @csrf
            @method('PATCH')
            <button type="submit">Edit</button>
        </form>
        <form action="{{route('category.destroy', $category)}}" method="post">
            @csrf
            @method('DELETE')
            <button type="submit">Delete</button>
        </form>
    </div>
@endforeach
</body>
</html>
