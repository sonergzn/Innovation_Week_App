@extends('layouts.app')

@section('content')
    <div class=" w-4/5 m-auto text-center">
        <div class="py-16 border-b border-gray-200">
            <h1 class="font-bold font-sans break-normal text-gray-900 pt-6 pb-2 text-3xl md:text-4xl">Manage Editors</h1>
            <small class="text-sm md:text-base font-normal text-gray-600">{{$post->title}}</small>
        </div>
    </div>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        @if (session()->has('error'))
            <div class="bg-red-100 border-t border-b border-red-500 text-red-700 px-4 py-3" role="alert">
                <p class="font-bold">Message</p>
                <p class="text-sm">{{session()->get('error')}} </p>
            </div>
        @endif
        <div class="mt-6 mb-4">
            <p class="text-base md:text-sm text-blue-500 font-bold">&lt <a href="{{route('posts.workspace')}}" class="text-base md:text-sm text-blue-500 font-bold no-underline hover:underline">BACK</a></p>
        </div><br>
    </div>
    <br>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div>
                        @if(!$invites->isEmpty())
                            <h1 class="text-xl text-gray-600">Pending Invites</h1>
                            <table class="bg-white rounded-lg shadow border-gray-300 w-full mt-4 mb-10">
                                @foreach($invites as $invite)
                                <tr class="divide-gray-100">
                                        <td class="p-4">{{$invite->email}}</td>
                                        <td>
                                            <div>
                                                <form method="POST" action="/invites/{{$invite->id}}">
                                                    @csrf
                                                    @method('delete')
                                                    <button type="submit" class="bg-red-500 hover:bg-red-700 text-white text-center py-2 px-4 mt-2">
                                                        Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                </tr>
                                @endforeach
                            </table>
                        @endif
                        @if(!$editors->isEmpty())
                            <h1 class="text-xl text-gray-600">Editors</h1>
                            <table class="bg-white rounded-lg shadow border-gray-300 w-full mt-4 mb-10">
                                @foreach($editors as $editor)
                                    <tr class="divide-gray-100">
                                        <td class="p-4">{{$editor->email}}</td>
                                        <td>
                                            @if(Auth::id() == $editor->id)
                                                <span class="text-xs font-semibold inline-block py-1 px-2 uppercase rounded-full text-blue-600 bg-blue-200 uppercase last:mr-0 mr-1">
                                                  Admin Editor
                                                </span>
                                            @else
                                            <div>
                                                <form method="POST" action="{{ route('editors.destroy', ['id' => $post->id]) }}">
                                                    @csrf
                                                    @method('delete')
                                                    <input type="text" name="editor" id="editor" value="{{$editor->email}}" hidden />
                                                    <button type="submit" class="bg-red-500 hover:bg-red-700 text-white text-center py-2 px-4 mt-2">
                                                        Remove
                                                    </button>
                                                </form>
                                            @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        @endif
                    </div>
                    <hr/>
                    <form id="form" method="POST" action="{{ url('invites/'.$post->id) }}" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-4">
                            <div class="mb-2">
                                <label class="text-xl text-gray-600">Invite an editor<span class="text-red-500">*</span>
                                </label>
                            </div>
                            </br>
                            <input type="email" class="border-2 border-gray-300 p-2 w-full" name="email" id="email" value="" placeholder="Enter email address">
                        </div>
                        <div class="flex p-1">
                            <button type="submit" class="p-3 bg-blue-500 text-white hover:bg-blue-400" required>Send Invite</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

