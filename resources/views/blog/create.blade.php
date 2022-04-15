@extends('layouts.app')

@section('content')
    <div class=" w-4/5 m-auto text-center">
        <div class="py-16 border-b border-gray-200">
            <h1 class="font-bold font-sans break-normal text-gray-900 pt-6 pb-2 text-3xl md:text-4xl">Create A New Post</h1>
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
            <p class="text-base md:text-sm text-blue-500 font-bold">&lt <a href="{{url()->previous()}}" class="text-base md:text-sm text-blue-500 font-bold no-underline hover:underline">BACK</a></p>
        </div><br>
    </div>
    <br>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form id="form" method="POST" action="/blog" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-4">
                            <label class="text-xl text-gray-600">Title <span class="text-red-500">*</span>
                            </label>
                            </br>
                            <input type="text" class="border-2 border-gray-300 p-2 w-full" name="title" id="title" value="" required>
                        </div>
                        <div class="mb-8">
                            <label class="text-xl text-gray-600">Content <span class="text-red-500">*</span>
                            </label>
                            </br>
                            <div id="editor" name="editor" style="font-family: Georgia">

                            </div>
                            <input type="text" name="content" id="content" value="" hidden>
                        </div>
                        <div class="bg-grey-lighter pt-15">
                            <label class="text-xl text-gray-600">Upload an image (jpg,png,jpeg)  <span class="text-red-500">*</span></label>
                                <div class="flex items-center justify-center w-full">
                                    <label class="flex flex-col w-full h-32 border-4 border-dashed hover:bg-gray-100 hover:border-gray-300">
                                        <div class=" flex flex-col items-center justify-center pt-7">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                 class="w-125 h-12 text-gray-400 group-hover:text-gray-600" viewBox="0 0 20 20"
                                                 fill="currentColor">
                                                <path fill-rule="evenodd"
                                                      d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z"
                                                      clip-rule="evenodd" />
                                            </svg>
                                            <p class="pt-1 text-sm tracking-wider w-full text-gray-400 group-hover:text-gray-600">
                                            </p>
                                        </div>
                                        <input value="Select" type="file" class="opacity-50  mt-15 bg-blue-500 text-gray-100" name="image" accept=".png, .jpg, .jpeg" >
                                        <!-- <input type="file" class="opacity-0" /> -->
                                    </label>
                                </div>
                        </div>
                        <div class="flex p-1 mt-4">
                            <select class="border-2 border-gray-300 border-r p-2" name="action">
                                <option>Publish</option>
                            </select>
                            <button type="submit" class="p-3 bg-blue-500 text-white hover:bg-blue-400" required>Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<script src="{{asset('js/quill-custom.js')}}"></script>
@endsection

