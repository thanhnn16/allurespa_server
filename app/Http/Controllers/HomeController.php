<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\Process\Process;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('pages.dashboard');
    }

    public function home()
    {
        return redirect('/dashboard');
    }

    public function webhook(Request $request)
    {
        if ($request->hasHeader('X-GitHub-Event')) {
            if ($request->header('X-GitHub-Event') == 'pull_request') {
                $payload = $request->all();
                if ($payload['action'] == 'closed') {
                    $branch = $payload['pull_request']['head']['ref'];
                    $repo = $payload['pull_request']['head']['repo']['name'];
                    $owner = $payload['pull_request']['head']['repo']['owner']['login'];
                    $url = $payload['pull_request']['head']['repo']['clone_url'];
                    $commit = $payload['pull_request']['head']['sha'];
                    $this->gitPull($branch, $repo, $owner, $url, $commit);
                }
            }
        }
        return response()->json(['success' => 'Webhook received']);
    }

    private function gitPull(mixed $branch, mixed $repo, mixed $owner, mixed $url, mixed $commit)
    {
        $process = new Process(['cd /var/www/allurespa_server && git pull']);
        $process->run();

        if (!$process->isSuccessful()) {
            throw new \Exception('Git pull failed: ' . $process->getErrorOutput());
        }

        echo $process->getOutput();
    }
}
