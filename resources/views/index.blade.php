@extends('layouts.app')

@section('content')
@include('cookie-consent::index')
@if (session()->has('info')) 
    <div class="w-4/5 m-auto mt-10 pl-2">
        <p class="w-3/6 mb-4 text-gray-40 text-center bg-yellow-300 rounded-1xl py-4"> {{session()->get('info')}} </p>
    </div>
@endif


<div class="background-image grid grid-cols-1 m-auto">
    <div class="flex text-gray-100 pt-10">
        <div class="m-auto pt-4 pb-16 sm:m-auto w-4/5 block text-center">
            <h1 class="sm:text-whote text-4xl uppercase font-bold text-shadow-md pb-14">Share your story with the world.</h1>
            <!--<a href="/blog" class="text-center bg-gray-50 text-gray-50 text-gray-700 py-2 px-4 font-bold text-xl uppercase"> Read More </a>-->
        </div>
    </div>
</div>



<div class="sm:grid grid-cols-2 gap-20 w-4/5 mx-auto py-4 py-15 border-b w-25 border-gray-200"> 
    <div>
        <img src="https://cdn.pixabay.com/photo/2016/11/22/21/26/notebook-1850613_960_720.jpg" width="600" alt=""/>
    </div>

    <div class="m-auto sm:auto text-left w-4/5 block py-3 m">
        <h2 class=" text-2xl font-extrabold text-gray-600">Struggling to be a better web developer? </h2>
        <p class="py-8 text-gray-500 text-5 text-s"> Read our last posts</p>
        <a href="/blog" class="uppercase bg-blue-500 text-gray-100 text-s font-extrabold py-3 px-8 rounded-3xl"> Find out more posts </a>
    </div>
</div>



<div class="py-12 text-center p-15 bg-stone-300 text-white">
    <p class=" text-2xl text-center font-extrabold text-gray-600">Last 3 months Posts..</p>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @foreach ($posts as $post)
                <div class="grid grid-cols-1 sm:grid-cols-6 md:grid-cols-6 lg:grid-cols-6 xl:grid-cols-6 gap-4 mt-8 mb-8">
                    <div class="col-span-2 sm:col-span-1 xl:col-span-1">
                       @if ($post->image_path)
                          <img src="{{asset('images/' . $post->image_path) }}" width="600" alt="post_image"/>
                        @else
                            <img src="{{asset('images/df.jpg')}}" width="600" alt="post_default_image"/>
                        @endif
                    </div>
                    
                    <div class="col-span-2 sm:col-span-4 xl:col-span-4">
                        <h2 class="text-2xl font-medium text-gray-900 title-font mb-2">{{$post->title}}</h2>
                        <p class="leading-relaxed">{{Helper::ellipse(strip_tags(html_entity_decode($post->content)))}}</p>
                        <span class="font-semibold title-font text-gray-700">{{$post->likes->count()}} {{Str::plural('like', $post->likes->count()) }}</span>
                        <span class="mt-1 text-gray-500 text-sm">Last Edited On {{$post->updated_at}}</span>
                        <a href="{{ URL::temporarySignedRoute('posts.show', now()->addMinutes(30), ['id' => $post->id]) }}" class="text-blue-500 inline-flex items-center mt-4">Keep Reading
                            <svg class="w-4 h-4 ml-2" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M5 12h14"></path>
                                <path d="M12 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            @endforeach
        <span>
           
        </span>
    </div>
</div>

<div class="text-center p-15 bg-black text-white py-3">
    <h2 class="tet-2xl pb-5 text-xl"> I'm an extpert in... </h2>

    <span class="font-extrabold block text-3xl py-2"> UX Design </span>
    <span class="font-extrabold block text-3xl py-2"> Project Management </span>
    <span class="font-extrabold block text-3xl py-2"> Development </span>
    <span class="font-extrabold block text-3xl py-2"> Network </span>
</div>

<div class="sm:grid grid-cols-2 w-4/5 m-auto">
    
    <div class="flex bg-yellow-700 text-gray-100 pt-10"> 
        <span class="uppercase text-m text-center px-10"> PHP </span>
       <!--<div class="m-auto pt-4 pb-16 sm:m-auto w-4/5 block">
            
        </div> -->
        <h3 class="text-xl font-bold py-9 px-3"> 
        </h3>
        <a href="" class="uppercase bg-transparent text-gray-100 text-xs font-extrabold py-2 px-4 rounded-1xl hover:bg-gray-900 m:auto"> 
           Find out More 
        </a>
    </div>

    <div>
        <img src="https://cdn.pixabay.com/photo/2016/11/22/21/26/notebook-1850613_960_720.jpg" width="600" alt=""/>
    </div>
</div>
@endsection
