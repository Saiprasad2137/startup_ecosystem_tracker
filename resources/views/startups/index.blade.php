<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Startups') }}
            </h2>
            @if(auth()->user()->isAdmin())
                <a href="{{ route('startups.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">
                    Add New Startup
                </a>
            @endif
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                    @if(session('success'))
                        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-md">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-100 dark:bg-gray-700">
                                    <th class="px-4 py-3 border-b border-gray-200 dark:border-gray-600">Name</th>
                                    <th class="px-4 py-3 border-b border-gray-200 dark:border-gray-600">Industry</th>
                                    <th class="px-4 py-3 border-b border-gray-200 dark:border-gray-600">Stage</th>
                                    <th class="px-4 py-3 border-b border-gray-200 dark:border-gray-600">Funding Raised</th>
                                    <th class="px-4 py-3 border-b border-gray-200 dark:border-gray-600">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($startups as $startup)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-600">
                                        <td class="px-4 py-3 border-b border-gray-200 dark:border-gray-700">{{ $startup->name }}</td>
                                        <td class="px-4 py-3 border-b border-gray-200 dark:border-gray-700">{{ $startup->industry }}</td>
                                        <td class="px-4 py-3 border-b border-gray-200 dark:border-gray-700">{{ $startup->stage }}</td>
                                        <td class="px-4 py-3 border-b border-gray-200 dark:border-gray-700">₹{{ number_format($startup->funding_raised, 2) }}</td>
                                        <td class="px-4 py-3 border-b border-gray-200 dark:border-gray-700 flex space-x-3 items-center">
                                            <form action="{{ route('portfolio.toggle', $startup->id) }}" method="POST" class="inline-flex m-0">
                                                @csrf
                                                <button type="submit" class="{{ auth()->user()->portfolio->contains($startup->id) ? 'text-yellow-400 hover:text-yellow-500' : 'text-gray-400 hover:text-yellow-400 dark:text-gray-500 dark:hover:text-yellow-400' }} transition" title="Toggle Portfolio">
                                                    <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                                </button>
                                            </form>
                                            <a href="{{ route('startups.show', $startup->id) }}" class="text-indigo-500 hover:text-indigo-600 dark:text-indigo-400 font-medium">View</a>
                                            @if(auth()->user()->isAdmin())
                                                <a href="{{ route('startups.edit', $startup->id) }}" class="text-blue-500 hover:text-blue-600 dark:text-blue-400 font-medium">Edit</a>
                                                <form action="{{ route('startups.destroy', $startup->id) }}" method="POST" onsubmit="return confirm('Are you sure?');" class="inline-flex m-0">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-500 hover:text-red-600 dark:text-red-400 font-medium">Delete</button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-4 py-3 border-b text-center text-gray-500 dark:text-gray-400">No startups found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
