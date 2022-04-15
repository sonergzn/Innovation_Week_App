@extends('layouts.app')

@section('content')

@if ($errors->any())
    <div class="w-4/5 m-auto">
        <ul>
            @foreach ($errors->all() as $error)
                <li class="w-1/5 mb-4 text-gray-50 bg-red-700 py-4">
                    {{$error}}
                </li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ url('userpage/'.$user->id) }}" name="editprofile" method="POST">
    <div class="container">
    
        @csrf
        @method('PUT')

        <div class="w-4/5 m-auto pt-20">
          <label class="block text-gray-500 font-bold md:text-left mb-1 md:mb-0 pr-4" for="name">First Name: </label>
          <input type="text" value="{{$user->name}}" id="name" name="name" placeholder="name" class="focus:ring focus:border-blue-300 hover:border-green-300 bg-transparent py-20 block border-b-2 w-full h-60 text-xl">
          <span style="color: red">@error('name'){{$message}}@enderror</span> <br>
        </div>
    
          <div class="w-4/5 m-auto pt-20">
            <label class="block text-gray-500 font-bold md:text-left mb-1 md:mb-0 pr-4" for="email">Email: </label>
            <input type="email" value="{{$user->email}}" id="email" name="email" placeholder="Email.." class="focus:ring focus:border-blue-300 hover:border-green-300 bg-transparent py-20 block border-b-2 w-full h-60 text-xl outline-border">
            <span style="color: red">@error('email'){{$message}}@enderror</span> <br>
          </div>
    
          <div class="w-4/5 m-auto pt-20">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="email">Created </label>
            <input disabled type="text" value="{{$user->created_at}}" id="created_at" name="created_at"  class="focus:ring focus:border-blue-300 hover:border-green-300 bg-transparent py-20 block border-b-2 w-full h-60 text-xl outline-border">
          </div>
    
          <div class="w-4/5 m-auto pt-20">
            <label  class="block text-gray-700 text-sm font-bold mb-2" for="email">Updated</label>
            <input disabled type="text" value="{{$user->updated_at}}" id="updated_at" name="updated_at"  class="focus:ring focus:border-blue-300 hover:border-green-300 bg-transparent py-20 block border-b-2 w-full h-60 text-xl outline-border">
          </div> <br>

          <button type="submit" class="uppercase mt-15 bg-blue-500 text-gray-100 text-lg font-extrabold py-4 px-8 rounded-3xl"> Save </button>
          <button class="uppercase mt-15 bg-blue-500 text-gray-100 text-lg font-extrabold py-4 px-8 rounded-3xl"> <a href="/userpage"> Back </a> </button>
    </div>
    </form>
    <br>

     <a href="{{url('userpage/data/'.$user->id) }}"> <button class="mt-15 bg-blue-500 text-gray-100 text-lg py-4 px-8 rounded-3xl" type="submit">Get My Data</button> </a>

        <form action="{{ url('userpage/'.$user->id) }}" name="editprofile" method="POST">
            <div class="container">
                @csrf
                @method('delete')
                <button class="uppercase mt-15 bg-red-500 text-white-100 text-lg font-extrabold py-4 px-8 rounded-3xl" type="submit"> DELETE MY PROFILE </button>
            </div>
    </form>
    @endsection