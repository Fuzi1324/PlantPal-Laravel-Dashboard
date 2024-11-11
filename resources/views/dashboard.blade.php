<x-app-layout>
    <x-slot name="header">
        <h2>{{ __('Dashboard') }}</h2>
    </x-slot>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
            <h3>My Installations</h3>
            <a href="{{ route('installations.create') }}" class="btn btn-primary">+ Add Installation</a>

            @if (Auth::user()->installations->isEmpty())
                <p>You have no installations.</p>
            @else
                <ul>
                    @foreach (Auth::user()->installations as $installation)
                        <li>
                            <a href="{{ route('installations.show', $installation) }}">
                                {{ $installation->name ?? $installation->installation_code }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
</x-app-layout>
