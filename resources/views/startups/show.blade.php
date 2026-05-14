<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div class="flex items-center space-x-4">
                <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ $startup->name }}
                </h2>
                <form action="{{ route('portfolio.toggle', $startup->id) }}" method="POST" class="inline-flex m-0 mt-1">
                    @csrf
                    <button type="submit" class="{{ auth()->user()->portfolio->contains($startup->id) ? 'text-yellow-400 hover:text-yellow-500' : 'text-gray-400 hover:text-yellow-400 dark:text-gray-600 dark:hover:text-yellow-400' }} transition" title="Toggle Portfolio">
                        <svg class="w-6 h-6 fill-current" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                    </button>
                </form>
            </div>
            <a href="{{ route('startups.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 transition">
                &larr; Back
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Startup Overview -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border border-gray-100 dark:border-gray-700">
                <div class="p-6">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Overview</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Industry</p>
                            <p class="font-medium text-gray-900 dark:text-gray-100">{{ $startup->industry ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Stage</p>
                            <p class="font-medium text-gray-900 dark:text-gray-100">{{ $startup->stage ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Total Funding Raised</p>
                            <p class="font-medium text-gray-900 dark:text-gray-100">₹{{ number_format($startup->funding_raised, 2) }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Founders -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border border-gray-100 dark:border-gray-700">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white">Founders</h3>
                        </div>

                        <!-- Add Founder Form -->
                        @if(auth()->user()->isAdmin())
                        <form action="{{ route('founders.store', $startup->id) }}" method="POST" class="mb-6 flex gap-2">
                            @csrf
                            <input type="text" name="name" placeholder="Founder Name" required class="flex-1 rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            <input type="text" name="role" placeholder="Role" class="flex-1 rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            <button type="submit" class="inline-flex justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none">Add</button>
                        </form>
                        @endif
                        @if($startup->founders->count() > 0)
                            <ul class="space-y-3">
                                @foreach($startup->founders as $founder)
                                    <li class="flex items-center p-3 rounded-lg bg-gray-50 dark:bg-gray-700/50">
                                        <div class="w-10 h-10 rounded-full bg-blue-100 dark:bg-blue-900/50 flex items-center justify-center text-blue-600 dark:text-blue-400 font-bold mr-4">
                                            {{ substr($founder->name, 0, 1) }}
                                        </div>
                                        <div class="flex-1">
                                            <p class="font-medium text-gray-900 dark:text-white">{{ $founder->name }}</p>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ $founder->role }}</p>
                                        </div>
                                        @if(auth()->user()->isAdmin())
                                        <form action="{{ route('founders.destroy', $founder->id) }}" method="POST" onsubmit="return confirm('Remove founder?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-700 text-sm font-medium">Remove</button>
                                        </form>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-gray-500 dark:text-gray-400">No founders added yet.</p>
                        @endif
                    </div>
                </div>

                <!-- Funding Rounds -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border border-gray-100 dark:border-gray-700">
                    <div class="p-6">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Funding Rounds</h3>

                        <!-- Add Funding Round Form -->
                        @if(auth()->user()->isAdmin())
                        <form action="{{ route('funding-rounds.store', $startup->id) }}" method="POST" class="mb-6 grid grid-cols-2 gap-2">
                            @csrf
                            <input type="text" name="round_name" placeholder="Round Name" required class="rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            <input type="number" step="0.01" name="amount" placeholder="Amount (₹)" class="rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            <input type="date" name="date" class="rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            <button type="submit" class="inline-flex justify-center rounded-md border border-transparent bg-green-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-green-700 focus:outline-none">Add Round</button>
                        </form>
                        @endif
                        @if($startup->fundingRounds->count() > 0)
                            <div class="space-y-4">
                                @foreach($startup->fundingRounds as $round)
                                    <div class="p-4 rounded-lg border border-gray-200 dark:border-gray-600">
                                        <div class="flex justify-between items-start mb-2">
                                            <div>
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">
                                                    {{ $round->round_name }}
                                                </span>
                                                <p class="mt-1 font-bold text-gray-900 dark:text-white">₹{{ number_format($round->amount, 2) }}</p>
                                            </div>
                                            <div class="flex flex-col items-end gap-2">
                                                <div class="text-sm text-gray-500 dark:text-gray-400">
                                                    {{ $round->date ? \Carbon\Carbon::parse($round->date)->format('M d, Y') : 'Unknown date' }}
                                                </div>
                                                @if(auth()->user()->isAdmin())
                                                <form action="{{ route('funding-rounds.destroy', $round->id) }}" method="POST" onsubmit="return confirm('Remove funding round?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-500 hover:text-red-700 text-xs font-medium">Delete</button>
                                                </form>
                                                @endif
                                            </div>
                                        </div>
                                        
                                        @if($round->investors->count() > 0)
                                            <div class="mt-3 pt-3 border-t border-gray-200 dark:border-gray-600">
                                                <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2">Investors</p>
                                                <div class="flex flex-wrap gap-2">
                                                    @foreach($round->investors as $investor)
                                                        <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300">
                                                            {{ $investor->name }}
                                                        </span>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-500 dark:text-gray-400">No funding rounds recorded.</p>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
