@extends('layouts.soc')

@section('content')
<h1>Edit Alert</h1>
<p class="muted">Admin update panel.</p>

<div class="card">
    <form method="POST" action="{{ route('alerts.update', $alert) }}">
        @csrf
        @method('PUT')

        <label>Title</label>
        <input name="title" value="{{ old('title', $alert->title) }}">
        @error('title') <div class="error-box">{{ $message }}</div> @enderror

        <label>Category</label>
        <input name="category" value="{{ old('category', $alert->category) }}">
        @error('category') <div class="error-box">{{ $message }}</div> @enderror

        <label>Description</label>
        <textarea name="description">{{ old('description', $alert->description) }}</textarea>
        @error('description') <div class="error-box">{{ $message }}</div> @enderror

        <label>Severity</label>
        <select name="severity">
            @foreach(['Low','Medium','High','Critical'] as $severity)
                <option value="{{ $severity }}" @selected(old('severity', $alert->severity) === $severity)>
                    {{ $severity }}
                </option>
            @endforeach
        </select>

        <label>Status</label>
        <select name="status">
            @foreach(['New','In Progress','Resolved','False Positive'] as $status)
                <option value="{{ $status }}" @selected(old('status', $alert->status) === $status)>
                    {{ $status }}
                </option>
            @endforeach
        </select>

        <label>Source IP</label>
        <input name="source_ip" value="{{ old('source_ip', $alert->source_ip) }}">
        @error('source_ip') <div class="error-box">{{ $message }}</div> @enderror

        <label>Target System</label>
        <input name="target_system" value="{{ old('target_system', $alert->target_system) }}">

        <label>Recommendation</label>
        <textarea name="recommendation">{{ old('recommendation', $alert->recommendation) }}</textarea>

        <label>Raw Log</label>
        <textarea name="raw_log">{{ old('raw_log', $alert->raw_log) }}</textarea>

        <button class="btn btn-warning">Update Alert</button>
        <a class="btn btn-dark" href="{{ route('alerts.show', $alert) }}">Cancel</a>
    </form>
</div>
@endsection
