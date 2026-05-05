<x-guest-layout>
    <div style="text-align:center; margin-bottom:20px;">
        <h2 style="font-size:24px; font-weight:bold;">Choose SOC Role</h2>
        <p style="color:#64748b;">Select your role before creating an account.</p>
    </div>

    <form method="POST" action="{{ route('choose-role.store') }}">
        @csrf

        <div>
            <label>
                <input type="radio" name="role" value="analyste" checked>
                SOC Analyste
            </label>
            <p style="font-size:13px; color:#64748b;">
                Can view alerts, investigate, update status, and see history.
            </p>
        </div>

        <br>

        <div>
            <label>
                <input type="radio" name="role" value="admin">
                SOC Admin
            </label>
            <p style="font-size:13px; color:#64748b;">
                Can create, edit, delete alerts and manage the full simulator.
            </p>
        </div>

        <div style="margin-top:15px;">
            <label>Admin Code</label>
            <input
                type="password"
                name="admin_code"
                placeholder="Required only for admin"
                style="width:100%; padding:10px; border:1px solid #ddd; border-radius:8px;"
            >
            @error('admin_code')
                <p style="color:red;">{{ $message }}</p>
            @enderror
        </div>

        @error('role')
            <p style="color:red;">{{ $message }}</p>
        @enderror

        <button
            type="submit"
            style="margin-top:20px; width:100%; padding:12px; background:#111827; color:white; border-radius:8px;"
        >
            Continue to Register
        </button>
    </form>
</x-guest-layout>
