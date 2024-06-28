<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>GiftPits</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</head>
<body>
    <x-app-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Dashboard') }}
            </h2>
        </x-slot>
         {{-- create container div contains to buttons--}}     
        <div class="container" style="width: 25%;height:250px;padding-top:125px;margin-top:50px; background:rgb(243, 239, 239)">
            <div class="row">
                <div class="col-md-6">
                    <a href="{{route('create.level')}}" class="btn btn-primary">Create Level</a>
                </div>
                <div class="col-md-6">
                   <a href="{{route('create.question')}}" class="btn btn-primary">Craete Question</a>
                </div>
            </div>
          </div>
    </x-app-layout>
     
    
</body>
</html>
