@extends('layouts.app')

@section('content')

@if ($message = Session::get('info'))
    <div class="w-4/5 m-auto mt-10 pl-2">
        <p class="w-3/6 mb-4 text-gray-40 text-center bg-yellow-300 rounded-1xl py-4"> {{ $message }} </p>
    </div>
@endif

<?php
    $username = Auth::user()->name;
    $counter = 0;
    $user = Auth::user(); ?>
<div class=" w-4/5 m-auto text-center">
    <div class="py-16 border-b border-gray-200">
        <h1 class="text-6xl">
            User Page for {{$username}}
        </h1>
    </div>
</div>
<div class="py-16 border-b border-gray-200">
    <div class="pt-15 <-4/5 m-auto">
        <a href="/userpage/{{ Auth::id() }}" class="bg-blue-500 uppercase bg-transparent test-gray-100 text-xs font-extrabold py-3 px-5 "> Edit my Data</a>
    </div>
</div>


@forelse ($userposts as $post)

<div class="w-4/5 m-auto text-left">
    <div class="w-4/5 m-auto mt-10 pl-2 text-left">
        </div>
        <div class="w-4/5 m-auto mt-10 pl-2 text-left">
          <h3 class="text-4xl font-normal leading-normal mt-0 mb-2 text-gray-800 text-left"> {{$post->title}} </h3>
          <p class="text-lg text-black font-semibold"> {{strip_tags(html_entity_decode($post->content))}} </p>


        </div>
        <?php $name = Auth::user()->name; ?>
        <img accept=".png, .jpg, .jpeg" src="{{asset('images/' . $post->image_path) }}" class="rounded-full h-14 w-14 flex items-center md:float-center" /> <br>
        <p class="text-lg font-semibold"> Created at: {{$post->created_at}} </p>
        <p class="text-lg font-semibold"> Updated at: {{$post->updated_at}} </p>
        <p class="text-lg font-semibold"> User Id: {{$post->author_id}}</p>
        <p class="text-lg font-semibold"> Post Id: {{$post->id}}</p>
        <?php $counter++;
        ?>
    </div>
</div>

@empty
<p> No posts availible </p>
@endforelse
<p class="text-lg text-black font-semibold text-center"> Total: <strong>{{$counter}} </strong> posts </p>


@endsection


