
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





<div style='display:flex' class="w-4/5 m-auto text-center">
    <div class="pt-15 w-4/5 m-auto">
        <a href="/customer/create"
            class="bg-blue-500 uppercase bg-transparent text-gray-100 text-xs font-extrabold py-3 px-5 rounded-3xl">
            Create Customer
        </a>
    </div>
    <div class="w-full md:w-2/3 shadow p-5 rounded-lg bg-white">
        <form action="/customer/filter" method="post">
             @csrf
        <div class="relative">
            <div class="absolute flex items-center ml-2 h-full">
                <svg class="w-4 h-4 fill-current text-primary-gray-dark" viewBox="0 0 16 16" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M15.8898 15.0493L11.8588 11.0182C11.7869 10.9463 11.6932 10.9088 11.5932 10.9088H11.2713C12.3431 9.74952 12.9994 8.20272 12.9994 6.49968C12.9994 2.90923 10.0901 0 6.49968 0C2.90923 0 0 2.90923 0 6.49968C0 10.0901 2.90923 12.9994 6.49968 12.9994C8.20272 12.9994 9.74952 12.3431 10.9088 11.2744V11.5932C10.9088 11.6932 10.9495 11.7869 11.0182 11.8588L15.0493 15.8898C15.1961 16.0367 15.4336 16.0367 15.5805 15.8898L15.8898 15.5805C16.0367 15.4336 16.0367 15.1961 15.8898 15.0493ZM6.49968 11.9994C3.45921 11.9994 0.999951 9.54016 0.999951 6.49968C0.999951 3.45921 3.45921 0.999951 6.49968 0.999951C9.54016 0.999951 11.9994 3.45921 11.9994 6.49968C11.9994 9.54016 9.54016 11.9994 6.49968 11.9994Z">
                    </path>
                </svg>
            </div>

            <input type="text" name = 'search_name' placeholder="Search by name..." value='{{ $search_name}}'
                class="px-8 py-3 w-50 rounded-md bg-gray-100 border-transparent focus:border-gray-500 focus:bg-white focus:ring-0 text-sm">
            <input type="text" name = 'search_phone' placeholder="Search by phone ..." value='{{ $search_phone }}'
                class="px-7 py-3 w-50 rounded-md bg-gray-100 border-transparent focus:border-gray-500 focus:bg-white focus:ring-0 text-sm">
        </div>

        <div class="flex items-center justify-between mt-4">
            <p class="font-medium">
              Age filter
            </p>

            <button class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-800 text-sm font-medium rounded-md">
              Filter
            </button>
        </div>

        <div>
            <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-4 mt-4">
                <label for="first_name" class="block text-sm font-medium text-gray-700"> From </label>

                <div class="mt-1">
                    <input type="number"  name="from_age" value="{{ $from_age}}"
                        class="block w-full appearance-none bg-white border border-gray-400 rounded-md py-2 px-3 text-base leading-normal transition duration-150 ease-in-out sm:text-sm sm:leading-5" />
                </div>

                <label for="first_name" class="block text-sm font-medium text-gray-700"> To </label>

                <div class="mt-1">
                    <input type="number" name="to_age" value="{{ $to_age }}"
                        class="block w-full appearance-none bg-white border border-gray-400 rounded-md py-2 px-3 text-base leading-normal transition duration-150 ease-in-out sm:text-sm sm:leading-5" />
                </div>


            </div>
        </div>
        @if (!empty($errors))
            @foreach ($errors as $err)
            <p> {{ $err }}</p>
            @endforeach
        @endif
</form>
    </div>

</div>




<!-- component -->


@if (is_null($customers) &&empty($customers) && count($customers)==0 )
<h1 class="text-3xl font-light text-center">

    Customer data is empty
</h1>

@else


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
                    @foreach ($customers as $customer)

                    <tr class="bg-blue-200 lg:text-black">
                        <td class="p-3 font-medium ">{{ $customer->name }}</td>
                        <td class="p-3">{{ $customer->number_phone }}</td>
                        <td class="p-3">{{ $customer->birthday }}</td>
                        <td class="p-3 uppercase"> {{ Str::limit($customer->address, 50) }}</td>

                        <td class="p-3">

                            <a href="/customer/{{ $customer->id }}/edit"
                                class="float-left text-yellow-400 hover:text-gray-100 mx-2">
                                <i style='    font-size: 22px !important;'
                                    class="material-icons-outlined text-base">edit</i>
                            </a>
                            <span class="float-left">


                                <form action="/customer/{{ $customer->id }}" method="POST">
                                    @csrf
                                    @method('delete')

                                    <button class="text-red-500 pr-3" type="submit">
                                        <i style='    font-size: 22px !important;'
                                            class="material-icons-round text-base">delete_outline</i>
                                    </button>

                                </form>
                            </span>
                        </td>
                    </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>
</div>
@endif

@endsection
