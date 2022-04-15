@extends('layouts.app')

@section('content')

    <div class=" w-4/5 m-auto text-center">
        <div class="py-16 border-b border-gray-200">
            <h1 class="font-bold font-sans break-normal text-gray-900 pt-6 pb-2 text-3xl md:text-4xl">Blog Feed</h1>
        </div>
    </div>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        @if (session()->has('message'))
            <div class="bg-green-100 border-t border-b border-green-500 text-green-700 px-4 py-3" role="alert">
                <p class="font-bold">Message</p>
                <p class="text-sm">{{session()->get('message')}} </p>
            </div>
        @endif
        <div class="mt-6 mb-4">
            <p class="text-base md:text-sm text-blue-500 font-bold">&lt <a href="{{route('index')}}" class="text-base md:text-sm text-blue-500 font-bold no-underline hover:underline">HOME</a></p>
        </div><br>
    </div>
    <br>


    <div class="py-12">
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
                            @if (Auth::Check())
                                @if(Auth::user()->isadmin == 1 || $post->hasEditor(Auth::user()->email))
                            <a href="{{ URL::temporarySignedRoute('workspace.edit', now()->addMinutes(30), ['id' => $post->id]) }}"
                                class="text-gray-700 hover:text-gray-900 ml-5 pb-0.5 border-b-2">Edit
                             </a>
                                @endif
                            @endif (Auth::Check())
                            
                            @if (Auth::Check())
                                @if (isset(Auth::user()->id) && $post->isAuthor(Auth::user()) || Auth::user()->isadmin == 1)
                                    <span class="float-right">
                                            <form method="POST" action="/blog/{{$post->id}}">
                                                @csrf
                                                @method('delete')
                                                <button class="text-red-700 hover:text-red-900 pb-1 border-b-2"
                                                        type="submit">Delete</button>
                                            </form>
                                    </span>
                                @endif
                            @endif

                        </div>
                    </div>
                @endforeach
            <span>
                {!! $posts->render() !!}
            </span>
        </div>
    </div>
@endsection
