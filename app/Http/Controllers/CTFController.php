<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CTFController extends Controller
{
    private function challenges(): array
    {
        return config('ctf.challenges', []);
    }

    private function getChallenge(string $slug): array
    {
        $challenges = $this->challenges();

        if (! isset($challenges[$slug])) {
            abort(404);
        }

        return $challenges[$slug];
    }

    private function solved(Request $request): array
    {
        return $request->session()->get('ctf.solved', []);
    }

    private function fragments(Request $request): array
    {
        return $request->session()->get('ctf.fragments', []);
    }

    private function isSolved(Request $request, string $slug): bool
    {
        return in_array($slug, $this->solved($request), true);
    }

    private function isFinalUnlocked(Request $request): bool
    {
        $fragments = $this->fragments($request);

        return isset($fragments['A'], $fragments['B'], $fragments['C']);
    }

    private function isLocked(Request $request, string $slug): bool
    {
        if ($slug === 'operation-agadir-shield') {
            return ! $this->isFinalUnlocked($request);
        }

        return false;
    }

    private function score(Request $request): int
    {
        $score = 0;
        $solved = $this->solved($request);

        foreach ($this->challenges() as $slug => $challenge) {
            if (in_array($slug, $solved, true)) {
                $score += $challenge['points'];
            }
        }

        return $score;
    }

    private function totalPoints(): int
    {
        return collect($this->challenges())->sum('points');
    }

    private function isFakeFlag(string $flag): bool
    {
        return in_array($flag, config('ctf.fake_flags', []), true);
    }

    private function solveChallenge(Request $request, string $slug): void
    {
        $challenge = $this->getChallenge($slug);

        $solved = $this->solved($request);

        if (! in_array($slug, $solved, true)) {
            $solved[] = $slug;
            $request->session()->put('ctf.solved', $solved);
        }

        if (isset($challenge['fragment_key'], $challenge['fragment_value'])) {
            $fragments = $this->fragments($request);
            $fragments[$challenge['fragment_key']] = $challenge['fragment_value'];
            $request->session()->put('ctf.fragments', $fragments);
        }
    }

    public function index(Request $request)
    {
        if (! $request->session()->has('ctf.nickname')) {
            return view('ctf.index', [
                'nicknameMode' => true,
            ]);
        }

        $challenges = $this->challenges();
        $solved = $this->solved($request);
        $fragments = $this->fragments($request);

        return view('ctf.index', [
            'nicknameMode' => false,
            'nickname' => $request->session()->get('ctf.nickname'),
            'challenges' => $challenges,
            'solved' => $solved,
            'fragments' => $fragments,
            'score' => $this->score($request),
            'totalPoints' => $this->totalPoints(),
            'solvedCount' => count($solved),
            'totalChallenges' => count($challenges),
            'finalUnlocked' => $this->isFinalUnlocked($request),
        ]);
    }

    public function start(Request $request)
    {
        $data = $request->validate([
            'nickname' => ['required', 'string', 'min:2', 'max:30'],
        ]);

        $request->session()->put('ctf.nickname', $data['nickname']);
        $request->session()->put('ctf.solved', []);
        $request->session()->put('ctf.fragments', []);

        return redirect()->route('ctf.index')->with('success', 'Welcome to Agadir SOC CTF Lab.');
    }

    public function reset(Request $request)
    {
        $request->session()->forget('ctf');

        return redirect()->route('ctf.index')->with('success', 'CTF session reset successfully.');
    }

    public function challenge(Request $request, string $slug)
    {
        if (! $request->session()->has('ctf.nickname')) {
            return redirect()->route('ctf.index');
        }

        $challenge = $this->getChallenge($slug);

        if ($this->isLocked($request, $slug)) {
            return redirect()->route('ctf.index')
                ->with('error', 'Final mission is locked. Collect fragments A, B and C first.');
        }

        $response = response()->view('ctf.challenge', [
            'slug' => $slug,
            'challenge' => $challenge,
            'isSolved' => $this->isSolved($request, $slug),
            'fragments' => $this->fragments($request),
        ]);

        if ($slug === 'blue-team-header') {
            $response->header('X-SOC-Signal', 'U09De0hFQURFUl9BTkFMWVNUfQ==');
        }

        return $response;
    }

    public function submit(Request $request, string $slug)
    {
        if (! $request->session()->has('ctf.nickname')) {
            return redirect()->route('ctf.index');
        }

        $challenge = $this->getChallenge($slug);

        if ($this->isLocked($request, $slug)) {
            return back()->with('error', 'This challenge is locked.');
        }

        $data = $request->validate([
            'flag' => ['required', 'string', 'max:120'],
        ]);

        $flag = trim($data['flag']);

        if ($this->isFakeFlag($flag)) {
            return back()->with('fake', 'Fake flag detected. Analysts verify before submitting.');
        }

        if (hash_equals($challenge['hash'], hash('sha256', $flag))) {
            $alreadySolved = $this->isSolved($request, $slug);

            $this->solveChallenge($request, $slug);

            if ($alreadySolved) {
                return back()->with('success', 'Correct flag, but this challenge was already solved.');
            }

            return back()->with('success', 'Correct flag! Points added.');
        }

        return back()->with('error', 'Wrong flag. Keep investigating.');
    }

    public function submitGlobal(Request $request)
    {
        if (! $request->session()->has('ctf.nickname')) {
            return redirect()->route('ctf.index');
        }

        $data = $request->validate([
            'flag' => ['required', 'string', 'max:120'],
        ]);

        $flag = trim($data['flag']);

        if ($this->isFakeFlag($flag)) {
            return back()->with('fake', 'Fake flag detected. Analysts verify before submitting.');
        }

        foreach ($this->challenges() as $slug => $challenge) {
            if ($this->isLocked($request, $slug)) {
                continue;
            }

            if (hash_equals($challenge['hash'], hash('sha256', $flag))) {
                $alreadySolved = $this->isSolved($request, $slug);

                $this->solveChallenge($request, $slug);

                if ($alreadySolved) {
                    return back()->with('success', 'Correct flag, but this challenge was already solved.');
                }

                return back()->with('success', 'Correct flag for: ' . $challenge['title']);
            }
        }

        return back()->with('error', 'Wrong flag. Keep investigating.');
    }

    public function socNote()
    {
        return response(
            "Agadir SOC Public Analyst Note\n\n" .
            "Some developers forget training notes in public endpoints.\n\n" .
            "Fragment A recovered: AGADIR\n" .
            "Submit this flag:\n" .
            "SOC{FRAGMENT_A_AGADIR}\n"
        )->header('Content-Type', 'text/plain');
    }

    public function adminGateway(Request $request)
    {
        $data = $request->validate([
            'username' => ['nullable', 'string', 'max:120'],
            'password' => ['nullable', 'string', 'max:120'],
        ]);

        $username = strtolower($data['username'] ?? '');
        $password = strtolower($data['password'] ?? '');
        $payload = $username . ' ' . $password;

        $isSqlInjection =
            str_contains($payload, "' or '1'='1")
            || str_contains($payload, "' or 1=1")
            || str_contains($payload, "or 1=1 --")
            || str_contains($payload, "admin' --");

        if ($isSqlInjection) {
            return redirect()->route('ctf.challenge', 'admin-gateway')
                ->with('success', 'Bypass detected. Submit this flag: SOC{ADMIN_GATEWAY_BYPASSED}');
        }

        return redirect()->route('ctf.challenge', 'admin-gateway')
            ->with('error', 'Access denied. The simulated SQL condition is still false.');
    }
}
