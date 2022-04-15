@extends('layouts.app')

@section('content')
    <div class="container w-full md:max-w-3xl mx-auto pt-20">
        <div class="w-full px-4 md:px-6 text-xl text-gray-800 leading-normal" style="font-family:Georgia,serif;">
            <!--Post Title-->
            <div class="font-sans">
                <p class="text-base md:text-sm text-blue-500 font-bold"> &lt <a href="{{ URL::temporarySignedRoute('posts.index', now()->addMinutes(30)) }}" class="text-base md:text-sm text-blue-500 font-bold no-underline hover:underline">BACK TO BLOG</a>
                </p>
                <h1 class="font-bold font-sans break-normal text-gray-900 pt-6 pb-2 text-3xl md:text-4xl">{{$post->title}}</h1>
                <p class="text-sm md:text-base font-normal text-gray-600">Published {{$post->posted_at}}</p>
            </div>
            <!--Post Content-->
            <div class="unreset">
                {!! html_entity_decode(($post->content)) !!}
            </div>
            <!--/ Post Content-->

            @if (!$post->likedBy(auth()->user()))
                <form action="{{ route('posts.likes', $post->id) }}" method="POST" >
                    @csrf
                    <button style="font-family: system-ui" type="submit"
                    class="h-10 px-5 m-2 text-green-100 transition-colors duration-150 bg-green-700 rounded-lg focus:shadow-outline hover:bg-green-800">Like</button>
                </form>
            @else
                <form action="{{ route('posts.likes.delete', $post->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button style="font-family: system-ui" type="submit"
                    class="h-10 px-5 m-2 text-gray-100 transition-colors duration-150 bg-gray-700 rounded-lg focus:shadow-outline hover:bg-gray-800">UnLike</button>
                </form>
            @endif
        </div>
        <hr class="border-0 bg-gray-500 text-gray-500 h-px">
        <!--Author-->
        <div class="flex w-full items-center font-sans px-4 py-12">
            <img class="w-10 h-10 rounded-full mr-4" src="https://cdn1.iconfinder.com/data/icons/technology-devices-2/100/Profile-512.png" alt="Avatar of Author">
            <div class="flex-1 px-2">
                <p class="text-base font-bold text-base md:text-xl leading-none mb-2"> {{$post->author->name}}</p>
                <p class="text-gray-600 text-xs md:text-base">Author
                </p>
            </div>
        </div>
        <!--/Author-->

        <!-- comment form -->

            <form id="comment-form" class="bg-white rounded-lg p-3  flex flex-col justify-center items-center md:items-start shadow-lg mb-4" method="POST" action="{{URL::temporarySignedRoute('comments.store', now()->addMinutes(30), ['post_id' => $post->id])}}" enctype="multipart/form-data">
                @csrf
                <div class="flex flex-wrap -mx-3 mb- p-7" >
                    <h2 class="px-4 pt-3 pb-2 text-gray-800 text-lg">Leave a comment</h2>
                    <div class="mt-3 p-3 w-full">
                        <textarea class="border p-2 rounded w-full resize-none" placeholder="Write something..." name="content"></textarea>
                    </div>
                    <div class="w-full md:w-full flex items-start md:w-full px-3">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white text-center py-2 px-4 mt-2">
                            Submit comment
                        </button>
                    </div>
                </div>
            </form>

            @foreach($comments as $comment)
            <div class="bg-white rounded-lg p-3  flex flex-col justify-center items-center md:items-start shadow-lg mb-4">
                <div class="flex flex-row justify-center mr-2">
                    <img alt="avatar" width="48" height="48" class="rounded-full w-10 h-10 mr-4 shadow-lg mb-4" src="https://cdn1.iconfinder.com/data/icons/technology-devices-2/100/Profile-512.png">
                    <h3 class="text-blue-600 font-semibold text-lg text-center md:text-left ">&#64;{{$comment->author->name}}</h3>
                </div>
                <p style="width: 90%" class="text-gray-600 text-lg text-center md:text-left pb-2">{{$comment->content}}</p>
                <small>Posted at: {{$comment->posted_at}}</small>
                @if($comment->author == Auth::user() && Auth::user()->isadmin == 1)
                    <form method="POST" action="/comments/{{$comment->id}}">
                        @csrf
                        @method('delete')
                        <button type="submit" class="bg-red-500 hover:bg-red-700 text-white text-center py-2 px-4 mt-2">
                            Delete
                        </button>
                    </form>
                @endif
            </div>
        @endforeach
        <span>
         {!! $comments->render() !!}
        </span>

    </div>
@endsection
