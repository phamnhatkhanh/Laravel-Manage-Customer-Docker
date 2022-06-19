
@extends('layouts.app')
@section('content')

<div class="w-4/5 m-auto text-center">
    <div class="py-15 border-b border-gray-200">
        <h1 class="text-6xl">
          Customer information
        </h1>
    </div>
</div>

@if (session()->has('message'))
    <div class="w-4/5 m-auto mt-10 pl-2">
        <p class="w-2/6 mb-4 text-gray-50 bg-green-500 rounded-2xl py-4">
            {{ session()->get('message') }}
        </p>
    </div>
@endif








<div class="flex items-center justify-center bg-white">
    <div class="col-span-12">
        <div class="overflow-auto lg:overflow-visible">

            <table class="table text-gray-400 border-separate space-y-6 text-sm">
                <thead class="bg-blue-500 text-white">
                    <tr>
                        <th class="p-3">Name</th>
                        <th class="p-3 text-left">Phone</th>
                        <th class="p-3 text-left">Birthday</th>
                        <th class="p-3 text-left">Address</th>


                        <th class="p-3 text-left">Action</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- @php
                        gettype($customers);
                    @endphp --}}
                    @foreach ($customers as $customer)

                    <tr class="bg-blue-200 lg:text-black">
                        <td class="p-3 font-medium ">{{ $customer->name}}</td>

                    </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>
</div>
{{-- @endif --}}

@endsection
