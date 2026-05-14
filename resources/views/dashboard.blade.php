<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard Overview') }}
        </h2>
    </x-slot>

    <!-- Include Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Charts and Activity Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                
                <!-- Chart Area -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">Startups by Stage</h3>
                    </div>
                    <div class="p-6 flex justify-center items-center h-80">
                        <canvas id="stageChart"></canvas>
                    </div>
                </div>

                <!-- Recent Activity List -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg flex flex-col">
                    <div class="p-6 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">Recently Added Startups</h3>
                        <a href="{{ route('startups.index') }}" class="text-sm text-blue-500 hover:text-blue-600 dark:text-blue-400">View All &rarr;</a>
                    </div>
                    <div class="p-6 flex-1 overflow-y-auto">
                        @if($recentStartups->count() > 0)
                            <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($recentStartups as $startup)
                                    <li class="py-3">
                                        <div class="flex justify-between items-center">
                                            <div>
                                                <p class="font-medium text-gray-900 dark:text-white">{{ $startup->name }}</p>
                                                <p class="text-sm text-gray-500 dark:text-gray-400">{{ $startup->industry ?? 'No Industry' }}</p>
                                            </div>
                                            <div>
                                                <a href="{{ route('startups.show', $startup->id) }}" class="inline-flex items-center px-3 py-1 bg-gray-100 dark:bg-gray-700 border border-transparent rounded-md text-xs font-medium text-gray-800 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600 transition">
                                                    View
                                                </a>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <div class="flex flex-col items-center justify-center h-full text-gray-500 dark:text-gray-400">
                                <p>No startups added yet.</p>
                                @if(auth()->user()->isAdmin())
                                    <a href="{{ route('startups.create') }}" class="mt-4 text-sm text-blue-500 hover:underline">Add your first startup</a>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const ctx = document.getElementById('stageChart').getContext('2d');
            const data = @json($startupsByStage);
            
            const labels = Object.keys(data);
            const values = Object.values(data);

            const isDarkMode = document.documentElement.classList.contains('dark') || window.matchMedia('(prefers-color-scheme: dark)').matches;
            const textColor = isDarkMode ? '#e5e7eb' : '#374151';

            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: labels,
                    datasets: [{
                        data: values,
                        backgroundColor: [
                            'rgba(59, 130, 246, 0.8)', // Blue
                            'rgba(16, 185, 129, 0.8)', // Green
                            'rgba(139, 92, 246, 0.8)', // Purple
                            'rgba(245, 158, 11, 0.8)', // Amber
                            'rgba(239, 68, 68, 0.8)'   // Red
                        ],
                        borderColor: isDarkMode ? '#1f2937' : '#ffffff',
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'right',
                            labels: {
                                color: textColor
                            }
                        }
                    }
                }
            });
        });
    </script>
</x-app-layout>
