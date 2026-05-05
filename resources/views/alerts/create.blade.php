@extends('layouts.soc')

@section('content')
<h1>Create Alert</h1>
<p class="muted">Manual alert creation for admin users.</p>

<div class="card">
    <form method="POST" action="{{ route('alerts.store') }}">
        @csrf

        <label>Title</label>
        <input name="title" value="{{ old('title') }}">
        @error('title') <div class="error-box">{{ $message }}</div> @enderror

        <label>Category</label>
        <input name="category" value="{{ old('category') }}" placeholder="Web Attack, Malware, Network Attack...">
        @error('category') <div class="error-box">{{ $message }}</div> @enderror

        <label>Description</label>
        <textarea name="description">{{ old('description') }}</textarea>
        @error('description') <div class="error-box">{{ $message }}</div> @enderror

        <label>Severity</label>
        <select name="severity">
            @foreach(['Low','Medium','High','Critical'] as $severity)
                <option value="{{ $severity }}">{{ $severity }}</option>
            @endforeach
        </select>

        <label>Status</label>
        <select name="status">
            @foreach(['New','In Progress','Resolved','False Positive'] as $status)
                <option value="{{ $status }}">{{ $status }}</option>
            @endforeach
        </select>

        <label>Source IP</label>
        <input name="source_ip" value="{{ old('source_ip') }}" placeholder="192.168.1.10">
        @error('source_ip') <div class="error-box">{{ $message }}</div> @enderror

        <label>Target System</label>
        <input name="target_system" value="{{ old('target_system') }}">

        <label>Recommendation</label>
        <textarea name="recommendation">{{ old('recommendation') }}</textarea>

        <label>Raw Log</label>
        <textarea name="raw_log">{{ old('raw_log') }}</textarea>

        <button class="btn btn-success">Save Alert</button>
        <a class="btn btn-dark" href="{{ route('alerts.index') }}">Cancel</a>
    </form>
</div>
@endsection
