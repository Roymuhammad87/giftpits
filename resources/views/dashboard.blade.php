<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>GiftPits</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <style>
        /* Add some basic styling to the container */
        .container {
            max-width: 800px; /* Set a maximum width */
            margin: 40px auto; /* Add some margin and center the container */
            padding: 20px; /* Add some padding */
            background-color: #f3f3f3; /* Set a light gray background color */
            border: 1px solid #ddd; /* Add a border */
            border-radius: 10px; /* Add some rounded corners */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Add some subtle shadow */
        }
        
        /* Add some margin between the buttons */
        .btn {
            margin-bottom: 10px; /* Add some margin between the buttons */
        }
        
        /* Make the buttons equal width */
        .btn-group {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }
        
        .btn-group .btn {
            flex: 1;
            margin: 10px;
        }
    </style>
</head>
<body>
    <x-app-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Dashboard') }}
            </h2>
        </x-slot>
        <!-- Create container div contains two buttons -->
        <div class="container">
            <div class="btn-group">
                <a href="{{route('create.level')}}" class="btn btn-primary">Create Level</a>
                <a href="{{route('create.question')}}" class="btn btn-primary">Create Question</a>
            </div>
        </div>
    </x-app-layout>
</body>
</html>