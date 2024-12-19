<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 ">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    {{ session('error') }}
                </div>
            @endif

            <div class="flex justify-start mb-4">
                <a href="{{ route('users.create') }}"
                   class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Add User
                </a>
            </div>

            <table class="w-full table-auto text-gray-800 dark:text-white bg-gray-300 dark:bg-gray-800">
                <thead>
                <tr class="text-gray-950 dark:text-gray-100 uppercase text-sm leading-normal">
                    <th class="py-2 px-2 text-left">Name</th>
                    <th class="py-2 px-2 text-left hidden sm:table-cell ">Email</th>
                    <th class="py-2 px-2 text-left hidden sm:table-cell">Phone</th>
                    <th class="py-2 px-2 text-left hidden sm:table-cell">Company Name</th>
                    <th class="py-2 px-2 text-center">Actions</th>
                </tr>
                </thead>
                <tbody class="text-sm font-light">
                @foreach($users as $user)
                    <tr class="hover:bg-gray-400 dark:hover:bg-gray-500">
                        <td class="py-2 px-2 text-left">
                            <div class="flex items-center gap-4">
                                <div class="mr-2">
                                    <img class="w-8 h-8 rounded-full"
                                         src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}"
                                         alt="{{ $user->name }}">
                                </div>
                                <span>{{ $user->name }}</span>
                                @if($user->is_admin)
                                    <sup class="text-xs bg-amber-600 text-white rounded-md p-1">Admin</sup>
                                @endif
                            </div>
                        </td>
                        <td class="py-2 px-2 text-left hidden sm:table-cell">
                            {{ $user->email }}
                        </td>
                        <td class="py-2 px-2 text-left hidden sm:table-cell">{{ $user->phone_number}}</td>
                        <td class="py-2 px-2 text-left hidden sm:table-cell">{{ $user->company_name}}</td>
                        <td class="py-2 px-2 text-center">
                            <div class="flex item-center justify-center gap-4">
                                <a href="{{ route('users.edit', $user) }}"
                                   class="transform hover:text-purple-500 hover:scale-110">
                                    Edit
                                </a>
                                <form action="{{ route('users.destroy', $user) }}" method="POST"
                                      onsubmit="return confirm('Are you sure?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="transform hover:text-red-500 hover:scale-110">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>

                @endforeach
                </tbody>
            </table>

        </div>
    </div>
</x-app-layout>
