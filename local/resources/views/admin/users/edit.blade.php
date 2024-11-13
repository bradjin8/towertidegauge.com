<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="max-w-lg mx-auto bg-gray-300 dark:bg-gray-800 p-8 rounded-lg shadow-lg">
                <form action="{{ route('users.update', $user) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Name Field -->
                    <div class="mb-4">
                        <label for="name"
                               class="block text-sm font-medium text-gray-700 dark:text-gray-300">Name</label>
                        <input
                            type="text"
                            name="name"
                            id="name"
                            value="{{ old('name', $user->name) }}"
                            class="mt-1 block w-full px-4 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-200 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                            required>
                    </div>

                    <!-- Email Field -->
                    <div class="mb-4">
                        <label for="email"
                               class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
                        <input
                            type="email"
                            name="email"
                            id="email"
                            value="{{ old('email', $user->email) }}"
                            class="mt-1 block w-full px-4 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-200 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                            required>
                    </div>

                    <!-- Phone Number Field -->
                    <div class="mb-4">
                        <label for="phone_number" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Phone
                            Number</label>
                        <input
                            type="tel"
                            name="phone_number"
                            id="phone_number"
                            value="{{ old('phone_number', $user->phone_number) }}"
                            class="mt-1 block w-full px-4 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-200 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <!-- Company Name Field -->
                    <div class="mb-4">
                        <label for="company_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Company
                            Name</label>
                        <input
                            type="text"
                            name="company_name"
                            id="company_name"
                            value="{{ old('company_name', $user->company_name) }}"
                            class="mt-1 block w-full px-4 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-200 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <!-- Admin Role Selector -->
                    <div class="mb-4">
                        <label for="is_admin"
                               class="block text-sm font-medium text-gray-700 dark:text-gray-300">Role</label>
                        <select
                            name="is_admin"
                            id="is_admin"
                            class="mt-1 block w-full px-4 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-200 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                            required>
                            <option value="0" {{ old('is_admin', $user->is_admin) == '0' ? 'selected' : '' }}>User
                            </option>
                            <option value="1" {{ old('is_admin', $user->is_admin) == '1' ? 'selected' : '' }}>Admin
                            </option>
                        </select>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-end">
                        <button type="submit"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition duration-300">
                            Update User
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>
