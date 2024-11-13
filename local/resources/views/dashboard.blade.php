<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-gradient-to-r from-blue-500 to-blue-700 dark:from-blue-800 dark:to-blue-900 text-white overflow-hidden shadow-lg rounded-lg p-8">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-3xl font-bold">{{ Auth()->user()->is_admin ? 'Admin Dashboard' : 'User Dashboard' }}</h3>
                        <p class="mt-2 text-gray-200 dark:text-gray-300">
                            {{ Auth()->user()->is_admin ? 'Overview of system data.' : 'Overview of your assigned resources.' }}
                        </p>
                    </div>
                    <img src="https://img.icons8.com/ios-filled/50/ffffff/dashboard.png" alt="Dashboard Icon" class="w-12 h-12 opacity-75">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @if(Auth()->user()->is_admin)
                    <!-- Total Users Card -->
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Total Users</h4>
                                <p class="mt-2 text-4xl font-bold text-blue-600 dark:text-blue-400">{{ $data['users'] }}</p>
                            </div>
                            <img src="https://img.icons8.com/ios-filled/50/000000/user-group-man-man.png" alt="Users Icon" class="w-10 h-10 opacity-75 dark:invert">
                        </div>
                    </div>

                    <!-- Total Tide Gauges Card -->
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Total Tide Gauges</h4>
                                <p class="mt-2 text-4xl font-bold text-blue-600 dark:text-blue-400">{{ $data['tideGauges'] }}</p>
                            </div>
                            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSY5LwgmDWPzizXdfd7J6dcVEP9-XnoJLFwxKZIW-MoZcgSTiXd0qmT_PSb_k6NTslXrm0&usqp=CAU" alt="Tide Gauges Icon" class="w-10 h-10 opacity-75 dark:invert">
                        </div>
                    </div>
                @else
                    <!-- Assigned Tide Gauges Card for Regular Users -->
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Assigned Tide Gauges</h4>
                                <p class="mt-2 text-4xl font-bold text-blue-600 dark:text-blue-400">{{ $data['tideGauges'] }}</p>
                            </div>
                            <img src="https://img.icons8.com/ios-filled/50/000000/water-level.png" alt="Assigned Icon" class="w-10 h-10 opacity-75 dark:invert">
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
