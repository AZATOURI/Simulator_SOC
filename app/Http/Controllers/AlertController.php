<?php

namespace App\Http\Controllers;

use App\Models\Alert;
use App\Models\AlertLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AlertController
{
    private function adminOnly(): void
    {
        $user = Auth::user();

        if (! $user || $user->role !== 'admin') {
            abort(403, 'Access denied. Admin only.');
        }
    }

    public function dashboard()
    {
        return view('dashboard', [
            'total' => Alert::count(),
            'critical' => Alert::where('severity', 'Critical')->count(),
            'high' => Alert::where('severity', 'High')->count(),
            'new' => Alert::where('status', 'New')->count(),
            'inProgress' => Alert::where('status', 'In Progress')->count(),
            'resolved' => Alert::where('status', 'Resolved')->count(),
            'falsePositive' => Alert::where('status', 'False Positive')->count(),
            'latestAlerts' => Alert::latest()->take(7)->get(),
        ]);
    }

    public function index()
    {
        $alerts = Alert::latest()->paginate(10);

        return view('alerts.index', compact('alerts'));
    }

    public function create()
    {
        $this->adminOnly();

        return view('alerts.create');
    }

    public function store(Request $request)
    {
        $this->adminOnly();

        $data = $request->validate([
            'title' => ['required', 'string', 'min:3', 'max:255'],
            'category' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'min:10'],
            'severity' => ['required', 'in:Low,Medium,High,Critical'],
            'status' => ['required', 'in:New,In Progress,Resolved,False Positive'],
            'source_ip' => ['nullable', 'ip'],
            'target_system' => ['nullable', 'string', 'max:255'],
            'recommendation' => ['nullable', 'string', 'max:1000'],
            'raw_log' => ['nullable', 'string', 'max:3000'],
        ]);

        try {
            $alert = Alert::create($data);

            AlertLog::create([
                'alert_id' => $alert->id,
                'user_id' => Auth::id(),
                'action' => 'Alert created manually by admin',
                'old_status' => null,
                'new_status' => $alert->status,
            ]);

            return redirect()
                ->route('alerts.index')
                ->with('success', 'Alert created successfully.');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Error while creating alert.')
                ->withInput();
        }
    }

    public function show(Alert $alert)
    {
        $alert->load(['logs.user']);

        return view('alerts.show', compact('alert'));
    }

    public function edit(Alert $alert)
    {
        $this->adminOnly();

        return view('alerts.edit', compact('alert'));
    }

    public function update(Request $request, Alert $alert)
    {
        $this->adminOnly();

        $data = $request->validate([
            'title' => ['required', 'string', 'min:3', 'max:255'],
            'category' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'min:10'],
            'severity' => ['required', 'in:Low,Medium,High,Critical'],
            'status' => ['required', 'in:New,In Progress,Resolved,False Positive'],
            'source_ip' => ['nullable', 'ip'],
            'target_system' => ['nullable', 'string', 'max:255'],
            'recommendation' => ['nullable', 'string', 'max:1000'],
            'raw_log' => ['nullable', 'string', 'max:3000'],
        ]);

        try {
            $oldStatus = $alert->status;

            $alert->update($data);

            AlertLog::create([
                'alert_id' => $alert->id,
                'user_id' => Auth::id(),
                'action' => 'Alert updated by admin',
                'old_status' => $oldStatus,
                'new_status' => $alert->status,
            ]);

            return redirect()
                ->route('alerts.show', $alert)
                ->with('success', 'Alert updated successfully.');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Error while updating alert.')
                ->withInput();
        }
    }

    public function destroy(Alert $alert)
    {
        $this->adminOnly();

        try {
            $alert->delete();

            return redirect()
                ->route('alerts.index')
                ->with('success', 'Alert deleted successfully.');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Error while deleting alert.');
        }
    }

    public function changeStatus(Request $request, Alert $alert)
    {
        $data = $request->validate([
            'status' => ['required', 'in:New,In Progress,Resolved,False Positive'],
        ]);

        try {
            $oldStatus = $alert->status;

            $alert->update([
                'status' => $data['status'],
            ]);

            AlertLog::create([
                'alert_id' => $alert->id,
                'user_id' => Auth::id(),
                'action' => 'Analyst changed alert status',
                'old_status' => $oldStatus,
                'new_status' => $data['status'],
            ]);

            return back()
                ->with('success', 'Status updated successfully.');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Error while changing status.');
        }
    }

    public function generateAttack()
    {
        $attacks = [
            [
                'title' => 'Brute Force Login Attempt',
                'category' => 'Authentication Attack',
                'description' => 'Multiple failed login attempts detected against the authentication service.',
                'severity' => 'High',
                'source_ip' => '192.168.10.' . rand(10, 250),
                'target_system' => 'Identity Provider',
                'recommendation' => 'Block the source IP, enable MFA, and review authentication logs.',
                'raw_log' => '[AUTH] Failed login attempts exceeded threshold for user admin@company.local',
            ],
            [
                'title' => 'SQL Injection Attempt',
                'category' => 'Web Attack',
                'description' => 'Suspicious SQL payload detected in HTTP request parameters.',
                'severity' => 'Critical',
                'source_ip' => '10.0.4.' . rand(10, 250),
                'target_system' => 'Customer Web Portal',
                'recommendation' => 'Validate inputs, use prepared statements, and review WAF logs.',
                'raw_log' => '[WAF] Payload detected: OR 1=1 -- in /login endpoint',
            ],
            [
                'title' => 'Malware Detected on Endpoint',
                'category' => 'Endpoint Security',
                'description' => 'Endpoint protection detected a suspicious executable on a workstation.',
                'severity' => 'Critical',
                'source_ip' => '172.16.8.' . rand(10, 250),
                'target_system' => 'Finance Workstation',
                'recommendation' => 'Isolate the endpoint and run a full malware scan.',
                'raw_log' => '[EDR] Suspicious process spawned from Downloads folder.',
            ],
            [
                'title' => 'DDoS Traffic Spike',
                'category' => 'Network Attack',
                'description' => 'Unusual traffic volume detected against the public web server.',
                'severity' => 'High',
                'source_ip' => '45.33.' . rand(1, 99) . '.' . rand(10, 250),
                'target_system' => 'Public Web Server',
                'recommendation' => 'Enable rate limiting and contact the network provider.',
                'raw_log' => '[NETFLOW] Requests per second exceeded baseline by 500%.',
            ],
            [
                'title' => 'Unauthorized Admin Panel Access',
                'category' => 'Access Control',
                'description' => 'A user attempted to access a restricted administration page.',
                'severity' => 'Medium',
                'source_ip' => '192.168.56.' . rand(10, 250),
                'target_system' => 'Admin Panel',
                'recommendation' => 'Review user permissions and access logs.',
                'raw_log' => '[ACCESS] HTTP 403 generated for restricted admin route.',
            ],
        ];

        try {
            $attack = $attacks[array_rand($attacks)];

            $alert = Alert::create([
                'title' => $attack['title'],
                'category' => $attack['category'],
                'description' => $attack['description'],
                'severity' => $attack['severity'],
                'status' => 'New',
                'source_ip' => $attack['source_ip'],
                'target_system' => $attack['target_system'],
                'recommendation' => $attack['recommendation'],
                'raw_log' => $attack['raw_log'],
            ]);

            AlertLog::create([
                'alert_id' => $alert->id,
                'user_id' => Auth::id(),
                'action' => 'Attack generated by SOC simulator',
                'old_status' => null,
                'new_status' => 'New',
            ]);

            return redirect()
                ->route('dashboard')
                ->with('success', 'New simulated enterprise attack generated.');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Error while generating attack.');
        }
    }

    public function history()
    {
        $logs = AlertLog::with(['alert', 'user'])
            ->latest()
            ->paginate(15);

        return view('alerts.history', compact('logs'));
    }

    public function addNote(Request $request, Alert $alert)
    {
        $data = $request->validate([
            'note' => ['required', 'string', 'min:5', 'max:120'],
        ]);

        try {
            AlertLog::create([
                'alert_id' => $alert->id,
                'user_id' => auth::id(),
                'action' => 'Investigation note: ' . $data['note'],
                'old_status' => $alert->status,
                'new_status' => $alert->status,
            ]);

            return back()->with('success', 'Investigation note added successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error while adding note.');
        }
    }

    public function sendReport(Request $request, Alert $alert)
    {
        $data = $request->validate([
            'report_target' => ['required', 'in:SOC Manager,Team Lead,CISO'],
            'report_summary' => ['required', 'string', 'min:10', 'max:100'],
        ]);

        try {
            AlertLog::create([
                'alert_id' => $alert->id,
                'user_id' => auth::id(),
                'action' => 'Incident report sent to ' . $data['report_target'] . ': ' . $data['report_summary'],
                'old_status' => $alert->status,
                'new_status' => $alert->status,
            ]);

            return back()->with('success', 'Incident report sent successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error while sending report.');
        }
    }

    public function escalate(Alert $alert)
    {
        try {
            AlertLog::create([
                'alert_id' => $alert->id,
                'user_id' => auth::id(),
                'action' => 'Alert escalated to SOC Manager',
                'old_status' => $alert->status,
                'new_status' => $alert->status,
            ]);

            return back()->with('success', 'Alert escalated successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error while escalating alert.');
        }
    }
}
