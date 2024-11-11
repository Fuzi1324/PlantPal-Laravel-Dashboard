<x-app-layout>
    <div class="container">
        <h1>My Installations</h1>
        <a href="{{ route('installations.create') }}" class="btn btn-primary">+ Add Installation</a>
        <ul>
            @foreach ($installations as $installation)
                <li>
                    <a
                        href="{{ route('installations.show', $installation) }}">{{ $installation->name ?? $installation->installation_code }}</a>
                </li>
            @endforeach
        </ul>
    </div>
</x-app-layout>
