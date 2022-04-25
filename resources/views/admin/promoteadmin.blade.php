@extends('layouts.app') @section('content')
    <div class=" w-4/5 m-auto text-center">
        <div class="py-16 border-b border-gray-200">
            <h1 class="font-bold font-sans break-normal text-gray-900 pt-6 pb-2 text-3xl md:text-4xl">Admin Page</h1> </div>
    </div>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8"> @if (session()->has('error'))
            <div class="bg-red-100 border-t border-b border-red-500 text-red-700 px-4 py-3" role="alert">
                <p class="font-bold">Message</p>
                <p class="text-sm">{{session()->get('error')}} </p>
            </div> @endif
        <div class="mt-6 mb-4">
            <p class="text-base md:text-sm text-blue-500 font-bold">&lt <a href="/adminpage" class="text-base md:text-sm text-blue-500 font-bold no-underline hover:underline">BACK</a></p>
        </div>
        <br> </div>
    <br>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 mt bg-white border-b border-gray-200">
                    <div>
                        <h1 class="text-xl text-gray-600">Promote user</h1>
                        <form class="mt-5" action="{{ route('admin.promoteuser') }}" name="promoteuserform" method="POST"> @csrf
                                <div class="form-group"> <b><label for="ID" class="text-gray-700">ID: </label></b>
                                    <input type="hidden" name="id" value="{{$user->id}}" />
                                    <input class="border-2 border-gray-300 p-2" readonly="readonly" disabled type="numeric" class="form-control" id="id" name="id" value="{{$user->id}}"> </div>
                                <div class="form-group mt-4"> <strong><label for="UserName" class="text-gray-700"> Username: </label></strong>
                                    <input class="border-2 border-gray-300 p-2" disabled type="text" class="form-control" id="username" name="username" value="{{$user->name}}"> <span style="color: red">@error('username'){{$message}}@enderror</span>
                                    <br> </div>
                                <div class="form-group mt-4"> <b><label for="email" class="text-gray-700">E-mail: </label></b>
                                    <input class="border-2 border-gray-300 p-2" disabled type="email" class="form-control" id="email" name="email" value="{{$user->email}}"> <span style="color: red">@error('email'){{$message}}@enderror</span>
                                    <br> </div> @if ($user->id == Auth::user()->id)
                                    <div class="form-group mt-4"> <strong><label for="isadmin" class="text-gray-700">Role: </label></strong>
                                        <select disabled class="form-control" name="admin" id="admin">
                                            <option name="isadminyes" value="1">ADMIN</option>
                                            <option name="isadminno" value="0">USER</option>
                                        </select> <span style="color: red">@error('isadmin'){{$message}}@enderror</span>
                                        <br> </div> @else
                                    <div class="form-group"> <strong><label for="isadmin" class="text-gray-700">Role: </label></strong>
                                        <select class="form-control" name="isadmin" min="0" max="1" name="admin" id="admin" value={{$user->isadmin ? 'Yes' : 'No'}}>
                                            <option name="isadmin" value="1">ADMIN</option>
                                            <option name="isadmin" value="0">USER</option>
                                        </select> <span style="color: red">@error('isadmin'){{$message}}@enderror</span>
                                        <br>
                                    </div>
                                @endif
                            <button type="submit" class="mt-10 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 border border-blue-700 rounded"> Save </button>
                        </form>
                        <br>
                        <hr>
                        <h1 class="text-xl text-gray-600">Posts from the User {{$user->name}}</h1>
                        <p><strong class="text-gray-700">Total Posts: </strong>{{count($user->posts)}} </p>
                        <div class="py-12">
                            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8"> @foreach ($user->posts as $post)
                                    <div class="grid grid-cols-1 sm:grid-cols-6 md:grid-cols-6 lg:grid-cols-6 xl:grid-cols-6 gap-4 mt-8 mb-8">
                                        <div class="col-span-2 sm:col-span-1 xl:col-span-1"> @if ($post->image_path) <img src="{{asset('images/' . $post->image_path) }}" width="600" alt="post_image" /> @else <img src="{{asset('images/df.jpg')}}" width="600" alt="post_default_image" /> @endif </div>
                                        <div class="col-span-2 sm:col-span-4 xl:col-span-4">
                                            <h2 class="text-2xl font-medium text-gray-900 title-font mb-2">{{$post->title}}</h2>
                                            <p class="leading-relaxed">{{Helper::ellipse(strip_tags(html_entity_decode($post->content)))}}</p> <span class="font-semibold title-font text-gray-700">{{$post->likes->count()}} {{Str::plural('like', $post->likes->count()) }}</span> <span class="mt-1 text-gray-500 text-sm">Last Edited On {{$post->updated_at}}</span> <a href="{{ URL::temporarySignedRoute('posts.show', now()->addMinutes(30), ['id' => $post->id]) }}" class="text-blue-500 inline-flex items-center mt-4">Keep Reading
                                                <svg class="w-4 h-4 ml-2" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                    <path d="M5 12h14"></path>
                                                    <path d="M12 5l7 7-7 7"></path>
                                                </svg>
                                            </a> </div>
                                    </div> @endforeach <span>

            </span> </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
