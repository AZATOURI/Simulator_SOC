@extends('layouts.soc')

@section('content')
<div class="topbar">
    <div>
        <h1>Alerts Center</h1>
        <p class="muted">Centralized list of detected security events.</p>
    </div>

    @if(auth()->user()->role === 'admin')
        <a class="btn btn-success" href="{{ route('alerts.create') }}">Create Alert</a>
    @endif
</div>

<div class="card">
    <table>
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Category</th>
            <th>Severity</th>
            <th>Status</th>
            <th>Source IP</th>
            <th>Target</th>
            <th>Actions</th>
        </tr>

        @forelse($alerts as $alert)
            <tr>
                <td>#{{ $alert->id }}</td>
                <td>{{ $alert->title }}</td>
                <td>{{ $alert->category }}</td>
                <td>
                    <span class="badge {{ strtolower($alert->severity) }}">
                        {{ $alert->severity }}
                    </span>
                </td>
                <td><span class="badge status">{{ $alert->status }}</span></td>
                <td>{{ $alert->source_ip }}</td>
                <td>{{ $alert->target_system }}</td>
                <td>
                    <a class="btn btn-primary" href="{{ route('alerts.show', $alert) }}">View</a>

                    @if(auth()->user()->role === 'admin')
                        <a class="btn btn-warning" href="{{ route('alerts.edit', $alert) }}">Edit</a>

                        <form class="form-inline" method="POST" action="{{ route('alerts.destroy', $alert) }}">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger" onclick="return confirm('Delete this alert?')">
                                Delete
                            </button>
                        </form>
                    @endif
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="8">No alerts found.</td>
            </tr>
        @endforelse
    </table>

    <div style="margin-top:20px;">
        {{ $alerts->links() }}
    </div>
</div>
@endsection
