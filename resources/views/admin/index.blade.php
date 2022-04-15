@extends('layouts.app') @section('content')
    <div class=" w-4/5 m-auto text-center">
        <div class="py-16 border-b border-gray-200">
            <h1 class="font-bold font-sans break-normal text-gray-900 pt-6 pb-2 text-3xl md:text-4xl">Admin Page</h1> </div>
    </div>
    <br/>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div>
                        <h1 class="text-xl text-gray-600">View all users</h1>
                        <form action="{{url('adminpage/promoteadmin')}}" method="get">
                            <div class=""> 
                                <input class="h-14 w-96 pr-8 pl-5 rounded z-0 focus:shadow focus:outline-none" name="searchTerms" type="text" class="form-control typeahead" placeholder="Search user by name" />
                                <input class="bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded" type="submit" name="search" class="btn" value="Search" />
                                <div class="absolute top-4 right-3"> <i class="fa fa-search text-gray-400 z-20 hover:text-gray-500"></i> </div>
                            </div>
                            
                        </form>
                        <br>
                        <table class="table-auto w-full">
                            <thead class="text-xs font-semibold uppercase text-gray-400 bg-gray-50">
                            <tr>
                                <th class="p-2 whitespace-nowrap">
                                    <div class="font-semibold text-left">ID</div>
                                </th>
                                <th class="p-2 whitespace-nowrap">
                                    <div class="font-semibold text-left">Name</div>
                                </th>
                                <th class="p-2 whitespace-nowrap">
                                    <div class="font-semibold text-left">Email</div>
                                </th>
                                <th class="p-2 whitespace-nowrap">
                                    <div class="font-semibold text-center">Role</div>
                                </th>
                                <th class="p-2 whitespace-nowrap">
                                    <div class="font-semibold text-center">Total Posts</div>
                                </th>
                                <th class="p-2 whitespace-nowrap">
                                    <div></div>
                                </th>
                            </tr>
                            </thead>
                            <tbody class="text-sm divide-y divide-gray-100"> @forelse ($users as $user)
                                <tr>
                                    <td class="p-2 whitespace-nowrap">{{$user->id}} </td>
                                    <td class="p-2 whitespace-nowrap">{{$user->name}} </td>
                                    <td class="p-2 whitespace-nowrap">{{$user->email}} </td>
                                    <td class="p-2 whitespace-nowrap text-center"> @if($user->isadmin) <span class="text-xs font-semibold inline-block py-1 px-2 uppercase rounded-full text-blue-600 bg-blue-200 uppercase last:mr-0 mr-1">ADMIN</span> @else <span class="text-xs font-semibold inline-block py-1 px-2 uppercase rounded-full text-green-600 bg-green-200 uppercase last:mr-0 mr-1">USER</span> @endif </td>
                                    <td class="p-2 whitespace-nowrap text-center">{{count($user->posts)}} </td>
                                    <td> <a class="text-gray-700 hover:text-gray-900 ml-5 pb-0.5 border-b-2" href="{{ url('adminpage/promoteadmin', ['userid' => $user->id]) }}"> Edit Admin Rights</a> </td>

                                    <form action="{{ url('adminpage/'.$user->id) }}" name="deletefromadmin" method="POST">
                                        <div class="container">
                                            @csrf
                                            @method('delete')
                                            @if ($user->id == Auth::user()->id)
                                            <td> Go to <a href="/userpage" class="focus:shadow-outline hover:text-green-500 "> My Profile </a> to delete your profile. </td>
                                            @else
                                            <td> <button class="text-slate-400 hover:text-white transition-colors duration-150 bg-white-700 focus:shadow-outline hover:bg-red-500 ml-5 pb-0.5 border-b-2" type="submit"> Delete</button> </td>
                                            @endif
                                        </div>
                                    </form>   

                                    
                                </tr> @empty
                                <tr>
                                    <td> Nothing Found... </td>
                                </tr> @endforelse </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
